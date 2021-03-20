<?php

namespace App\Http\Controllers\Admin;

use App\Library\Users\Notification;
use App\Mail\UserNotificationMail;
use App\Exports\AnswerExport;
use App\Exports\AnswerExportFullTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Questionnaire;
use App\Model\Questionnaire\FieldType;
use App\Model\Questionnaire\QuestionnaireType;
use App\Model\Questionnaire\Question;
use App\Model\Questionnaire\Answer;
use App\Model\Project;
use App\Library\Users\ModeratorLogs;

use Illuminate\Support\Facades\Mail;
use PDF;
use Excel;
use SEO;
use AdminPageData;


class QuestionnaireController extends Controller
{
	protected $childsId = [];
    //
	public function all(){

		SEO::setTitle('Анкеты проектов');
		AdminPageData::setPageName('Все Анкеты');
		AdminPageData::addBreadcrumbLevel('Анкеты');

		return view('admin.questionnaire.all');
	}

	public function all_ajax(Request $request){
		$questionnaires = Questionnaire::with(['type','project'])
			->where('rus_lang_id', 0)
			->orderBy('id','desc');

		return datatables()->eloquent($questionnaires)
			->addColumn('type', function (Questionnaire $questionnaire) {
				return $questionnaire->type->name;
			})->addColumn('project', function (Questionnaire $questionnaire) {
				return (!empty($questionnaire->project))?$questionnaire->project->name:'-';
			})
			->toJson();
	}

	public function project($project_id){
		$questionnaires = Questionnaire::with(['type','project.requests','questions'])
			->withCount(['questions' => function ($query) {
				$query->whereNotIn('type_id',[7,9])->where('lang','ru');
			}])->where([
				['rus_lang_id', 0],
				['project_id', $project_id],
				])
			->get();
		$project = Project::find($project_id);
		SEO::setTitle('Анкеты проекта: '.$project->name);
		AdminPageData::setPageName('Анкеты проекта: '.$project->name);
		AdminPageData::addBreadcrumbLevel('Анкеты проекта');

		return view('admin.questionnaire.project',[
			'questionnaires'=>$questionnaires,
		]);
	}

	public function new(){
		$questionnaireTypes = QuestionnaireType::all();
		$projects = Project::where([
			['rus_lang_id', 0],
			//['isHide', 0]
		])->get();

		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();

		SEO::setTitle('Новая анкета');
		AdminPageData::setPageName('Новая анкета');
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel('Новая анкета');

		return view('admin.questionnaire.new',[
			'projects' => $projects,
			'questionnaireTypes' => $questionnaireTypes,
			'questionTypes'=>$questionTypes,
		]);
	}
	public function edit($questionnaire_id){
		$viewVarible = $this->getEditOrCopyPageContent($questionnaire_id);
		$questionIds = [];
		foreach ($viewVarible['questions'] as $question){
			$questionIds[] = $question->id;
			foreach ($question->options as $option){
				$questionIds[] = $option->id;
			}
		}
		$viewVarible['answersCount'] = Answer::whereIn('question_id',$questionIds)
			->get()
			->unique('project_request_id')
			->count();

		SEO::setTitle('Редактирование анкеты');
		AdminPageData::setPageName('Редактирование анкеты');
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel('Редактирование анкеты');

		return view('admin.questionnaire.edit', $viewVarible);
	}

