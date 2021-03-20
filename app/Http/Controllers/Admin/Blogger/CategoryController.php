<?php

namespace App\Http\Controllers\Admin\Blogger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blogger\BloggerCategory;
use App\Library\Users\ModeratorLogs;

use SEO;
use AdminPageData;

class CategoryController extends Controller
{
	public function __construct()
	{

		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блогеры','blogger');
	}

	public function all(){
		$categories = BloggerCategory::all();

		SEO::setTitle('Все категории');
		AdminPageData::setPageName('Все категории');
		AdminPageData::addBreadcrumbLevel('Категории');

		return view('admin.users.blogger.category.all',compact('categories'));
	}

	public function create(Request $request){
		$category = new BloggerCategory();
		$category->name = $request->name;
		$category->save();

		ModeratorLogs::addLog("Добавил категорию: ".$category->name);

		return redirect()->route('adm_users_blogger_category');
	}

	public function save(Request $request, $category_id){
		$category = BloggerCategory::find($category_id);
		$category->name = $request->name;
		$category->save();

		ModeratorLogs::addLog("Изменил категорию: ".$category->name);

		return redirect()->route('adm_users_blogger_category');
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$categories = BloggerCategory::where('name','like',$name.'%')->limit(10)->get();

		$formatted_categories = [];

		foreach ($categories as $category) {
			$formatted_categories[] = ['id' => $category->id, 'text' => $category->name];
		}

		return \Response::json($formatted_categories);
	}
}
