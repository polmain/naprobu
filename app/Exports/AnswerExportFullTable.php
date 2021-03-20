<?php

namespace App\Exports;

use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Project\ProjectRequest;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnswerExportFullTable implements  WithTitle, FromQuery, WithMapping,WithHeadings
{
	use Exportable;
	protected $questionnaire_id;
	protected $questionnaireRegistration_id;
	protected $questions;
	protected $questionsRegistration;
	protected $question_count;
	protected $question_id;
	protected $heads;

	public function __construct($questionnaire_id,$questionnaireRegistration_id = null)
	{
		$this->questionnaire_id = $questionnaire_id;
		$this->questionnaireRegistration_id = $questionnaireRegistration_id;
		$this->questions = Question::with(['options'])
			->where([
				['questionnaire_id',$this->questionnaire_id],
				['rus_lang_id',0],
			])
			->orderBy('sort')
			->get();
		if($questionnaireRegistration_id){
			$this->questionsRegistration = Question::with(['options'])
				->where([
					['questionnaire_id',$questionnaireRegistration_id],
					['rus_lang_id',0],
				])
				->orderBy('sort')
				->get();
		}
		$this->headGenerator();
	}


	public function title(): string
	{
		return 'Все ответы';
	}


	public function query()
	{
		$questionnaire = Questionnaire::with(['project'])
			->find($this->questionnaire_id);

		$status = 1;
		if($questionnaire->type_id >= 3){
			$status = 9;
		}
		$requests = ProjectRequest::with(['user','answers.question.parent_question'])
			->where([
				['status_id','>=',$status],
				['project_id',$questionnaire->project_id],
			]);
		return $requests;
	}
	public function map($request): array
	{
		$row = [];
		$row[] = $request->id;

		$row[] = $request->user->name;
		$row[] = $request->user->last_name;
		$row[] = $request->user->first_name;
		$row[] = $request->user->patronymic;
		$row[] = $request->user->birsday;
		$row[] = $request->user->region;
		$row[] = $request->user->city;
		$row[] = $request->user->email;
		$row[] = $request->user->phone;
		$row[] = 'https://naprobu.ua/user/'.$request->user->id.'/';
		for ($i = 11; $i < $this->question_count+11; $i++){
			$row[$i] = "";
		}
		$questions = [];

		$questionnaires = [$this->questionnaire_id];
		if($this->questionnaireRegistration_id)
		{
			$questionnaires = [$this->questionnaireRegistration_id];
		}

		foreach ($request->answers as $answer){
			if($answer->question ){
				if(in_array($answer->question->questionnaire_id,$questionnaires) && (!array_search($answer->question->id,$questions))){
					$questions[] = $answer->question->id;
					if($answer->question->type_id == 7){
						$index = array_search ($answer->question->parent_question->id,$this->question_id);
						if($index < count($row)){
							$row[$index] .= $answer->question->name.", ";
						}
					}elseif($answer->question->type_id == 9){
						$index = array_search ($answer->question->parent_question->id,$this->question_id);
						if($index < count($row))
						{
							$row[$index] .= "(" . $answer->question->name . ") " . $answer->answer;
						}
					}else
					{
						$index = array_search($answer->question->id, $this->question_id);
						if($index < count($row))
						{
							$row[$index] = $answer->answer;
						}
					}
				}
			}
		}

		return $row;
	}
	public function headings(): array
	{
		return $this->heads;
	}

	protected function headGenerator(){
		$this->heads = [];
		$this->heads[] = '#';
		$this->heads[] = 'Никнейм';
		$this->heads[] = 'Фамилия';
		$this->heads[] = 'Имя';
		$this->heads[] = 'Очество';
		$this->heads[] = 'Год рождения';
		$this->heads[] = 'Область';
		$this->heads[] = 'Город';
		$this->heads[] = 'E-mail';
		$this->heads[] = 'Телефон';
		$this->heads[] = 'Ссылка на профиль пользователя';
		$this->question_id = [];
		for($i = 0; $i < 11; $i++){
			$this->question_id[] = 0;
		}
		$this->question_count = 0;
		if($this->questionnaireRegistration_id){
			foreach($this->questionsRegistration as $question){
				if(($question->type_id != 7 && $question->type_id != 9)){
					$this->heads[] = $question->name;
					$this->question_id[] = $question->id;
					$this->question_count ++;
				}
			}
		}

		foreach($this->questions as $question){
			if(($question->type_id != 7 && $question->type_id != 9)){
				$this->heads[] = $question->name;
				$this->question_id[] = $question->id;
				$this->question_count ++;
			}
		}
	}
}
