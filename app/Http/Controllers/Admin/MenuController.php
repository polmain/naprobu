<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Menu\Menu;
use App\Model\Menu\MenuItem;

use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class MenuController extends Controller
{
	protected $childsId = [];

	public function list(){
		SEO::setTitle('Меню');
		AdminPageData::setPageName('Меню');
		AdminPageData::addBreadcrumbLevel('Меню');

		$menus = Menu::withCount('items')
			->get();

		return view('admin.menu.all',[
			'menus'	=>	$menus
		]);
	}

	public function edit($id){
		$menu = Menu::with(['items'])->find($id);


		SEO::setTitle('Редактирование меню');
		AdminPageData::setPageName('Редактирование меню');
		AdminPageData::addBreadcrumbLevel('Меню','menu');
		AdminPageData::addBreadcrumbLevel('Редактирование меню');

		return view('admin.menu.edit', [
			'menu' => $menu,
		]);
	}


	public function save(Request $request,$id){
		$menu = Menu::find($id);

		$sort = 1;

		foreach ($request->item as $key=>$value){
			$this->editItem($request,$key,$sort,$menu->id);
			$sort++;
		}

		ModeratorLogs::addLog("Отредактировал Menu: ".$menu->name);
		
		if(($request->submit == "save")){
			return redirect()->route('adm_menu_edit',$menu->id);
		}
		return redirect()->route('adm_menu');
	}

	protected function editItem($request,$key,$sort,$menu_id){
		$item = MenuItem::find($request->item[$key]);
		$item->label = $request->item_label[$key];
		$item->sort = $sort;
		if($menu_id == 3){
			$item->link = $request->item_link[$key];
		}
		$item->save();


		$item_ua = $item->translates->where('lang','ua')->first();
		$item_ua->label = $request->item_label_ua[$key];
		$item_ua->sort = $sort;
		if($menu_id == 3){
			$item_ua->link = $request->item_link_ua[$key];
		}
		$item_ua->save();
	}
}
