<?php

namespace App\Http\Controllers\Admin;

use App\Model\Questionnaire\Answer;
use App\Model\Questionnaire\QuestionnaireType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Questionnaire\Question;
use App\Model\Questionnaire\FieldType;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class QuestionController extends Controller
{
	protected $childsId = [];

	public function ajax(Request $request,$questionnaire_id){
		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();
		$questions = Question::with(['type','translate','options.translate'])->where([
			['parent',0],
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id', 0],
			['isHide', 0]
		])->orderBy('sort')->paginate(5);
		$request->ajax();

		$view = view('admin.questionnaire.includes.questions',compact('questions','questionTypes'))->render();
		return response()->json([
			'html' => $view,
			'isNext' => $questions->nextPageUrl() || false
		]);
	}


	public function ajax_copy(Request $request,$questionnaire_id){
		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();
		$questions = Question::with(['type','translate','options.translate'])->where([
			['parent',0],
			['questionnaire_id',$questionnaire_id],
			['rus_lang_id', 0],
			['isHide', 0]
		])->orderBy('sort')->paginate(5);
		$request->ajax();

		$view = view('admin.questionnaire.includes.questions_copy',compact('questions','questionTypes'))->render();
		return response()->json([
			'html' => $view,
			'isNext' => $questions->nextPageUrl() || false
		]);
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$questions = Question::where([
			['lang','ru'],
			['parent',0],
			['name','like',"%".$name."%"],
		])->limit(5)->get();

		$formatted_projects = [];

		foreach ($questions as $question) {
			$formatted_projects[] = [
				'id' => $question->id,
				'text' => $question->name.'(id: '.$question->id.')'
			];
		}

		return \Response::json($formatted_projects);
	}

	public function find_options($id)
	{
		$questions = Question::where([
			['lang','ru'],
			['parent',$id],
		])->orderBy('sort')->get();

		$formatted_data = [];

		foreach ($questions as $question) {
			$formatted_data[] = [
				'id' => $question->id,
				'text' => $question->name
			];
		}

		return \Response::json($formatted_data);
	}

	public function new($questionnaire_id){
		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();
		$relation_questions = Question::whereIn('type_id',[3,4,5])
			->where([
				['questionnaire_id',$questionnaire_id],
				['lang','ru'],
			])->orderBy('sort')
			->get();

		SEO::setTitle('Новый вопрос');
		AdminPageData::setPageName('Новый вопрос');
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel('Редактирование анкеты','edit/'.$questionnaire_id);
		AdminPageData::addBreadcrumbLevel('Новый вопрос');

		return view('admin.questionnaire.question_new', compact('questionnaire_id', 'questionTypes','relation_questions'));
	}

	public function create(Request $request, $questionnaire_id){
		$question = $this->createOrEdit($request,null,$questionnaire_id);

		ModeratorLogs::addLog("Добавил Вопрос: ".$request->name);

		if (($request->submit == "save")){
			return redirect()->route('adm_question_edit',$question->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_questionnaire_edit',$question->questionnaire_id);
		}else{
			return redirect()->route('adm_question_create',$question->questionnaire_id);
		}
	}

	public function edit($id){
		$question = Question::find($id);
		$questionTypes = FieldType::whereNotIn('id', [7, 9])->get();
		$relation_questions = Question::whereIn('type_id',[3,4,5])
			->where([
				['questionnaire_id',$question->questionnaire_id],
				['lang','ru'],
			])->orderBy('sort')
			->get();

		$question_relation = Question::find($question->question_relation_id);

		SEO::setTitle('Редактирование вопроса');
		AdminPageData::setPageName('Вопрос '.$question->name);
		AdminPageData::addBreadcrumbLevel('Анкеты','questionnaire');
		AdminPageData::addBreadcrumbLevel('Редактирование анкеты','edit/'.$question->questionnaire_id);
		AdminPageData::addBreadcrumbLevel('Редактирование вопроса');

		return view('admin.questionnaire.question', compact('question', 'questionTypes', 'relation_questions', 'question_relation'));
	}

	public function save(Request $request,$question_id){
		$question = Question::find($question_id);
		$this->createOrEdit($request,$question,$question->questionnaire_id);

		ModeratorLogs::addLog("Отредактировал Вопрос: ".$request->name);
		if (($request->submit == "save")){
			return redirect()->route('adm_question_edit',$question->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_questionnaire_edit',$question->questionnaire_id);
		}else{
			return redirect()->route('adm_question_create',$question->questionnaire_id);
		}
	}

	public function delete($question_id){
		if($question_id != 0){


			$questions = Question::where('parent',$question_id)->get();
			foreach ($questions as $question){
				foreach (Answer::where('question_id',$question->id)->get() as $answer){
					Answer::destroy($answer->id);
				}

				Question::destroy($question->id);
			}
			$questions = Question::where('rus_lang_id',$question_id)->get();
			foreach ($questions as $question){
				foreach (Answer::where('question_id',$question->id)->get() as $answer){
					Answer::destroy($answer->id);
				}
				Question::destroy($question->id);
			}

			Question::destroy($question_id);
		}
		return "ok";
	}
	public function hide($question_id){
		$question = Question::find($question_id);
		$question->isHide = true;
		$question->save();
		return "ok";
	}
	public function show($question_id){
		$question = Question::find($question_id);
		$question->isHide = false;
		$question->save();
		return "ok";
	}


	protected function createOrEdit($request,$question, $questionnaire_id){
		if(empty($question)){
			$question = new Question();
			$question->questionnaire_id = $questionnaire_id;
			$question->sort = time();
		}
		$question->name = $request->question_name;
		$question->type_id = $request->question_type;
		$question->required = ($request->has('question_required'));
		$question->help = $request->question_help;
		$restrictions = [
			"min" => $request->question_min,
			"max" => $request->question_max
		];
		$question->restrictions = $restrictions;
		if(isset($request->question_relation)){
			//if(array_key_exists(((int)$request->question_relation[$key]),$this->childsId)){
				$question->question_relation_id = $request->question_relation;
			//}
		}

		$question->save();

		$this->childsId[] = $question->id;

		switch ($question->type_id){
			case 3:
			case 4:
			case 5:
				$this->newOrEditChild($request,$question->id,$questionnaire_id);
				break;
		}

		$other = Question::with(['type'])->where( 'parent' , $question->id )->where('type_id',9)->first();
		if ($request->has('question_'.$request->question.'_other')){
			if(empty($other)){
				$this->newOtherChild($question->id,$questionnaire_id);
			}
		}elseif(!empty($other)){
			$other->delete();
		}

		$ruId = $question->id;
		/* UA */
		$questionUA = Question::where('rus_lang_id',$ruId)->first();

		if(empty($questionUA))
		{
			$questionUA = new Question();
			$questionUA->lang = 'ua';
			$questionUA->rus_lang_id = $ruId;
			$questionUA->sort = time();
			$questionUA->questionnaire_id = $questionnaire_id;
		}

		$questionUA->type_id = $question->type_id;

		$questionUA->name = $request->question_name_ua;
		$questionUA->required = $question->required;
		$questionUA->help = $request->question_help_ua;

		$questionUA->save();

		return $question;
	}

	protected function newOrEditChild($request,$question_id,$questionnaire_id){
		$sort = 1;
		if($request->has('question_children_question_'.$request->question.'')){
			foreach ($request->input('question_children_question_'.$request->question) as $i=>$children){
				$child = Question::find($request->input('question_'.$request->question.'_children_id.'.$i));
				if(empty($child)){
					$child = new Question();
					$child->type_id = 7;
					$child->parent = $question_id;
					$child->questionnaire_id = $questionnaire_id;
				}
				$child->name = $request->input('question_children_question_'.$request->question)[$i];
				$child->sort = $sort;
				$child->save();
				$this->childsId[((int)$request->input('question_'.$request->question.'_children_id.'.$i))] = $child->id;
				$translate =  Question::where('rus_lang_id',$child->id)->first();
				if(empty($translate)){
					$translate = new Question();
					$translate->type_id = 7;
					$translate->parent = $question_id;
					$translate->questionnaire_id = $questionnaire_id;
					$translate->lang = 'ua';
					$translate->rus_lang_id = $child->id;
				}
				$translate->name = $request->input('question_children_ua_question_'.$request->question)[$i];
				$translate->sort = $sort;
				$translate->save();
				$sort++;
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
}
