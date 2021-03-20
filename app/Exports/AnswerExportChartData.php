<?php

namespace App\Exports;

use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Project\ProjectRequest;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;


class AnswerExportChartData implements FromView, WithTitle
{
	use Exportable;
	protected $questionnaire_id;
	protected $questionnaireRegistration_id;

	public function __construct($questionnaire_id,$questionnaireRegistration_id = null)
	{
		$this->questionnaire_id = $questionnaire_id;
		$this->questionnaireRegistration_id = $questionnaireRegistration_id;
	}
	public function title(): string
	{
		return 'Диаграммы';
	}

	public function view(): View
	{
		$questionnaire = Questionnaire::with(['project'])
			->find($this->questionnaire_id);
		$questions = Question::with(['options','answers.request.user'])
			->where('questionnaire_id',$this->questionnaire_id)
			->get();
		$questionsRegistration = null;
		if($this->questionnaireRegistration_id){
			$questionsRegistration = Question::with(['options'])
				->where([
					['questionnaire_id',$this->questionnaireRegistration_id],
					['rus_lang_id',0],
				])
				->orderBy('sort')
				->get();
		}
		$status = 1;
		if($questionnaire->type_id >= 3){
			$status = 9;
		}
		$requests = ProjectRequest::with(['user','answers.question.parent_question'])
			->where([
				['status_id','>=',$status],
				['project_id',$questionnaire->project_id],
			])
			->get();
		return view('admin.questionnaire.excel', [
			'questions' => $questions,
			'questionsRegistration' => $questionsRegistration,
			'requests' => $requests,
		]);
	}

}
