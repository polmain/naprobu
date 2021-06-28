<?php

namespace App\Exports;


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
		$filters = $this->filters;

		$cities = [];
		$projects = [];
		$projectExpert = [];
		$questions = [];
        $educationArray = [];
        $employmentArray = [];
        $workArray = [];
        $familyStatusArray = [];
        $materialConditionArray = [];
        $hobbiesArray = [];

		if($filters->has('filter.city'))
		{
            foreach ( $filters->filter['city'] as $key => $item){
                $cities[] = $filters->input('filter.city')[$key];
            }
		}

		if($filters->has('filter.education')){
			foreach ( $filters->filter['education'] as $key => $item){
                $educationArray[] = $filters->input('filter.education')[$key];
			}
		}

		if($filters->has('filter.employment')){
			foreach ( $filters->filter['employment'] as $key => $item){
                $employmentArray[] = $filters->input('filter.employment')[$key];
			}
		}

		if($filters->has('filter.work')){
			foreach ( $filters->filter['work'] as $key => $item){
                $workArray[] = $filters->input('filter.work')[$key];
			}
		}

		if($filters->has('filter.family_status')){
			foreach ( $filters->filter['family_status'] as $key => $item){
                $familyStatusArray[] = $filters->input('filter.family_status')[$key];
			}
		}

		if($filters->has('filter.material_condition')){
			foreach ( $filters->filter['material_condition'] as $key => $item){
                $materialConditionArray[] = $filters->input('filter.material_condition')[$key];
			}
		}

		if($filters->has('filter.hobbies')){
			foreach ( $filters->filter['hobbies'] as $key => $item){
                $hobbiesArray[] = $filters->input('filter.hobbies')[$key];
			}
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
			->when( !empty($filters->filter['id_min']), function ($query) use ($filters){
				$query->where('id','>=',$filters->filter['id_min']);
			})
			->when( !empty($filters->filter['id_max']), function ($query) use ($filters){
				$query->where('id','<=',$filters->filter['id_max']);
			})
			->when( !empty($filters->filter['sex']), function ($query) use ($filters){
				$query->where('sex',$filters->filter['sex']);
			})
			->when( !empty($filters->filter['status']), function ($query) use ($filters){
				$query->where('status_id',$filters->filter['status']);
			})->when( !empty($filters->filter['old_min']), function ($query) use ($filters){
				$query->where('birsday','>=',Carbon::now()->year - $filters->filter['old_min']);
			})->when( !empty($filters->filter['old_max']), function ($query) use ($filters){
				$query->where('birsday','<=',Carbon::now()->year - $filters->filter['old_max']);
			})->when( !empty($filters->filter['city']), function ($query) use ($cities){
				$query->whereIn('city_id',    $cities );
			})->when( !empty($filters->filter['region']), function ($query) use ($filters){
                $query->where('region_id',  $filters->filter['region'] );
			})->when( !empty($filters->filter['country']), function ($query) use ($filters){
                $query->where('country_id',  $filters->filter['country'] );
			})->when( !empty($filters->filter['role']), function ($query) use ($filters){
				$query->whereHas('roles', function($q) use ($filters){
					$q->where('name', $filters->filter['role']);
				});
			})->when( $filters->has('filter.education'), function ($query) use ($educationArray){
				$query->whereIn('education', $educationArray);
			})->when( $filters->has('filter.employment'), function ($query) use ($employmentArray){
				$query->whereIn('employment', $employmentArray);
			})->when( $filters->has('filter.work'), function ($query) use ($workArray){
				$query->whereIn('work', $workArray);
			})->when( $filters->has('filter.family_status'), function ($query) use ($familyStatusArray){
				$query->whereIn('family_status', $familyStatusArray);
			})->when( $filters->has('filter.material_condition'), function ($query) use ($materialConditionArray){
				$query->whereIn('material_condition', $materialConditionArray);
			})->when( $filters->has('filter.hobbies'), function ($query) use ($hobbiesArray){
				$query->where(function ($q) use ($hobbiesArray){
				    $i = 0;
				    foreach ($hobbiesArray as $hobby){
				        if($i === 0){
                            $q->where('hobbies', 'LIKE', '%'.$hobby.'%');
                            $i++;
                        }else{
                            $q->orWhere('hobbies', 'LIKE', '%'.$hobby.'%');
                        }
                    }
                });
			})->when( !empty($filters->filter['rang']), function ($query) use ($filters){
                $query->where('rang_id',  $filters->filter['rang'] );
            })->when( !empty($filters->filter['rating_min']), function ($query) use ($filters){
                $query->where('current_rating', '>=',  $filters->filter['rating_min'] );
            })->when( !empty($filters->filter['rating_max']), function ($query) use ($filters){
                $query->where('current_rating', '<=',  $filters->filter['rating_max'] );
            })->when( !empty($filters->filter['online_min']), function ($query) use ($filters){
                $query->where('last_active', '>=',  Carbon::parse($filters->filter['online_min']) );
            })->when( !empty($filters->filter['online_max']), function ($query) use ($filters){
                $query->where('last_active', '<=',  Carbon::parse($filters->filter['online_max']) );
            })->when( !empty($filters->filter['registration_min']), function ($query) use ($filters){
                $query->where('created_at', '>=',  Carbon::parse($filters->filter['registration_min']) );
            })->when( !empty($filters->filter['registration_max']), function ($query) use ($filters){
                $query->where('created_at', '<=',  Carbon::parse($filters->filter['registration_max']) );
            })->when( !empty($filters->filter['project_min']), function ($query) use ($filters){
                $query->whereHas('requests', function($q){
                    $q->where('status_id', '>=', 7);
                },'>=',$filters->filter['project_min']);
            })->when( !empty($filters->filter['project_max']), function ($query) use ($filters){
                $query->whereHas('requests', function($q){
                    $q->where('status_id', '>=', 7);
                },'<=',$filters->filter['project_max']);
            })->when( !empty($filters->filter['project_date_min']), function ($query) use ($filters){
                $query->whereHas('requests', function($q) use ($filters){
                    $q->where('status_id', '>=', 7)->where('created_at', '>=', Carbon::parse($filters->filter['project_date_min']));
                });
            })->when( !empty($filters->filter['project_date_max']), function ($query) use ($filters){
                $query->whereHas('requests', function($q) use ($filters){
                    $q->where('status_id', '>=', 7)->where('created_at', '<=', Carbon::parse($filters->filter['project_date_max']));
                });
            })->when( $filters->has('filter.project'), function ($query) use ($projects){
				$query->whereHas('requests', function($q) use ($projects){
					$q->whereIn('project_id', $projects);
				});
			})->when( $filters->has('filter.projectExpert'), function ($query) use ($projectExpert){
				$query->whereHas('requests', function($q) use ($projectExpert){
					$q->where('status_id', '>=', 7)->whereIn('project_id', $projectExpert);
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
