<?php

namespace App\Http\Controllers\Admin\Project;

use App\Entity\Collection\CountryCollection;
use App\Entity\ProjectAudienceEnum;
use App\Http\Controllers\Admin\iAdminController;
use App\Model\Blogger\BloggerUserProject;
use App\Model\Questionnaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Project\ProjectMessage;
use App\Model\Project\ProjectRequest;
use App\Model\Questionnaire\Answer;
use App\Model\Review;
use App\Model\User\UserShipping;

use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Project\ProjectStatus;
use App\Model\Project\ProjectBlock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Library\Users\ModeratorLogs;
use PDF;
use SEO;
use AdminPageData;
use Storage;

class ProjectController extends Controller implements iAdminController
{
    public function __construct()
    {
        app()->setLocale('ru');
    }

	//Список всех проектов
	public function all(){
        $countryCollection = CountryCollection::buildCollection();
        dd($countryCollection->getValues());

		$projects = Project::with(['category','status','requests'])
			->withCount(['requests'])
			->where('lang','ru')
			->orderBy('id','desc')
			->get();

		SEO::setTitle('Все проекты');
		AdminPageData::setPageName('Все проекты');
		AdminPageData::addBreadcrumbLevel('Проекты');

		return view('admin.projects.all',['projects'=>$projects]);
	}

    //Список всех проектов из категории
	public function category($category_id){
		$projects = Project::with(['category','status'])
			->where([
				['lang','ru'],
				['category_id',$category_id]
				])
			->get();

		SEO::setTitle('Все проекты:'.$projects->first()->category->name);
		AdminPageData::setPageName('Все проекты:'.$projects->first()->category->name);
		AdminPageData::addBreadcrumbLevel('Проекты','project');
		AdminPageData::addBreadcrumbLevel($projects->first()->category->name);

		return view('admin.projects.all',['projects'=>$projects]);
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$projects = Project::where('lang','ru')->where('name','like',"%".$name."%")->limit(5)->get();

		$formatted_projects = [];

		foreach ($projects as $project) {
			$formatted_projects[] = ['id' => $project->id, 'text' => $project->name];
		}

		return \Response::json($formatted_projects);
	}
	public function validURL(Request $request,$project_id)
	{
		$url = $request->url;
		$lang = $request->lang;

		if($this->isBusyUrlProject($lang,$project_id,$url) || $this->isBusyUrlProjectCategory($lang,$project_id,$url))
		{
			$id = 0;
			do{
				if($id > 50){
					break;
				}
				$id++;
			}while($this->isBusyUrlProject($lang,$project_id,$url.'-'.$id)  || $this->isBusyUrlProjectCategory($lang,$project_id,$url.'-'.$id));
			$url .= '-'.$id;
		}

		return $url;
	}

