<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Admin\iAdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project\ProjectBloggerPost;
use App\Model\Blogger\BloggerUserProject;
use App\Model\Project\ProjectCategory;
use App\Model\Project;
use App\Model\Review;
use App\Model\Post;
use App\Model\Questionnaire;
use App\Model\Questionnaire\Answer;
use App\Model\User\UserShipping;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class CategoryController extends Controller implements iAdminController
{
	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}

	//Список всех категорий проектов
	public function all(){
		$categories = ProjectCategory::with(['projects'])
			->where('lang','ru')
			->get();

		SEO::setTitle('Категории проектов');
		AdminPageData::setPageName('Категории проектов');
		AdminPageData::addBreadcrumbLevel('Категории');

		return view('admin.projects.category.all',['categories'=>$categories]);
	}

	public function new()
	{
		SEO::setTitle('Новая категория проектов');
		AdminPageData::setPageName('Новая категория проектов');
		AdminPageData::addBreadcrumbLevel('Категории','category');
		AdminPageData::addBreadcrumbLevel('Новая категория проектов');

		return view('admin.projects.category.new');
	}

	public function create(Request $request)
	{
		$category = new ProjectCategory();
		$this->createOrEdit($request, $category, "create");

		ModeratorLogs::addLog("Создал Категорию для проектов: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_category_edit',$category->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_category');
		}else{
			return redirect()->route('adm_project_category_new');
		}
	}

	public function edit(Request $request, $category_id)
	{
		$category =  ProjectCategory::find($category_id);
		$translate =  ProjectCategory::where('rus_lang_id',$category->id)->first();
		if(empty($translate)){
			$translate = new ProjectCategory();
		}

		SEO::setTitle('Редактирование категории проектов: '.$category->name);
		AdminPageData::setPageName('Редактирование категории проектов');
		AdminPageData::addBreadcrumbLevel('Категории','category');
		AdminPageData::addBreadcrumbLevel($category->name);

		return view('admin.projects.category.edit',[
			'category'	=>	$category,
			'translate'	=>	$translate
		]);
	}

	public function save(Request $request, $category_id)
	{
		$category = ProjectCategory::find($category_id);
		$this->createOrEdit($request, $category, "update");

		ModeratorLogs::addLog("Отредактировал Категорию для проектов: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_category_edit',$category_id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_category');
		}else{
			return redirect()->route('adm_project_category_new');
		}
	}

	public function delete($category_id)
	{
		ProjectCategory::destroy($category_id);

		$projects = Project::where('category_id',$category_id);

		foreach ($projects as $project){
			$project_id = $project->id;
			$subpages = Project\Subpage::where('project_id',$project_id)->get();

			foreach ($subpages as $subpage){
				$reviews = Review::where('subpage_id',$subpage->id)->get();
				foreach ($reviews as $review){
					Review\Comment::where('review_id',$review->id)->delete();
					Review\ReviewLike::where('review_id',$review->id)->delete();
					$review->delete();
				}
				$subpage->delete();
			}
			Project\ProjectBloggerPost::where('project_id',$project_id)->delete();
			BloggerUserProject::where('project_id',$project_id)->delete();

			$questionnaires = Questionnaire::where('project_id',$project_id)->get();

			foreach ($questionnaires as $questionnaire){
				Questionnaire\Question::where('questionnaire_id',$questionnaire->id)->delete();
				$questionnaire->delete();
			}

			$requests = ProjectRequest::where('project_id',$project_id)->get();
			foreach ($requests as $request){
				Answer::where('project_request_id',$request->id)->delete();
				UserShipping::where('request_id',$request->id)->delete();
				$request->delete();
			}

			$posts = Post::where('project_id',$project_id)->get();
			foreach ($posts as $post){
				Post\PostComment::where('post_id',$post->id)->delete();
				Post\PostTag::where('post_id',$post->id)->delete();
				$post->delete();
			}

			ProjectMessage::where('project_id',$project_id)->delete();

			Project::where('rus_lang_id',$project_id)->delete();
		}

		ProjectCategory::where('rus_lang_id',$category_id)->delete();
		return "ok";
	}

	public function hide($category_id)
	{
		$category = ProjectCategory::find($category_id);
		$category->isHide = true;
		$category->save();
		$category = ProjectCategory::where('rus_lang_id',$category_id)->first();
		$category->isHide = true;
		$category->save();
		return "ok";
	}

	public function show($category_id)
	{
		$category = ProjectCategory::find($category_id);
		$category->isHide = false;
		$category->save();

		$category = ProjectCategory::where('rus_lang_id',$category_id)->first();
		$category->isHide = false;
		$category->save();
		return "ok";
	}

	protected function createOrEdit($request,$category,$mode){
		$category->name = $request->name;
		$category->url = $request->url;
		$category->isHide = ($request->submit == "save-hide");

		//Seo
		$category->seo_title = $request->title;
		$category->seo_description = $request->description;
		$category->seo_keyword = $request->keywords;

		$category->save();

		//Translate
		$categoryUA = ProjectCategory::where('rus_lang_id',$category->id)->first();

		if(empty($categoryUA))
		{
			$categoryUA = new ProjectCategory();
			$categoryUA->lang = 'ua';
			$categoryUA->rus_lang_id = $category->id;

		}

		$categoryUA->name = $request->nameUA;
		$categoryUA->url = $request->urlUA;
		$categoryUA->isHide = ($request->submit == "save-hide");

		//Seo
		$categoryUA->seo_title = $request->titleUA;
		$categoryUA->seo_description = $request->descriptionUA;
		$categoryUA->seo_keyword = $request->keywordsUA;

		$categoryUA->save();
	}
}
