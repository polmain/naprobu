<?php

namespace App\Library\Queries;

use App\User;
use Carbon\Carbon;

class UserFilterServices
{
    public static function getFilteredUsersQuery($request)
    {
        $filters = $request;

        $cities = [];
        $projects = [];
        $projectExpert = [];
        $questions = [];
        $educationArray = [];
        $employmentArray = [];
        $workArray = [];
        $familyStatusArray = [];
        $hasChildArray = [];
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

        if($filters->has('filter.has_child')){
            foreach ( $filters->filter['has_child'] as $key => $item){
                $hasChildArray[] = $filters->input('filter.has_child')[$key];
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
            'roles',
            'status'
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
            ->when( !empty($filters->filter['is_good_photo']), function ($query) use ($filters){
                $query->where('is_good_photo',$filters->filter['is_good_photo']);
            })
            ->when( !empty($filters->filter['is_good_video']), function ($query) use ($filters){
                $query->where('is_good_video',$filters->filter['is_good_video']);
            })
            ->when( !empty($filters->filter['is_good_review']), function ($query) use ($filters){
                $query->where('is_good_review',$filters->filter['is_good_review']);
            })
            ->when( !empty($filters->filter['status']), function ($query) use ($filters){
                $query->where('status_id',$filters->filter['status']);
            })->when( !empty($filters->filter['old_min']), function ($query) use ($filters){
                $query->where('birsday','<=',Carbon::now()->year - $filters->filter['old_min']);
            })->when( !empty($filters->filter['old_max']), function ($query) use ($filters){
                $query->where('birsday','>=',Carbon::now()->year - $filters->filter['old_max']);
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
            })->when( $filters->has('filter.has_child'), function ($query) use ($hasChildArray){
                $query->whereIn('has_child', $hasChildArray);
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
}
