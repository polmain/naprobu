<?php

namespace App\Http\Controllers\Admin\Blogger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blogger\BloggerSubject;
use App\Library\Users\ModeratorLogs;

use SEO;
use AdminPageData;

class SubjectController extends Controller
{
	public function __construct()
	{

		AdminPageData::addBreadcrumbLevel('Пользователи','users');
		AdminPageData::addBreadcrumbLevel('Блогеры','blogger');
	}

	public function all(){
		$subjects = BloggerSubject::all();

		SEO::setTitle('Все тематики');
		AdminPageData::setPageName('Все тематики');
		AdminPageData::addBreadcrumbLevel('Тематики');

		return view('admin.users.blogger.subject.all',compact('subjects'));
	}

	public function create(Request $request){
		$subject = new BloggerSubject();
		$subject->name = $request->name;
		$subject->save();

		ModeratorLogs::addLog("Добавил тематику: ".$subject->name);

		return redirect()->route('adm_users_blogger_subject');
	}

	public function save(Request $request, $subject_id){
		$subject = BloggerSubject::find($subject_id);
		$subject->name = $request->name;
		$subject->save();

		ModeratorLogs::addLog("Изменил тематику: ".$subject->name);

		return redirect()->route('adm_users_blogger_subject');
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$subjects = BloggerSubject::where('name','like',$name.'%')->limit(10)->get();

		$formatted_subjects = [];

		foreach ($subjects as $subject) {
			$formatted_subjects[] = ['id' => $subject->id, 'text' => $subject->name];
		}

		return \Response::json($formatted_subjects);
	}
}
