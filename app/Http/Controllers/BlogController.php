<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App;
use Cookie;
use App\Model\Page;
use App\Model\Post;
use App\Model\Post\PostTagList;
use App\Model\Post\PostComment;
use App\Model\Project;
use App\Model\Review;
use App\Model\Project\ProjectCategory;
use App\User;
use App\Library\Users\UserRating;

use Carbon;
use SEO;
use SEOMeta;
use OpenGraph;

class BlogController extends Controller
{
	protected $sidebar;

	public function __construct()
	{
		$locale = App::getLocale();

		$projects = Project::where([
				['lang',$locale],
				['isHide',0],
				['status_id','<>',3],
				['status_id','<>',10],
				['type','<>','only-blogger'],
			])->orderBy('start_registration_time','desc')
			->limit(2)
			->get();

		$reviews = Review::with(['user.roles','subpage.project'])
			->whereHas('subpage',function($subpage){
				$subpage->where('type_id',1);
			})->orderBy('created_at','desc')
			->limit(3)
			->get();

		$tags = PostTagList::withCount('posts')
			->where([
				['lang','ru']
			])
			->orderBy('posts_count','desc')
			->limit(30)
			->get();


		$this->sidebar['projects'] = $projects;
		$this->sidebar['reviews'] = $reviews;
		$this->sidebar['tags'] = $tags;
	}


	function all(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','blog'],
			['lang',$locale],
			['isHide',0],
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

		$lastPost = Post::with(['project.category.translate','base'])
			->withCount(['visible_comments'])->where([
				['lang',$locale],
				['isHide',0],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate','base']);

		$url = route('blog');

		return $this->list($posts, $lastPost, $page, $request, $url);
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
				['isHide',0],
			])->first()){
			return $this->project( $request,$url);
		}
		if(User::where([
				['name',$url],
			])->first()){
			return $this->user( $request,$url);
		}
		if(PostTagList::where('url',$url)->first()){
			return $this->tag($request,$url);
		}
		if(Post::where([
			['url',$url],
			//['isHide',0]
			]
		)->first()){
			return $this->index($request,$url);
		}
		if($url == 'news'){
			return $this->news($request);
		}

