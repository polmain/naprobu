<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Queries\QueryBuilder;
use App\Library\Users\ModeratorLogs;
use App\Library\Users\UserRating;
use App\Model\Review\Comment;
use App\Model\Review\StatusReview;
use SEO;
use AdminPageData;

class CommentController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Отзывы','reviews');
	}

	public function all()
	{
		SEO::setTitle('Все комментарии');
		AdminPageData::setPageName('Все комментарии');
		AdminPageData::addBreadcrumbLevel('Комментарии');

		return view('admin.review.comment.all');
	}

	public function all_ajax(Request $request){
		$filter = QueryBuilder::getFilter($request);
		$comments = Comment::with(['user','review.subpage.project','status'])
			->where(function($q) use ($filter){
				$q->where($filter)->orWhere($filter)->orWhere($filter);
			})
			->orderBy('id','desc');

		return datatables()->eloquent($comments)
			->addColumn('user', function (Comment $comment) {
				return $comment->user->name;
			})->addColumn('project', function (Comment $comment) {
				/*if($comment->review){
					*/return $comment->review->subpage->project->name;/*
				}else{
					return '';
				}*/
			})->addColumn('review', function (Comment $comment) {
				return $comment->review;
			})
			->addColumn('status', function (Comment $comment) {
				return $comment->status->name;
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
				$query->whereHas('review', function ($review) use ($keyword){
					$review->whereHas('subpage', function ($subpage) use ($keyword){
						$subpage->whereHas('project', function ($project) use ($keyword){
							$project->where('name','like',["%{$keyword}%"]);
						});
					});
				});
			})
			->filter(function ($query) use ($request) {
				if (request()->has('user')) {
					$query->whereHas('user', function ($user){
						$user->where('name','like',"%" . request('name') . "%");
					});
				}
				if (request()->has('project')) {
					$query->whereHas('review', function ($review){
						$review->whereHas('subpage', function ($subpage){
							$subpage->whereHas('project', function ($project){
								$project->where('name','like',"%" . request('name') . "%");
							});
						});
					});
				}
			}, true)
			->toJson();
	}

	public function edit(Request $request, $comment_id)
	{
		$comment = Comment::with(['user','review.subpage.project','status'])->find($comment_id);
		$statuses = StatusReview::all();

		SEO::setTitle('Редактирование комментария');
		AdminPageData::setPageName('Редактирование комментария');
		AdminPageData::addBreadcrumbLevel('Комментарии','comments');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.review.comment.edit',[
			'comment' => $comment,
			'statuses' => $statuses
		]);
	}

	public function save(Request $request, $comment_id)
	{
		$comment = Comment::find($comment_id);
		$comment->text = $request->text;
		$oldStatus = $comment->status_id;
		$comment->status_id = $request->status;
		$comment->isImportant = $request->has('isImportant');
		$comment->save();

		$this->ratingComment($comment,$oldStatus);

		ModeratorLogs::addLog("Отредактировал комментарий к отзыву: ".$request->text);
		if(($request->submit == "save")){
			return redirect()->route('adm_comment_edit',$comment->id);
		}else{
			return redirect()->route('adm_comment');
		}

	}

	public function delete($comment_id){
		$comment = Comment::find($comment_id);
		$this->deleteRating($comment,$comment->status_id);
		$comment->delete();
		ModeratorLogs::addLog("Удалил комментарий: ".$comment_id);
		return "ok";
	}
	public function changeStatus($status_id,$comment_id){
		$comment = Comment::find($comment_id);
		$oldStatus = $comment->status_id;
		$comment->status_id = $status_id;
		$comment->save();
		ModeratorLogs::addLog("Сменил статус у комментария: ".$comment_id);

		$this->ratingComment($comment,$oldStatus);
		return "ok";
	}
	public function hide($comment_id){
		$comment = Comment::find($comment_id);
		$comment->isHide = true;
		$comment->save();
		return "ok";
	}
	public function show($comment_id){
		$comment = Comment::find($comment_id);
		$comment->isHide = false;
		$comment->save();
		return "ok";
	}

	protected function ratingComment($comment,$oldStatus){
		if($oldStatus != $comment->status_id){
			if($comment->status_id == 2){
				$user = $comment->user;
				UserRating::addAction('comment', $user);
			}elseif($oldStatus == 2){
				$this->deleteRating($comment,$oldStatus);
			}
		}
	}

	protected function deleteRating($comment,$oldStatus){
		if($oldStatus == 2){
			$user = $comment->user;
			UserRating::addAction('delete_comment', $user);
		}

	}
}
