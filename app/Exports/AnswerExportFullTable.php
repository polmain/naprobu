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

        $row[] = $request->user->city_model ? $request->user->city_model->name : '-';
        $row[] = $request->user->region_model ? $request->user->region_model->name : '-';

		$row[] = $request->user->email;
		$row[] = $request->user->phone;
		$row[] = 'https://naprobu.ua/user/'.$request->user->id.'/';

        $row[] = $request->user->education ? trans("education.".$request->user->education) : '-';
        $row[] = $request->user->employment ? trans("employment.".$request->user->employment) : '-';
        $row[] = $request->user->work && $request->user->employment ? trans("work.".$request->user->work) : '-';
        $row[] = $request->user->family_status ? trans("family_status.".$request->user->family_status) : '-';
        $row[] = $request->user->material_condition ? trans("material_condition.".$request->user->material_condition) : '-';


        if(is_array($request->user->hobbies)){
            $hobbies = '';
            foreach($request->user->hobbies as $hobby){
                $hobbies.= trans("hobbies.".$hobby).'; ';
            }
            if($request->user->hobbies_other){
                $hobbies.= $request->user->hobbies_other;
            }
            $row[] = $hobbies;
        }
        else {
            $row[] = '-';
        }

        $row[] = $request->user->getPriority();
        $row[] = $request->user->rang->name;
        $row[] = $request->user->history->sum('score');
        $row[] = $request->user->last_active;
        $row[] = $request->user->created_at;
        $row[] = $request->user->lastApproveRequest()?$request->user->lastApproveRequest()->updated_at : '-';
        $row[] = $request->user->approveRequestCount();


		for ($i = 24; $i < $this->question_count+24; $i++){
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

        $this->heads[] = 'Образование';
        $this->heads[] = 'Занятость';
        $this->heads[] = 'Кем работает';
        $this->heads[] = 'Семейное положение';
        $this->heads[] = 'Материальное состояние';
        $this->heads[] = 'Увлечения';
        $this->heads[] = 'Приоритет';
        $this->heads[] = 'Ранг';
        $this->heads[] = 'Балы';
        $this->heads[] = 'Был на сайте';
        $this->heads[] = 'Регистрация';
        $this->heads[] = 'Последние участие в проекте';
        $this->heads[] = 'Количество участий в проектах';
		$this->question_id = [];
		for($i = 0; $i < 24; $i++){
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
