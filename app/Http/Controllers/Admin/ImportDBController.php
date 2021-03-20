<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\Project\ProjectCategory;
use App\Model\Project\ProjectStatus;
use App\Model\Project\ProjectMessage;
use App\Model\Project\ProjectRequest;
use App\Model\Project\Subpage;
use App\Model\Project\SubpageType;
use App\Model\Review\StatusReview;
use App\Model\Review\Comment;
use App\Model\Review;
use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Questionnaire\Answer;
use App\User;

use App\Model\Import\Xcontent118;
use App\Model\Import\Xcontent120;
use App\Model\Import\Xcontent122;
use App\Model\Import\Xcontent144;
use App\Model\Import\Xcontent150;
use App\Model\Import\Xcontent151;
use App\Model\Import\Xcontent152;
use App\Model\Import\Xcontent154;
use App\Model\Import\Xcontent155;


use App\Model\Import\InvalidUser;
use Carbon\Carbon;
use Storage;

class ImportDBController extends Controller
{
	protected $projectCategory = [
			1091 => "Бытовая химия",
			1107 => "Красота и уход",
			1108 => "Еда и напитки",
			1120 => "Гигиена",
			1118 => "Техника",
			1122 => "Услуги"
	];

	protected $projectStatus = [
		381 => "Не начатый",
		382 => "Регистрация",
		383 => "Новый проект (регистрация завершена)",
		384 => "Тестирование",
		385 => "Заполнение отчёта",
		3657 => "Завершен",
		3658 => "Архив"
	];

	protected $userStases = [
		3642 => 1,
		3643 => 2,
		3644 => 3,
		3645 => 4
	];

	protected $projectRequestStases = [
		149 => 3,
		150 => 7,
		151 => 3,
	];

	protected $questionnaireName = [
		2 => 'Анкета для участия в проекте',
		3 => 'Отчет об участии в проекте'
	];

	protected $questionType = [
		442 => 1,
		443 => 8,
		444 => 10,
		445 => 5,
		446 => 4,
		447 => 1,
		448 => 2,
		449 => 1,
	];

	protected $questionTypeSelect = [
		442 => 1,
		443 => 8,
		444 => 10,
		445 => 5,
		446 => 4,
		447 => 1,
		448 => 2,
		449 => 1,
	];

