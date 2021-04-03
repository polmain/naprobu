<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Project\ProjectCategory;
use Menu;

use App;


class GenerateMenus
{
    private const UKRAINE_ONLY_ROUTE_LIST = ['partner', 'blog'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $international = $request->get('international');
    	$lang = App::getLocale();
		$projectCategories = ProjectCategory::where('lang',$lang)->get();

		$menus = App\Model\Menu\Menu::all();

		foreach ($menus as $menu){
			Menu::make($menu->name, function ($menuView) use ($projectCategories, $lang, $menu, $international) {
				foreach ($menu->items->where('lang',$lang) as $menuItem){
				    if ($international && in_array($menuItem->route, self::UKRAINE_ONLY_ROUTE_LIST)){
				        continue;
                    }
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
