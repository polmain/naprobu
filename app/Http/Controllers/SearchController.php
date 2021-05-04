<?php

namespace App\Http\Controllers;

use App\Services\LanguageServices\AlternativeUrlService;
use Illuminate\Http\Request;
use App;
use App\Model\Project;
use App\Model\Review;
use App\Model\Post;
use App\Model\Page;
use SEO;
use SEOMeta;
use OpenGraph;

class SearchController extends Controller
{
	public function live(Request $request){
		if($request->ajax()){
			$locale = $request->lang;

			$name = $request->get('name');

			App::setLocale($locale);

			$projects = Project::where([
				['name','like',"%".$name."%"],
				['status_id','<>',3],
				['status_id','<>',10],
				['isHide',0],
				['type','<>','only-blogger'],
				['lang',$locale]
			])->orWhere([
				['text','like',"%".$name."%"],
				['status_id','<>',3],
				['status_id','<>',10],
				['isHide',0],
				['type','<>','only-blogger'],
				['lang',$locale]
			])->orderBy('id','desc')->limit(5)->get();

			$posts = Post::where([
				['name','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orWhere([
				['content','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orderBy('id','desc')->limit(5)->get();

			$reviews= Review::where([
				['name','like',"%".$name."%"],
				['isHide',0],
				['status_id',2],
			])->orderBy('id','desc')->limit(5)->get();

			$result = [];

			if(count($projects))
			{
				$category = [];
				foreach ($projects as $project)
				{
					$category[] = ['text' => $project->name, 'url' => route('project.level2', [$project->url])];
				}
				$result['project'] = $category;
			}

			if(count($posts)){
				$category = [];
				foreach ($posts as $post) {
					$category[] = ['text' => $post->name, 'url' => route('blog.level2',[$post->url])];
				}
				$result['blog'] = $category;
			}

			if(count($reviews)){
				$category = [];
				foreach ($reviews as $review) {
					$category[] = ['text' => $review->name, 'url' => route('review.level2',[$review->id])];
				}
				$result['review'] = $category;
			}

			$view = view('include.search_result',compact('result'))->render();


			return response()->json(['html'=>$view]);
		}

	}

	public function index(Request $request)
	{
		$locale = App::getLocale();

		$page = Page::where([
			['url','search'],
			['lang',$locale],
		])->first();

		$name = $request->get('name');
		$result = [];
		$error = '';

		if(mb_strlen($name)>2){
			$projects = Project::where([
				['name','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orWhere([
				['text','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orderBy('id','desc')->get();

			$posts = Post::where([
				['name','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orWhere([
				['content','like',"%".$name."%"],
				['isHide',0],
				['lang',$locale]
			])->orderBy('id','desc')->get();

			$reviews= Review::where([
				['name','like',"%".$name."%"],
				['isHide',0],
				['status_id',2],
			])->orderBy('id','desc')->get();



			if(count($projects))
			{
				$category = [];
				foreach ($projects as $project)
				{
					$category[] = ['name' => $project->name, 'url' => route('project.level2', [$project->url])];
				}
				$result['project'] = $category;
			}

			if(count($posts)){
				$category = [];
				foreach ($posts as $post) {
					$category[] = ['name' => $post->name, 'url' => route('blog.level2',[$post->url])];
				}
				$result['blog'] = $category;
			}

			if(count($reviews)){
				$category = [];
				foreach ($reviews as $review) {
					$category[] = ['name' => $review->name, 'url' => route('review.level2',[$review->id])];
				}
				$result['review'] = $category;
			}
		}else{
			$error = trans('search.little');
		}

		$title = $page->seo_title ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','title_default'],['lang',$locale]])->first()->value);
		$description = $page->seo_description ?? str_replace(':page_name:',$page->name, \App\Model\Setting::where([['name','description_default'],['lang',$locale]])->first()->value);
		$og_image = $page->og_image ?? \App\Model\Setting::where('name','og_image_default')->first()->value;

		SEO::setTitle($title);
		SEO::setDescription($description);
		SEOMeta::setKeywords($page->seo_keywords);
		OpenGraph::addImage([
				'url' => (($request->secure())?"https://":"http://").$request->getHost().$og_image,
				'width' => 350,
				'height' => 220
			]
		);

        $routes = AlternativeUrlService::generateReplyRoutes('search/?name='.$request->name);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		return view('search',[
			'page' => $page,
			'result' => $result,
			'error' => $error,
			'alternativeUrls' => $alternativeUrls
		]);
	}
}