    public function project(){
		$olds = Xcontent144::all();
    	foreach ($olds as $old){
    		if(Project::where('old_id',$old->content_id)->first()){
    			continue;
			}
			$category = ProjectCategory::firstOrCreate(['name' => $this->projectCategory[$old->xcid]]);
			$status = ProjectStatus::firstOrCreate(['name' => $this->projectStatus[$old->f1226]]);
			$newProject = new Project();
			$newProject->old_id = $old->content_id;
			$newProject->name = $old->content_name;
			$newProject->category_id = $category->id;
			$newProject->isHide = ($old->content_del == 1);
			$newProject->text = $this->textImageReplace($old->f1204);
			$newProject->short_description = $old->f1203;
			$newProject->product_name = $old->f1313;
			$newProject->rules = $old->f1285;
			$newProject->count_users = $old->f1312;
			$newProject->status_id = $status->id;
			$newProject->start_registration_time = Carbon::createFromTimestamp($old->f1237)->toDateTimeString();
			$newProject->end_registration_time = Carbon::createFromTimestamp($old->f1317)->toDateTimeString();
			$newProject->start_test_time = Carbon::createFromTimestamp($old->f1238)->toDateTimeString();
			$newProject->start_report_time = Carbon::createFromTimestamp($old->f1348)->toDateTimeString();
			$newProject->end_project_time = Carbon::createFromTimestamp($old->f1239)->toDateTimeString();
			$newProject->seo_description = $old->f1352;
			$newProject->seo_keyword = $old->f1351;


			$newProject->type = 'only-expert';
			$newProject->url =  $this->str2url($newProject->name);


			if($old->f1202 != 0){
				$newProject->preview_image = '/public/uploads/images/1/project/'.$this->saveFile($old->f1202,'1/project/');
			}
			if($old->f1284 != 0){
				$newProject->main_image = '/public/uploads/images/1/project/'.$this->saveFile($old->f1284,'1/project/');
			}
			if($old->f1322 != 0){
				$newProject->review_image = '/public/uploads/images/1/project/'.$this->saveFile($old->f1322,'1/project/');
			}
			$newProject->save();


			$projectUA = new Project();
			$projectUA->lang = 'ua';
			$projectUA->rus_lang_id = $newProject->id;


			$projectUA->type = $newProject->type;
			$projectUA->category_id = $newProject->category_id;
			$projectUA->name = $newProject->name.' [УКР]';
			$projectUA->url = $newProject->url.'-ukr';
			$projectUA->short_description = $newProject->short_description;
			$projectUA->text = $newProject->text;
			$projectUA->product_name = $newProject->product_name;
			$projectUA->rules = $newProject->rules;
			$projectUA->qa_text = $newProject->qa_text;
			$projectUA->count_users = $newProject->count_users;
			$projectUA->isHide = $newProject->isHide;

			// Project Time
			$projectUA->start_registration_time = $newProject->start_registration_time;
			$projectUA->end_registration_time = $newProject->end_registration_time;
			$projectUA->start_test_time = $newProject->start_test_time;
			$projectUA->start_report_time = $newProject->start_report_time;
			$projectUA->end_project_time = $newProject->end_project_time;

			$projectUA->status_id = ProjectStatus::where([
				["rus_lang_id",$newProject->status_id],
				["lang","ua"]
			])->first()
				->id;

			//SEO
			$projectUA->seo_title = $newProject->seo_title;
			$projectUA->seo_description = $newProject->seo_description;
			$projectUA->seo_keyword = $newProject->seo_keyword;

			$projectUA->save();
		}
	}
	public function projectSubpage(){
		$olds = Xcontent155::all();
		foreach ($olds as $old){
			if(Subpage::where('old_id',$old->content_id)->first()){
				continue;
			}
			$subpage = new Subpage();
			$subpage->name = $old->content_name;
			$subpage->isHide = ($old->content_del == 1);
			if(!empty($old->f1304)){
				$subpage->text = $this->textImageReplace($old->f1304);
			}else{
				$subpage->text = $old->f1306;
			}

			$project = Project::where('old_id',$old->f1307)->first();
			if(empty($project)){
				continue;
			}
			$subpage->project_id = $project->id;
			$subpage->old_id = $old->content_id ;
			$subpage->short_description = $old->f1342;
			$subpage->hasComments = ($old->f1336 == 1);
			$subpage->hasReviews = ($old->f1319 == 1);
			$subpage->isReviewForm = ($old->f1335 == 1);

			$subpage->url = $this->str2url($old->content_name);


			switch ($old->type){
				case "review":
					$subpage->type_id = 1;
					break;
				case "contest":
					$subpage->type_id = 3;
					break;
				case "member":
					$subpage->type_id = 5;
					break;
				case "qa":
					$subpage->type_id = 7;
					break;
				case "rules":
					$subpage->type_id = 9;
					break;
				case "video":
					$subpage->type_id = 11;
					break;
				default:
					$subpage->type_id = 13;
					break;
			}
			if($old->f1340 != 0)
			{
				$subpage->image = $this->saveFile($old->f1340);
			}

			$subpage->save();

			$translate = new Subpage();
			$translate->lang = 'ua';
			$translate->rus_lang_id = $subpage->id;

			$translate->name = $subpage->name.' [УКР]';
			$translate->isHide = $subpage->isHide ;
			$translate->url = $subpage->url.'-ukr';
			$translate->text = $subpage->text;
			$translate->short_description = $subpage->short_description;
			$translate->type_id = $subpage->type_id;
			$translate->project_id = $subpage->project_id;

			$translate->hasComments = $subpage->hasComments;
			$translate->hasReviews = $subpage->hasReviews;
			$translate->isReviewForm = $subpage->isReviewForm;
			$translate->min_charsets = 0;
			$translate->image = $subpage->image;

			$translate->seo_title = $subpage->seo_title.' [УКР]';
			$translate->seo_description = $subpage->seo_description.' [УКР]';
			$translate->seo_keyword = $subpage->seo_keyword;

			$translate->save();
		}
	}

