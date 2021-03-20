<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\Model\User\UserPresents;
use App\Model\Project\ProjectRequest;
use App\Model\Review;
use App\Model\Review\Comment;
use App\Model\Post\PostComment;
use App\Model\Feedback;

class Notifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$requestsCount = ProjectRequest::where('status_id',1)->count();
    	$reviewsCount = Review::where('status_id',1)->count();
    	$commentsCount = Comment::where('status_id',1)->count();
    	$commentsBlogCount = PostComment::where('status_id',1)->count();

    	$feedbackCount = Feedback::where('isNew',1)->count();

    	$presentCount = UserPresents::where([['isGet','1'],['isSent','0']])->count();

    	$total = $reviewsCount + $commentsCount + $commentsBlogCount + $requestsCount;

		$request->attributes->Add(['requestsCount' => $requestsCount]);
		$request->attributes->Add(['reviewsCount' => $reviewsCount]);
		$request->attributes->Add(['commentsCount' => $commentsCount]);
		$request->attributes->Add(['commentsBlogCount' => $commentsBlogCount]);
		$request->attributes->Add(['feedbackCount' => $feedbackCount]);
		$request->attributes->Add(['presentCount' => $presentCount]);
		$request->attributes->Add(['totalNotifications' => $total]);
		return $next($request);
    }
}
