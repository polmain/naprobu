<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App;
use App\User;
use App\Model\Page;
use App\Model\Review;
use App\Model\Review\Comment;
use App\Model\Project\ProjectCategory;
use App\Model\Review\ReviewLike;
use App\Library\Users\UserRating;
use App\Library\Users\Notification;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;
use SEO;
use SEOMeta;
use OpenGraph;

class ReviewController extends Controller
{
	public function all(Request $request){
		$locale = App::getLocale();

		$page = Page::where([
			['url','reviews'],
			['lang',$locale],
		])->first();

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where('name','title_default')->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where('name','description_default')->first()->value);
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

		$categories = ProjectCategory::with(['projects'])->where([['lang',$locale],['isHide',0]])->get();

		$reviews	=	Review::with(['subpage.project','user.roles','visibleComments.user.roles','likes'])->where([
			['isReviewCatalog',1],
			['isHide',0],
		]);
		if($request->has('orderBy')){
			switch ($request->orderBy){
				case 'user_asc':
					$reviews = $reviews->orderBy('user_id')->paginate(5);
					break;
				case 'user_desc':
					$reviews = $reviews->orderBy('user_id','desc')->paginate(5);
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
			$view = view('review.include.review_item',compact('reviews'))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $reviews->nextPageUrl() == false
			]);
		}

		$lang = ($locale == 'ru')?'ua':'ru';

		$url = ($reviews->previousPageUrl())?route('review',['page'=>$reviews->currentPage()]):route('review');
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

		return view('review.list',[
			'categories'	=>	$categories,
			'reviews'	=>	$reviews,
			'locale'	=>	$locale,
			'page'	=> $page,
			'alternet_url' => $alternet_url
		]);
	}

	public function lavel2(Request $request,$url){
		$locale = App::getLocale();
		if(ProjectCategory::where([['url',$url],['lang',$locale],['isHide',0]])->first()){
			return $this->category( $request,$url);
		}
		if(is_numeric($url)){
			return $this->index( $request,$url);
		}

		return abort(404);
	}

	public function category(Request $request,$url){
		$locale = App::getLocale();

		$category = ProjectCategory::with(['base'])->where([['url',$url],['lang',$locale],['isHide',0]])->first();

		$base = ($locale == 'ru')? $category->id : $category->rus_lang_id;

		$title = str_replace(':category_name:',$category->name, \App\Model\Setting::where([['name','review_category_title'],['lang',$locale]])->first()->value);
		$description = str_replace(':category_name:',$category->name, \App\Model\Setting::where([['name','review_category_description'],['lang',$locale]])->first()->value);
		$og_image = \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$categories = ProjectCategory::where([['lang',$locale],['isHide',0]])->get();
		Review::with(['subpage.project','user.roles','visibleComments.user.roles','likes'])->where([
			['isReviewCatalog',1],
			['isHide',0],
		]);

		$reviews	=	Review::with(['subpage.project','user.roles','visibleComments.user.roles','likes'])
			->whereHas('subpage',function($subpage) use ($base,$locale){
				$subpage->whereHas('project',function($project) use ($base,$locale){
					$project->where([
						['category_id',$base],
						['isHide',0],
					]);
				});
			})->where([
				['isReviewCatalog',1],
				['isHide',0],
			]);

		if($request->has('orderBy')){
			switch ($request->orderBy){
				case 'user_asc':
					$reviews = $reviews->orderBy('user_id')->paginate(5);
					break;
				case 'user_desc':
					$reviews = $reviews->orderBy('user_id','desc')->paginate(5);
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
			$view = view('review.include.review_item',compact('reviews'))->render();
			return response()->json([
				'html' => $view,
				'isNext' => $reviews->nextPageUrl() == false
			]);
		}

		$lang = ($locale == 'ru')?'ua':'ru';
		$category_alt = ($locale == 'ru')? $category->translate->url : $category->base->url;

		$url = ($reviews->previousPageUrl())?route('review.level2',['url'=>$category_alt,'page'=>$reviews->currentPage()]):route('review.level2',['url'=>$category_alt]);
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

		return view('review.list',[
			'categories'	=>	$categories,
			'reviews'	=>	$reviews,
			'locale'	=>	$locale,
			'page'	=> $category,
			'alternet_url' => $alternet_url
		]);
	}

	public function index(Request $request,$url){
		$locale = App::getLocale();

		$reviews	=	Review::with(['subpage.project','user.roles','visibleComments.user.roles','likes'])->where([
			['id',$url],
		])->get();

		$project_name = ($locale == "ru")? $reviews->first()->subpage->project->name : $reviews->first()->subpage->project->translate->name;
		$project = ($locale == "ru")? $reviews->first()->subpage->project : $reviews->first()->subpage->project->translate;

		$title = str_replace(':user_name:',$reviews->first()->user->name, \App\Model\Setting::where([['name','review_single_title'],['lang',$locale]])->first()->value);
		$title = str_replace(':project_name:',$project_name, $title);
		$description = str_replace(':user_name:',$reviews->first()->user->name, \App\Model\Setting::where([['name','review_single_description'],['lang',$locale]])->first()->value);
		$description = str_replace(':project_name:',$project_name, $description);
		$og_image = $project->preview_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

		$lang = ($locale == 'ru')?'ua':'ru';

		$url = route('review.level2',['url'=>$url]);
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

		return view('review.single',[
			'reviews'	=>	$reviews,
			'alternet_url' => $alternet_url
		]);
	}

	public function createComment( Request $request, $review_id){
		$user_id = Auth::user()->id;

		$comment = Comment::where([
			['user_id',$user_id],
			['review_id',$review_id],
			['created_at','>=',Carbon::now()->subSeconds(10)],
		])->get();

		if($comment->count() == 0){
			$comment = new Comment();
			$comment->text = $request->text;
			$comment->reply_comment_id = $request->reply_id;
			$comment->review_id = $review_id;
			$comment->user_id = $user_id;
			$comment->status_id = 1;
			$comment->save();

			$review = Review::find($review_id);

			$reply_comment = null;
			if($request->reply_id != 0){
				$reply_comment = Comment::find($request->reply_id);
			}
			$send_author = true;
			foreach ($review->comments->groupBy('user_id') as $usr_comment){
				if($reply_comment){
					if($reply_comment->user_id == $usr_comment->first()->user_id){
						Notification::send('review_comment_reply',$usr_comment->first()->user,0, route('review.level2',[$review->id]).'#comment-'.$comment->id ,['user'=>Auth::user()->name]);
						if($reply_comment->user_id == $review->user_id){
							$send_author = false;
						}
						continue;
					}
				}
				if($usr_comment->first()->user_id != $user_id && $usr_comment->first()->user_id != $review->user_id){
					Notification::send('review_comment_other',$usr_comment->first()->user,0, route('review.level2',[$review->id]),['user'=>Auth::user()->name]);
				}
			}

			if($review->user_id != $user_id && $send_author){
				Notification::send('review_comment',$review->user,0, route('review.level2',[$review->id]),['user'=>Auth::user()->name]);
			}
		}

		return redirect()->back();
	}

	public function like(Request $request, $review_id){
		$user_id = Auth::user()->id;
		$like = ReviewLike::where([
			['user_id',$user_id],
			['review_id',$review_id],
		])->first();
		if(isset($like)){
			$like->delete();
		}else{
			$like = new ReviewLike();
			$like->user_id = $user_id;
			$like->review_id = $review_id;
			$like->save();
		}
		$like_count = ReviewLike::where([
			['review_id',$review_id],
		])->count();

		$responce = [
			'status' => 'ok',
			'like_count' => $like_count,
		];


		return \Response::json($responce);
	}

	public function share(Request $request){
		if(Auth::check()){
			UserRating::addAction('share_review', Auth::user());
		}
	}

	function create(Request $request)
	{
		$user_id = Auth::user()->id;


		$review = new Review();

		$review->name = $request->name;
		$review->text = nl2br($request->text);
		$review->user_id = $user_id;
		$review->status_id = 1;
		$review->subpage_id = $request->subpage;

		$review->video = $this->convertYoutube($request->video);


		if(isset($request->images)){
			$images = json_decode($request->images);
			$review->images = $images;
		}
		$review->save();
		/////////////
		/*UserRating::addAction('send_review', Auth::user());
		if(isset($request->images)){
			$images = json_decode($request->images);
			$review->images = $images;
			foreach ($images as $image){
				UserRating::addAction('image_review', Auth::user());
			}
		}
		$review->save();



		if($request->subpage_type == 3){
			UserRating::addAction('contest', Auth::user());
		}
		if(isset($request->video)){
			UserRating::addAction('video_review', Auth::user());
		}*/
///////////////
		return 'OK';
	}

	function save(Request $request)
	{


		$review = Review::find($request->review_id);

		$review->name = $request->name;
		$review->text = nl2br($request->text);
		//$review->status_id = 1;

		if(isset($request->images))
		{
			$old_images_count = 0;
			if(isset($review->images)){
				$old_images_count = count($review->images);
			}
			$images = json_decode($request->images);
			if ($old_images_count < count($images))
			{
				for ($i = $old_images_count - 1; $i < count($images); $i++)
				{
					UserRating::addAction('image_review', Auth::user());
				}
			}
			$review->images = $images;
		}



		if(isset($request->video) && empty($review->video)){
			UserRating::addAction('video_review', Auth::user());
		}

		$review->video = $this->convertYoutube($request->video);

		$review->save();

		return 'OK';
	}

	function addImage(Request $request){
		$user_id = Auth::user()->id;


		$rules = array(
			'upload' => 'required',
		);
		$validation = Validator::make($request->all(), $rules);

		if ($validation->fails())
		{
			return \Response::make($validation->errors()->first(), 400);
		}
		$images = $this->saveImageGallery($request->upload,$user_id);

		$responce = [
			'status' => 'OK',
			'images' => $images,
		];

		return \Response::json($responce);
	}

	protected function saveImageGallery($images,$user){
		$out_images = [];
		$i = 0;
		foreach ($images as $image){
			$out_images[] = $this->saveImageWithPreview($image, $i,$user);
			$i += 2;
		}
		return $out_images;
	}

	protected function saveImageWithPreview($image,$modificator,$user){
		Storage::disk("public_uploads")->makeDirectory('/images/reviews/'.$user);
		$nameFileModerate = count(Storage::disk("public_uploads")->files('/images/reviews/'.$user));
		$images = [];
		$filename = $user.'/'.time().$nameFileModerate .$modificator. '.' . $image->getClientOriginalExtension();
		Image::make($image)->fit (300, 300)->orientate()->save( public_path('/uploads/images/reviews/'.$filename ) );
		$images[] = $filename;

		$filename = $user.'/'.time().$nameFileModerate .($modificator+1). '.' . $image->getClientOriginalExtension();
		Image::make($image)->orientate()->save( public_path('/uploads/images/reviews/'.$filename ) );
		$images[] = $filename;

		return $images;
	}

	protected function convertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"https://www.youtube.com/embed/$2",
			$string
		);
	}
}