	public function user(){
		$olds = Xcontent122::where('content_id','>',46247)->get();
		foreach ($olds as $old){
			$user =  new User();

			if(empty($old->f615)){
				$user = new InvalidUser();
				$user->id = $old->content_id;
				$user->name = $old->content_name;
				$user->save();
				continue;
			}
			if(!empty(User::where('email',$old->f615)->first())){
				$user = new InvalidUser();
				$user->id = $old->content_id;
				$user->name = 'duble '.User::where('email',$old->f615)->first()->id;
				$user->save();
				continue;
			}
			$user->oldId = $old->content_id;

			$user->name = $old->f1248;
			$user->first_name = $old->f716;
			$user->last_name = $old->f1240;
			$user->patronymic = $old->f1241;

			$user->sex = ($old->f1208 == 337);

			$user->isHide = ($old->content_del == 1);
			$user->email = $old->f615;
			$user->phone = $old->f1154;
			$user->md5_pass = $old->f658;
			$user->ip = $old->f665;
			$user->isFreeComments = $old->f1297;
			$user->status_id = $this->userStases[$old->f1311];
			$user->isNewsletter = ($old->f1359 == 1);

			if($old->f1303 != 0){
				$user->avatar = $this->saveFile($old->f1303,'avatars/');
			}

			$user->birsday = (strlen($old->f1247) == 4)?$old->f1247:null;
			$user->city = $old->f1129;
			$user->region = $old->f1314;
			$user->country = "Украина";


			$user->created_at = Carbon::createFromTimestamp($old->f664)->toDateTimeString();

			$user->password = "empty";
			$user->current_rating = 0;
			$user->rang_id = 1;

			$user->save();
			if(
				isset($user->last_name)
				&& isset($user->first_name)
				&& isset($user->birsday)
				&& isset($user->country)
				&& isset($user->region)
				&& isset($user->city)
				&& isset($user->name)
				&& isset($user->email)
			){
				$user->makeExployee('expert');
			}else{
				$user->makeExployee('user');
			}

			$user->save();
		}
	}

	public function userAnketData(){
		$olds = Xcontent122::where([
			['content_id','>',25000],
			['content_id','<=',50000],
		])->get();
		//$olds = Xcontent122::all();
		foreach ($olds as $old){
			$user =  User::where('oldid',$old->content_id)->first();
			if(!empty($user)){
				$user->birsday = (strlen($old->f1247) == 4)?$old->f1247:null;

				$user->save();
			}
		}
	}
	public function userRoles(){
		$users = User::where([
			['id','>',40000],
			['id','<=',45000]
		])->get();
		foreach ($users as $user){
			$user->makeExployee('user');

			$user->save();
		}
	}

	public function review(){
		$olds = Xcontent154::where([
			['content_id','>',52478],
			['content_id','<=',53000],
		])->get();
		foreach ($olds as $old){
			if($old->f1350 == 0){
				$this->addReview($old);
			}else{
				$this->addProjectMessage($old);
			}
		}
	}

	private function addReview($old){
		$review = new Review();

		$review->oldId = $old->content_id;
		$review->isHide = ($old->content_del == 1);
		$review->text = $old->f1289;

		$review->status_id = ($old->content_del == 1)?3:2;

		$user = User::where('oldId',$old->f1290)->first();
		if(empty($user)){
			$user = new InvalidUser();
			$user->id = $old->content_id;
			$user->name = 'user: '.$old->f1290;
			$user->save();
			return false;
		}
		$review->user_id = $user->id;

		$subpage = Subpage::where('old_id',$old->f1320)->first();
		if(empty($subpage)){
			$project = Project::where('old_id',$old->f1287)->first();
			$subpage = Subpage::firstOrCreate([
				'name' => 'Отзывы',
				'project_id' => $project->id,
				'type_id' => 1,
				'url' => 'otzyvy'
			]);
		}
		$review->subpage_id = $subpage->id;

		$review->isReviewCatalog = ($old->f1291 == 1);
		$review->isMainReview = ($old->f1347 == 1);
		$review->isProjectGallery = ($old->f1302 == 1);

		if(!empty($old->f1292) ){
			$review->images = $this->getImages($old->f1292,'reviews/');
		}


		$review->created_at = Carbon::createFromTimestamp($old->f1288)->toDateTimeString();
		$review->save();
	}

