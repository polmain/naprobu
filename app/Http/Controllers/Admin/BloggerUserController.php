<?php

namespace App\Http\Controllers\Admin;

use App\Model\Blogger\BloggerUser;
use App\Model\Blogger\BloggerCategory;
use App\Model\Blogger\BloggerUserCategory;
use App\Model\Blogger\BloggerSubject;
use App\Model\Blogger\BloggerUserSubject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Users\ModeratorLogs;

use Excel;
use App\Imports\BloggerImport;

use SEO;
use AdminPageData;

class BloggerUserController extends Controller
{
	public function all(){

		SEO::setTitle('Все Блогеры');
		AdminPageData::setPageName('Все Блогеры');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блогеры');

		return view('admin.users.blogger.all');
	}

	public function all_ajax(Request $request){
		$users = BloggerUser::with(['city','categories','subjects']);


		return datatables()->eloquent($users)
			->addColumn('city', function (BloggerUser $user) {
				return $user->city->name;
			})
			->addColumn('categories', function (BloggerUser $user) {

				$categories= '';
				foreach ($user->categories as $category){
					$categories.= $category->name.', ';
				}
				$categories = substr($categories,0,-2);

				return $categories;
			})
			->addColumn('subjects', function (BloggerUser $user) {
				$subjects = '';
				foreach ($user->subjects as $subject){
					$subjects.= $subject->name.', ';
				}
				$subjects = substr($subjects,0,-2);

				return $subjects;
			})
			->addColumn('social', function (BloggerUser $user) {
				$subjects = '';
				foreach ($user->subjects as $subject){
					$subjects.= $subject->name.', ';
				}
				$subjects = substr($subjects,0,-2);

				return $subjects;
			})
			->toJson();
	}

	public function new(){
		SEO::setTitle('Новый блоггер');
		AdminPageData::setPageName('Новый блоггер');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блоггеры','blogger');
		AdminPageData::addBreadcrumbLevel('Новый блоггер');

		return view('admin.users.blogger.new');
	}

	public function edit($user_id){
		SEO::setTitle('Редактирование блоггера');
		AdminPageData::setPageName('Редактирование блоггера');
		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блоггеры','blogger');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		$blogger = BloggerUser::with(['city','categories','subjects'])->find($user_id);

		return view('admin.users.blogger.edit',compact('blogger'));
	}

	public function create(Request $request){
		$blogger = new BloggerUser();

		$this->createOrSave($request,$blogger);

		ModeratorLogs::addLog("Добавил блоггера: ".$blogger->name);

		return redirect()->route('adm_users_bloger');
	}

	public function save(Request $request, $blogger_id){
		$blogger = BloggerUser::find($blogger_id);

		$this->createOrSave($request,$blogger);

		ModeratorLogs::addLog("Изменил блоггера: ".$request->name);

		return redirect()->route('adm_users_bloger');
	}

	public function createOrSave($request, $user){
		$user->name = $request->name;
		$user->fio = $request->fio;
		$user->link = $request->link;
		$user->site = $request->site;
		$user->instagram_link = $request->instagram_link;
		$user->instagram_subscriber = $request->instagram_subscriber;
		$user->facebook_link = $request->facebook_link;
		$user->facebook_subscriber = $request->facebook_subscriber;
		$user->youtube_link = $request->youtube_link;
		$user->youtube_subscriber = $request->youtube_subscriber;
		$user->youtube_avg_views = $request->youtube_avg_views;
		$user->other_network = $request->other_network;
		$user->contacts = $request->contacts;
		$user->city_id = $request->city_id;
		$user->nova_poshta = $request->nova_poshta;
		$user->phone = $request->phone;
		$user->description = $request->description;
		$user->children = $request->children;
		$user->price = $request->price;
		$user->note = $request->note;
		$user->old_member_in_project = $request->old_member_in_project;

		$user->save();

		$user->categories()->detach();
		$user->subjects()->detach();
		if($request->has('categories')){
			$this->setCategories($user->id,$request->categories);
		}
		if($request->has('subjects')){
			$this->setSubject($user->id,$request->subjects);
		}
	}

	protected function setCategories($user_id, $categories){
		foreach ($categories as $category){
			BloggerUserCategory::create([
				'blogger_id' => $user_id,
				'category_id' => $category
			]);
		}
	}

	protected function setSubject($user_id, $subjects){
		foreach ($subjects as $subject_id){
			BloggerUserSubject::create([
				'blogger_id' => $user_id,
				'subject_id' => $subject_id
			]);
		}
	}

	public function delete($blogger_id){
		$blogger = BloggerUser::find($blogger_id);
		$blogger->categories()->detach();
		$blogger->subjects()->detach();

		BloggerUserProject::where('blogger_id',$blogger_id)->delete();

		$blogger->delete();

		return "ok";
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$bloggers = BloggerUser::where('name','like',$name.'%')->limit(10)->get();

		$formatted_bloggers = [];

		foreach ($bloggers as $blogger) {
			$formatted_bloggers[] = ['id' => $blogger->id, 'text' => $blogger->name];
		}

		return \Response::json($formatted_bloggers);
	}

	public function importExcel(){
		Excel::import(new BloggerImport, request()->file('file'));

		return 'ok';
	}
}
