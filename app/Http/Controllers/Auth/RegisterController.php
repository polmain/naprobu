<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Entity\Collection\CountryCollection;
use App\Entity\EducationEnum;
use App\Entity\EmploymentEnum;
use App\Entity\FamilyStatusEnum;
use App\Entity\HobbiesEnum;
use App\Entity\MaterialConditionEnum;
use App\Entity\WorkEnum;
use App\Services\LanguageServices\AlternativeUrlService;
use Cookie;
use App\Library\Users\UserRating;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\EmailVerification;
use Illuminate\Http\Request;

use App\Model\Page;
use SEO;
use SEOMeta;
use OpenGraph;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


	public function showRegistrationForm(Request $request)
	{
		$locale = App::getLocale();

		$countries = App\Model\User\UserCountry::all();

        $educationArray = EducationEnum::toArray();
        $employmentArray = EmploymentEnum::toArray();
        $workArray = WorkEnum::toArray();
        $familyStatusArray = FamilyStatusEnum::toArray();
        $materialConditionArray = MaterialConditionEnum::toArray();
        $hobbiesArray = HobbiesEnum::toArray();

		$page = Page::where([
			['url','registration'],
			['lang',$locale],
		])->first();

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

        $routes = AlternativeUrlService::generateReplyRoutes('registration/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('auth.register',[
			'page' => $page,
			'alternativeUrls' => $alternativeUrls,
			'countries'	=> $countries,
			'educationArray'	=> $educationArray,
			'employmentArray'	=> $employmentArray,
			'workArray'	=> $workArray,
			'familyStatusArray'	=> $familyStatusArray,
			'materialConditionArray'	=> $materialConditionArray,
			'hobbiesArray'	=> $hobbiesArray,
		]);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'lang' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
	{
		$user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status_id' => 5,
			'current_rating' => 0,
			'rang_id' => 1,
			'lang' => $data['lang']
        ]);
        return $user;
    }

	/**
	 * The user has been registered.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function registered(Request $request, $user)
	{
		$locale = App::getLocale();

		$this->user_rating($user);
		$user->makeExployee('user');


		EmailVerification::sendVerifyCode($user);

		if($request->hasCookie('ref_id')){
			$ref_owner = User::find(Cookie::get('ref_id'));
			UserRating::addAction('friend',$ref_owner);
		}

		$this->guard()->logout();

        $routes = AlternativeUrlService::generateReplyRoutes('');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('message',[
			'header'	=>	trans('page_message.registered_header'),
			'message'	=>	trans('page_message.registered_message',['email' => $user->email]),
			'alternativeUrls' => $alternativeUrls
		]);
	}

	protected function user_rating($user){
		UserRating::addAction('register',$user);
		UserRating::addAction('email',$user);
	}

}
