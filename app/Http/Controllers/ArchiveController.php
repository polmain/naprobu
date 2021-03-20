<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Post;
use App\Model\Page;
use SEO;
use SEOMeta;
use OpenGraph;


class ArchiveController extends Controller
{
    public function index(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','archive'],
			['lang',$locale],
		])->first();

		$projects = Project::where([
			['lang',$locale],
			['isHide',0],
			['type','<>','only-blogger'],
		])->orderBy('start_registration_time','desc')->get();

		$posts = Post::where([
				['lang',$locale],
				['isHide',0],
			])->orderBy('id','desc')
			->get();

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
		$segments = explode('/', route('archive'));

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

		return view('archive',[
			'projects'	=>	$projects,
			'posts'	=>	$posts,
			'page'	=>	$page,
			'alternet_url' => $alternet_url
		]);
	}

	public function sitemap(Request $request){

		$categories = ProjectCategory::where([
			['lang','ru'],
			['isHide',0],
		])->get();

		$projects = Project::where([
			['lang','ru'],
			['isHide',0],
			['type','<>','only-blogger'],
		])->orderBy('start_registration_time','desc')->get();

		$posts = Post::where([
			['lang','ru'],
			['isHide',0],
		])->orderBy('id','desc')
			->get();



		return response()->view('sitemap', compact(['projects','posts','categories']))->header('Content-Type', 'text/xml');
	}
}
