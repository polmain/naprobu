<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Mail\PartnerNotificationMail;
use App\Model\Project;
use App\Model\Review;
use App\Model\Post;
use App\Model\Page;
use App\Model\Page\Block;
use App\Model\Page\Brand;
use App\Model\Feedback;
use App\Model\Faq\FaqCategory;
use Illuminate\Support\Facades\Mail;
use App\User;
use PageBlock;
use SEO;
use SEOMeta;
use OpenGraph;

class MainController extends Controller
{
    private const FAKE_PROJECT_COUNT_INCREMENTER = 37;
    private const OPEN_GRAPH_IMAGE_WIDTH = 350;
    private const OPEN_GRAPH_IMAGE_HEIGHT = 220;

    public function home(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','/'],
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
				'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
				'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);

    	$projects = Project::where([
    		['lang',$locale],
    		['isHide',0],
    		['status_id','<>',3],
    		['status_id','<>',10],
			['type','<>','only-blogger'],
		])->orderBy('start_registration_time','desc')->limit(6)->get();

		$project_count = Project::where([
			['lang','ru'],
			['isHide',0],
			['status_id','<>',3],
		])->count() + self::FAKE_PROJECT_COUNT_INCREMENTER;

    	$reviews = Review::with(['user.roles','subpage.project.translate'])
			->where([
				['isMainReview',1],
				['isHide',0],
			])
			->orderBy('id','desc')
			->limit(12)
			->get();

		$review_count = Review::with(['subpage'])->where([
							['status_id',2],
							['isHide',0],
						])->whereHas('subpage', function ($review){
							$review->where('type_id',1);
						})->count();

		$expert_count = User::with(['roles'])->whereHas('roles', function($q) {
								$q->where('name', 'expert');
							})->count();

    	$posts = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])->where([
				['lang','ru'],
				['isHide',0],
			])->orderBy('created_at','desc')
			->limit(4)
			->get();

		$brands = Brand::where([
			['lang',$locale],
			['isHide',0],
		])->get();



		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('home'));

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

    	return view('home',[
    		'projects'	=>	$projects,
    		'reviews'	=>	$reviews,
    		'posts'	=>	$posts,
    		'brands'	=>	$brands,
    		'project_count'	=>	$project_count,
    		'review_count'	=>	$review_count,
    		'expert_count'	=>	$expert_count,
			'alternet_url'	=> $alternet_url,
		]);
	}

	public function about(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','about'],
			['lang',$locale],
		])->first();

		$base = ($locale == 'ru')? $page : $page->base;

		$blocks = Block::where([
			['page_id', $base->id],
			['lang',$locale]
		])->get();

		$brands = Brand::where([
			['lang',$locale],
			['isHide',0],
		])->get();

		PageBlock::setBlocks($blocks);

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
                'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
                'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('about'));

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

    	return view('about',[
    		'page' => $page,
    		'brands' => $brands,
			'alternet_url' => $alternet_url
		]);
	}

	public function faq(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','faq'],
			['lang',$locale],
		])->first();

		$faqCategories = FaqCategory::with(['translate','questions.translate'])->where([
			['lang','ru'],
			['isHide',0],
		])->orderBy('sort')->get();

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
                'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
                'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);
		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('faq'));

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

    	return view('faq',[
    		'page' => $page,
    		'faqCategories' => $faqCategories,
			'alternet_url' => $alternet_url
		]);
	}

	public function contact(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','contact'],
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
                'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
                'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('contact'));

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

    	return view('contact',[
    		'page' => $page,
			'alternet_url' => $alternet_url
		]);
	}

	public function partner(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','partner'],
			['lang',$locale],
		])->first();

		$base = ($locale == 'ru')? $page : $page->base;

		$blocks = Block::where([
			['page_id', $base->id],
			['lang',$locale]
		])->get();

		PageBlock::setBlocks($blocks);

		$brands = Brand::where([
			['lang',$locale],
			['isHide',0],
		])->get();

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
                'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
                'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('partner'));

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

		return view('b2b',[
			'page' => $page,
			'brands' => $brands,
			'alternet_url' => $alternet_url
		]);
	}

	public function simple(Request $request,$url){
		$locale = App::getLocale();

		$page = Page::where([
			['url',$url],
			['lang',$locale],
		])->first();

		if(empty($page)){
			abort(404);
		}

		$base = ($locale == 'ru')? $page : $page->base;

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
                'width' => self::OPEN_GRAPH_IMAGE_WIDTH,
                'height' => self::OPEN_GRAPH_IMAGE_HEIGHT
			]
		);


		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('simple',$page->url));

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

		return view('message',[
			'header' => $page->name,
			'message' => $page->content,
			'alternet_url' => $alternet_url
		]);
	}

	public function feedback(Request $request){
    	if($request->text){
			$feedback = new Feedback();
			$feedback->name = $request->name;
			$feedback->email = $request->email;
			$feedback->subject = $request->subject;
			$feedback->text = $request->text;
			$feedback->save();

			return 'OK';
		}else{
    		return 'Error';
		}

	}

	public function partnerSend(Request $request){
        $body = "";
        $body.= "<strong>Ваше ім`я:</strong> ".$request->name."<br>";
        $body.= "<strong>Ваш E-mail:</strong> ".$request->email."<br>";
        $body.= "<strong>Ваш телефон:</strong> ".$request->phone."<br>";

        Mail::to("influence@burda.ua")->send(new PartnerNotificationMail($request->subject, $body));

        return 'OK';
    }
}
