<?php

namespace App\Http\Controllers\Admin\Blogger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blogger\BloggerCity;
use App\Library\Users\ModeratorLogs;

use SEO;
use AdminPageData;

class CityController extends Controller
{
	public function __construct()
	{

		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блогеры','blogger');
	}

	public function all(){
		$cities = BloggerCity::all();

		SEO::setTitle('Все города');
		AdminPageData::setPageName('Все города');
		AdminPageData::addBreadcrumbLevel('Города');

		return view('admin.users.blogger.city.all',compact('cities'));
	}

	public function create(Request $request){
		$city = new BloggerCity();
		$city->name = $request->name;
		$city->save();

		ModeratorLogs::addLog("Добавил город: ".$city->name);

		return redirect()->route('adm_users_blogger_city');
	}

	public function save(Request $request, $city_id){
		$city = BloggerCity::find($city_id);
		$city->name = $request->name;
		$city->save();

		ModeratorLogs::addLog("Изменил город: ".$city->name);

		return redirect()->route('adm_users_blogger_city');
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$cities = BloggerCity::where('name','like',$name.'%')->limit(10)->get();

		$formatted_cities = [];

		foreach ($cities as $city) {
			$formatted_cities[] = ['id' => $city->id, 'text' => $city->name];
		}

		return \Response::json($formatted_cities);
	}
}
