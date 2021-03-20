<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Auth;

class UserChangeLang
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
			$lang = App::getLocale();
			if($lang != 'ua' && $lang != 'ru'){
				$lang = 'ua';
			}

			$request->user()->lang = $lang;
			$request->user()->save();
		}


		return $next($request);
    }
}
