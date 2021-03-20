<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\User\UserNotification;
use Carbon;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function get(Request $request){
		$user = Auth::user();

		$notifications = UserNotification::where([
			['user_id',$user->id],
			['created_at','>=',Carbon::now()->subSeconds(15)],
		])->get();

		$view = view('user.include.notification_popup',compact('notifications'))->render();
		$notification = view('user.include.notification_page',compact('notifications'))->render();
		return response()->json(['html'=>$view,'notification' => $notification,'count' => $notifications->count()]);
	}

	public function onView(Request $request){
		$user = Auth::user();

		$notifications = UserNotification::where([
			['user_id',$user->id],
			['isNew',1],
		])->get();

		foreach ($notifications as $notification){
			$notification->isNew = 0;
			$notification->save();
		}
	}
}