	private function addProjectMessage($old){
		$projectMessage = new ProjectMessage();

		$projectMessage->old_id = $old->content_id;
		$projectMessage->isHide = ($old->content_del == 1);
		$projectMessage->text = $old->f1289;

		$user = User::where('oldId',$old->f1290)->first();
		if(empty($user)){
			$user = new InvalidUser();
			$user->id = $old->content_id;
			$user->name = 'user: '.$old->f1290;
			$user->save();
			return false;
		}
		$projectMessage->user_id = $user->id;
		$projectMessage->project_id = $old->f1287;

		if(!empty($old->f1292) ){
			$projectMessage->images = $this->getImages($old->f1292,'reviews/');
		}

		$projectMessage->created_at = Carbon::createFromTimestamp($old->f1288)->toDateTimeString();
		$projectMessage->save();
	}

	public function comment(){
		$olds = Xcontent118::where([
			['content_id','>',39924],
			['content_id','<=',40000],
		])->get();
		foreach ($olds as $old){
			$comment = new Comment();

			$comment->isHide = ($old->content_del == 1);

			$comment->text = $old->f511;

			$user = User::where('oldId',$old->f1276)->first();
			$review = Review::where('oldId',$old->f1293)->first();
			if(empty($user) || empty($review)){
				continue;
			}

			$comment->review_id = $review->id;
			$comment->user_id = $user->id;
			$comment->status_id = ($old->content_del == 1)?3:2;

			$comment->isImportant = ($old->content_del == 1);

			$comment->created_at = Carbon::createFromTimestamp($old->f1277)->toDateTimeString();

			$comment->old_id = $old->content_id;

			$comment->save();
		}
	}

	public function project_request(){
		$olds = Xcontent120::where([
			['content_id','>',81054],
			['content_id','<=',100000],
		])->get();
		$i = 0;
		foreach ($olds as $old){
			$projectRequest = new ProjectRequest();

			$projectRequest->isHide = ($old->content_del == 1);

			$user = User::where('oldId',$old->f1156)->first();
			$project = Project::where('old_id',$old->f1227)->first();
			if(empty($user) || empty($project)){
				continue;
			}

			$projectRequest->project_id = $project->id;
			$projectRequest->user_id = $user->id;
			$projectRequest->status_id = $this->projectRequestStases[$old->f1164];

			$projectRequest->created_at = Carbon::createFromTimestamp($old->f1286)->toDateTimeString();

			$projectRequest->old_id = $old->content_id;

			$projectRequest->save();

			$i = $projectRequest->id;
		}
		return 'Last id: '.$i;
	}

	public function questionnaire_question(){
		$olds = Xcontent150::where('content_id','>',1846)->get();
		foreach ($olds as $old){
			$question = new Question();

			$question->isHide = ($old->content_del == 1);

			$project = Project::where('old_id',$old->f1260)->first();
			if(empty($project)){
				continue;
			}

			$type_id = ($old->xcid == 1109)?2:3;
			$question->questionnaire_id = $this->getQuestionnaire($project->id,$type_id);

			$question->name = $old->content_name;
			$question->help = $old->f1254;
			$question->required = ($old->f1275 == 1);
			$question->sort = $old->f1274;

			$question->type_id = $this->questionType[$old->f1255];

			$question->question_relation_id = $this->getQuestionRelationId($old->f1272, $old->f1273);

			$question->old_id = $old->content_id;
			$question->save();

			$this->addChildToSelect($old, $question);
			$this->addOtherToSelect($old, $question);
		}
	}


	private function getQuestionnaire($project_id,$type_id){
		$questionnaire = Questionnaire::where([
			['project_id',$project_id],
			['type_id',$type_id],
		])->first();
		if(empty($questionnaire)){
			$questionnaire = new Questionnaire();
			$questionnaire->project_id = $project_id;
			$questionnaire->type_id = $type_id;
			$questionnaire->name = $this->questionnaireName[$type_id];
			$questionnaire->save();
		}
		return $questionnaire->id;
	}

	private function addChildToSelect($old, $question){
		if($this->isSelectedTypeOld($old->f1255)){
			$names = explode(PHP_EOL,$old->f1257);
			foreach ($names as $key => $name){
				$this->addSelectItem($key, $name, $question);
			}
		}
	}

	private function isSelectedTypeOld($type_id){
		switch ($type_id){
			case 445:
			case 446:
				return true;
			default:
				return false;
		}
	}

