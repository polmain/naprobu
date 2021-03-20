<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin\UserLog;
use Illuminate\Support\Facades\Auth;
use App\Library\Users\ModeratorLogs;

class ChangePageLog
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
				//ModeratorLogs::addLog("Переход на страницу");
			}
		}
        return $next($request);
    }
}
