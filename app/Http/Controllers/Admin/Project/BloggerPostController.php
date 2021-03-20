<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Project\ProjectBloggerPost;
use App\Model\Project;
use App\Library\Users\ModeratorLogs;
use PDF;
use SEO;
use AdminPageData;
use Storage;

class BloggerPostController extends Controller
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

	public function all($project_id){
		$posts = ProjectBloggerPost::where('project_id',$project_id)
			->get();
		$project = Project::find($project_id);

		SEO::setTitle('Все посты');
		AdminPageData::setPageName('Все посты');
		AdminPageData::addBreadcrumbLevel($project->name, 'edit/'.$project_id);
		AdminPageData::addBreadcrumbLevel('Посты');

		return view('admin.projects.blogger.post.all',[
			'posts'		=> $posts,
			'project'	=> $project
		]);
	}

	public function create(Request $request, $project_id){
		$post = new ProjectBloggerPost();
		$post->code = $request->code;
		$post->project_id = $project_id;
		$post->save();

		ModeratorLogs::addLog("Добавил пост к проекту: ".Project::find($project_id)->name);

		return redirect()->route('adm_project_blogger_post',$project_id);
	}

	public function delete($post_id){
		ProjectBloggerPost::destroy($post_id);
		return "ok";
	}

	public function hide($post_id){
		$post = ProjectBloggerPost::find($post_id);
		$post->isHide = true;
		$post->save();
		return "ok";
	}
	public function show($post_id){
		$post = ProjectBloggerPost::find($post_id);
		$post->isHide = false;
		$post->save();
		return "ok";
	}
}
