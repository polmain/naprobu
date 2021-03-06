<?php

namespace App\Http\Controllers;

use App;
use App\Entity\Collection\CountryCollection;
use App\Entity\EducationEnum;
use App\Entity\EmploymentEnum;
use App\Entity\FamilyStatusEnum;
use App\Entity\HobbiesEnum;
use App\Entity\MaterialConditionEnum;
use App\Entity\WorkEnum;
use App\Model\Geo\City;
use App\Model\Geo\Region;
use App\Services\LanguageServices\AlternativeUrlService;
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

		$defaultCountry = App\Model\Geo\Country::find(637);
        $educationArray = EducationEnum::values();
        $employmentArray = EmploymentEnum::values();
        $workArray = WorkEnum::values();
        $familyStatusArray = FamilyStatusEnum::values();
        $materialConditionArray = MaterialConditionEnum::values();
        $hobbiesArray = HobbiesEnum::values();

		$locale = App::getLocale();
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

		$url = 'cabinet/';
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('user.main',[
    		'userLikes' => $userLikes,
    		'ratingStatuses' => $ratingStatuses,
			'alternativeUrls' => $alternativeUrls,
            'educationArray'	=> $educationArray,
            'employmentArray'	=> $employmentArray,
            'workArray'	=> $workArray,
            'familyStatusArray'	=> $familyStatusArray,
            'materialConditionArray'	=> $materialConditionArray,
            'hobbiesArray'	=> $hobbiesArray,
            'defaultCountry'	=> $defaultCountry
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

        $url = 'cabinet/rating/'.($userRatings->previousPageUrl()?'?page='.$userRatings->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('user.rating',[
    		'userLikes' => $userLikes,
    		'ratingStatuses' => $ratingStatuses,
    		'userRatings' => $userRatings,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'cabinet/project/'.($projects->previousPageUrl()?'?page='.$projects->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.project',[
			'userLikes' => $userLikes,
			'projects'	=>	$projects,
			'lang'	=> $locale,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'cabinet/review/'.($reviews->previousPageUrl()?'?page='.$reviews->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.review',[
			'userLikes' => $userLikes,
			'reviews' => $reviews,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'cabinet/notification/'.($notifications->previousPageUrl()?'?page='.$notifications->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.notification',[
			'userLikes' => $userLikes,
			'notifications' => $notifications,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'cabinet/setting/';
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.setting',[
			'userLikes' => $userLikes,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'profile/'.$id.'/'.($reviews->previousPageUrl()?'?page='.$reviews->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.profile.index',[
			'user'		=> $user,
			'userLikes' => $userLikes,
			'reviews'	=> $reviews,
			'alternativeUrls' => $alternativeUrls
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

        $url = 'profile/comment/'.$id.'/'.($comments->previousPageUrl()?'?page='.$comments->currentPage():'');
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('user.profile.comment',[
			'user'		=> $user,
			'userLikes' => $userLikes,
			'comments'	=> $comments,
			'alternativeUrls' => $alternativeUrls
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

		$country_id = $request->country_id;
        $user->country_id = $country_id;

        $region_id = $request->region_id !== 'other' ? $request->region_id : null;
		if($request->new_region != ""){
            $region = new Region();
            $region->name = $request->new_region;
            $region->lang = 'ru';
            $region->rus_lang_id = 0;
            $region->country_id = $country_id;
            $region->is_verify = false;
            $region->save();

            $region_id = $region->id;
        }
        $user->region_id = $region_id;

        $city_id = $request->city_id;
        if($request->new_city != ""){
            $city = new City();
            $city->name = $request->new_city;
            $city->lang = 'ru';
            $city->rus_lang_id = 0;
            $city->country_id = $country_id;
            $city->region_id = $region_id;
            $city->is_verify = false;
            $city->save();

            $city_id = $city->id;
        }
        $user->city_id = $city_id;

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

        $user->nova_poshta_city = $request->nova_poshta_city_name;
        $user->nova_poshta_warehouse = $request->nova_poshta_warehouse;

        $user->education = $request->education;
        $user->employment = $request->employment;
        $user->family_status = $request->family_status;
        $user->material_condition = $request->material_condition;
        $user->hobbies = $request->hobbies;
        $user->hobbies_other = $request->hobbies_other;

        if(EmploymentEnum::getInstance($request->employment)->isWork()){
            $user->work = $request->work;
        }else{
            $user->work = null;
        }

		$user->new_form_status = true;

		$user->save();

		if(!$user->hasRole('expert')){
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

	public function isPhoneRegister(Request $request){
		$phone = $request->phone;
		$user = User::where('phone',$phone)->where('id','<>',Auth::user()->id)->first();
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
	    if($request->lang === 'en'){
            return response()->json([
                'data' => null,
                'result' => 'not_found'
            ]);
        }

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
        if($request->lang === 'en'){
            return response()->json([
                'data' => null,
                'result' => 'not_found'
            ]);
        }

		$lang = $request->lang=='uk'?'ua':'ru';
		$region = UserRegion::where('iso',$request->region)->first();

		$cities = UserCity::select('name_'.$lang.' as name')->where('region_id',$region->id)->orderBy('name_'.$lang)->get();

		return response()->json([
			'data' => $cities,
			'result' => 'ok'
		]);
	}
}
