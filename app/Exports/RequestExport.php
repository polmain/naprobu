<?php

namespace App\Exports;

use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Project\ProjectRequest;
use App\Model\Project;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestExport implements  WithTitle, FromQuery, WithMapping,WithHeadings
{
	use Exportable;
	protected $filters;
	protected $project_id;

	protected $questionnaire_id;
	protected $questions;
	protected $question_count;
	protected $question_id;
	protected $heads;

	public function __construct($request, $project_id)
	{
		$this->filters = $request;
		$this->project_id = $project_id;

		$this->questionnaire_id = Questionnaire::where([
			['type_id',2],
			['project_id',$project_id],
		])->first()->id;
		$this->questions = Question::with(['options'])
			->where([
				['questionnaire_id',$this->questionnaire_id],
				['rus_lang_id',0],
			])
			->get();
		$this->question_count = Question::with(['options'])
			->where([
				['questionnaire_id',$this->questionnaire_id],
				['rus_lang_id',0],
				['parent',0]
			])
			->count();
		$this->headGenerator();
	}


	public function title(): string
	{
		return 'Все ответы';
	}


	public function query()
	{

		$request = $this->filters;
		$project_id = $this->project_id;


		$projectRequests = ProjectRequest::with(['user','answers.question.parent_question'])
			->where([
				['project_id',$this->project_id],
			]);

		$filters = Question::with(['questionnaire','options'])
			->whereHas('questionnaire', function ($questionnaire) use ($project_id){
				$questionnaire->where([
					['project_id',$project_id],
					['type_id',2]
				]);
			})->whereNotIn('type_id',[7,9])
			->get();
		if($request->has('sex')){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('sex', $request->sex);
			});
		}

		if(isset($request->old_min)){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('birsday','>=', $request->old_min);
			});
		}
		if(isset($request->old_max)){
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($request){
				$user->where('birsday','<=', $request->old_max);
			});
		}

		if(isset($request->city))
		{
			$cities = explode(',', $request->city);
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($cities){
				$user->whereIn('city', $cities);
			});
		}
		if(isset($request->region))
		{
			$regions = explode(',', $request->region);
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($regions){
				$user->whereIn('region', $regions);
			});
		}

		if($request->has('user_status')){
			$filterItem = [];
			foreach ( $request->input('user_status') as $key => $item){
				$filterItem[] = (int)$request->input('user_status')[$key];
			}
			$projectRequests = $projectRequests->whereHas('user', function ($user) use ($filterItem){
				$user->whereIn('status_id', $filterItem);
			});
		}
		if($request->has('status')){
			$filterItem = [];
			foreach ( $request->input('status') as $key => $item){
				$filterItem[] = (int)$request->input('status')[$key];
			}
			$projectRequests = $projectRequests->whereIn('status_id',$filterItem);
		}
		foreach ($filters as $filter){
			if($request->has('option_'.$filter->id)){
				$filterItem = [];
				foreach ( $request->input('option_'.$filter->id) as $key => $item){
					$filterItem[] = (int)$request->input('option_'.$filter->id)[$key];
				}
				$projectRequests = $projectRequests->whereHas('answers', function ($answer) use ($filterItem){
					$answer->whereIn('question_id', $filterItem);
				});
			}
		}
		$projectRequests = $projectRequests->orderBy('id','desc');

		return $projectRequests;
	}
	public function map($request): array
	{
		$row = [];
		$row[] = $request->id;
		$row[] = $request->status->name;
		$row[] = isset($request->shipping)?$request->shipping->ttn:'';

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

		for ($i = 26; $i < $this->question_count+26; $i++){
			$row[$i] = "";
		}
		foreach ($request->answers as $answer){
			if($answer->question){
				if($answer->question->questionnaire_id == $this->questionnaire_id){
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
		$this->heads[] = 'Статус заявки';
		$this->heads[] = 'Номер ТТН';
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
		for($i = 0; $i < 13; $i++){
			$this->question_id[] = 0;
		}
		$this->question_count = 0;
		foreach($this->questions as $question){
			if(($question->type_id != 7 && $question->type_id != 9)){
				$this->heads[] = $question->name;
				$this->question_id[] = $question->id;
				$this->question_count ++;
			}
		}
	}
}
