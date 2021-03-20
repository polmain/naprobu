<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\Model\Admin\AdminPageName;
use App\User;

class Breadcrumbs
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
		$url = $request->path();
		$urls = explode('/', $url);
		$curUrl = '';
		$curUrlModer = '';
		$levels = count($urls);
		$level = 0;
		$breadcrumbs = '<ol class="breadcrumb">';
		foreach ($urls as $key => $value){
			if($level<3){
				$level++;
				if($key != 0){
					$curUrl .= '/';
				}
				$curUrl .= $value;
				$pageName = AdminPageName::where('url', $curUrl)->first()->name;
				if($key == 0){
					$breadcrumbs .= ' <li><a href="/'.$curUrl.'"><i class="fa fa-dashboard"></i>'.$pageName.'</a></li>';
				}
				elseif($key < $levels-1){
					$breadcrumbs .= ' <li><a href="/'.$curUrl.'">'.$pageName.'</a></li>';
				}else{
					$breadcrumbs .= ' <li class="active">'.$pageName.'</li>';
				}
			}
		}

		$breadcrumbs .= '</ol>';



		$request->attributes->Add(['breadcrumbs' => $breadcrumbs]);
        return $next($request);
    }
}
