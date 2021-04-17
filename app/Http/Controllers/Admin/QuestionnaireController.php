<?php

namespace App\Http\Controllers\Admin;

use App\Library\Users\Notification;
use App\Mail\UserNotificationMail;
use App\Exports\AnswerExport;
use App\Exports\AnswerExportFullTable;
use App\Model\Project\ProjectRequest;
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
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

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

		foreach (self::TRANSLATE_LANG as $lang){
            $this->copyTranslate($original_questionnaire, $questionnaire, $lang);
        }

		$this->copyQuestions($original_questionnaire, $questionnaire);

		return redirect()->route('adm_questionnaire_edit',[$questionnaire->id]);
	}

	private function copyTranslate(Questionnaire $originalQuestionnaire, Questionnaire $questionnaire, string $lang): void
    {
        $original_translate = Questionnaire::where([
            'rus_lang_id' => $originalQuestionnaire->id,
            'lang' => $lang,
        ])->first();

        if(!$original_translate){
            return;
        }

        $translate = new Questionnaire();

        $translate->name = $original_translate->name.' (Копия)';
        $translate->text = $original_translate->text;
        $translate->lang = $lang;
        $translate->rus_lang_id = $questionnaire->id;
        $translate->type_id = $original_translate->type_id;
        $translate->save();
    }

    private function copyQuestions(Questionnaire $originalQuestionnaire, Questionnaire $questionnaire): void
    {
        $questions = Question::with(['type','translate','options.translate'])->where([
            ['parent',0],
            ['questionnaire_id',$originalQuestionnaire->id],
            ['rus_lang_id', 0],
            ['isHide', 0]
        ])->orderBy('sort')->get();

        foreach ($questions as $question){
            $copyQuestion = new Question();
            $copyQuestion->questionnaire_id = $questionnaire->id;
            $copyQuestion->sort = $question->sort;
            $copyQuestion->name = $question->name;
            $copyQuestion->type_id = $question->type_id;
            $copyQuestion->required = $question->required;
            $copyQuestion->help = $question->help;
            $copyQuestion->restrictions = $question->restrictions;
            $copyQuestion->question_relation_id = $question->question_relation_id;
            $copyQuestion->save();

            switch ($question->type_id){
                case 3:
                case 4:
                case 5:
                    $this->copyChild($copyQuestion,$question);
                    break;
            }

            $other = Question::with(['type'])->where( 'parent' , $question->id )->where('type_id',9)->first();

            if(isset($other)){
                $this->newOtherChild($copyQuestion->id,$questionnaire->id);
            }

            foreach (self::TRANSLATE_LANG as $lang){
                $this->copyTranslateQuestion($question, $copyQuestion, $lang);
            }

        }
    }

    private function copyTranslateQuestion(Question $originalQuestion, Question $copyQuestion,  string $lang): void
    {
        $translate = Question::where([
            'rus_lang_id' => $originalQuestion->id,
            'lang' => $lang,
        ])->first();

        if(!$translate){
            return;
        }

        $copyTranslate = new Question();
        $copyTranslate->lang = $lang;
        $copyTranslate->rus_lang_id = $copyQuestion->id;
        $copyTranslate->sort = $translate->sort;
        $copyTranslate->questionnaire_id = $copyQuestion->questionnaire_id;
        $copyTranslate->type_id = $translate->type_id;

        $copyTranslate->name = $translate->name;
        $copyTranslate->required = $translate->required;
        $copyTranslate->help = $translate->help;

        $copyTranslate->save();
    }

	private function getEditOrCopyPageContent($questionnaire_id): array{
		$questionnaire = Questionnaire::find($questionnaire_id);
		$translate = Questionnaire::where('rus_lang_id',$questionnaire_id)->get();
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

		$this->createOrEdit($request,$questionnaire);

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

		$this->createOrEdit($request,$questionnaire);
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

	private function createOrEdit(Request $request,Questionnaire $questionnaire): void
    {
		$questionnaire->name = $request->name;
		$questionnaire->text = $request->text;
		$questionnaire->type_id = $request->questionnaire_type;
		if($request->questionnaire_type !== 1 && $request->questionnaire_type !== 5){
			$questionnaire->project_id = $request->project_id;
		}
		$questionnaire->isHide = ($request->submit === "save-hide");
		$questionnaire->save();

		foreach (self::TRANSLATE_LANG as $lang){
            if($this->checkRequiredForLang($request, $lang)){
                $this->createOrEditTranslate($questionnaire, $request, $lang);
            }
        }

		$sort = 1;

		if($request->has('question')){
			foreach ($request->question as $key=>$value){
				$this->createOrEditQuestion($request,$key,$sort);
				$sort++;
			}
		}

		if(!$questionnaire->isSendNotification && !$questionnaire->isHide){
			$this->sendNotification($questionnaire);
		}

	}

	private function sendNotification(Questionnaire $questionnaire): void
    {
        $questionnaire->isSendNotification = true;
        $questionnaire->save();
        if ($questionnaire->type_id === 4)
        {
            $projectRequests = ProjectRequest::where('project_id', $questionnaire->project_id)->get();
            $project = $questionnaire->project;

            foreach ($projectRequests as $projectRequest)
            {
                if($projectRequest->status_id >= 9){
                    $link = "ru/projects/questionnaire/".$questionnaire->id.'/';
                    $projectName = $project->name;

                    $userLang = $projectRequest->user->lang;
                    $projectTranslate = $project->translate->firstWhere('lang', $userLang);

                    if($projectTranslate){
                        $projectName = $projectTranslate->name;

                        if($userLang === 'ua'){
                            $link = "projects/questionnaire/".$questionnaire->id.'/';
                        }else{
                            $link = $userLang."/projects/questionnaire/".$questionnaire->id.'/';
                        }
                    }

                    if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter){
                        Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 'questionnaire_second_report', url('/').$link, ['project' => $projectName]));
                    }
                    Notification::send('questionnaire_second_report', $projectRequest->user, 1, $link, ['project' => $projectName]);
                }
            }
        }
    }

	private function checkRequiredForLang(Request  $request, string $lang): bool
    {
        $upperLang = mb_strtoupper($lang);

        return (bool) $request->input('name'.$upperLang);
    }

	private function createOrEditTranslate(Questionnaire $questionnaire, Request $request, string $lang): void
    {
        $translate = Questionnaire::where([
            'rus_lang_id' => $questionnaire->id,
            'lang' => $lang
        ])->first();

        if(empty($translate)){
            $translate = new Questionnaire();

            $translate->lang = $lang;
            $translate->rus_lang_id = $questionnaire->id;
        }
        $upperLang = mb_strtoupper($lang);

        $translate->name = $request->input('name'.$upperLang);
        $translate->text = $request->input('text'.$upperLang);

        $translate->type_id = $request->questionnaire_type;
        $translate->save();
    }

	private function createOrEditQuestion(Request $request,$key,$sort): void{
		$question = Question::find($request->question[$key]);
		$question->sort = $sort;

		$question->save();

        foreach (self::TRANSLATE_LANG as $lang){
            $translate = Question::where([
                'rus_lang_id' => $question->id,
                'lang' => $lang,
            ])->first();

            if($translate){
                $translate->sort = $sort;
                $translate->save();
            }
        }
	}

	private function copyChild(Question $copyQuestion, Question $question): void
    {
        foreach ($question->options as $option) {
            if($option->type_id == 7){
                $copyOption = new Question();
                $copyOption->type_id = 7;
                $copyOption->parent = $copyQuestion->id;
                $copyOption->questionnaire_id = $copyQuestion->questionnaire_id;
                $copyOption->name = $option->name;
                $copyOption->sort = $option->sort;
                $copyOption->save();

                foreach (self::TRANSLATE_LANG as $lang){
                    $this->copyTranslateChildQuestion($option, $copyOption, $copyQuestion, $lang);
                }
            }
        }
	}

	private function copyTranslateChildQuestion(
	    Question $originalOption,
        Question $copyOption,
        Question $copyQuestion,
        string $lang
    ): void
    {
        $translate = Question::where([
            'rus_lang_id' => $originalOption->id,
            'lang' => $lang,
        ])->first();

        if(!$translate){
            return;
        }

        $copyTranslate = new Question();
        $copyTranslate->type_id = 7;
        $copyTranslate->parent = $copyQuestion->id;
        $copyTranslate->questionnaire_id = $copyQuestion->questionnaire_id;
        $copyTranslate->lang = 'ua';
        $copyTranslate->rus_lang_id = $copyOption->id;
        $copyTranslate->name = $translate->name;
        $copyTranslate->sort = $translate->sort;
        $copyTranslate->save();
    }

	private function newOtherChild($question_id,$questionnaire_id): void{
		$child = new Question();
		$child->name = "Другое";
		$child->type_id = 9;
		$child->parent = $question_id;
		$child->questionnaire_id = $questionnaire_id;
		$child->save();
	}
}