	private function addSelectItem($key, $name, $question){
		$nameEmpty = preg_replace ('/\s/', '', $name);
		$nameEmpty = preg_replace ('/\n/', '', $nameEmpty);
		$nameEmpty = preg_replace ('/\r/', '', $nameEmpty);
		if(empty($nameEmpty)) return false;
		$selectItem = new Question();
		$name = trim($name);
		$selectItem->name = $name;
		$selectItem->type_id = 7;
		$selectItem->parent = $question->id;
		$selectItem->sort = $key+1;
		$selectItem->questionnaire_id = $question->questionnaire_id;

		$selectItem->save();
	}

	private function addOtherToSelect($old, $question){
		if($old->f1259 == 1){
			$otherItem = new Question();

			$otherItem->name = "Другое";
			$otherItem->type_id = 9;
			$otherItem->parent = $question->id;
			$otherItem->sort = 0;
			$otherItem->questionnaire_id = $question->questionnaire_id;

			$otherItem->save();
		}
	}

	private function getQuestionRelationId($question_id, $selectItemText){
		if(!empty($question_id)){
			$question = Question::where('old_id', $question_id)->first();
			if(!empty($selectItemId)){
				$selectItem = Question::where([
						['parent',$question->id],
						['text',$selectItemText],
					])-first();
				return $selectItem->id;
			}
			return (empty($question))?0:$question->id;
		}
		return 0;
	}

	public function answers(){
		$olds = Xcontent151::where([
			['content_id','>',1820000],
			['content_id','<=',1840000],
		])->get();
		foreach ($olds as $old){
			$question = Question::where('old_id',$old->f1265)->first();

			if($old->xcid == 1111){
				$projectRequest = ProjectRequest::where('old_id',$old->f1266)->first();
			}else{
				$oldReport = Xcontent152::where('content_id',$old->f1266)->first();

				$user = User::where('oldId',$oldReport->f1270)->first();
				if(empty($user)){
					continue;
				}
				$project = Project::where('old_id',$oldReport->f1268)->first();
				$projectRequest = ProjectRequest::where([
					['user_id',$user->id],
					['project_id',$project->id],
				])->first();

			}


			if(empty($question) || empty($projectRequest)){
				continue;
			}

			$oldAnswers = [];
			$oldAnswers[] = $old->content_name;
			if($question->type_id == 4){
				$oldAnswers = explode(',',$old->content_name);
			}

			foreach ($oldAnswers as $oldAnswer){
				$answer = new Answer();
				$answer->isHide = ($old->content_del == 1);

				if($this->isSelectedType($question->type_id)){
					$selectItem = Question::where([
						['parent',$question->id],
						['type_id',7],
						['name',$oldAnswer],
					])->first();


					if(!empty($selectItem)){
						$answer->question_id = $selectItem->id;
					}else{
						$selectItem = Question::where([
							['parent',$question->id],
							['type_id',9],
						])->first();
						if(empty($selectItem)){
							continue;
						}
						$answer->question_id = $selectItem->id;
						$answer->answer = $oldAnswer;
					}
				}
				else{
					$answer->answer = $oldAnswer;
					$answer->question_id = $question->id;
				}


				$answer->project_request_id = $projectRequest->id;

				$answer->created_at = Carbon::createFromTimestamp($old->f1264)->toDateTimeString();

				$answer->save();

				if($old->xcid == 1112){
					$projectRequest->status_id = 9;
					$projectRequest->save();
				}
			}

		}
	}

	public function changeRequestIdToAnswers(){
		$olds = Xcontent151::where([
			['xcid',1112],
			['content_id','>',1700000],
			['content_id','<=',1800000],
		])->get();
		foreach ($olds as $old){
			$question = Question::where('old_id',$old->f1265)->first();
			$projectRequest = ProjectRequest::where('old_id',$old->f1266)->first();

			if(empty($question) || empty($projectRequest)){
				continue;
			}
			$oldAnswers = [];
			$oldAnswers[] = $old->content_name;
			if($question->type_id == 4){
				$oldAnswers = explode(',',$old->content_name);
			}

			foreach ($oldAnswers as $oldAnswer){
				$question_id = 0;

				if($this->isSelectedType($question->type_id)){
					$selectItem = Question::where([
						['parent',$question->id],
						['type_id',7],
						['name',$oldAnswer],
					])->first();


					if(!empty($selectItem)){
						$question_id = $selectItem->id;
					}else{
						$selectItem = Question::where([
							['parent',$question->id],
							['type_id',9],
						])->first();
						if(empty($selectItem)){
							continue;
						}
						$question_id = $selectItem->id;
					}
				}
				else{
					$question_id = $question->id;
				}


				$answer = Answer::where([
					['question_id',$question_id],
					['project_request_id',$projectRequest->id],
				])->first();

				$oldReport = Xcontent152::where('content_id',$old->f1266)->first();
				$user = User::where('oldId',$oldReport->f1270)->first();

				$projectRequest = ProjectRequest::where([
						['user_id',$user->id],
						['project_id',$oldReport->f1268],
					])->first();

				if(empty($answer)){
					continue;
				}
				$answer->project_request_id = $projectRequest->id;
				$answer->save();
			}

		}
	}

