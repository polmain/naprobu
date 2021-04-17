<?php

namespace App\Http\Controllers\Admin\Project;

use App\Model\Blogger\BloggerUser;
use App\Model\Blogger\BloggerUserProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Library\Users\ModeratorLogs;

use Export;
use App\Exports\SelectionBlogger;
use App\Exports\ProjectBlogger;

use SEO;
use AdminPageData;
use Carbon;

class BloggerController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

	public function all(Request $request){
		$type = ['expert-blogger','only-blogger'];

		$statuses = [];
		if($request->has('status')){
			if(isset($request->status)){
				if($request->status == 1){
					$statuses = [2,4,5,6,7];
				}else{
					$statuses = [1,3];
				}
			}
		}

		$projects = Project::with(['category','status','requests'])
			->withCount(['requests'])
			->where([
				['lang','ru'],
				])
			->whereIn('type',['expert-blogger','only-blogger']);

		if($request->has('name')){
			$name = $request->input('name');
			if(isset($name)){
				$projects = $projects->where('name','like','%'.$name.'%');
			}
		}
		if($request->has('status')){

			if($request->input('status') !== null){
				$projects = $projects->whereIn('status_id',$statuses);
			}
		}
		if($request->has('date_from')){
			$date = $request->input('date_from');
			if(isset($date)){
				$projects = $projects->where('start_registration_time','>=',Carbon::parse($request->date_from));
			}
		}
		if($request->has('date_to')){
			$date = $request->input('date_to');
			if(isset($date)){
				$projects = $projects->where('end_project_time','<=',Carbon::parse($request->date_to));
			}
		}

		$projects = $projects->get();
		SEO::setTitle('Проекты для блоггеров');
		AdminPageData::setPageName('Проекты для блоггеров');
		AdminPageData::addBreadcrumbLevel('Для блоггеров');

		return view('admin.projects.blogger.all',['projects'=>$projects]);
	}

	public function findMembers($project_id){
		$project = Project::find($project_id);

		SEO::setTitle('Подборка блогеров');
		AdminPageData::setPageName('Подборка блогеров');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Подборка блогеров');

		return view('admin.projects.blogger.add_member',[
			'project' => $project,
		]);
	}

	public function findBloggers(Request $request){
		$bloggers = BloggerUser::with(['city','categories','subjects','subjectsID','categoriesID']);

		if($request->has('bloggers')){
			$blogger_arr = [];
			foreach ( $request->input('bloggers') as $key => $item){
				$blogger_arr[] = (int)$request->input('bloggers')[$key];
			}
			$bloggers = $bloggers->whereIn('id', $blogger_arr);
		}
		if($request->has('cities')){
			$cities = [];
			foreach ( $request->input('cities') as $key => $item){
				$cities[] = (int)$request->input('cities')[$key];
			}
			$bloggers = $bloggers->whereIn('city_id', $cities);
		}
		if($request->has('categories')){
			$filterItem = [];
			foreach ( $request->input('categories') as $key => $item){
				$filterItem[] = (int)$request->input('categories')[$key];
			}
			$bloggers = $bloggers->whereHas('categoriesId', function ($categories) use ($filterItem){
				$categories->whereIn('category_id', $filterItem);
			});
		}
		if($request->has('subjects')){
			$filterItem = [];
			foreach ( $request->input('subjects') as $key => $item){
				$filterItem[] = (int)$request->input('subjects')[$key];
			}
			$bloggers = $bloggers->whereHas('subjectsId', function ($subjects) use ($filterItem){
				$subjects->whereIn('subject_id', $filterItem);
			});
		}
		if($request->social){
			$filterItem = [];
			$filterItem[] = [
				$request->input('social'),'<>',null
			];
			$bloggers = $bloggers->where($filterItem);
		}
		$bloggers = $bloggers->get();
		$view = view('admin.users.blogger.include.finds_blogger',compact('bloggers'))->render();
		return response()->json([
			'html' => $view,
		]);
	}

	public function addMember(Request $request, $project_id){
		if($request->submit == "save"){
			if($request->has('blogger_id')){
				foreach ( $request->input('blogger_id') as $key => $item){
					$bloggerProject = new BloggerUserProject();
					$bloggerProject->blogger_id = (int)$request->input('blogger_id')[$key];
					$bloggerProject->project_id = $project_id;
					$bloggerProject->save();
				}
				return redirect()->route('adm_project_edit',[$project_id]);
			}else{
				return redirect()->back();
			}

		}else{
			$excel = new SelectionBlogger($request);
			return $excel->download('bloggers_'.time().'.xlsx');
		}
	}

	public function viewMembers($project_id){
		$project = Project::find($project_id);

		SEO::setTitle('Блоггеры проекта');
		AdminPageData::setPageName('Блоггеры проекта');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project->id);
		AdminPageData::addBreadcrumbLevel('Блоггеры');

		return view('admin.projects.blogger.view_member',[
			'project' => $project,
		]);
	}

	public function editMembers(Request $request,$member_id){
		$bloggerProject = BloggerUserProject::find($member_id);

		$bloggerProject->format = $request->input('format');
		$bloggerProject->ohvat = $request->ohvat;
		$bloggerProject->prise_without_nds = $request->prise_without_nds;
		$bloggerProject->link_to_post = $request->link_to_post;
		$bloggerProject->screen_post = $request->screen_post;
		$bloggerProject->views = $request->views;
		$bloggerProject->likes = $request->likes;
		$bloggerProject->comments = $request->comments;
		$bloggerProject->ohvat_fact = $request->ohvat_fact;
		$bloggerProject->er = $request->er;
		$bloggerProject->other = $request->other;

		$bloggerProject->save();

		ModeratorLogs::addLog("Изменил информацию о блоггере: ".$bloggerProject->blogger->name);

		return redirect()->route('adm_project_blogger_view_member',[$bloggerProject->project_id]);
	}

	public function exportMembers($project_id){
		$excel = new ProjectBlogger($project_id);
		return $excel->download('bloggers_'.time().'.xlsx');
	}

}
