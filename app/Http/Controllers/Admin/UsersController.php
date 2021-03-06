<?php

namespace App\Http\Controllers\Admin;

use App\Entity\EducationEnum;
use App\Entity\EmploymentEnum;
use App\Entity\FamilyStatusEnum;
use App\Entity\HobbiesEnum;
use App\Entity\MaterialConditionEnum;
use App\Entity\WorkEnum;
use App\Exports\UserExport;
use App\Library\Queries\UserFilterServices;
use App\Library\Users\UserRating;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\Model\Geo\Region;
use App\Model\Post;
use App\Model\Project;
use App\Model\Project\ProjectMessage;
use App\Model\Project\ProjectRequest;
use App\Model\Questionnaire\Answer;
use App\Model\Questionnaire\Question;
use App\Model\Queue;
use App\Model\Review;
use App\Model\User\UserNotification;
use App\Model\User\UserPresents;
use App\Model\User\UserRatingHistory;
use App\Model\User\UserShipping;
use App\Model\User\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\User\UserRatingStatus;
use App\Model\User\UserChangeStatuses;
use App\Model\Role;
use App\Model\Admin\UserLog;
use App\Library\Users\ModeratorLogs;
use App\Model\Admin\ModeratorActiveTime;
use Image;
use Datatables;
use SEO;
use AdminPageData;

class UsersController extends Controller
{
    private const TRANSLATE_LANG = ['ua', 'en'];

    public function __construct()
    {
        app()->setLocale('ru');
    }

