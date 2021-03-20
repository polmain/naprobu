<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Review\StatusReview;
use App\Model\Project;
use App\User;
use App\Model\Post\PostComment;
use Image;
use App\Library\Users\ModeratorLogs;

class BlogController extends Controller
{
	public function all(){
		$posts = Post::with(['project','comments'])->where('rus_lang_id',0)->get();
		return view('admin.post.all',[
			'posts'	=>	$posts
		]);
	}

	public function new(){
		$projects = Project::where('rus_lang_id',0)->get();
		return view('admin.post.new',[
			'projects'	=>	$projects
		]);
	}

	public function edit($post_id){
		$projects = Project::where('rus_lang_id',0)->get();
		$post = Post::with(['translate'])->where('id',$post_id)->first();
		return view('admin.post.edit',[
			'projects'	=>	$projects,
			'post'	=>	$post,
		]);
	}

	public function create(Request $request){
		$post = new Post();
		$this->saveOrCreate($post,$request);

		ModeratorLogs::addLog("Создал статью: ".$request->name);
		if(($request->submit == "save-hide")||($request->submit == "save-close")){
			return redirect()->route('adm_post');
		}else{
			return redirect()->route('adm_post_new');
		}
	}

	public function save(Request $request,$post_id){
		$post = Post::find($post_id);
		$this->saveOrCreate($post,$request);

		ModeratorLogs::addLog("Отредактировал страницу: ".$request->name);
		if(($request->submit == "save-hide")||($request->submit == "save-close")){
			return redirect()->route('adm_post');
		}else{
			return redirect()->route('adm_post_new');
		}
	}

	public function delete($post_id){
		Post::destroy($post_id);
		Post::where('rus_lang_id',$post_id)->delete();
		return "ok";
	}

	public function hide($post_id){
		$post = Post::find($post_id);
		$post->isHide = true;
		$post->save();
		return "ok";
	}
	public function show($post_id){
		$post = Post::find($post_id);
		$post->isHide = false;
		$post->save();
		return "ok";
	}

	protected function saveOrCreate($post,$request){
		$post->name = $request->name;
		$post->content = $request->content;
		$post->url = $request->url;
		$post->isHide = ($request->submit == "save-hide");
		$post->project_id = $request->project_id;
		if($request->hasFile('image')){
			$image = $request->file('image');
			$name = time();
			$images = [];
			$images[] = $filename = $name . '_large.' . $image->getClientOriginalExtension();
			Image::make($image)->save( public_path('/uploads/images/blog/' . $filename ) );
			$images[] = $filename = $name . '_small.' . $image->getClientOriginalExtension();
			Image::make($image)->fit (400, 400)->save( public_path('/uploads/images/blog/' . $filename ) );

			$post->image = $images;
		}

		$post->seo_title = $request->seo_title;
		$post->seo_description = $request->seo_description;
		$post->seo_keywords = $request->seo_keywords;
		$post->save();

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

		$translate->seo_title = $request->seo_titleUA;
		$translate->seo_description = $request->seo_descriptionUA;
		$translate->seo_keywords = $request->seo_keywordsUA;
		$translate->save();
	}
}