		return abort(404);
	}

	public function index(Request $request,$url){
		$locale = App::getLocale();

		$categories = ProjectCategory::with(['base'])->where([
			['lang',$locale],
			['isHide',0],
		])->get();

		if($locale == "ru"){
			$base = $post = Post::with(['project.category.translate','comments.user.roles','tags','author'])
				->withCount(['visible_comments'=> function ($query) {
					$query->whereIn('status_id', [1,2]);
				}])->where([
					['lang',$locale],
					['url', $url],
				])
				->first();

		}else{
			$post = Post::with(['project.category.translate','author'])
				->where([
					['lang',$locale],
					['url', $url],
				])->first();
			$base = Post::with(['project.category.translate','comments.user.roles','tags'])
				->withCount(['visible_comments'=> function ($query) {
					$query->whereIn('status_id', [1,2]);
				}])->find($post->rus_lang_id);
		}

		$lang = ($locale == 'ru')?'ua':'ru';
		$post_alt = ($locale == 'ru')? $post->translate->url : $post->base->url;

		$url = route('blog.level2',['url'=>$post_alt]);
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

		if($post->isHide){
			SEO::setTitle(trans('blog.hide_title'));
			$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;
			OpenGraph::addImage([
					'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
					'width' => 350,
					'height' => 220
				]
			);
			if($request->hasCookie('post_'.$post->id.'_password')){
				$password = Cookie::get('post_'.$post->id.'_password');
				if(!Hash::check($password,$post->password)){
					return view('blog.password',[
						'categories'	=>	$categories,
						'post'	=>	$post,
						'base'		=>	$base,
						'alternet_url'	=> $alternet_url
					]);
				}
			}else{
				return view('blog.password',[
					'categories'	=>	$categories,
					'post'	=>	$post,
					'base'		=>	$base,
					'alternet_url'	=> $alternet_url
				]);
			}
		}


		$title = $post->seo_title ?? str_replace(':page_name:',$post->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $post->seo_description ?? str_replace(':page_name:',$post->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $base->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($post->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		return view('blog.single',[
			'categories'	=>	$categories,
			'post'	=> $post,
			'base'	=> $base,
			'locale'	=>	$locale,
			'sidebar'	=> $this->sidebar,
			'alternet_url' => $alternet_url
		]);
	}

	public function category($request, $url){
		$locale = App::getLocale();

		$category = ProjectCategory::with(['base'])->where([
			['url',$url],
			['lang',$locale],
		])->first();
		$categoryBase = ($locale == "ru")? $category : $category->base;

		if(\App\Model\Setting::where([['name','seo_blog_category'],['lang',$locale]])->first()){
			$title = $category->seo_title
				??
				str_replace(':category_name:',$category->name, \App\Model\Setting::where([['name','seo_blog_category'],['lang',$locale]])->first()->value);
			$description = $category->seo_description ?? str_replace(':category_name:',$category->name, \App\Model\Setting::where([['name','seo_blog_category'],['lang',$locale]])->first()->value);

		}
		else{
			$title = $category->seo_title ?? $category->name;
			$description = $category->seo_description ?? $category->name;
		}
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

		$lastPost = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])
			->whereHas('project', function($prj) use ($categoryBase){
				$prj->where('category_id',$categoryBase->id);
			})
			->where([
				['lang',$locale],
				['isHide',0],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate'])
			->whereHas('project', function($prj) use ($categoryBase){
				$prj->where('category_id',$categoryBase->id);
			});

		$post_alt = ($locale == 'ru')? $category->translate->url : $category->base->url;
		$url = route('blog.level2',['url'=>$post_alt]);

		return $this->list($posts, $lastPost, $category, $request, $url);
	}

	public function project($request, $url){
		$locale = App::getLocale();

		$project = Project::where([
			['url',$url],
			['lang',$locale],
		])->first();
		$projectBase = ($locale == "ru")? $project : $project->base;

		SEO::setTitle($project->seo_title);
		SEO::setDescription($project->seo_description);
		SEOMeta::setKeywords($project->seo_keywords);

		$title = $project->seo_title ?? str_replace(':project_name:',$project->name, \App\Model\Setting::where([['name','blog_project_title'],['lang',$locale]])->first()->value);
		$description = $project->seo_description ?? str_replace(':project_name:',$project->name, \App\Model\Setting::where([['name','blog_project_description'],['lang',$locale]])->first()->value);
		$og_image = $projectBase->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($project->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);


		$lastPost = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])
			->where([
				['lang',$locale],
				['isHide',0],
				['project_id',$projectBase->id],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate'])
			->where('project_id',$projectBase->id);

		$post_alt = ($locale == 'ru')? $project->translate->url : $project->base->url;
		$url = route('blog.level2',['url'=>$post_alt]);

		return $this->list($posts, $lastPost, $project, $request, $url);
	}

	public function user($request, $url){
		$locale = App::getLocale();

		$user = User::where([
			['name',$url],
		])->first();


		$title = str_replace(':author_name:',$user->name, \App\Model\Setting::where([['name','blog_author_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':author_name:',$user->name, \App\Model\Setting::where([['name','blog_author_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lastPost = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])
			->where([
				['lang',$locale],
				['isHide',0],
				['author_id',$user->id],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate'])
			->where('author_id',$user->id);

		$url = route('blog.level2',['url'=>$url]);

		return $this->list($posts, $lastPost, $user, $request, $url);
	}

	public function tag($request, $url){
		$locale = App::getLocale();

		$tag = PostTagList::where([
			['lang',$locale],
			['url',$url],
		])->first();

		$base = ($locale == 'ru')? $tag : $tag->base;

		$title = str_replace(':tag_name:',$tag->name, \App\Model\Setting::where([['name','blog_tag_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':tag_name:',$tag->name, \App\Model\Setting::where([['name','blog_tag_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lastPost = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])
			->whereHas('tags',function ($tags) use ($base){
				$tags->where('url',$base->url);
			})
			->where([
				['lang',$locale],
				['isHide',0],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate'])
			->whereHas('tags',function ($tags) use ($base){
				$tags->where('url',$base->url);
			});

		if($locale != 'ru'){
			$lastPost = Post::with(['project.category.translate'])
				->withCount(['visible_comments'])
				->whereHas('base',function ($pst) use ($base){
					$pst->whereHas('tags',function ($tags) use ($base){
						$tags->where('url',$base->url);
					});
				})
				->where([
					['lang',$locale],
					['isHide',0],
				])->orderBy('id','desc')
				->first();

			$posts = Post::with(['project.category.translate'])
				->whereHas('base',function ($pst) use ($base){
					$pst->whereHas('tags',function ($tags) use ($base){
						$tags->where('url',$base->url);
					});
				});
		}


		$post_alt = ($locale == 'ru')? $tag->translate->url : $tag->base->url;
		$url = route('blog.level2',['url'=>$post_alt]);

		return $this->list($posts, $lastPost, $tag, $request, $url);
	}



	public function news($request){
		$locale = App::getLocale();


		$title =  \App\Model\Setting::where([['name','blog_news_title'],['lang',$locale]])->first()->value;
		$description = \App\Model\Setting::where([['name','blog_news_description'],['lang',$locale]])->first()->value;
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lastPost = Post::with(['project.category.translate'])
			->withCount(['visible_comments'])
			->where([
				['lang',$locale],
				['isHide',0],
				['project_id',null],
			])->orderBy('id','desc')
			->first();

		$posts = Post::with(['project.category.translate'])
			->where('project_id',null);

		$url = route('blog.level2',['url'=>'news']);

		$page = null;

		return $this->list($posts, $lastPost, $page, $request, $url);
	}

	public function list($posts, $lastPost, $page, $request, $url){
		$locale = App::getLocale();

		$categories = ProjectCategory::with(['base'])->where([['lang',$locale],['isHide',0]])->get();

		if(isset($lastPost)){
			$posts = $posts->where([
				['lang',$locale],
				['isHide',0],
				['id','<>',$lastPost->id ]
			])
				->withCount(['visible_comments'])
				->orderBy('id','desc')
				->paginate(10);
		}else{
			$posts = $posts->where('id',-1)
				->withCount(['visible_comments'])
				->orderBy('id','desc')
				->paginate(10);
		}


		if ($request->ajax()) {
			$view = view('blog.include.blog_item',compact(['posts', 'locale']))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $posts->nextPageUrl() == false
			]);
		}

		$lang = ($locale == 'ru')?'ua':'ru';

		$url = ($posts->previousPageUrl())?($url.'?page='.$posts->currentPage()):$url;
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

		return view('blog.list',[
			'categories'	=>	$categories,
			'posts'	=>	$posts,
			'page'	=> $page,
			'locale'	=>	$locale,
			'lastPost'	=>	$lastPost,
			'sidebar'	=> $this->sidebar,
			'alternet_url' => $alternet_url
		]);
	}

	public function createComment( Request $request, $post_id){
		$user_id = Auth::user()->id;


		$comment = PostComment::where([
			['user_id',$user_id],
			['post_id',$post_id],
			['created_at','>=',Carbon::now()->subSeconds(5)],
		])->get();

		if($comment->count() == 0){

			$comment = new PostComment();
			$comment->text = $request->text;
			$comment->post_id = $post_id;
			$comment->user_id = $user_id;
			$comment->status_id = 1;
			$comment->save();
		}

		return redirect()->back();
	}

	public function password(Request $request){
		Cookie::queue('post_'.$request->post_id.'_password',$request->password, 10080);

		return redirect()->back();
	}
}
