<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Project\ProjectCategory;
use Menu;

use App;


class GenerateMenus
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
    	$lang = App::getLocale();
		$projectCategories = ProjectCategory::where('lang',$lang)->get();

		$menus = App\Model\Menu\Menu::all();

		foreach ($menus as $menu){
			Menu::make($menu->name, function ($menuView) use ($projectCategories, $lang, $menu) {
				foreach ($menu->items->where('lang',$lang) as $menuItem){
					$options = [];
					if($menuItem->route){
						$options['route'] = $menuItem->route;
					}
					if($menuItem->link){
						$options['url'] = $menuItem->link;
					}
					if($menuItem->hasChild){
						$options['class'] = 'parent-menu-item';
					}
					$options['secure'] = true;

					$menuView->add($menuItem->label, $options)->nickname($menuItem->name);

					if($menuItem->hasChild){
						foreach ($projectCategories as $projectCategory){
							$menuView->get($menuItem->name)->add($projectCategory->name,route('project.level2',$projectCategory->url));
						}
					}
				}
			});
		}
		
		return $next($request);
    }

}
