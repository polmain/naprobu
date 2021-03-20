<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Post;
use App\Model\Review\StatusReview;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\User;
use App\Model\Post\PostComment;
use Image;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class BlogController extends Controller
{
	public function all(){
		$posts = Post::with(['project','comments'])->where('rus_lang_id',0)->get();

		SEO::setTitle('Блог');
		AdminPageData::setPageName('Блог');
		AdminPageData::addBreadcrumbLevel('Блог');

		return view('admin.post.all',[
			'posts'	=>	$posts
		]);
	}

	public function new(){
		$projects = Project::where('rus_lang_id',0)->get();

		SEO::setTitle('Новая статья');
		AdminPageData::setPageName('Новая статья');
		AdminPageData::addBreadcrumbLevel('Блог','blog');
		AdminPageData::addBreadcrumbLevel('Новая статья');

		return view('admin.post.new',[
			'projects'	=>	$projects
		]);
	}

	public function edit($post_id){
		$projects = Project::where('rus_lang_id',0)->get();
		$post = Post::with(['translate','tags.translate','author'])->where('id',$post_id)->first();

		SEO::setTitle('Редактирование статьи');
		AdminPageData::setPageName('Редактирование статьи');
		AdminPageData::addBreadcrumbLevel('Блог','blog');
		AdminPageData::addBreadcrumbLevel('Редактирование статьи');

		return view('admin.post.edit',[
			'projects'	=>	$projects,
			'post'	=>	$post,
		]);
	}

	public function create(Request $request){
		$post = new Post();
		$this->saveOrCreate($post,$request);

		ModeratorLogs::addLog("Создал статью: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_post_edit',$post->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_post');
		}else{
			return redirect()->route('adm_post_new');
		}
	}

	public function save(Request $request,$post_id){
		$post = Post::find($post_id);
		$this->saveOrCreate($post,$request);

		ModeratorLogs::addLog("Отредактировал страницу: ".$request->name);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_post_edit',$post->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_post');
		}else{
			return redirect()->route('adm_post_new');
		}
	}

	public function delete($post_id){
		Post::destroy($post_id);

		Post\PostComment::where('post_id',$post_id)->delete();
		Post\PostTag::where('post_id',$post_id)->delete();

		Post::where('rus_lang_id',$post_id)->delete();
		return "ok";
	}

	public function hide($post_id){
		$post = Post::find($post_id);
		$post->isHide = true;
		$post->save();
		$post->translate->isHide = true;
		$post->translate->save();
		return "ok";
	}
	public function show($post_id){
		$post = Post::find($post_id);
		$post->isHide = false;
		$post->save();

		$post->translate->isHide = false;
		$post->translate->save();
		return "ok";
	}

	protected function saveOrCreate($post,$request){
		$post->name = $request->name;
		$post->content = $request->content;
		$post->url = $request->url;
		$post->isHide = ($request->submit == "save-hide");
		$post->project_id = ($request->has('project_id'))?$request->project_id:null;
		$post->image = $request->image;
		$post->author_id = $request->author_id;
		$post->seo_title = $request->seo_title;
		$post->seo_description = $request->seo_description;
		$post->seo_keywords = $request->seo_keywords;

		if(isset($request->password)){
			$post->password = Hash::make($request->password);
		}

		$post->save();

		$post->makeTags($request->tags);

		$translate = Post::where('rus_lang_id',$post->id)->first();
		if(empty($translate)){
			$translate = new Post();
			$translate->rus_lang_id = $post->id;
			$translate->lang = 'ua';
		}
		$translate->name = $request->nameUA;
		$translate->content = $request->contentUA;
		$translate->url = $request->urlUA;
		$translate->isHide = ($request->submit == "save-hide");
		$translate->project_id = $request->project_id;
		$translate->author_id = $request->author_id;
		$translate->password = $post->password;

		$translate->seo_title = $request->seo_titleUA;
		$translate->seo_description = $request->seo_descriptionUA;
		$translate->seo_keywords = $request->seo_keywordsUA;
		$translate->save();
	}

	public function validURL(Request $request,$post_id)
	{
		$url = $request->url;
		$lang = $request->lang;

		if($this->isBusyUrlBlog($lang,$post_id,$url) || $this->isBusyUrlProjectCategory($lang,$post_id,$url))
		{
			$id = 0;
			do{
				if($id > 50){
					break;
				}
				$id++;
			}while($this->isBusyUrlBlog($lang,$post_id,$url.'-'.$id)  || $this->isBusyUrlProjectCategory($lang,$post_id,$url.'-'.$id));
			$url .= '-'.$id;
		}

		return $url;
	}

	protected function isBusyUrlBlog($lang,$post_id,$url){
		if($lang == 'ru'){
			return Post::where([
					['lang','ru'],
					['id','<>',$post_id],
					['url',$url],
				])->first() !== null;
		}else{
			return Post::where([
					['lang','ua'],
					['rus_lang_id','<>',$post_id],
					['url',$url],
				])->first() !== null;
		}
	}

	protected function isBusyUrlProjectCategory($lang,$category_id,$url){
		if($lang == 'ru'){
			return ProjectCategory::where([
					['lang','ru'],
					['id','<>',$category_id],
					['url',$url],
				])->first() !== null;
		}else{
			return ProjectCategory::where([
					['lang','ua'],
					['rus_lang_id','<>',$category_id],
					['url',$url],
				])->first() !== null;
		}
	}
}
