<?php

namespace App\Http\Controllers\Admin\Project;

use App\Entity\EducationEnum;
use App\Entity\EmploymentEnum;
use App\Entity\FamilyStatusEnum;
use App\Entity\HobbiesEnum;
use App\Entity\MaterialConditionEnum;
use App\Entity\WorkEnum;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\Model\Geo\Region;
use App\Model\User\UserRatingStatus;
use App\User;
use App\Model\User\UserStatus;
use App\Model\User\UserShipping;
use App\Model\Project;
use App\Model\Questionnaire\Answer;
use App\Model\Project\ProjectRequestStatus;
use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use Carbon\Carbon;
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
        app()->setLocale('ru');
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
		if($request->submit == "randomList"){
			$this->randomList($request,$project_id);
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

		$country = null;
		$region = null;
		$cities = [];

		if($request->has('country')){
            $country = Country::where('id', $request->input('country'))->first();
        }

		if($request->has('region')){
            $region = Region::where('id', $request->input('region'))->first();
        }

		if($request->has('city')){
            $citiesArray = [];
            foreach ( $request->city as $key => $item){
                $citiesArray[] = $request->input('city')[$key];
            }
		    $cities = City::whereIn('id', $citiesArray)->get();
        }

        $ratingStatuses = UserRatingStatus::where('lang', 'ru')->get();
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

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
			'userStatuses' => $userStatuses,
            'ratingStatuses'	=>	$ratingStatuses,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray,
            'country' => $country,
            'region' => $region,
            'cities' => $cities
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
	private function getFilteredProjectRequest(Request $request,$project_id)
    {
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
                $user->where('birsday','<=', Carbon::now()->year - $request->old_min);
            });
        }
        if(isset($request->old_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('birsday','>=', Carbon::now()->year - $request->old_max);
            });
        }

        if(isset($request->city))
        {
            $cities = [];
            foreach ( $request->city as $key => $item){
                $cities[] = $request->input('city')[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($cities){
                $user->whereIn('city_id', $cities);
            });
        }
        if(isset($request->region))
        {
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('region_id', $request->region);
            });
        }
        if(isset($request->country))
        {
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('country_id', $request->country);
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
        if(isset($request->education))
        {
            $educationArray = [];
            foreach ( $request->education as $key => $item){
                $educationArray[] = $request->education[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($educationArray){
                $user->whereIn('education', $educationArray);
            });
        }
        if(isset($request->employment))
        {
            $employmentArray = [];
            foreach ( $request->employment as $key => $item){
                $employmentArray[] = $request->employment[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($employmentArray){
                $user->whereIn('employment', $employmentArray);
            });
        }
        if(isset($request->work))
        {
            $workArray = [];
            foreach ( $request->work as $key => $item){
                $workArray[] = $request->work[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($workArray){
                $user->whereIn('work', $workArray);
            });
        }
        if(isset($request->family_status))
        {
            $familyStatusArray = [];
            foreach ( $request->family_status as $key => $item){
                $familyStatusArray[] = $request->family_status[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($familyStatusArray){
                $user->whereIn('family_status', $familyStatusArray);
            });
        }
        if(isset($request->material_condition))
        {
            $materialConditionArray = [];
            foreach ( $request->material_condition as $key => $item){
                $materialConditionArray[] = $request->material_condition[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($materialConditionArray){
                $user->whereIn('material_condition', $materialConditionArray);
            });
        }
        if(isset($request->hobbies))
        {
            $hobbiesArray = [];
            foreach ( $request->hobbies as $key => $item){
                $hobbiesArray[] = $request->hobbies[$key];
            }

            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($hobbiesArray){
                $i = 0;
                foreach ($hobbiesArray as $hobby){
                    if($i === 0){
                        $user->where('hobbies', 'LIKE', '%'.$hobby.'%');
                        $i++;
                    }else{
                        $user->orWhere('hobbies', 'LIKE', '%'.$hobby.'%');
                    }
                }
            });
        }
        if(isset($request->rang))
        {
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('rang_id',  $request->rang );
            });
        }
        if(isset($request->rating_min)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('current_rating','>=', $request->rating_min);
            });
        }
        if(isset($request->rating_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('current_rating','<=', $request->rating_max);
            });
        }
        if(isset($request->online_min)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('last_active','>=', Carbon::parse($request->online_min));
            });
        }
        if(isset($request->online_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('last_active','<=', Carbon::parse($request->online_max));
            });
        }
        if(isset($request->registration_min)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('created_at','>=', Carbon::parse($request->registration_min));
            });
        }
        if(isset($request->registration_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->where('created_at','<=', Carbon::parse($request->registration_max));
            });
        }
        if(isset($request->project_min)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->whereHas('requests', function($q){
                    $q->where('status_id', '>=', 7);
                },'>=',$request->project_min);
            });
        }
        if(isset($request->project_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->whereHas('requests', function($q){
                    $q->where('status_id', '>=', 7);
                },'<=',$request->project_max);
            });
        }
        if(isset($request->project_date_min)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->whereHas('requests', function($q) use ($request){
                    $q->where('status_id', '>=', 7)->where('created_at', '>=', Carbon::parse($request->project_date_min));
                });
            });
        }
        if(isset($request->project_date_max)){
            $projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
                $user->whereHas('requests', function($q) use ($request){
                    $q->where('status_id', '>=', 7)->where('created_at', '<=', Carbon::parse($request->project_date_max));
                });
            });
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

        return $projectRequests;
    }

	public function project_all_ajax(Request $request,$project_id){

		$projectRequests = $this->getFilteredProjectRequest($request, $project_id);

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

	private function randomList(Request $request, $project_id){
        $projectRequests = $this->getFilteredProjectRequest($request, $project_id);

        $project = Project::find($project_id);
        $approvedRequestsCount = ProjectRequest::where([
            ['project_id',$project_id],
            ['status_id','>=',7]
        ])->count();
        $limit = $project->count_users - $approvedRequestsCount;
        $projectRequests = $projectRequests->where('status_id','<',7)->inRandomOrder()->limit($limit)->get();
        foreach ($projectRequests as $projectRequest){
            $projectRequest->status_id = 7;
            $projectRequest->save();
        }
    }
}
