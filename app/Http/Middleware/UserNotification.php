<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserNotification
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
		if (Auth::check())
		{
			$notify = $request->user()->userNotifications;

			$request->attributes->Add(['userNotification' => $notify]);
		}


		return $next($request);
    }
}
