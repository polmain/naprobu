<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\Model\Admin\AdminPageName;

class PageName
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
		$pageName = "";
		$url = $request->path();
		$urls = explode('/', $url);
		$levels = count($urls);
		$pageName = "";
		if($levels<=3){
			$pageNameObj = AdminPageName::where('url', $url)->first();
			if($pageNameObj){
				$pageName = $pageNameObj->name;
			}
		}

		$request->attributes->Add(['pageName' => $pageName]);
        return $next($request);
    }
}
