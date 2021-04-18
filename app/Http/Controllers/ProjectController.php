<?php

namespace App\Http\Controllers;

use App;
use App\Entity\ProjectAudienceEnum;
use App\Library\Users\UserRating;
use App\Services\LanguageServices\AlternativeUrlService;
use Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Model\Page;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Project\Subpage;
use App\Model\Project\ProjectRequest;
use App\Model\Project\ProjectBloggerPost;
use App\Model\Review;
use App\Model\Post;
use SEO;
use SEOMeta;
use OpenGraph;

// todo refactoring this class
class ProjectController extends Controller
{
    public function all(Request $request){
        $international = $request->get('international');
		$locale = App::getLocale();

		$page = Page::where([
			['url','projects'],
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

    	$categories = ProjectCategory::where([
			['lang',$locale],
			['isHide',0],
		])->get();

    	$audience = ProjectAudienceEnum::UKRAINE;
    	if($international){
            $audience = ProjectAudienceEnum::WORD;
        }

    	$projects	=	Project::where([
    		['lang',$locale],
			['status_id','<>',3],
			['status_id','<>',10],
			['type','<>','only-blogger'],
    		['isHide',0],
            ['audience',$audience],
		])->orderBy('start_registration_time','desc')->paginate(15);

		if ($request->ajax()) {
			$view = view('project.include.project_item',compact('projects'))->render();
			header('Vary:X-Requested-With');
			return response()->json([
				'html' => $view,
				'isNext' => $projects->nextPageUrl() == false
			]);
		}

        $url = ($projects->previousPageUrl())? 'projects/?page='.$projects->currentPage(): 'projects/';
        $routes = AlternativeUrlService::generateReplyRoutes($url);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

    	return view('project.list',[
    		'categories'	=>	$categories,
    		'projects'	=>	$projects,
			'lang'	=> $locale,
			'page'	=> $page,
			'alternativeUrls' => $alternativeUrls
		]);
	}

	public function lavel2(Request $request,$url){
		$locale = App::getLocale();

    	if(ProjectCategory::where([
    		['url',$url],
    		['lang',$locale],
    		['isHide',0],
		])->first()){
    		return $this->category( $request,$url);
		}
    	if(Project::where([
			['url',$url],
			['lang',$locale],
		])->first()){
    		return $this->index($request, $url);
		}
		return abort(404);
	}

	public function category(Request $request,$url){
		$locale = App::getLocale();

		$category = ProjectCategory::where([
			['url',$url],
			['lang',$locale],
		])->first();

		$base = ($locale == 'ru')? $category : $category->base;

		$title = $category->seo_title ?? str_replace(':page_name:',$category->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $category->seo_description ?? str_replace(':page_name:',$category->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($category->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);


		$categories = ProjectCategory::where([
			['lang',$locale],
			['isHide',0],
		])->get();
		$projects	=	Project::where([
							['category_id',$base->id],
							['lang',$locale],
							['status_id','<>',3],
							['status_id','<>',10],
							['isHide',0],
							['type','<>','only-blogger'],
						])->orderBy('start_registration_time','desc')
			->paginate(15);

		if ($request->ajax()) {
			$view = view('project.include.project_item',compact('projects'))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $projects->nextPageUrl() == false
			]);
		}

        $routes = ['ru' => 'projects/'.$base->url.'/'.($projects->previousPageUrl() ?'?page='.$projects->currentPage() : '')];

        foreach ($base->translate as $translate){
            $routes[$translate->lang] = 'projects/'.$translate->url.'/'.($projects->previousPageUrl() ?'?page='.$projects->currentPage() : '');
        }

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('project.list',[
			'categories'	=>	$categories,
			'projects'	=>	$projects,
			'page'	=> $category,
			'lang'	=> $locale,
			'alternativeUrls' => $alternativeUrls
		]);
	}

	public function index(Request $request,$url){

		$locale = App::getLocale();

		$categories = ProjectCategory::where([
			['lang',$locale],
			['isHide',0],
		])->get();

		$project	=	Project::with(['subpages.reviews.user','category','status','questionnaires','messages','base'])
			->where([
				['url', $url],
				['lang', $locale],
			])->first();
		if(empty($project)){
			abort(404);
		}

		$base = ($locale == 'ru')? $project : $project->base;

        $routes = ['ru' => 'projects/'.$base->url.'/'];

        foreach ($base->translate as $translate){
            $routes[$translate->lang] = 'projects/'.$translate->url.'/';
        }

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		if($project->isHide || $project->type == 'only-blogger'){
			SEO::setTitle(trans('project.hide_title'));
			$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;
			OpenGraph::addImage([
					'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
					'width' => 350,
					'height' => 220
				]
			);
			if($request->hasCookie('project_'.$project->id.'_password')){
				$password = Cookie::get('project_'.$project->id.'_password');
				if(!Hash::check($password,$project->password)){
					return view('project.subpage.password',[
						'categories'	=>	$categories,
						'project'	=>	$project,
						'base'		=>	$base,
						'alternativeUrls'	=> $alternativeUrls
					]);
				}
			}else{
				return view('project.subpage.password',[
					'categories'	=>	$categories,
					'project'	=>	$project,
					'base'		=>	$base,
					'alternativeUrls'	=> $alternativeUrls
				]);
			}
		}

		$projectRequest = null;
		if(Auth::check()){
			$projectRequest = ProjectRequest::where([
				['project_id',$base->id],
				['user_id',Auth::user()->id],
			])->first();
		}

		$reviews = Review::with(['user.roles','visibleComments.user.roles','likes','subpage.translate'])
			->whereHas('subpage',function ($subpage) use ($base){
				$subpage->where([
					['project_id',$base->id],
					['type_id',1],
					['lang','ru'],
					['hasReviews',1],
				]);
			})
			->where([
				['status_id',2],
				['isProjectGallery',1],
			])
			->limit(5)->orderBy('id','desc')->get();

		$lastPost = Post::where([
				['project_id',$base->id],
				['isHide',0],
				['lang',$locale],
			])->orderBy('created_at','desc')
			->first();

		$blocks = Project\ProjectBlock::where([
			['project_id',$base->id],
			['lang',$locale],
		])->get();

		$title = $project->seo_title ?? str_replace(':page_name:',$project->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $project->seo_description ?? str_replace(':page_name:',$project->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $base->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($project->seo_keyword);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		return view('project.single',[
			'categories'	=>	$categories,
			'project'	=>	$project,
			'base'		=>	$base,
			'reviews'	=>	$reviews,
			'lastPost'	=>	$lastPost,
			'lang'	=>	$locale,
			'projectRequest'	=>	$projectRequest,
			'blocks'	=>	$blocks,
			'alternativeUrls' => $alternativeUrls
		]);
	}

	public function subpage(Request $request,$project_url,$subpage){
		$locale = App::getLocale();

		$project = Project::with(['base','category'])->where([
			['lang',$locale],
			['url',$project_url],
		])->first();

		if(empty($project)){
			abort(404);
		}

		$project_id = ($locale == 'ru')? $project->id : $project->base->id;

		$subpage = Subpage::with('project.translate','base.project.translate')
			->where([
				['lang',$locale],
				['project_id',$project_id],
				['url',$subpage],
				['isHide',0],
			])->first();



		if(isset($subpage)){
			$subpage_base = ($locale == 'ru')?$subpage:$subpage->base;

			$title = $subpage->seo_title ?? str_replace(':page_name:',$subpage->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
			$description = $subpage->seo_description ?? str_replace(':page_name:',$subpage->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
			$og_image = (($locale == 'ru')?$project:$project->base)->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

			SEO::setTitle($title);
			SEO::setDescription($description);
			SEOMeta::setKeywords($subpage->seo_keywords);
			OpenGraph::addImage([
					'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
					'width' => 350,
					'height' => 220
				]
			);

			if($subpage->type_id == 5){
				$requests = ProjectRequest::with(['user'])->where([
						['project_id', $project_id],
						['status_id','>=',7],
					])
					->get()
					->sortBy((function($item,$key) {
						return mb_substr(mb_strtolower($item->user->name),0,1);
					}));

                $routes = ['ru' => 'projects/'.$subpage_base->project->url.'/'.$subpage_base->url.'/'];

                foreach ($subpage_base->translate as $translate){
                    $projectTranslate = $subpage_base->project->firstWhere('lang', $translate->lang);
                    if($projectTranslate){
                        $routes[$translate->lang] = 'projects/'.$projectTranslate->url.'/'.$translate->url.'/';
                    }
                }

                $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

				return view('project.subpage.member',[
					'project' => $project,
					'subpage' => $subpage,
					'requests' => $requests,
					'alternativeUrls' => $alternativeUrls
				]);

			}elseif($subpage->type_id == 15){
				$posts = ProjectBloggerPost::where([
					['project_id', $project_id],
					['isHide',0],
				])->orderBy('created_at','desc')
					->paginate(15);

				if ($request->ajax()) {
					$view = view('project.include.post_item',compact(['posts','subpage']))->render();
					return response()->json([
						'html' => $view,
						'isNext' => $posts->nextPageUrl() == false
					]);
				}

				$routes = ['ru' => 'projects/'.$subpage_base->project->url.'/'.$subpage_base->url.'/'.($posts->previousPageUrl() ?'?page='.$posts->currentPage() : '')];

                foreach ($subpage_base->translate as $translate){
                    $projectTranslate = $subpage_base->project->firstWhere('lang', $translate->lang);
                    if($projectTranslate){
                        $routes[$translate->lang] = 'projects/'.$projectTranslate->url.'/'.$translate->url.'/'.($posts->previousPageUrl() ?'?page='.$posts->currentPage() : '');
                    }
                }

                $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

				return view('project.subpage.blogger_post',[
					'project' => $project,
					'subpage' => $subpage,
					'posts' => $posts,
					'alternativeUrls' => $alternativeUrls
				]);
			}
			else{
				$reviews	=	Review::with(['user.roles','visibleComments.user.roles','likes'])->where([
					['subpage_id',$subpage_base->id],
					['status_id',2],
					['isHide',0],
				]);
				if($request->has('orderBy')){
					switch ($request->orderBy){
						case 'user_asc':
							$reviews = $reviews->orderBy('user_id')->paginate(5);
							break;
						case 'date_asc':
							$reviews = $reviews->paginate(5);
							break;
						case 'popular':
							$reviews = $reviews->withCount('likes')->orderBy('likes_count','desc')->paginate(5);
							break;
					}
					$reviews->appends(['orderBy'=>$request->orderBy]);

				}else{
					$reviews = $reviews->orderBy('id','desc')->paginate(5);
				}


				if ($request->ajax()) {
					$view = view('review.include.review_item_subpage',compact(['reviews','subpage']))->render();
					return response()->json([
						'html' => $view,
						'isNext' => $reviews->nextPageUrl() == false
					]);
				}

				$projectRequest = null;
				if(Auth::check()){
					$projectRequest = ProjectRequest::where([
						['project_id',$project_id],
						['user_id',Auth::user()->id],
						['status_id','>=',7],
					])->first();
				}

				$routes = ['ru' => 'projects/'.$subpage_base->project->url.'/'.$subpage_base->url.'/'.($reviews->previousPageUrl() ?'?page='.$reviews->currentPage() : '')];

                foreach ($subpage_base->translate as $translate){
                    $projectTranslate = $subpage_base->project->firstWhere('lang', $translate->lang);
                    if($projectTranslate){
                        $routes[$translate->lang] = 'projects/'.$projectTranslate->url.'/'.$translate->url.'/'.($reviews->previousPageUrl() ?'?page='.$reviews->currentPage() : '');
                    }
                }

                $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

				return view('project.subpage.review',[
					'project'		=>	$project,
					'subpage'		=>	$subpage,
					'reviews'		=>	$reviews,
					'subpage_base'	=>	$subpage_base,
					'projectRequest'	=>	$projectRequest,
					'alternativeUrls' => $alternativeUrls
				]);
			}
		}


		return abort(404);
	}
	public function password(Request $request){
		Cookie::queue('project_'.$request->project_id.'_password',$request->password, 10080);

		return redirect()->back();
	}


	public function share(Request $request){
		if(Auth::check()){
			UserRating::addAction('share_project', Auth::user());
		}
	}

}