	public function copy($questionnaire_id){
		$original_questionnaire = Questionnaire::find($questionnaire_id);
		$questionnaire = new Questionnaire();
		$questionnaire->name = $original_questionnaire->name.' (Копия)';
		$questionnaire->text = $original_questionnaire->text;
		$questionnaire->type_id = $original_questionnaire->type_id;
		$questionnaire->project_id = $original_questionnaire->project_id;
		$questionnaire->isHide = 1;
		$questionnaire->save();


		$original_translate = Questionnaire::where('rus_lang_id',$questionnaire_id)->first();
		$translate = new Questionnaire();

		$translate->name = $original_translate->name.' (Копия)';
		$translate->text = $original_translate->text;
		$translate->lang = 'ua';
		$translate->rus_lang_id = $questionnaire->id;
		$translate->type_id = $original_translate->type_id;
		$translate->save();

		$questions = Question::with(['type','translate','options.translate'])->where([
			['parent',0],
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id', 0],
			['isHide', 0]
		])->orderBy('sort')->get();

		foreach ($questions as $question){
			$copy_question = new Question();
			$copy_question->questionnaire_id = $questionnaire->id;
			$copy_question->sort = $question->sort;
			$copy_question->name = $question->name;
			$copy_question->type_id = $question->type_id;
			$copy_question->required = $question->required;
			$copy_question->help = $question->help;
			$copy_question->restrictions = $question->restrictions;
			$copy_question->question_relation_id = $question->question_relation_id;
			$copy_question->save();

			switch ($question->type_id){
				case 3:
				case 4:
				case 5:
					$this->copyChild($copy_question,$question);
					break;
			}

			$other = Question::with(['type'])->where( 'parent' , $question->id )->where('type_id',9)->first();

				if(isset($other)){
					$this->newOtherChild($copy_question->id,$questionnaire->id);
				}
			$questionUA = Question::where('rus_lang_id',$question->id)->first();
			$copy_questionUA = new Question();
			$copy_questionUA->lang = 'ua';
			$copy_questionUA->rus_lang_id = $copy_question->id;
			$copy_questionUA->sort = $questionUA->sort;
			$copy_questionUA->questionnaire_id = $questionnaire->id;
			$copy_questionUA->type_id = $questionUA->type_id;

			$copy_questionUA->name = $questionUA->name;
			$copy_questionUA->required = $questionUA->required;
			$copy_questionUA->help = $questionUA->help;

			$copy_questionUA->save();

		}

		return redirect()->route('adm_questionnaire_edit',[$questionnaire->id]);
		/*SEO::setTitle('Копия анкеты');
		AdminPageData::setPageName('Копия анкеты');
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel('Копия анкеты');

		return view('admin.questionnaire.copy', $this->getEditOrCopyPageContent($questionnaire_id));*/
	}

	protected function getEditOrCopyPageContent($questionnaire_id){
		$questionnaire = Questionnaire::find($questionnaire_id);
		$translate = Questionnaire::where('rus_lang_id',$questionnaire_id)->first();
		$questionnaireTypes = QuestionnaireType::all();
		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();
		$questions = Question::with(['type','translate','options.translate'])->where([
			['parent',0],
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id', 0],
			['isHide', 0]
		])->orderBy('sort')->get();

		$projects = Project::where([
			['rus_lang_id', 0],
		])->get();

		return [
			'questionnaire' => $questionnaire,
			'translate' => $translate,
			'projects' => $projects,
			'questionnaireTypes' => $questionnaireTypes,
			'questionTypes' => $questionTypes,
			'questions' => $questions,
		];
	}

