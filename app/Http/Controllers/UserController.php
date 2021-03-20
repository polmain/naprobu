<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Cookie;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\EmailVerify;
use App\Model\User\UserRatingStatus;
use App\Model\User\UserRatingHistory;
use App\Model\User\UserNotification;
use App\Model\User\UserPresents;
use App\Model\User\UserCountry;
use App\Model\User\UserRegion;
use App\Model\User\UserCity;
use App\Model\Project\ProjectRequest;
use App\Model\Review;
use App\Model\Review\Comment;
use App\Model\Review\ReviewLike;
use App\User;
use App\Library\Users\UserRating;

use SEO;
use SEOMeta;
use OpenGraph;

class UserController extends Controller
{

	public function index(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();
		$ratingStatuses = UserRatingStatus::with(['translate'])->where('lang','ru')->get();

		$locale = App::getLocale();
		$countries = App\Model\User\UserCountry::all();
		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_main_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_main_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('user.cabinet'));

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

    	return view('user.main',[
    		'userLikes' => $userLikes,
    		'ratingStatuses' => $ratingStatuses,
			'alternet_url' => $alternet_url,
			'countries' => $countries,
		]);
	}

	public function rating(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();
		$ratingStatuses = UserRatingStatus::with(['translate'])->where('lang','ru')->get();
		$userRatings = UserRatingHistory::with(['rating_action.translate'])->where('user_id',$user->id)->orderBy('id','desc')->paginate(5);


		if ($request->ajax()) {
			$view = view('user.include.rating_item',compact('userRatings'))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $userRatings->nextPageUrl() == false
				]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_rating_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_rating_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		$url = ($userRatings->previousPageUrl())?route('user.rating',['page'=>$userRatings->currentPage()]):route('user.rating');
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

    	return view('user.rating',[
    		'userLikes' => $userLikes,
    		'ratingStatuses' => $ratingStatuses,
    		'userRatings' => $userRatings,
			'alternet_url' => $alternet_url
		]);
	}

	public function project(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$locale = App::getLocale();

		$projects	=	ProjectRequest::whereHas('project',function($prj) use ($locale){
			$prj->where([
				['isHide',0],
			]);
		})->where('user_id',$user->id)->orderBy('id','desc')->paginate(15);

		if ($request->ajax()) {
			$view = view('project.include.project_item_user',compact('projects'))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $projects->nextPageUrl() == false
			]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_project_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_project_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		$url = ($projects->previousPageUrl())?route('user.project',['page'=>$projects->currentPage()]):route('user.project');
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.project',[
			'userLikes' => $userLikes,
			'projects'	=>	$projects,
			'lang'	=> $locale,
			'alternet_url' => $alternet_url
		]);

	}

	public function review(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$reviews	=	Review::with(['user.roles','visibleComments.user.roles','likes'])->where([
			['user_id',$user->id],
			['status_id', 2],
			['isHide',0],
		])->orderBy('id','desc')->paginate(5);


		if ($request->ajax()) {
			$view = view('review.include.review_item_user',compact(['reviews']))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $reviews->nextPageUrl() == false
			]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_review_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_review_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		$url = ($reviews->previousPageUrl())?route('user.review',['page'=>$reviews->currentPage()]):route('user.review');
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.review',[
			'userLikes' => $userLikes,
			'reviews' => $reviews,
			'alternet_url' => $alternet_url
		]);
	}

	public function notification(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$notifications = UserNotification::with(['type'])->where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
		foreach ($notifications->where('isNew',1) as $notification){
			$notification->isNew = 0;
			$notification->save();
		}
		if ($request->ajax()) {
			$view = view('user.include.notification_page',compact(['notifications']))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $notifications->nextPageUrl() == false
			]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_notification_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_notification_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		$url = ($notifications->previousPageUrl())?route('user.notification',['page'=>$notifications->currentPage()]):route('user.notification');
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.notification',[
			'userLikes' => $userLikes,
			'notifications' => $notifications,
			'alternet_url' => $alternet_url
		]);
	}

	public function setting(Request $request){
		$user = Auth::user();
		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_setting_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','user_setting_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		$url = route('user.setting');
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.setting',[
			'userLikes' => $userLikes,
			'alternet_url' => $alternet_url
		]);
	}

	public function profile(Request $request, $id){
		$user = User::find($id);

		if(empty($user)){
			return abort(404);
		}

		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$reviews	=	Review::with(['user.roles','visibleComments.user.roles','likes'])->where([
			['user_id',$user->id],
			['status_id', 2],
			['isHide',0],
		])->orderBy('id','desc')->paginate(5);


		if ($request->ajax()) {
			$view = view('review.include.review_item_profile',compact(['reviews']))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $reviews->nextPageUrl() == false
			]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','profile_review_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','profile_review_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';

		$url = ($reviews->previousPageUrl())?route('profile',['id'=>$id,'page'=>$reviews->currentPage()]):route('profile',['id'=>$id]);
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.profile.index',[
			'user'		=> $user,
			'userLikes' => $userLikes,
			'reviews'	=> $reviews,
			'alternet_url' => $alternet_url
		]);
	}

	public function profileComment(Request $request, $id){
		$user = User::find($id);

		if(empty($user)){
			return abort(404);
		}

		$userLikes = ReviewLike::with(['review'])->whereHas('review',function ($review) use ($user){
			$review->where('user_id',$user->id);
		})->count();

		$comments = Comment::with('review.user.roles','review.likes')->where(
			[
				['isHide',0],
				['user_id',$user->id],
				['status_id',2],
			]
		)->orderBy('id','desc')->paginate(5);


		if ($request->ajax()) {
			$view = view('review.include.review_item_profile_comment',compact(['comments']))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $comments->nextPageUrl() == false
			]);
		}

		$locale = App::getLocale();

		$title = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','profile_comment_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':user_name:',$user->name, \App\Model\Setting::where([['name','profile_comment_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';

		$url = ($comments->previousPageUrl())?route('profile.comment',['id'=>$id,'page'=>$comments->currentPage()]):route('profile.comment',['id'=>$id]);
		//разбиваем на массив по разделителю
		$segments = explode('/', $url);

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		return view('user.profile.comment',[
			'user'		=> $user,
			'userLikes' => $userLikes,
			'comments'	=> $comments,
			'alternet_url' => $alternet_url
		]);
	}

	public function ref(Request $request, $id){
		if(!$request->hasCookie('ref_id')){
			if(User::findOrFail($id)){
				Cookie::queue('ref_id',$id, 10080);
			}
		}

		return redirect()->route('home');
	}

	public function getPresent(Request $request){
		$userPercent = UserPresents::find($request->present_id);
		$userPercent->isGet = 1;
		$userPercent->save();
	}

	public function ban(){
		$user = Auth::user();

		return view('user.ban',[
			'user' => $user
		]);
	}

	public function dataSave(Request $request){
		$user = Auth::user();

		$user->last_name = $request->last_name;
		$user->first_name = $request->first_name;
		$user->patronymic = $request->patronymic;
		$user->sex = $request->sex;
		$user->birsday = $request->birsday;
		$user->country = $request->country;
		$user->region = $request->region;
		$user->city = $request->city;
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->password = Hash::make($request->password);
		if($user->email != $request->email){
			if(empty($user->email)){
				UserRating::addAction('email',$user);
			}
			$user->email = $request->email;
			$user->status_id = 5;
		}

		$user->save();

		if(
			isset($request->last_name)
			&& isset($request->first_name)
			&& isset($request->birsday)
			&& isset($request->country)
			&& isset($request->region)
			&& isset($request->city)
			&& isset($request->name)
			&& isset($request->email)
			&& isset($request->phone)
			&& !$user->hasRole('expert')
		){
			$user->makeExployee('expert');
		}

		return redirect()->route('user.cabinet');
	}

	public function settingSave(Request $request){
		$user = Auth::user();

		$user->isNewsletter = $request->has('isNewsletter');

		if($request->hasFile('avatar')){
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->fit (250, 250)->save( public_path('/uploads/images/avatars/' . $filename ) );

			$user->avatar = $filename;
		}

		$user->save();

		return redirect()->route('user.setting');
	}

	public function isNameRegister(Request $request){
		

		$name = $request->name;
		$user = User::where('name',$name)->where('id','<>',Auth::user()->id)->first();
		if(!empty($user)){
			return 'false';
		}
		return "true";
	}

	public function isEmailRegister(Request $request){


		$email = mb_strtolower($request->email);
		$user = User::where('email',$email)->where('id','<>',Auth::user()->id)->first();
		if(!empty($user)){
			return 'false';
		}
		return "true";
	}

	public function parseCountry(){
		$json = @file_get_contents( ("http://geohelper.info/api/v1/countries?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=ru"));
		$countries = json_decode($json)->result;

		foreach($countries as $country){
			UserCountry::create([
				'name_ru'	=> $country->name,
				'geohelper' => $country->id,
				'iso'		=> $country->iso
			]);
		}

		$json = @file_get_contents( ("http://geohelper.info/api/v1/countries?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=uk"));
		$countries = json_decode($json)->result;

		foreach($countries as $country){
			$userCountry = UserCountry::where('geohelper', $country->id)->first();
			$userCountry->name_ua = $country->name;
			$userCountry->save();
		}

		return 'ok';
	}

	public function parceRegion(Request $request){
		$json = @file_get_contents( "http://geohelper.info/api/v1/regions?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=ru&filter%5BcountryIso%5D=ua&pagination%5Blimit%5D=100");
		$regions = json_decode($json)->result;

		foreach($regions as $region){
			UserRegion::create([
				'name_ru'	=> $region->name,
				'geohelper' => $region->id,
				'iso'		=> $region->id,
				'country_id'=> 215
			]);
		}

		$json = @file_get_contents( "http://geohelper.info/api/v1/regions?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=uk&filter%5BcountryIso%5D=ua&pagination%5Blimit%5D=100");
		$regions = json_decode($json)->result;

		foreach($regions as $region){
			$userRegion = UserRegion::where('geohelper', $region->id)->first();
			$userRegion->name_ua = $region->name;
			$userRegion->save();
		}

		return 'ok';
	}

	public function parseCity($id){
		$region = UserRegion::find($id);

		$json = @file_get_contents( "http://geohelper.info/api/v1/cities?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=ru&filter%5BregionId%5D=".$region->iso."&pagination%5Blimit%5D=100");
		$data = json_decode($json);

		$prevCity = "";

		for($i = 1;$i <= $data->pagination->totalPageCount; $i++){
			$json = @file_get_contents( "http://geohelper.info/api/v1/cities?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=ru&filter%5BregionId%5D=".$region->iso."&pagination%5Blimit%5D=100&pagination%5Bpage%5D=".$i);
			$cities = json_decode($json)->result;
			$citiesArr = [];
			foreach($cities as $city){
				if($prevCity != $city->name){
					$citiesArr[] = [
						'name_ru'	=> $city->name,
						'name_ua'	=> $city->localizedNames->uk,
						'geohelper' => $city->id,
						'region_id'	=> $region->id
					];
				}
				$prevCity = $city->name;
			}
			UserCity::insert($citiesArr);
		}

		return 'ok';
	}

	/*public function getRegion(Request $request){
		$lang = $request->lang;
		$country = $request->country;


		$json = @file_get_contents( "http://geohelper.info/api/v1/regions?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=".$lang."&filter%5BcountryIso%5D=".$country."&pagination%5Blimit%5D=100");
		$regions = json_decode($json)->result;
		return response()->json([
			'data' => $regions,
			'result' => 'ok'
		]);
	}*/

	public function getRegion(Request $request){
		$lang = $request->lang=='uk'?'ua':'ru';
		$country = UserCountry::where('iso',$request->country)->first();

		$regions = UserRegion::select('name_'.$lang.' as name','iso as id')->where('country_id',$country->id)->get();

		return response()->json([
			'data' => $regions,
			'result' => 'ok'
		]);
	}

	/*public function getCity(Request $request){
		$lang = $request->lang;
		$region = $request->region;

		$json = @file_get_contents( "http://geohelper.info/api/v1/cities?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=".$lang."&filter%5BregionId%5D=".$region."&pagination%5Blimit%5D=100");
		$data = json_decode($json);

		$regions = $data->result;
		for($i = 2;$i <= $data->pagination->totalPageCount; $i++){
			$json = @file_get_contents( "http://geohelper.info/api/v1/cities?apiKey=3QttKHWMyRfJwNXTPqmYiEHga0tuew7I&locale%5Blang%5D=".$lang."&filter%5BregionId%5D=".$region."&pagination%5Blimit%5D=100&pagination%5Bpage%5D=".$i);
			$regions = array_merge($regions,json_decode($json)->result);
		}

		return response()->json([
			'data' => $regions,
			'result' => 'ok'
		]);
	}*/

	public function getCity(Request $request){
		$lang = $request->lang=='uk'?'ua':'ru';
		$region = UserRegion::where('iso',$request->region)->first();

		$cities = UserCity::select('name_'.$lang.' as name')->where('region_id',$region->id)->orderBy('name_'.$lang)->get();

		return response()->json([
			'data' => $cities,
			'result' => 'ok'
		]);
	}
}