	public function addCompliteStatusForRequest(){
		$questionnaires = Questionnaire::with('questions')->where('type_id',3)->get();
		foreach ($questionnaires as $questionnaire){
			$questionIds = [];
			foreach ($questionnaire->questions as $question){
				$questionIds[] = $question->id;
				foreach ($question->options as $option){
					$questionIds[] = $option->id;
				}
			}

			$answers = Answer::whereIn('question_id',$questionIds)
				->get()
				->unique('project_request_id');

			foreach ($answers as $answer){
				$request = ProjectRequest::find($answer->project_request_id);
				$request->status_id = 9;
				$request->save();
			}
		}

	}

	private function isSelectedType($type_id){
		switch ($type_id){
			case 4:
			case 5:
				return true;
			default:
				return false;
		}
	}

	private function setSelectAnswer($question,$answer,$old){
		$selectItem = null;
		if($question->type_id == 4){


		}else{
			$selectItem = Question::where([
				['parent',$question->id],
				['type_id',7],
				['name',$old->content_name],
			])->first();
		}

		if(!empty($selectItem)){
			$answer->question_id = $selectItem->id;
		}else{
			$selectItem = Question::where([
				['parent',$question->id],
				['type_id',9],
			])->first();
			if(empty($selectItem)){
				return false;
			}
			$answer->question_id = $selectItem->id;
			$answer->answer = $old->content_name;
		}

		return $answer;
	}


	private function getImages($imagesWebo, $path){
		$images = [];
		$imagesGroups = explode('::',$imagesWebo);
		foreach ($imagesGroups as $imagesGroup){
			$imagesGroup = str_replace(':','',$imagesGroup);
			$imagesGroup = substr($imagesGroup, 0, -1);
			$imagesGroup = explode('|',$imagesGroup);
			$images[] = $this->saveImages($imagesGroup,$path);
		}
		return $images;
	}

	private function saveImages($imageArray, $path){
		$images = [];
		foreach ($imageArray as $image){
			$images[] = $this->saveFile($image,$path);
		}
		return $images;
	}


	private function saveFile($namefile, $folder = ''){
		$url = "http://na-proby.com/img/content/i".(($namefile - $namefile%1000)/1000).'/'.$namefile.".gif";
		$contents = file_get_contents($url);
		$newName = $namefile.".gif";
		$name = '/images/'.$folder.$newName ;
		Storage::disk("public_uploads")->put($name, $contents);
		return $newName;
	}

	private function saveFilePath($path){
		$url = "http://na-proby.com/".$path;

		if($this->get_http_response_code($url) != "200"){
			return $url;
		}else{
			$contents = file_get_contents($url);
			$name = '/files/images/'.basename($path) ;
			Storage::disk("public_uploads")->put($name, $contents);
			return '/public/uploads'.$name;
		}
	}

	private function get_http_response_code($url) {
		$headers = get_headers($url);
		return substr($headers[0], 9, 3);
	}

	private function textImageReplace($text){
		$newText = $text;

		$doc=new \DOMDocument;
		$newText = preg_replace('/<(\w+):(\w+)/', '<\1 data-namespace="\2"' , $newText);
		$doc->loadHTML($newText,LIBXML_NOERROR | LIBXML_NSCLEAN );
		$xml=simplexml_import_dom($doc); // just to make xpath more simple
		$images=$xml->xpath("//img");
		foreach ($images as $img) {
			$oldImage = $img["src"];
			$newName = $this->saveFilePath($img["src"]);
			$newText = str_replace($oldImage, $newName, $newText);
		}

		return $newText;
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