	public function statistics($questionnaire_id){
		$questions = Question::with(['type','translate','options.translate','options.answers'])->where([
			['parent',0],
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id', 0],
			['isHide', 0]
		])->get();
		$questionnaire = Questionnaire::find($questionnaire_id);
		SEO::setTitle('Статистика анкеты');
		AdminPageData::setPageName('Статистика анкеты');
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel($questionnaire->name,'edit/'.$questionnaire->id);
		AdminPageData::addBreadcrumbLevel('Статистика');

		return view('admin.questionnaire.statistics', [
			'questions' => $questions,
		]);
	}
	public function create(Request $request){
		$questionnaire = new Questionnaire();
		$translate = new Questionnaire();

		$this->createOrEdit($request,$questionnaire,$translate);

		ModeratorLogs::addLog("Добавил Анкету: ".$request->name);
		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_questionnaire_edit',$questionnaire->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_questionnaire');
		}else{
			return redirect()->route('adm_questionnaire_new');
		}
	}
	public function save(Request $request,$questionnaire_id){
		$questionnaire = Questionnaire::find($questionnaire_id);
		$translate = Questionnaire::where('rus_lang_id',$questionnaire_id)->first();

		$this->createOrEdit($request,$questionnaire,$translate);
		ModeratorLogs::addLog("Отредактировал анкету Анкету: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_questionnaire_edit',$questionnaire->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_questionnaire');
		}else{
			return redirect()->route('adm_questionnaire_new');
		}

	}
	public function delete($questionnaire_id){
		Questionnaire::destroy($questionnaire_id);
		Questionnaire::where('rus_lang_id',$questionnaire_id)->delete();

		$questions = Question::where('questionnaire_id',$questionnaire_id)->get();
		foreach ($questions as $question){
			Answer::where('question_id',$question->id)->delete();
			$question->delete();
		}
		return "ok";
	}
	public function hide($questionnaire_id){
		$questionnaire = Questionnaire::find($questionnaire_id);
		$questionnaire->isHide = true;
		$questionnaire->save();
		$questionnaire = Questionnaire::where('rus_lang_id',$questionnaire_id)->first();
		if($questionnaire){
			$questionnaire->isHide = true;
			$questionnaire->save();
		}
		return "ok";
	}
	public function show($questionnaire_id){
		$questionnaire = Questionnaire::find($questionnaire_id);
		$questionnaire->isHide = false;
		$questionnaire->save();
		$questionnaire = Questionnaire::where('rus_lang_id',$questionnaire_id)->first();
		if($questionnaire){
			$questionnaire->isHide = false;
			$questionnaire->save();
		}
		return "ok";
	}

	public function pdf($questionnaire_id){
		$questionnaire = Questionnaire::with(['project'])
			->find($questionnaire_id);
		$questions = Question::with(['options','answers'])
			->where([
				['questionnaire_id',$questionnaire_id],
				['lang','ru'],
			])
			->get();
		$pdf = PDF::loadView('admin.questionnaire.pdf', [
			'questionnaire' => $questionnaire,
			'questions' => $questions,
		]);
		$pdf->setOption('enable-javascript', true);
		$pdf->setOption('javascript-delay', 5000);
		$pdf->setOption('enable-smart-shrinking', true);
		$pdf->setOption('no-stop-slow-scripts', true);
		$pdf->setOption('footer-center', '[page]');
		return $pdf->download($questionnaire->name.': '.$questionnaire->project->name.'.pdf');
		/*return view('admin.questionnaire.pdf',
			[
				'questionnaire' => $questionnaire,
				'questions' => $questions,
			]
		);*/
	}

	public function getExcel($questionnaire_id){
		$questionnaire = Questionnaire::with(['project'])
			->find($questionnaire_id);
		return (new AnswerExport($questionnaire_id))
			->download($questionnaire->id.'_'.time().'.xlsx');
	}

	public function getExcelWithRegistration($questionnaire_id){
		$questionnaire = Questionnaire::with(['project'])
			->find($questionnaire_id);
		$questionnaireRegistration = Questionnaire::with(['project'])->where([
			['project_id', $questionnaire->project_id],
			['type_id', 2],
		])->first();

		return (new AnswerExport($questionnaire_id,$questionnaireRegistration->id))
			->download($questionnaire->id.'_'.time().'.xlsx');
	}

	protected function createOrEdit($request,$questionnaire,$translate){
		$questionnaire->name = $request->name;
		$questionnaire->text = $request->text;
		$questionnaire->type_id = $request->questionnaire_type;
		if($request->questionnaire_type != 1 && $request->questionnaire_type != 5){
			$questionnaire->project_id = $request->project_id;
		}
		$questionnaire->isHide = ($request->submit == "save-hide");
		$questionnaire->save();

		$translate->name = $request->nameUA;
		$translate->text = $request->textUA;
		$translate->lang = 'ua';
		$translate->rus_lang_id = $questionnaire->id;
		$translate->type_id = $request->questionnaire_type;
		$translate->save();

		$sort = 1;

		if($request->has('question')){
			foreach ($request->question as $key=>$value){
				$this->createOrEditQuestion($request,$key,$sort,$questionnaire->id);
				$sort++;
			}
		}


		//$this->deleteQuestions($questionnaire->id, $request);

		if(!$questionnaire->isSendNotification && !$questionnaire->isHide){
			$questionnaire->isSendNotification = true;
			$questionnaire->save();
			if ($questionnaire->type_id == 4)
			{
				$projectRequests = Project\ProjectRequest::where('project_id', $questionnaire->project_id)->get();
				$project = $questionnaire->project;
				foreach ($projectRequests as $projectRequest)
				{
					if($projectRequest->status_id >= 9){


						$link = "ru/projects/questionnaire/".$questionnaire->id.'/';
						$projectName = $project->name;
						if ($projectRequest->user->lang == "ua")
						{
							$link = "projects/questionnaire/".$questionnaire->id.'/';
							$projectName = $project->translate->name;
						}
						if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter){
							Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 'questionnaire_second_report', url('/').$link, ['project' => $projectName]));
						}
						Notification::send('questionnaire_second_report', $projectRequest->user, 1, $link, ['project' => $projectName]);
					}
				}
			}
		}

	}

	protected function createOrEditQuestion($request,$key,$sort,$questionnaire_id){
		$question = Question::find($request->question[$key]);
		/*if(empty($question)){
			$question = new Question();
		}
		$question->name = $request->question_name[$key];
		$question->type_id = $request->question_type[$key];
		$question->questionnaire_id = $questionnaire_id;
		$question->required = ($request->has('question_required.'.$key));
		$question->help = $request->question_help[$key];
		$restrictions = [
			"min" => $request->question_min[$key],
			"max" => $request->question_max[$key]
		];
		$question->restrictions = $restrictions;*/
		$question->sort = $sort;
		/*if(isset($request->question_relation[$key])){
			if(array_key_exists(((int)$request->question_relation[$key]),$this->childsId)){
				$question->question_relation_id = $this->childsId[((int)$request->question_relation[$key])];
			}
		}*/

		$question->save();
		/*
		$this->childsId[] = $question->id;


		switch ($question->type_id){
			case 3:
			case 4:
			case 5:
				$this->newOrEditChild($request,$question->id,$key,$questionnaire_id);
				break;
		}

		$other = Question::with(['type'])->where( 'parent' , $question->id )->where('type_id',9)->first();
		if ($request->has('question_'.$request->question[$key].'_other')){
			if(empty($other)){
				$this->newOtherChild($question->id,$questionnaire_id);
			}
		}elseif(!empty($other)){
			$other->delete();
		}

		$ruId = $question->id;*/
		// UA
		$questionUA = Question::where('rus_lang_id',$question->id)->first();

		/*if(empty($questionUA))
		{
			$questionUA = new Question();
			$questionUA->type_id = $question->type_id;
			$questionUA->lang = 'ua';
			$questionUA->rus_lang_id = $ruId;
		}

		$questionUA->name = $request->question_name_ua[$key];
		$questionUA->required = $question->required;
		$questionUA->help = $request->question_help_ua[$key];
		$questionUA->questionnaire_id = $questionnaire_id;*/
		$questionUA->sort = $sort;

		$questionUA->save();

	}

	protected function newOrEditChild($request,$question_id,$key,$questionnaire_id){
		$sort = 1;
		if($request->has('question_children_question_'.$request->question[$key].'')){
			foreach ($request->input('question_children_question_'.$request->question[$key]) as $i=>$children){
				$child = Question::find($request->input('question_'.$request->question[$key].'_children_id.'.$i));
				if(empty($child)){
					$child = new Question();
					$child->type_id = 7;
					$child->parent = $question_id;
					$child->questionnaire_id = $questionnaire_id;
				}
				$child->name = $request->input('question_children_question_'.$request->question[$key])[$i];
				$child->sort = $sort;
				$child->save();
				$this->childsId[((int)$request->input('question_'.$request->question[$key].'_children_id.'.$i))] = $child->id;
				$translate =  Question::where('rus_lang_id',$child->id)->first();
				if(empty($translate)){
					$translate = new Question();
					$translate->type_id = 7;
					$translate->parent = $question_id;
					$translate->questionnaire_id = $questionnaire_id;
					$translate->lang = 'ua';
					$translate->rus_lang_id = $child->id;
				}
				$translate->name = $request->input('question_children_ua_question_'.$request->question[$key])[$i];
				$translate->sort = $sort;
				$translate->save();
				$sort++;
			}
		}
	}

	protected function copyChild($copy_question,$question){

			foreach ($question->options as $option)
			{
				if($option->type_id == 7){
					$copy_option = new Question();
					$copy_option->type_id = 7;
					$copy_option->parent = $copy_question->id;
					$copy_option->questionnaire_id = $copy_question->questionnaire_id;
					$copy_option->name = $option->name;
					$copy_option->sort = $option->sort;
					$copy_option->save();

					$translate = Question::where('rus_lang_id', $option->id)->first();

					$copy_translate = new Question();
					$copy_translate->type_id = 7;
					$copy_translate->parent = $copy_question->id;
					$copy_translate->questionnaire_id = $copy_question->questionnaire_id;
					$copy_translate->lang = 'ua';
					$copy_translate->rus_lang_id = $copy_option->id;
					$copy_translate->name = $translate->name;
					$copy_translate->sort = $translate->sort;
					$copy_translate->save();
				}

			}
	}

	protected function newOtherChild($question_id,$questionnaire_id){
		$child = new Question();
		$child->name = "Другое";
		$child->type_id = 9;
		$child->parent = $question_id;
		$child->questionnaire_id = $questionnaire_id;
		$child->save();
	}
/*
	protected function deleteQuestions($questionnaire_id){
		$questions = Question::where([
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id',0],
			['parent',0],
		])->get();

		foreach ($questions as $question){
			if(!in_array($question->id,$this->childsId)){
				Question::where([
					['rus_lang_id',$question->id],
				])->delete();
				Question::where([
					['parent',$question->id],
				])->delete();
				$question->delete();
			}
		}
	}*/
}
