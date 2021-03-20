<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin\UserLog;
use Illuminate\Support\Facades\Auth;

class ModeratorLogs
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
			if ($request->user()->hasRole('moderator'))
			{
				$log = new UserLog();
				$log->user_id = $request->user()->id;
				$log->action = "Переход на страницу";
				$log->url = $request->getHost() . "/" . $request->path();
				$log->save();
			}
		}
        return $next($request);
    }
}