	public function all(Request $request){
        if($request->submit == "excel"){
            return $this->exportGenerate($request);
        }elseif ($request->submit == "notification"){
            return $this->sendCustomNotification($request);
        }

		SEO::setTitle('Все пользователи');
		AdminPageData::setPageName('Все пользователи');
		AdminPageData::addBreadcrumbLevel('Пользователи');

        $country = null;
        $region = null;
        $cities = [];
        $projects = [];
        $projectsExpert = [];
        $questions = [];

        if($request->has('filter.country')){
            $country = Country::where('id', $request->input('filter.country'))->first();
        }

        if($request->has('filter.region')){
            $region = Region::where('id', $request->input('filter.region'))->first();
        }

        if($request->has('filter.city')){
            $citiesArray = [];
            foreach ( $request->filter['city'] as $key => $item){
                $citiesArray[] = $request->input('filter.city')[$key];
            }
            $cities = City::whereIn('id', $citiesArray)->get();
        }

        if($request->has('filter.project')){
            $projectsArray = [];
            foreach ( $request->filter['project'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.project')[$key];
            }
            $projects = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.projectExpert')){
            $projectsArray = [];
            foreach ( $request->filter['projectExpert'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.projectExpert')[$key];
            }
            $projectsExpert = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.questions')){
            $questionsArray = [];
            foreach ( $request->filter['questions'] as $key => $item){
                $questionsArray[] = (int) $request->input('filter.questions')[$key];
            }
            $questions = Question::whereIn('id', $questionsArray)->get();
        }

        $statuses = UserStatus::where('lang', 'ru')->get();
        $ratingStatuses = UserRatingStatus::where('lang', 'ru')->get();
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

		return view('admin.users.all',[
            'statuses'	=>	$statuses,
            'ratingStatuses'	=>	$ratingStatuses,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray,
            'country' => $country,
            'region' => $region,
            'cities' => $cities,
            'projects' => $projects,
            'projectsExpert' => $projectsExpert,
            'questions' => $questions
        ]);
	}

	public function all_archive(Request $request)
    {
        if($request->submit == "excel"){
            return $this->exportGenerate($request);
        }elseif ($request->submit == "notification"){
            return $this->sendCustomNotification($request);
        }

        SEO::setTitle('Архив');
        AdminPageData::setPageName('Архив');
        AdminPageData::addBreadcrumbLevel('Пользователи','users');
        AdminPageData::addBreadcrumbLevel('Архив');

        $country = null;
        $region = null;
        $cities = [];
        $projects = [];
        $projectsExpert = [];
        $questions = [];

        if($request->has('filter.country')){
            $country = Country::where('id', $request->input('filter.country'))->first();
        }

        if($request->has('filter.region')){
            $region = Region::where('id', $request->input('filter.region'))->first();
        }

        if($request->has('filter.city')){
            $citiesArray = [];
            foreach ( $request->filter['city'] as $key => $item){
                $citiesArray[] = $request->input('filter.city')[$key];
            }
            $cities = City::whereIn('id', $citiesArray)->get();
        }

        if($request->has('filter.project')){
            $projectsArray = [];
            foreach ( $request->filter['project'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.project')[$key];
            }
            $projects = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.projectExpert')){
            $projectsArray = [];
            foreach ( $request->filter['projectExpert'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.projectExpert')[$key];
            }
            $projectsExpert = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.questions')){
            $questionsArray = [];
            foreach ( $request->filter['questions'] as $key => $item){
                $questionsArray[] = (int) $request->input('filter.questions')[$key];
            }
            $questions = Question::whereIn('id', $questionsArray)->get();
        }

        $statuses = UserStatus::where('lang', 'ru')->get();
        $ratingStatuses = UserRatingStatus::where('lang', 'ru')->get();
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

        return view('admin.users.all',[
            'isArchive' => true,
            'statuses'	=>	$statuses,
            'ratingStatuses'	=>	$ratingStatuses,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray,
            'country' => $country,
            'region' => $region,
            'cities' => $cities,
            'projects' => $projects,
            'projectsExpert' => $projectsExpert,
            'questions' => $questions
        ]);
    }

	public function all_ajax(Request $request){
        if($request->input('isArchive') == 1){
            $users = User::with(['roles','status'])->onlyTrashed();
        }else{
            $users = UserFilterServices::getFilteredUsersQuery($request);
        }

		if($request->has('role')){
			$users = $users->whereHas('roles', function($q) use	($request)
			{
				$q->where('name', $request->role);
			});
		}

		return datatables()->eloquent($users)
			->addColumn('role', function (User $user) {
				return ($user->roles->first())?$user->roles->first()->name:'';
			})
			->addColumn('isOnline', function (User $user) {
				return $user->isOnline();
			})
			->addColumn('status', function (User $user) {
				return $user->status->name;
			})
			->addColumn('lastOnline', function (User $user) {
				return $user->lastOnline();
			})
			->addColumn('priority', function (User $user) {
				return $user->getPriority();
			})
			->filterColumn('first_name', function($query, $keyword) {
				$query->whereRaw("CONCAT(`first_name`, ' ', `last_name`) like ?", ["%{$keyword}%"]);
			})
			->toJson();
	}

	public function expert(Request $request){
        if($request->submit == "excel"){
            return $this->exportGenerate($request);
        }elseif ($request->submit == "notification"){
            return $this->sendCustomNotification($request);
        }

        SEO::setTitle('Все Эксерты');
        AdminPageData::setPageName('Все Эксерты');
        AdminPageData::addBreadcrumbLevel('Пользователи','users');
        AdminPageData::addBreadcrumbLevel('Эксерты');

        $country = null;
        $region = null;
        $cities = [];
        $projects = [];
        $projectsExpert = [];
        $questions = [];

        if($request->has('filter.country')){
            $country = Country::where('id', $request->input('filter.country'))->first();
        }

        if($request->has('filter.region')){
            $region = Region::where('id', $request->input('filter.region'))->first();
        }

        if($request->has('filter.city')){
            $citiesArray = [];
            foreach ( $request->filter['city'] as $key => $item){
                $citiesArray[] = $request->input('filter.city')[$key];
            }
            $cities = City::whereIn('id', $citiesArray)->get();
        }

        if($request->has('filter.project')){
            $projectsArray = [];
            foreach ( $request->filter['project'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.project')[$key];
            }
            $projects = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.projectExpert')){
            $projectsArray = [];
            foreach ( $request->filter['projectExpert'] as $key => $item){
                $projectsArray[] = (int) $request->input('filter.projectExpert')[$key];
            }
            $projectsExpert = Project::whereIn('id', $projectsArray)->get();
        }

        if($request->has('filter.questions')){
            $questionsArray = [];
            foreach ( $request->filter['questions'] as $key => $item){
                $questionsArray[] = (int) $request->input('filter.questions')[$key];
            }
            $questions = Question::whereIn('id', $questionsArray)->get();
        }

        $statuses = UserStatus::where('lang', 'ru')->get();
        $ratingStatuses = UserRatingStatus::where('lang', 'ru')->get();
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

        return view('admin.users.all',[
            'role'=>'expert',
            'statuses'	=>	$statuses,
            'ratingStatuses'	=>	$ratingStatuses,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray,
            'country' => $country,
            'region' => $region,
            'cities' => $cities,
            'projects' => $projects,
            'projectsExpert' => $projectsExpert,
            'questions' => $questions
        ]);
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$users = User::orderBy('name')->where('name','like',$name.'%')->limit(5)->get();

		$formatted_users = [];

		foreach ($users as $user) {
			$formatted_users[] = ['id' => $user->id, 'text' => $user->name];
		}

		return \Response::json($formatted_users);
	}

	public function new(){
		SEO::setTitle('Новый пользователь');
		AdminPageData::setPageName('Новый пользователь');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Новый пользователь');

		return view('admin.users.new');
	}

	public function edit($user_id){
		SEO::setTitle('Редактирование пользователя');
		AdminPageData::setPageName('Редактирование пользователя');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Редактирование пользователя');

		return view('admin.users.edit',$this->getUserEditData($user_id));
	}

	public function profile(){
		$user_id = Auth::user()->id;

		SEO::setTitle('Профиль пользователя');
		AdminPageData::setPageName('Профиль пользователя');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Профиль пользователя');

		return view('admin.users.edit',$this->getUserEditData($user_id));
	}

	protected function getUserEditData($user_id){
		$user = User::withTrashed()->with(['roles','reviews','requests'])->withCount('requests')->find($user_id);

		/*$user->current_rating = $user->history->sum('score');
		$user->save();*/

		$countReviews = $user->reviews->count();
		$array = [];
		$array[] = 'user_id';
		$array[] = $user->id;
		$reviewFilter = json_encode($array);

		$countComments = $user->comments->count();
		$array = [];
		$array[] = 'user_id';
		$array[] = $user->id;
		$commentFilter = json_encode($array);

		$ratingStatus = UserRatingStatus::where([
			['rus_lang_id',0],
			['min','<=',$user->current_rating],
			['max','>=',$user->current_rating],
		])->first();
		/*$user->rang_id = $ratingStatus->id;
		$user->save();*/

		$statuses = UserStatus::all();

		$statusHistory = UserChangeStatuses::with(['status'])->where('user_id',$user_id)->get();

		return [
			"user"=>$user,
			"countReviews"=>$countReviews,
			"reviewFilter"=>$reviewFilter,
			'countComments' => $countComments,
			'commentFilter' => $commentFilter,
			'ratingStatus' => $ratingStatus,
			'statuses' => $statuses,
			'statusHistory' => $statusHistory,
		];
	}

	public function moderators (){
		$users = User::with(['roles'])->whereHas('roles', function($q)
		{
			$q->where('name', 'moderator');
		})->get();

		SEO::setTitle('Все Модераторы');
		AdminPageData::setPageName('Все Модераторы');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Модераторы');

		return view('admin.users.moderators',['users'=>$users]);
	}
	public function moderatorLogs ($user_id){
		$user = User::find($user_id);
		$log = UserLog::with(['user'])->where('user_id',$user_id)->get();
		$activeTimes = ModeratorActiveTime::where('user_id',$user_id)->orderBy('id','desc')->get();

		SEO::setTitle('Log Модератора: '.$user->name);
		AdminPageData::setPageName('Log Модератора: '.$user->name);
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel($user->name,'edit/'.$user->id);
		AdminPageData::addBreadcrumbLevel('Log');

		return view('admin.users.logs',[
			'logs'	=>	$log,
			'user'	=>	$user,
			'activeTimes'	=>	$activeTimes,
		]);
	}


	public function createUser(Request $request){
		$user = new User();
		$user->name = $request->login;
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->sex = $request->sex;
		$user->birsday = $request->birsday;
		$user->city_id = $request->city_id;
		$user->region_id = $request->region_id;
		$user->county_id = $request->county_id;
		$pass	= $request->password;
		$pass = Hash::make($pass);
		$user->password = $pass;
		$user->status_id = 1;
		$user->current_rating = 0;
		$user->rang_id = 1;


		if($request->hasFile('avatar')){
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->fit (250, 250)->save( public_path('/uploads/images/avatars/' . $filename ) );

			$user->avatar = $filename;
		}
		$user->save();
		$user->makeExployee($request->role);
		ModeratorLogs::addLog("Добавил пользователя: ".$request->login);

		return redirect()->route('adm_users_edit',$user->id);
	}

	public function saveUser(Request $request,$user_id){
		$user = User::withTrashed()->with(['roles'])->find($user_id);
		$user->name = $request->login;
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->sex = $request->sex;

		$user->birsday = $request->birsday;
		if(!$request->has('county_id')){
            $user->city = $request->city;
            $user->region = $request->region;
        }else{
            $user->city_id = $request->city_id;
            $user->region_id = $request->region_id;
            $user->county_id = $request->county_id;
        }

		$user->status_id = 1;
		$user->isNewsletter = $request->has('isNewsletter');

		$pass	= $request->password;
		if(isset($pass)){
			$pass = Hash::make($pass);
			$user->password = $pass;
		}
		if($request->hasFile('avatar')){
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->fit (250, 250)->save( public_path('/uploads/images/avatars/' . $filename ) );

			$user->avatar = $filename;
		}

		$user->save();
		$user->makeExployee($request->role);
		ModeratorLogs::addLog("Отредактировал пользователя: ".$request->login);

		return redirect()->route('adm_users_edit',$user->id);
	}

	public function delete($user_id){
		$user = User::find($user_id);
        $user->delete();
		/*
		$reviews = Review::where('user_id',$user_id)->get();
		foreach ($reviews as $review){
			Review\Comment::where('review_id',$review->id)->delete();
			Review\ReviewLike::where('review_id',$review->id)->delete();
			$review->delete();
		}
		Review\Comment::where('user_id',$user_id)->delete();

		$requests = ProjectRequest::where('user_id',$user_id)->get();
		foreach ($requests as $request){
			Answer::where('project_request_id',$request->id)->delete();
			UserShipping::where('request_id',$request->id)->delete();
			$request->delete();
		}
		ModeratorActiveTime::where('user_id',$user_id)->delete();

		$posts = Post::where('author_id',$user_id)->get();
		foreach ($posts as $post){
			Post\PostComment::where('post_id',$post->id)->delete();
			Post\PostTag::where('post_id',$post->id)->delete();
			$post->delete();
		}
		Post\PostComment::where('user_id',$user_id)->delete();

		ProjectMessage::where('user_id',$user_id)->delete();

		UserChangeStatuses::where('user_id',$user_id)->delete();
		UserLog::where('user_id',$user_id)->delete();
		UserNotification::where('user_id',$user_id)->delete();
		UserPresents::where('user_id',$user_id)->delete();
		UserRatingHistory::where('user_id',$user_id)->delete();*/

		return "ok";
	}

	public function hide($user_id){
		$user = User::find($user_id);
		$user->isHide = true;
		$user->save();
		return "ok";
	}
	public function show($user_id){
		$user = User::find($user_id);
		$user->isHide = false;
		$user->save();
		return "ok";
	}

	public function change_status(Request $request,$user_id){
		$user = User::withTrashed()->find($user_id);

		$userOldStatuse = UserChangeStatuses::all();
		foreach ($userOldStatuse as $userOldStatus){
			$userOldStatus->isEnd = true;
			$userOldStatus->save();
		}

		$userChangeStatus = new UserChangeStatuses();
		$userChangeStatus->note = $request->note;
		$userChangeStatus->next_status_id = $user->status_id;
		$userChangeStatus->user_id = $user->id;
		$userChangeStatus->status_id = $request->status;

		if($request->unlock_time == -1){
			$userChangeStatus->isForLife = true;
		}else{
			$userChangeStatus->unlock_time = (Carbon::now())->addMinutes($request->unlock_time);
		}
		$userChangeStatus->save();

		$user->status_id	=	$request->status;
		$user->save();

		ModeratorLogs::addLog("Сменил статус пользователя: ".$user->login);

		return redirect()->route('adm_users_edit',['user_id'	=>	$user_id]);
	}

	public function end_status($status_id){

		$userStatus = UserChangeStatuses::with(['user'])->find($status_id);
		$userStatus->isEnd = true;
		$userStatus->user->status_id = $userStatus->next_status_id;
		$userStatus->user->save();
		$userStatus->save();

		ModeratorLogs::addLog("Досрочно изменил статус пользователя: ".$userStatus->user->login);

		return 'ok';
	}


	public function statusesLog(){
		SEO::setTitle('Лог смены статусов');
		AdminPageData::setPageName('Лог смены статусов');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Лог смены статусов');

		return view('admin.users.statuses_log');
	}
	public function statusesLog_ajax(){
		$userChangeStatuses = UserChangeStatuses::with(['user.status','status'])
		->where('isEnd',false);

		return datatables()->eloquent($userChangeStatuses)
			->addColumn('user', function (UserChangeStatuses $userChangeStatus) {
				return $userChangeStatus->user->name;
			})
			->addColumn('status', function (UserChangeStatuses $userChangeStatus) {
				return $userChangeStatus->user->status->name;
			})

			->toJson();
	}

	public function export(){
		SEO::setTitle('Экспорт пользователей');
		AdminPageData::setPageName('Экспорт пользователей');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Экспорт пользователей');

		$statuses = UserStatus::where('lang', 'ru')->get();
		$ratingStatuses = UserRatingStatus::where('lang', 'ru')->get();
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

		return view('admin.users.export',[
			'statuses'	=>	$statuses,
			'ratingStatuses'	=>	$ratingStatuses,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray
		]);
	}

	public function exportTable()
	{
		SEO::setTitle('Все пользователи');
		AdminPageData::setPageName('Все пользователи');
		AdminPageData::addBreadcrumbLevel('Пользователи');

		return view('admin.users.export_table');
	}

	/*public function exportGenerate(Request $request){
		$excel = new UserExport($request);
		$excel->store('usres/users_'.time().'.xlsx','public_uploads');
		return $excel->download('users_'.time().'.xlsx');
	}*/

	public function exportGenerate(Request $request){
		$excel = new UserExport($request);
		//$excel->store('usres/users_'.time().'.xlsx','public_uploads');
		return $excel->download('users_'.time().'.xlsx');
	}

	/*public function exportGenerate(Request $request){

		(new UserExport($request))->queue('users/users_'.Carbon::now()->format('i.h d.m.Y').'.xlsx','public_uploads');

		return back()->withSuccess('Экспорт пользователей Начался!');
	}*/

	public function delete_ratting(Request $request,$user_id){
		$user = User::withTrashed()->find($user_id);
		UserRating::addAction($request->fine,$user);

		return redirect()->route('adm_users_edit',[$user_id]);
	}

	public function add_ratting(Request $request,$user_id){
		$user = User::withTrashed()->find($user_id);
		UserRating::newAction($request,$user);

		return redirect()->route('adm_users_edit',[$user_id]);
	}

	private function sendCustomNotification(Request $request){
	    $users = UserFilterServices::getFilteredUsersQuery($request);
	    $users = $users->orderBy('id');

	    $text = $request->hello_text.' :user_name: '.$request->notification_text;
	    $data = [
	        'text' => $text,
            'request' => $request->toArray()
        ];

	    $queue = new Queue();
        $queue->name = 'user_custom_notification';
        $queue->start = $users->first()->id;
        $queue->data = serialize($data);
        $queue->save();

        return redirect()->route('adm_users_notification_send');
    }

    public function notificationSend()
    {
        SEO::setTitle('Сообщение отправленно');
        AdminPageData::setPageName('Сообщение отправленно');
        AdminPageData::addBreadcrumbLevel('Пользователи','users');
        AdminPageData::addBreadcrumbLevel('Сообщение отправленно');

        return view('admin.users.notification');
    }
}
