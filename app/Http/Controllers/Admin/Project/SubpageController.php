<?php

namespace App\Http\Controllers\Admin\Project;

use App\Library\Users\Notification;
use App\Mail\UserNotificationMail;
use App\Model\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\iAdminController;
use App\Model\Project;
use App\Model\Project\Subpage;
use App\Model\Project\SubpageType;
use App\Model\Review;
use App\Library\Users\ModeratorLogs;
use Illuminate\Support\Facades\Mail;
use SEO;
use AdminPageData;

class SubpageController extends Controller implements iAdminController
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Проекты','project');
	}
    //
	public function all()
	{
		$subpages = Subpage::with(['project','type'])
			->where('lang','ru')
			->orderBy('id','desc')
			->get();

		SEO::setTitle('Подстраницы проектов');
		AdminPageData::setPageName('Подстраницы проектов');
		AdminPageData::addBreadcrumbLevel('Подстраницы');

		return view('admin.projects.subpage.all',[
			'subpages'=>$subpages
		]);
	}

	public function project($project_id)
	{
		$subpages = Subpage::with(['project','type'])
			->where([
				['lang','ru'],
				['project_id',$project_id]
			])
			->get();
		$project = Project::find($project_id);
		SEO::setTitle('Подстраницы проекта: '.$project->name);
		AdminPageData::setPageName('Подстраницы проектов');
		AdminPageData::addBreadcrumbLevel($project->name,'edit/'.$project_id);
		AdminPageData::addBreadcrumbLevel('Подстраницы');


		return view('admin.projects.subpage.all',[
			'subpages'=>$subpages
		]);
	}

	public function find(Request $request)
	{
		$name = $request->name;
		$project = $request->project;

		$subpages = Subpage::where('project_id',$project)
			->where('name','like',["%{$name}%"])
			->limit(5)
			->get();

		$formatted_subpages = [];

		foreach ($subpages as $subpage) {
			$formatted_subpages[] = ['id' => $subpage->id, 'text' => $subpage->name];
		}

		return \Response::json($formatted_subpages);
	}

	public function new()
	{
		$projects = Project::with(['category.translate','translate'])
			->where('lang','ru')
			->get();
		$types = SubpageType::where('lang','ru')->get();

		SEO::setTitle('Новая подстраница проекта');
		AdminPageData::setPageName('Новая подстраница проекта');
		AdminPageData::addBreadcrumbLevel('Подстраницы','subpages');
		AdminPageData::addBreadcrumbLevel('Новая подстраница');

		return view('admin.projects.subpage.new',[
			'projects' => $projects,
			'types' => $types
		]);
	}

	public function create(Request $request)
	{
		$subpage = new Subpage();
		$this->createOrEdit($request, $subpage, "create");

		ModeratorLogs::addLog("Создал Подстраницу проекта: ".$request->name);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_subpage_edit',$subpage->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_subpage');
		}else{
			return redirect()->route('adm_project_subpage_new');
		}
	}

	public function edit(Request $request, $subpage_id)
	{
		$subpage = Subpage::with(['reviews', 'translate'])->find($subpage_id);

		$projects = Project::with(['category.translate','translate'])
			->where('lang','ru')
			->get();
		$types = SubpageType::where('lang','ru')->get();

		$countReviews = $subpage->reviews->count();
		$array = [];
		$array[] = 'subpage_id';
		$array[] = $subpage->id;
		$reviewFilter = json_encode($array);

		SEO::setTitle('Редактирование подстраницы проекта');
		AdminPageData::setPageName('Редактирование подстраницы проекта');
		AdminPageData::addBreadcrumbLevel('Подстраницы','subpages');
		AdminPageData::addBreadcrumbLevel('Редактирование подстраницы');

		return view('admin.projects.subpage.edit',[
			'subpage' => $subpage,
			'projects' => $projects,
			'types' => $types,
			"countReviews"=>$countReviews,
			"reviewFilter"=>$reviewFilter,
		]);
	}

	public function save(Request $request, $subpage_id)
	{
		$subpage = Subpage::find($subpage_id);
		$this->createOrEdit($request, $subpage, "update");

		ModeratorLogs::addLog("Отредактировал Подстраницу проекта: ".$request->name);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_subpage_edit',$subpage->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project_subpage');
		}else{
			return redirect()->route('adm_project_subpage_new');
		}
	}

	public function delete($subpage_id){
		Subpage::destroy($subpage_id);

		$reviews = Review::where('subpage_id',$subpage_id)->get();
		foreach ($reviews as $review){
			Review\Comment::where('review_id',$review->id)->delete();
			Review\ReviewLike::where('review_id',$review->id)->delete();
			$review->delete();
		}

		Subpage::where('rus_lang_id',$subpage_id)->delete();
		return "ok";
	}

	public function hide($subpage_id){
		$subpage = Subpage::find($subpage_id);
		$subpage->isHide = true;
		$subpage->save();
		$subpage = Subpage::where('rus_lang_id',$subpage_id)->first();
		$subpage->isHide = true;
		$subpage->save();
		return "ok";
	}
	public function show($subpage_id){
		$subpage = Subpage::find($subpage_id);
		$subpage->isHide = false;
		$subpage->save();
		$subpage = Subpage::where('rus_lang_id',$subpage_id)->first();
		$subpage->isHide = false;
		$subpage->save();
		return "ok";
	}
	protected function createOrEdit($request,$subpage,$mode){
		$subpage->name = $request->name;
		$subpage->isHide = ($request->submit == "save-hide");
		$subpage->url = $request->url;
		$subpage->text = $request->text;
		$subpage->short_description = $request->short_description;
		$subpage->type_id = $request->type;
		$subpage->project_id = $request->project;
		$subpage->hasComments = ($request->has('isComments'));
		$subpage->hasReviews = ($request->has('isReview'));
		$subpage->isReviewForm = ($request->has('isForm'));
		$subpage->min_charsets = $request->min_charsets;
		$subpage->image = $request->image;

		$subpage->seo_title = $request->title;
		$subpage->seo_description = $request->description;
		$subpage->seo_keyword = $request->keywords;

		$subpage->save();

		$translate = Subpage::where('rus_lang_id',$subpage->id)->first();

		if(empty($translate))
		{
			$translate = new Subpage();
			$translate->lang = 'ua';
			$translate->rus_lang_id = $subpage->id;
		}

		$translate->name = $request->nameUA;
		$translate->isHide = ($request->submit == "save-hide");
		$translate->url = $request->urlUA;
		$translate->text = $request->textUA;
		$translate->short_description = $request->short_descriptionUA;
		$translate->type_id = $request->type;
		$translate->project_id = $request->project;

		$translate->hasComments = ($request->has('isComments'));
		$translate->hasReviews = ($request->has('isReview'));
		$translate->isReviewForm = ($request->has('isForm'));
		$translate->min_charsets = $request->min_charsets;
		$translate->image = $request->image_ua;

		$translate->seo_title = $request->titleUA;
		$translate->seo_description = $request->descriptionUA;
		$translate->seo_keyword = $request->keywordsUA;

		$translate->save();

		if(!$subpage->isSendNotification && !$subpage->isHide){

			switch ($subpage->type_id)
			{
				case 3:
					$subpage->isSendNotification = true;
					$subpage->save();

					$projectRequests = Project\ProjectRequest::where('project_id', $subpage->project_id)->orderBy('id')->first();

					$queue = new Queue();
					$queue->name = 'project_contest';
					$queue->project_id = $subpage->id;
					$queue->start = ($projectRequests->id - 1);
					$queue->save();
					break;
				case 5:
					$subpage->isSendNotification = true;
					$subpage->save();

					$projectRequests = Project\ProjectRequest::where('project_id', $subpage->project_id)->orderBy('id')->first();

					$queue = new Queue();
					$queue->name = 'project_membership';
					$queue->project_id = $subpage->id;
					$queue->start = ($projectRequests->id - 1);
					$queue->save();
					break;
			}
		}
	}

	protected function saveImage($image, $nameModificator){
		$newName = time().$nameModificator.'.'.$image->getClientOriginalExtension();
		$image->move(public_path()."/uploads/images/", $newName);
		return $newName;
	}

	public function validURL(Request $request,$subpage_id)
	{
		$url = $request->url;
		$lang = $request->lang;

		if($this->isBusyUrlSubpage($lang,$subpage_id,$url))
		{
			$id = 0;
			do{
				if($id > 50){
					break;
				}
				$id++;
			}while($this->isBusyUrlSubpage($lang,$subpage_id,$url.'-'.$id));
			$url .= '-'.$id;
		}

		return $url;
	}

	protected function isBusyUrlSubpage($lang,$subpage_id,$url){
		if($subpage_id != 0){
			$project_id = Subpage::find($subpage_id)->project_id;

			if($lang == 'ru'){
				return Subpage::where([
						['lang','ru'],
						['id','<>',$subpage_id],
						['project_id',$project_id],
						['url',$url],
					])->first() !== null;
			}else{
				return Subpage::where([
						['lang','ua'],
						['rus_lang_id','<>',$subpage_id],
						['project_id',$project_id],
						['url',$url],
					])->first() !== null;
			}
		}
		return false;
	}
}
