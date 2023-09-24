<?php

namespace App\Http\Middleware\Admin;

use App\Entity\PhoneStatusEnum;
use App\Model\Geo\City;
use App\Model\Geo\Region;
use App\Model\User\PhoneVerify;
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
        $cityCount = City::where('is_verify',0)->count();
        $regionCount = Region::where('is_verify',0)->count();
        $phoneCount = PhoneVerify::where('status',PhoneStatusEnum::NOT_VERIFIED)->count();

    	$feedbackCount = Feedback::where('isNew',1)->count();

    	$presentCount = UserPresents::where([['isGet','1'],['isSent','0']])->count();

    	$total = $reviewsCount + $commentsCount + $commentsBlogCount + $requestsCount;
        $totalGeo = $cityCount + $regionCount;

		$request->attributes->Add(['requestsCount' => $requestsCount]);
		$request->attributes->Add(['reviewsCount' => $reviewsCount]);
		$request->attributes->Add(['commentsCount' => $commentsCount]);
		$request->attributes->Add(['commentsBlogCount' => $commentsBlogCount]);
		$request->attributes->Add(['feedbackCount' => $feedbackCount]);
		$request->attributes->Add(['presentCount' => $presentCount]);
		$request->attributes->Add(['noVerifyCityCount' => $cityCount]);
		$request->attributes->Add(['noVerifyRegionCount' => $regionCount]);
		$request->attributes->Add(['notVerifyPhoneCount' => $phoneCount]);
		$request->attributes->Add(['totalNotifications' => $total]);
		$request->attributes->Add(['totalGeoNotifications' => $totalGeo]);
		return $next($request);
    }
}