	protected function isBusyUrlProject($lang,$project_id,$url){
		if($lang == 'ru'){
			return Project::where([
				['lang','ru'],
				['id','<>',$project_id],
				['url',$url],
			])->first() !== null;
		}else{
			return Project::where([
					['lang','ua'],
					['rus_lang_id','<>',$project_id],
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

	// Страница добавления проекта
	public function new(){
		$statuses = ProjectStatus::where('lang','ru')->get();
		$categories = ProjectCategory::where('lang','ru')->get();
		$audienceArray = ProjectAudienceEnum::toArray();

		SEO::setTitle('Новый проект');
		AdminPageData::setPageName('Новый проект');
		AdminPageData::addBreadcrumbLevel('Проекты','project');
		AdminPageData::addBreadcrumbLevel('Новый проект');

		return view('admin.projects.new',[
			'categories' => $categories,
			'statuses' => $statuses,
			'audienceArray' => $audienceArray,
		]);
	}

	// Добавление нового проекта
	public function edit(Request $request, $project_id){
		$project = Project::with(['messages','subpages.reviews','requests','questionnaires'])
			->withCount([
				'messages' => function($query){
					$query->where('lang','ru');
				},
				'links' => function($query){
					$query->where('lang','ru');
				},
				'requests',
				'questionnaires',
				'blogger_posts',
				'subpages' => function($query){
					$query->where('lang','ru');
				},
			])
			->find($project_id);
		$countReviews = 0;
		$array = [];
		$subpages = [];
		$array[] = 'subpage_id';
		foreach ($project->subpages as $subpage){
			$countReviews += $subpage->reviews->count();
			if($subpage->reviews->count() > 0){
				$subpages[] = $subpage->id;
			}
		}
		if(empty($subpages)){
			$subpages[] = 0;
		}
		$array[] = $subpages;
		$reviewFilter = json_encode($array);
		$translate = Project::with(['category','status'])
			->where('rus_lang_id',$project_id)
			->first();
		if(empty($translate)){
			$translate = new Project();
		}
		$categories = ProjectCategory::where('lang','ru')->get();
		$statuses = ProjectStatus::where('lang','ru')->get();
        $audienceArray = ProjectAudienceEnum::toArray();

		SEO::setTitle('Редактирование проекта: '.$project->name);
		AdminPageData::setPageName('Редактирование проекта');
		AdminPageData::addBreadcrumbLevel('Проекты','project');
		AdminPageData::addBreadcrumbLevel($project->name);

		return view('admin.projects.edit',[
			'project' => $project,
			'translate' => $translate,
			'categories' => $categories,
			'statuses' => $statuses,
			'countReviews' => $countReviews,
			'reviewFilter' => $reviewFilter,
			'audienceArray' => $audienceArray,
		]);
	}

	// Добавление нового проекта
	public function create(Request $request){
		$project = new Project();
		$this->createOrEdit($request, $project, "create");

		ModeratorLogs::addLog("Создал Проект: ".$request->name);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_edit',$project->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project');
		}else{
			return redirect()->route('adm_project_new');
		}
	}

	public function save(Request $request, $project_id){
		$project = Project::find($project_id);
		$this->createOrEdit($request, $project, "update");

		ModeratorLogs::addLog("Отредактировал Проект: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_project_edit',$project->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_project');
		}else{
			return redirect()->route('adm_project_new');
		}
	}

	public function delete($project_id){
		Project::destroy($project_id);

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
		return "ok";
	}

	public function hide($project_id){
		$project = Project::find($project_id);
		$project->isHide = true;
		$project->save();
		$project = Project::where('rus_lang_id',$project_id)->first();
		$project->isHide = true;
		$project->save();
		return "ok";
	}
	public function show($project_id){
		$project = Project::find($project_id);
		$project->isHide = false;
		$project->save();
		$project = Project::where('rus_lang_id',$project_id)->first();
		$project->isHide = false;
		$project->save();
		return "ok";
	}

	public function pdf($project_id){
		$project = Project::with(['subpages.reviews.comments.user','subpages.reviews.user'])->find($project_id);
		$pdf = PDF::loadView('admin.projects.pdf', [
			'project' => $project,
		]);
		/*$pdf->setOption('enable-javascript', true);
		$pdf->setOption('javascript-delay', 7000);*/
		/*$pdf->setOption('enable-smart-shrinking', true);
		$pdf->setOption('no-stop-slow-scripts', true);*/
		$pdf->setOption('footer-center', '[page]');
		return $pdf->download($project->name.'.pdf');
		/*return view('admin.projects.pdf',
			[
				'project' => $project,
			]
		);*/
	}

	// Создание или сохранения проекта
	protected function createOrEdit($request,$project,$mode){
		// Main Data
		$project->name = $request->name;
		$project->type = $request->type;
		$project->audience = $request->audience;
		$project->category_id = $request->category;
		$project->url = $request->url;
		$project->short_description = $request->short_description;
		$project->text = $request->text;
		$project->product_name = $request->product_name;
		$project->rules = $request->rules;
		$project->qa_text = $request->qa_text;
		$project->count_users = $request->count_users;
		$project->isHide = ($request->submit == "save-hide");

		if(isset($request->password)){
			$project->password = Hash::make($request->password);
		}

		// Project Time
		$start_registration_time = new Carbon($request->start_registration_time);
		$end_registration_time = new Carbon($request->end_registration_time);
		$start_test_time = new Carbon($request->start_test_time);
		$start_report_time = new Carbon($request->start_report_time);
		$end_project_time = new Carbon($request->end_project_time);

		$project->start_registration_time = $start_registration_time;
		$project->end_registration_time = $end_registration_time;
		$project->start_test_time = $start_test_time;
		$project->start_report_time = $start_report_time;
		$project->end_project_time = $end_project_time;

		//Project status
		if($request->status == ""){
			if($project->status_id != 3){
				if(Carbon::now() >= ($end_project_time)){
					$project->status_id = 1;
				}elseif (Carbon::now() >= ($start_report_time)){
					$project->status_id = 5;
				}elseif (Carbon::now() >= ($start_test_time)){
					$project->status_id = 6;
				}elseif (Carbon::now() >= ($end_registration_time)){
					$project->status_id = 7;
				}elseif (Carbon::now() >= ($start_registration_time)){
					$project->status_id = 2;
				}else{
					$project->status_id = 4;
				}
			}
		}else{
			$project->status_id = $request->status;
		}

		//SEO
		$project->seo_title = $request->title;
		$project->seo_description = $request->seo_description;
		$project->seo_keyword = $request->keywords;

		//img
		$project->main_image = $request->main_image;
		$project->preview_image = $request->preview_image;

		$project->save();

		//**** Translate *****//

		$projectUA = Project::where('rus_lang_id',$project->id)->first();

		if(empty($projectUA))
		{
			$projectUA = new Project();
			$projectUA->lang = 'ua';
			$projectUA->rus_lang_id = $project->id;
		}

		$projectUA->type = $request->type;
		$projectUA->audience = $request->audience;
		$projectUA->category_id = $request->category;
		$projectUA->name = $request->nameUA;
		$projectUA->url = $request->urlUA;
		$projectUA->short_description = $request->short_descriptionUA;
		$projectUA->text = $request->textUA;
		$projectUA->product_name = $request->product_nameUA;
		$projectUA->rules = $request->rulesUA;
		$projectUA->qa_text = $request->qa_textUA;
		$projectUA->count_users = $request->count_users;
		$projectUA->isHide = ($request->submit == "save-hide");
		$projectUA->password = $project->password;

		// Project Time
		$projectUA->start_registration_time = $start_registration_time;
		$projectUA->end_registration_time = $end_registration_time;
		$projectUA->start_test_time = $start_test_time;
		$projectUA->start_report_time = $start_report_time;
		$projectUA->end_project_time = $end_project_time;

		$projectUA->status_id = ProjectStatus::where([
									["rus_lang_id",$project->status_id],
									["lang","ua"]
								])->first()
								->id;

		//SEO
		$projectUA->seo_title = $request->titleUA;
		$projectUA->seo_description = $request->seo_description_ua;
		$projectUA->seo_keyword = $request->keywordsUA;

		$projectUA->main_image = $request->main_image_ua;
		$projectUA->preview_image = $request->preview_image_ua;

		$projectUA->save();

		$sort = 1;
		if($request->has('question')){
			foreach ($request->question as $key=>$value){
				$this->createOrEditQuestion($request,$key,$sort,$project->id);
				$sort++;
			}
		}

		$this->deleteQuestions($project->id, $request);
	}

	protected function saveImage($image, $nameModificator){
		$newName = time().$nameModificator.'.'.$image->getClientOriginalExtension();
		$image->move(public_path()."/uploads/images/", $newName);
		return $newName;
	}

	protected function createOrEditQuestion($request,$key,$sort,$project_id){
		$block = ProjectBlock::find($request->question[$key]);
		if(empty($block)){
			$block = new ProjectBlock();

		}
		$block->text = $request->label_ru[$key];
		$block->procent = $request->label_procent[$key];
		$block->project_id = $project_id;

		$block->save();
		$this->childsId[] = $block->id;


		$ruId = $block->id;
		/* UA */
		$blockUA = ProjectBlock::where('rus_lang_id',$ruId)->first();

		if(empty($blockUA))
		{
			$blockUA = new ProjectBlock();
			$blockUA->lang = 'ua';
			$blockUA->rus_lang_id = $ruId;
		}

		$blockUA->text = $request->label_ua[$key];
		$blockUA->procent = $block->procent;
		$blockUA->project_id = $project_id;

		$blockUA->save();
	}

	protected function deleteQuestions($project_id){
		$blocks = ProjectBlock::where([
			['project_id',$project_id],
			['rus_lang_id',0],
		])->get();

		foreach ($blocks as $block){
			if(!in_array($block->id,$this->childsId)){
				ProjectBlock::where([
					['rus_lang_id',$block->id],
				])->delete();
				$block->delete();
			}
		}
	}

	private function rus2translit($string) {
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		return strtr($string, $converter);
	}
	private function str2url($str) {
		// переводим в транслит
		$str = $this->rus2translit($str);
		// в нижний регистр
		$str = strtolower($str);
		// заменям все ненужное нам на "-"
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		// удаляем начальные и конечные '-'
		$str = trim($str, "-");
		return $str;
	}
}
