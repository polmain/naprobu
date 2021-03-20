<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserIsBan
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
			if (Auth::user()->status_id == 3 || Auth::user()->status_id == 4) {
				return redirect()->route('user.ban');
			}
		}
		return $next($request);
    }
}
