<?php

namespace App\Http\Controllers\Admin\Project;

use App\User;
use App\Model\User\UserStatus;
use App\Model\User\UserShipping;
use App\Model\Project;
use App\Model\Questionnaire\Answer;
use App\Model\Project\ProjectRequestStatus;
use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project\ProjectRequest;
use App\Exports\RequestExport;
use App\Library\Users\Notification;
use App\Mail\UserNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class RequestController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

	public function all()
	{
		SEO::setTitle('Заявки на учатие в проектах');
		AdminPageData::setPageName('Заявки на учатие в проектах');
		AdminPageData::addBreadcrumbLevel('Заявки на учатие');

		return view('admin.projects.request.all');
	}
	public function user_all($user_id)
	{
		$requests = ProjectRequest::with(['user','project','status'])
			->where('user_id',$user_id)
			->get();
		$user = User::withTrashed()->find($user_id);

		SEO::setTitle('Заявки на учатие в проектах: '.$user->name);
		AdminPageData::setPageName('Заявки на учатие в проектах: '.$user->name);
		AdminPageData::addBreadcrumbLevel('Заявки на учатие');

		return view('admin.projects.request.all_user',[
			'requests'	=> $requests
		]);
	}
	public function project_all(Request $request, $project_id)
	{
		if($request->submit == "excel"){
			return $this->excel($request,$project_id);
		}
		$filters = Question::with(['questionnaire','options'])
			->where([
				['lang','ru']
			])
			->whereHas('questionnaire', function ($questionnaire) use ($project_id){
				$questionnaire->where([
					['project_id',$project_id],
					['type_id',2]
				]);
			})->whereNotIn('type_id',[7,9])
			->get();

		$statuses = ProjectRequestStatus::where('rus_lang_id',0)->get();
		$userStatuses = UserStatus::where('rus_lang_id',0)->get();
		$project = Project::find($project_id);
		$approvedRequestsCount = ProjectRequest::where([
            ['project_id',$project_id],
            ['status_id','>=',7]
        ])->count();

		SEO::setTitle('Заявки на учатие в проекте: '.$project->name);
		AdminPageData::setPageName('Заявки на учатие в проекте');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Заявки на учатие');

		return view('admin.projects.request.project',[
			'project_id' => $project_id,
			'project' => $project,
			'filters' => $filters,
			'statuses' => $statuses,
			'approvedRequestsCount' => $approvedRequestsCount,
			'userStatuses' => $userStatuses
		]);
	}

	public function all_ajax(Request $request){
		$projectRequests = ProjectRequest::with(['user','project','status']);//->orderBy('id','desc');

		if($request->has('status')){
			$filterItem = [];
			foreach ( $request->input('status') as $key => $item){
				$filterItem[] = (int)$request->input('status')[$key];
			}
			$projectRequests = $projectRequests->whereIn('status_id',$filterItem);
		}

		return datatables()->eloquent($projectRequests)
			->addColumn('user', function (ProjectRequest $projectRequest) {
				return $projectRequest->user->name;
			})->addColumn('project', function (ProjectRequest $projectRequest) {
				return $projectRequest->project->name;
			})
			->addColumn('status', function (ProjectRequest $projectRequest) {
				return $projectRequest->status->name;
			})
			->filterColumn('status', function($projectRequests, $keyword) {
				$projectRequests->whereHas('status', function ($status) use ($keyword){
					$status->where('name','like',["%{$keyword}%"]);
				});
			})
			->filterColumn('user', function($query, $keyword) {
				$query->whereHas('user', function ($user) use ($keyword){
					$user->where('name','like',["%{$keyword}%"]);
				});
			})
			->filterColumn('project', function($query, $keyword) {
				$query->whereHas('project', function ($project) use ($keyword){
					$project->where('name','like',["%{$keyword}%"]);
				});
			})
			->filter(function ($query) use ($request) {
				if (request()->has('id')) {
					$query->where('id','like',"%" . request('name') . "%");
				}
				if (request()->has('user')) {
					$query->whereHas('user', function ($user){
						$user->where('name','like',"%" . request('name') . "%");
					});
				}
				if (request()->has('project')) {
					$query->whereHas('project', function ($project){
						$project->where('name','like',"%" . request('name') . "%");
					});
				}

			}, true)
			->toJson();
	}

	public function project_all_ajax(Request $request,$project_id){

		$projectRequests = ProjectRequest::with(['user','project','status','answers'])
			->where('project_id',$project_id );

		$filters = Question::with(['questionnaire','options'])
			->whereHas('questionnaire', function ($questionnaire) use ($project_id){
				$questionnaire->where([
					['project_id',$project_id],
					['type_id',2]
				]);
			})->whereNotIn('type_id',[7,9])
			->get();
		if($request->has('sex')){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('sex', $request->sex);
			});
		}

		if(isset($request->old_min)){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('birsday','>=', $request->old_min);
			});
		}
		if(isset($request->old_max)){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('birsday','<=', $request->old_max);
			});
		}

		if(isset($request->city))
		{
			$cities = explode(',', $request->city);
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($cities){
				$user->whereIn('city', $cities);
			});
		}
		if(isset($request->region))
		{
			$regions = explode(',', $request->region);
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($regions){
				$user->whereIn('region', $regions);
			});
		}

		if($request->has('user_status')){
			$filterItem = [];
			foreach ( $request->input('user_status') as $key => $item){
				$filterItem[] = (int)$request->input('user_status')[$key];
			}
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($filterItem){
				$user->whereIn('status_id', $filterItem);
			});
		}
		if($request->has('status')){
			$filterItem = [];
			foreach ( $request->input('status') as $key => $item){
				$filterItem[] = (int)$request->input('status')[$key];
			}
			$projectRequests = $projectRequests->whereIn('status_id',$filterItem);
		}
		foreach ($filters as $filter){
			if($request->has('option_'.$filter->id)){
				$filterItem = [];
				foreach ( $request->input('option_'.$filter->id) as $key => $item){
					$filterItem[] = (int)$request->input('option_'.$filter->id)[$key];
				}
				$projectRequests = $projectRequests->whereHas('answers', function ($answer) use ($filterItem){
					$answer->whereIn('question_id', $filterItem);
				});
			}
		}
		//$projectRequests = $projectRequests->orderBy('id','desc');
		return datatables()->eloquent($projectRequests)
			->addColumn('user', function (ProjectRequest $projectRequest) {
				return $projectRequest->user->name;
			})->addColumn('project', function (ProjectRequest $projectRequest) {
				return $projectRequest->project->name;
			})
			->addColumn('status', function (ProjectRequest $projectRequest) {
				return $projectRequest->status->name;
			})
			->filterColumn('status', function($projectRequests, $keyword) {
				$projectRequests->whereHas('status', function ($status) use ($keyword){
					$status->where('name','like',["%{$keyword}%"]);
				});
			})->filterColumn('user', function($query, $keyword) {
				$query->whereHas('user', function ($user) use ($keyword){
					$user->where('name','like',["%{$keyword}%"]);
				});
			})
			->filterColumn('project', function($query, $keyword) {
				$query->whereHas('project', function ($project) use ($keyword){
					$project->where('name','like',["%{$keyword}%"]);
				});
			})
			->filter(function ($query) use ($request) {
				if (request()->has('id')) {
					$query->where('id','like',"%" . request('name') . "%");
				}
				if (request()->has('user')) {
					$query->whereHas('user', function ($user){
						$user->where('name','like',"%" . request('name') . "%");
					});
				}
				if (request()->has('project')) {
					$query->whereHas('project', function ($project){
						$project->where('name','like',"%" . request('name') . "%");
					});
				}

			}, true)
			->toJson();
	}

	public function edit($request_id){
		$statuses = ProjectRequestStatus::where('rus_lang_id',0)->get();
		$request = ProjectRequest::with(['answers.question','user','project'])->find($request_id);
		$questionnaires = Questionnaire::where([
			['rus_lang_id',0],
			['project_id',$request->project_id],
		])->get();

		SEO::setTitle('Заявка пользователя: '.$request->user->name);
		AdminPageData::setPageName('Заявка пользователя: '.$request->user->name);
		AdminPageData::addBreadcrumbLevel($request->project->name,'edit/'.$request->project->id);
		AdminPageData::addBreadcrumbLevel('Заявка: '.$request->user->name);

		return view('admin.projects.request.edit',[
			'request' => $request,
			'questionnaires' => $questionnaires,
			'statuses' => $statuses,
		]);
	}

	public function save(Request $request,$request_id){
		$pr_request = ProjectRequest::with(['answers.question','user','project'])->find($request_id);
		$pr_request->status_id = $request->type;
		$pr_request->save();

		ModeratorLogs::addLog("Изменил статус заявки: ".$pr_request->id);

		if(($request->submit == "save")){
			return redirect()->route('adm_project_request_edit',$pr_request->id);
		}
		else{
			return redirect()->route("adm_select_project_request",[$pr_request->project_id]);
		}

	}

	public function status(Request $request,$status_id, $request_id){
		$pr_request = ProjectRequest::with(['answers.question','user','project'])->find($request_id);
		$pr_request->status_id = $status_id;
		$pr_request->save();

		ModeratorLogs::addLog("Изменил статус заявки: ".$pr_request->id);

		return redirect()->route("adm_select_project_request",[$pr_request->project_id]);
	}


	public function delete($request_id){

		Answer::where('project_request_id',$request_id)->delete();
		UserShipping::where('request_id',$request_id)->delete();
		ProjectRequest::destroy($request_id);

		return "ok";
	}

	public function hide($request_id){
		$request = ProjectRequest::find($request_id);
		$request->isHide = true;
		$request->save();
		return "ok";
	}
	public function show($request_id){
		$request = ProjectRequest::find($request_id);
		$request->isHide = false;
		$request->save();
		return "ok";
	}

	public function sendShipping(Request $request, $request_id){
		$shipping = UserShipping::where([
			['request_id',$request_id],
		])->first();

		$projectRequest = ProjectRequest::find($request_id);
		$projectName = $projectRequest->project->name;
		if ($projectRequest->user->lang !== "ru")
		{
            $projectTranslate = $projectRequest->project->translate->firstWhere('lang', $projectRequest->user->lang);
            if($projectTranslate){
                $projectName = $projectTranslate->name;
            }
		}

		if($shipping){
			$shipping->ttn = $request->ttn;
			$shipping->save();

			if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter){
				Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 're_shipping', null, [ 'ttn' => $shipping->ttn]));
			}
			Notification::send('re_shipping', $projectRequest->user, 1, null, ['ttn' => $shipping->ttn]);

		}else{
			$shipping = new UserShipping();
			$shipping->request_id = $request_id;
			$shipping->ttn = $request->ttn;
			$shipping->save();

			if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter){
				Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 'shipping', null, ['project' => $projectName, 'ttn' => $shipping->ttn]));
			}
			Notification::send('shipping', $projectRequest->user, 1, null, ['project' => $projectName, 'ttn' => $shipping->ttn]);

		}


		return redirect()->route('adm_project_request_edit',[$request_id]);
	}

	public function excel(Request $request, $project_id){
		$excel = new RequestExport($request,$project_id);
		$excel->store('request_project_'.$project_id.'_'.time().'.xlsx','public_uploads');
		return $excel->download('request_project_'.$project_id.'_'.time().'.xlsx');
	}
}
