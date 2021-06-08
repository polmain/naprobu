<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Library\Users\UserRating;
use App\Model\Post;
use App\Model\Project\ProjectMessage;
use App\Model\Project\ProjectRequest;
use App\Model\Questionnaire\Answer;
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

	public function all(){
		SEO::setTitle('Все пользователи');
		AdminPageData::setPageName('Все пользователи');
		AdminPageData::addBreadcrumbLevel('Пользователи');

		return view('admin.users.all');
	}

	public function all_archive()
    {
        SEO::setTitle('Архив');
        AdminPageData::setPageName('Архив');
        AdminPageData::addBreadcrumbLevel('Пользователи','users');
        AdminPageData::addBreadcrumbLevel('Архив');

        return view('admin.users.all',['isArchive' => true]);
    }

	public function all_ajax(Request $request){
        if($request->input('isArchive') == 1){
            $users = User::with(['roles','status'])->onlyTrashed();
        }else{
            $users = User::with(['roles','status']);
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
			->filterColumn('first_name', function($query, $keyword) {
				$query->whereRaw("CONCAT(`first_name`, ' ', `last_name`) like ?", ["%{$keyword}%"]);
			})
			->toJson();
	}

	public function expert(){


		SEO::setTitle('Все Эксерты');
		AdminPageData::setPageName('Все Эксерты');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Эксерты');

		return view('admin.users.all',['role'=>'expert']);
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
		if($request->has('city') && $request->has('region')){
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

		$statuses = UserStatus::all();

		return view('admin.users.export',[
			'statuses'	=>	$statuses
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
}
