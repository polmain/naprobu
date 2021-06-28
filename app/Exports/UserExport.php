<?php

namespace App\Exports;


use App\Library\Queries\UserFilterServices;
use App\User;
use App\Model\Questionnaire\Question;
//use App\Model\Project\ProjectRequest;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;

class UserExport implements  WithTitle, FromQuery, WithMapping,WithHeadings,ShouldQueue
{
	use Exportable;
	protected $filters;
	protected $questions;
	protected $heads;
	protected $question_id;

	public function __construct($request)
	{
		$this->filters = $request;
		$questions = [];
		if($request->has('filter.questions')){
			foreach ( $request->filter['questions'] as $key => $item){
				$questions[] = (int)$request->input('filter.questions')[$key];
			}
		}
		$this->questions = Question::with(['options'])
			->whereIn('id',$questions)
			->get();

		$this->headGenerator();
	}


	public function title(): string
	{
		return 'Пользователи';
	}
	public function query()
	{
		return UserFilterServices::getFilteredUsersQuery($this->filters);
	}

	public function map($user): array
	{
		$row = [];
		$row[] = $user->id;
		$row[] = $user->name;
		$row[] = ($user->roles->first())?$user->roles->first()->name:""; //$user->roles->first()->name;
		$row[] = $user->status->name;
		$row[] = $user->email;
		$row[] = $user->last_name . ' ' . $user->first_name . ' ' . $user->patronymic;
		$row[] = ($user->sex)?'Мужской':'Женский';
		$row[] = $user->birsday;
		$row[] = $user->city_model ? $user->city_model->name : '-';
		$row[] = $user->region_model ? $user->region_model->name : '-';
		$row[] = $user->country_model ? $user->country_model->name : '-';

		$row[] = $user->education ? trans("education.".$user->education) : '-';
		$row[] = $user->employment ? trans("employment.".$user->employment) : '-';
		$row[] = $user->work && $user->employment ? trans("work.".$user->work) : '-';
		$row[] = $user->family_status ? trans("family_status.".$user->family_status) : '-';
		$row[] = $user->material_condition ? trans("material_condition.".$user->material_condition) : '-';


		if(is_array($user->hobbies)){
            $hobbies = '';
            foreach($user->hobbies as $hobby){
                $hobbies.= trans("hobbies.".$hobby).'; ';
            }
            if($user->hobbies_other){
                $hobbies.= $user->hobbies_other;
            }
            $row[] = $hobbies;
        }
		else {
            $row[] = '-';
        }

        $row[] = $user->getPriority();
        $row[] = $user->rang->name;
        $row[] = $user->history->sum('score');
        $row[] = $user->last_active;
        $row[] = $user->created_at;
        $row[] = $user->lastApproveRequest()?$user->lastApproveRequest()->updated_at : '-';
        $row[] = $user->approveRequestCount();

		$projectNames = '';
		$projectInNames = '';
		foreach ($user->requests as $request){
			$projectNames .= $request->project->name.'; ';
			if($request->status_id == 9){
				$projectInNames .= $request->project->name.'; ';
			}
		}
		$row[] = $projectNames;
		$row[] = $projectInNames;

		for ($i = 13; $i < $this->questions->count() + 13; $i++){
			$row[$i] = "";
		}

		foreach ($user->requests as $request){
			foreach ($request->answers as $answer){
				if($answer->question){

					if($answer->question->type_id == 7){
						if(array_search ($answer->question->parent_question->id, $this->question_id) > -1){
							$row[array_search ($answer->question->parent_question->id,$this->question_id)] .= $answer->question->name.", ";
						}

					}elseif($answer->question->type_id == 9){
						if(array_search ($answer->question->parent_question->id, $this->question_id) > -1)
						{
							$row[array_search($answer->question->parent_question->id, $this->question_id)] .= "(" . $answer->question->name . ") " . $answer->answer;
						}
					}else
					{
						if(array_search ($answer->question->id, $this->question_id) > -1)
						{
							$row[array_search($answer->question->id, $this->question_id)] = $answer->answer;
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
		$this->heads[] = 'Логин';
		$this->heads[] = 'Роль пользователя';
		$this->heads[] = 'Статус';
		$this->heads[] = 'EMail';
		$this->heads[] = 'ФИО';
		$this->heads[] = 'Пол';
		$this->heads[] = 'Возраст';
		$this->heads[] = 'Город';
		$this->heads[] = 'Область';
		$this->heads[] = 'Страна';
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
		$this->heads[] = 'Подавал заявки в проекты';
		$this->heads[] = 'Учавствовал в проектах';


		$this->question_id = [];
		for( $i=0; $i<13; $i++){
			$this->question_id[] = 0;
		}

		foreach($this->questions as $question){
			$this->heads[] = $question->name;
			$this->question_id[] = $question->id;
		}
	}
}
