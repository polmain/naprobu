<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use App\User;
use App\Model\Admin\ModeratorActiveTime;
use Illuminate\Support\Facades\Auth;

class IsUserOnline
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
    	if($request->route()->getName() != 'user.notification.get'){
			if (Auth::check())
			{
				$request->user()->last_active = Carbon::now();
				$request->user()->save();

				if($request->user()->hasRole('moderator')){
					$moderatorActiveTime = ModeratorActiveTime::where('user_id',$request->user()->id)->orderBy('id','desc')->first();
					if(empty($moderatorActiveTime)){
						$moderatorActiveTime = new ModeratorActiveTime();
						$moderatorActiveTime->user_id = $request->user()->id;
					}elseif(Carbon::now()->subMinutes(5)->gt(new Carbon($moderatorActiveTime->updated_at))){
						$moderatorActiveTime = new ModeratorActiveTime();
						$moderatorActiveTime->user_id = $request->user()->id;
					}
					$moderatorActiveTime->updated_at = Carbon::now();
					$moderatorActiveTime->save();
				}
			}
		}

        return $next($request);
    }
}
