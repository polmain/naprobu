<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Review;
use App\Model\Project\ProjectRequest;
use SEO;
use App\Library\Admin\AdminPageData;
use App\Model\Queue;

class DashboardController extends Controller
{
	protected $projectCategory = [
		1091 => "Бытовая химия",
		1107 => "Красота и уход",
		1108 => "Еда и напитки",
		1120 => "Гигиена",
		1118 => "Техника",
		1122 => "Услуги"
	];
    //
	public function home(){
		$users = User::count();
		$reviews = Review::count();
		$projects = Project::where('rus_lang_id',0)->count();
		$requests = ProjectRequest::count();

		SEO::setTitle('Главная');
		AdminPageData::setPageName('Главная');


		return view('admin.dashboard',[
			'users' => $users,
			'projects' => $projects,
			'requests' => $requests,
			'reviews' => $reviews
			]);
	}

	public function redirectsGenerator(){
		echo 'Redirect 301 / '.route('home').'<br/>';
		echo 'Redirect 301 /about '.route('about').'<br/>';
		echo 'Redirect 301 /my/reg/ '.route('registration').'<br/>';
		echo 'Redirect 301 /projects '.route('project').'<br/>';

		$projects = Project::where([
			['rus_lang_id',0],
			['isHide',0],
			])->get();

		foreach ($projects as $project){
			$old_id = $project->old_id;
			if($old_id){
				$old_cat = array_search($project->category->name,$this->projectCategory);

				echo 'Redirect 301 /projects/'.$old_cat.'/0/'.$old_id.' '.route('project.level2',[$project->translate->url]).'<br/>';
			}

		}

		echo 'Redirect 301 /reviews '.route('review').'<br/>';
		$categories = ProjectCategory::where('rus_lang_id',0)->get();
		foreach ($categories as $category){

			$old_cat = array_search($category->name,$this->projectCategory);
			echo 'Redirect 301 /reviews/'.$old_cat.' '.route('review.level2',[$category->translate->url]).'<br/>';

		}

		foreach ($projects as $project){
			$old_id = $project->old_id;
			if($old_id){
				$old_cat = array_search($project->category->name,$this->projectCategory);
				$subpages = $project->subpages->where('lang','ua')->where('type_id',1)->first();

				echo 'Redirect 301 /reviews/'.$old_cat.'/0/'.$old_id.' '.route('project.subpage',[$project->translate->url,$subpages->url]).'<br/>';
			}
		}
	}
	public function userNewPasswords(){
		$queue = new Queue();
		$queue->name = 'new_pass';
		$queue->save();
	}
}
