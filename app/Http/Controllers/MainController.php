<?php

namespace App\Http\Controllers;

use App;
use App\Entity\ProjectAudienceEnum;
use App\Services\LanguageServices\AlternativeUrlService;
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
        $international = $request->get('international');
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

		$audience = ProjectAudienceEnum::UKRAINE;
		if($international){
            $audience = ProjectAudienceEnum::WORD;
        }

    	$projects = Project::where([
    		['lang',$locale],
    		['isHide',0],
    		['status_id','<>',3],
    		['status_id','<>',10],
			['type','<>','only-blogger'],
            ['audience',$audience],
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

		$expert_count = User::withTrashed()->with(['roles'])->whereHas('roles', function($q) {
								$q->where('name', 'expert');
							})->count();

		if($locale === 'ru'){
            $posts = Post::with(['project.category.translate'])->where([
                    ['lang',$locale],
                    ['isHide',0]
                ])
                ->withCount(['visible_comments'])->where([
                    ['lang','ru'],
                    ['isHide',0],
                ])->orderBy('created_at','desc')
                ->limit(4)
                ->get();
        }else{
            $posts = Post::with(['project.category.translate'])
                ->whereHas('translate', function ($translate) use ($locale){
                    return $translate->where('lang', $locale);
                })
                ->where([
                    ['lang','ru'],
                    ['isHide',0]
                ])
                ->withCount(['visible_comments'])->where([
                    ['lang','ru'],
                    ['isHide',0],
                ])->orderBy('created_at','desc')
                ->limit(4)
                ->get();
        }


		$brands = Brand::where([
			['lang',$locale],
			['isHide',0],
		])->get();

        $routes = AlternativeUrlService::generateReplyRoutes('');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('home',[
    		'projects'	=>	$projects,
    		'reviews'	=>	$reviews,
    		'posts'	=>	$posts,
    		'brands'	=>	$brands,
    		'project_count'	=>	$project_count,
    		'review_count'	=>	$review_count,
    		'expert_count'	=>	$expert_count,
			'alternativeUrls'	=> $alternativeUrls,
			'international'	=> $international,
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

		$routes = AlternativeUrlService::generateReplyRoutes('about/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('about',[
    		'page' => $page,
    		'brands' => $brands,
			'alternativeUrls' => $alternativeUrls
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

        $routes = AlternativeUrlService::generateReplyRoutes('faq');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('faq',[
    		'page' => $page,
    		'faqCategories' => $faqCategories,
			'alternativeUrls' => $alternativeUrls
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

        $routes = AlternativeUrlService::generateReplyRoutes('contact/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('contact',[
    		'page' => $page,
			'alternativeUrls' => $alternativeUrls
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

        $routes = AlternativeUrlService::generateReplyRoutes('partner/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('b2b',[
			'page' => $page,
			'brands' => $brands,
			'alternativeUrls' => $alternativeUrls
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

        $routes = ['ru' => $base->url.'/'];

        foreach ($base->translate as $translate){
            $routes[$translate->lang] = $translate->url.'/';
        }

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('message',[
			'header' => $page->name,
			'message' => $page->content,
			'alternativeUrls' => $alternativeUrls
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
        $body.= "<strong>???????? ????`??:</strong> ".$request->name."<br>";
        $body.= "<strong>?????? E-mail:</strong> ".$request->email."<br>";
        $body.= "<strong>?????? ??????????????:</strong> ".$request->phone."<br>";

        Mail::to("influence@burda.ua")->send(new PartnerNotificationMail($request->subject, $body));

        return 'OK';
    }
}
