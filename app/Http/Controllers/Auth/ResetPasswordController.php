<?php

namespace App\Http\Controllers\Auth;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Model\Page;
use SEO;
use SEOMeta;
use OpenGraph;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showEmailForm(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','password/reset'],
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

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('password.request'));

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

		return view('auth.passwords.email',[
			'page' => $page,
			'alternet_url'	=> $alternet_url
		]);
	}

	public function showResetForm(Request $request, $token = null)
	{
		$locale = App::getLocale();

		$page = Page::where([
			['url','password/reset'],
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

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('password.reset',[$token]));

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

		return view('auth.passwords.reset')->with(
			[
				'token' => $token,
				'email' => $request->email,
				'page' => $page,
				'alternet_url'	=> $alternet_url
			]
		);
	}
	protected function sendResetResponse(Request $request, $response)
	{
		return redirect()->route('user.cabinet')
			->with('status', trans($response));
	}
}
