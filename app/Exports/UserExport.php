<?php

namespace App\Exports;


use App\User;
use App\Model\Questionnaire\Question;
//use App\Model\Project\ProjectRequest;

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
		$filters = $this->filters;

		$cities = [];
		$regions = [];
		$projects = [];
		$projectExpert = [];
		$questions = [];

		if($filters->has('filter.city'))
		{
			$cities = explode(',', $filters->filter['city']);
		}
		if($filters->has('filter.region'))
		{
			$regions = explode(',', $filters->filter['region']);
		}
		if($filters->has('filter.project')){
			foreach ( $filters->filter['project'] as $key => $item){
				$projects[] = (int)$filters->input('filter.project')[$key];
			}
		}
		if($filters->has('filter.projectExpert')){
			foreach ( $filters->filter['projectExpert'] as $key => $item){
				$projectExpert[] = (int)$filters->input('filter.projectExpert')[$key];
			}
		}
		if($filters->has('filter.questions')){
			foreach ( $filters->filter['questions'] as $key => $item){
				$questions[] = (int)$filters->input('filter.questions')[$key];
			}
		}

		$users = User::with([
				'requests.answers.question.parent_question',
				'requests.project',
				'roles'
			])
			->when( !empty($filters->filter['sex']), function ($query) use ($filters){
				$query->where('sex',$filters->filter['sex']);
			})
			->when( !empty($filters->filter['status']), function ($query) use ($filters){
				$query->where('status_id',$filters->filter['status']);
			})->when( !empty($filters->filter['old_min']), function ($query) use ($filters){
				$query->where('birsday','>=',$filters->filter['old_min']);
			})->when( !empty($filters->filter['old_max']), function ($query) use ($filters){
				$query->where('birsday','<=',$filters->filter['old_max']);
			})->when( !empty($filters->filter['city']), function ($query) use ($cities){
				$query->whereIn('city',    $cities );
			})->when( !empty($filters->filter['region']), function ($query) use ($regions){
				$query->whereIn('region',    $regions );
			})->when( !empty($filters->filter['role']), function ($query) use ($filters){
				$query->whereHas('roles', function($q) use ($filters){
					$q->where('name', $filters->filter['role']);
				});
			})->when( $filters->has('filter.project'), function ($query) use ($projects){
				$query->whereHas('requests', function($q) use ($projects){
					$q->whereIn('project_id', $projects);
				});
			})->when( $filters->has('filter.projectExpert'), function ($query) use ($projectExpert){
				$query->whereHas('requests', function($q) use ($projectExpert){
					$q->where('status_id', 9)->whereIn('project_id', $projectExpert);
				});
			})->when( $filters->has('filter.questions'), function ($query) use ($questions){
				$query->whereHas('requests', function($requests) use ($questions){
					$requests->whereHas('answers', function($answers) use ($questions){
						$answers->whereIn('question_id', $questions)
							->orWhereHas('question', function($question) use ($questions){
								$question->whereIn('parent',$questions);
							});
					});
				});
			});
		return $users;
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
		$row[] = $user->city;
		$row[] = $user->region;
		$row[] = $user->country;

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
