<?php

namespace App\Http\Controllers\Admin;

use App\Model\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Review;
use App\Model\Review\StatusReview;
use App\Library\Users\ModeratorLogs;
use App\Library\Users\UserRating;
use Image;
use App\Library\Queries\QueryBuilder;
use SEO;
use AdminPageData;

class ReviewController extends Controller
{

	public function all()
	{
		SEO::setTitle('Все отзывы');
		AdminPageData::setPageName('Все отзывы');
		AdminPageData::addBreadcrumbLevel('Отзывы');

		$projects = Project::where([
		    ['lang','ru'],
		    ['isHide',0],
        ])->orderBy('id','DESC')->get();

		return view('admin.review.all',[
		    'projects' => $projects
        ]);
	}

	public function all_ajax(Request $request){
		$filter = QueryBuilder::getFilter($request);
		$reviews = Review::with(['user','subpage.project','status'])->where($filter)->orWhere($filter)->orWhere($filter)->orderBy('id','desc');

		return datatables()->eloquent($reviews)
			->addColumn('user', function (Review $review) {
				return $review->user->name;
			})
            ->addColumn('project', function (Review $review) {
				return $review->subpage->project->name;
			})
            ->addColumn('subpage', function (Review $review) {
				return $review->subpage->name;
			})
			->addColumn('status', function (Review $review) {
				return $review->status->name;
			})
			->filterColumn('status', function($review, $keyword) {
				$review->whereHas('status', function ($status) use ($keyword){
					$status->where('name','like',["%{$keyword}%"]);
				});
			})
			->filterColumn('user', function($query, $keyword) {
				$query->whereHas('user', function ($user) use ($keyword){
					$user->where('name','like',["%{$keyword}%"]);
				});
			})
			->filterColumn('project', function($query, $keyword) {
				$query->whereHas('subpage', function ($subpage) use ($keyword){
					$subpage->whereHas('project', function ($project) use ($keyword){
						$project->where('name','like',["%{$keyword}%"]);
					});
				});
			})
			->filterColumn('subpage', function($query, $keyword) {
				$query->whereHas('subpage', function ($subpage) use ($keyword){
                    $subpage->where('name','like',["%{$keyword}%"]);
				});
			})
			->filter(function ($query) use ($request) {
				if (request()->has('id')) {
					$query->where('id','like',"%" . request('name') . "%");
				}
				if (request()->has('user')) {
					$query->whereHas('user', function ($user){
						$user->where('name','like',"%" . request('name') . "%");
					});
				}
				if (request()->has('project')) {
					$query->whereHas('subpage', function ($subpage){
						$subpage->whereHas('project', function ($project){
							$project->where('name','like',"%" . request('name') . "%");
						});
					});
				}
				if (request()->has('subpage')) {
					$query->whereHas('subpage', function ($subpage){
                        $subpage->where('name','like',"%" . request('name') . "%");
					});
				}

			}, true)
			->toJson();
	}

	public function new()
	{
		$statuses = StatusReview::all();

		SEO::setTitle('Новый отзыв');
		AdminPageData::setPageName('Новый отзыв');
		AdminPageData::addBreadcrumbLevel('Отзывы','reviews');
		AdminPageData::addBreadcrumbLevel('Новый отзыв');

		return view('admin.review.new',['statuses' => $statuses]);
	}

	public function create(Request $request)
	{
		$review = new Review();
		$this->createOrEdit($request, $review);

		ModeratorLogs::addLog("Добавил отзыв: ".$request->id);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_review_edit',$review->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_review');
		}else{
			return redirect()->route('adm_review_new');
		}
	}

	public function edit(Request $request, $review_id)
	{
		$review = Review::with(['user','subpage.project','status','comments'])->find($review_id);
		$statuses = StatusReview::all();

		$countComments = $review->comments->count();
		$array = [];
		$array[] = 'review_id';
		$array[] = $review->id;
		$commentFilter = json_encode($array);

		SEO::setTitle('Редактирование отзыва');
		AdminPageData::setPageName('Редактирование отзыва');
		AdminPageData::addBreadcrumbLevel('Отзывы','reviews');
		AdminPageData::addBreadcrumbLevel('Редактирование отзыва');

		return view('admin.review.edit',[
			'review' => $review,
			'statuses' => $statuses,
			'countComments' => $countComments,
			'commentFilter' => $commentFilter,
		]);
	}

	public function save(Request $request, $review_id)
	{
		$review = Review::find($review_id);
		$oldStatus = $review->status_id;
		$review = $this->createOrEdit($request, $review);

		$this->ratingReview($review,$oldStatus);

		ModeratorLogs::addLog("Отредактировал отзыв: ".$request->id);

		if(($request->submit == "save")){
			return redirect()->route('adm_review_edit',$review->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_review');
		}else if($request->submit == "save-next"){
			$next = Review::where('status_id',1)->first();
			if(!empty($next)){
				return redirect()->route('adm_review_edit',['review_id' => $next->id]);
			}else{
				return redirect()->route('adm_review');
			}
		}else{
			return redirect()->route('adm_review_new');
		}
	}

	public function delete($review_id){
		$review = Review::find($review_id);
		$this->deleteRating($review,$review->status_id);
		$review->delete();
		Review\Comment::where('review_id',$review_id)->delete();
		Review\ReviewLike::where('review_id',$review_id)->delete();
		return "ok";
	}

	public function hide($review_id){
		$review = Review::find($review_id);
		$review->isHide = true;
		$review->save();
		return "ok";
	}
	public function show($review_id){
		$review = Review::find($review_id);
		$review->isHide = false;
		$review->save();
		return "ok";
	}

	public function changeStatus($status_id,$review_id){
		$review = Review::find($review_id);
		$oldStatus = $review->status_id;
		$review->status_id = $status_id;
		$review->save();
		ModeratorLogs::addLog("Сменил статус у отзыва: ".$review->id);

		$this->ratingReview($review,$oldStatus);
		return "ok";
	}

	protected function createOrEdit($request,$review){
		$review->text = $request->text;
		$review->name = $request->name;
		$review->video = $this->convertYoutube($request->video);

		$review->status_id = $request->status;
		$review->subpage_id = $request->subpage;
		$review->user_id = $request->user;
		$review->isMainReview = ($request->has('isMainReview'));
		$review->isProjectGallery = ($request->has('isProjectGallery'));
		$review->isReviewCatalog = ($request->has('isReviewCatalog'));

		if($request->hasFile('images')){
			$review->images = $this->saveImageGallery($request->images);
		}else{
			$review->images = json_decode($request->images);
		}

		$review->save();
		return $review;
	}

	protected function saveImageGallery($images){
		$out_images = [];
		$i = 0;
		foreach ($images as $image){
			$out_images[] = $this->saveImageWithPreview($image, $i);
			$i += 2;
		}
		return $out_images;
	}

	protected function saveImageWithPreview($image,$modificator){
		$images = [];
		$filename = time() .$modificator. '.' . $image->getClientOriginalExtension();
		Image::make($image)->save( public_path('/uploads/images/reviews/' . $filename ) );
		$images[] = $filename;

		$filename = time() .($modificator+1). '.' . $image->getClientOriginalExtension();
		Image::make($image)->fit (300, 300)->save( public_path('/uploads/images/reviews/' . $filename ) );
		$images[] = $filename;

		return $images;
	}

	protected function ratingReview($review,$oldStatus){
		if(($oldStatus != $review->status_id)){
			if($review->status_id == 2){
				$user = $review->user;

				UserRating::addAction('send_review', $user);
				if(isset($review->images)){
					for ($i = 0; $i < count($review->images); $i++)
					{
						UserRating::addAction('image_review', $user);
					}
				}
				if($review->subpage->type_id == 3){
					UserRating::addAction('contest', $user);
				}
				if(isset($review->video) && $review->video != ''){
					UserRating::addAction('video_review', $user);
				}
			}else{
				$this->deleteRating($review,$oldStatus);
			}
		}

	}

	protected function deleteRating($review,$oldStatus){
		if($oldStatus == 2){
			$user = $review->user;

			UserRating::addAction('delete_review', $user);
			if(isset($review->images)){
				for ($i = 0; $i < count($review->images); $i++)
				{
					UserRating::addAction('delete_image', $user);
				}
			}
			if($review->subpage->type_id == 3){
				UserRating::addAction('delete_contest', $user);
			}
			if(isset($review->video) && $review->video != ''){
				UserRating::addAction('delete_video', $user);
			}
		}
	}

	protected function convertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"https://www.youtube.com/embed/$2",
			$string
		);
	}

}
