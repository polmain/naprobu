<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 20.06.2019
 * Time: 14:23
 */

namespace App\Library\Cron;


use App\Entity\PhoneStatusEnum;
use App\Library\Queries\UserFilterServices;
use App\Model\User\PhoneVerify;
use App\Model\User\UserRatingHistory;
use App\Model\User\UserRatingStatus;
use App\Model\User\Viber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Mail\User\NewPassword;
use App\User;
use App\Model\User\UserChangeStatuses;
use App\Model\Project;
use Carbon;
use App\Library\Users\Notification;
use App\Mail\UserNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Model\Queue;
use Throwable;
use Illuminate\Http\Request;

class Cron
{
	public static function userStatus(){
		$userChangeStatuses = UserChangeStatuses::with(['user'])
			->where([
				['unlock_time',	'<=', Carbon::now()],
				['isEnd',	0],
			])->get();
		foreach ($userChangeStatuses as $userChangeStatus){
			$userChangeStatus->user->status_id	=	$userChangeStatus->next_status_id;
			$userChangeStatus->user->save();
			$userChangeStatus->isEnd = 1;
			$userChangeStatus->save();
		}
	}

	public static function projectStatus(){
		$projects = Project::where([
			['lang','ru'],
			['status_id','<>',3],
			['status_id','<>',1],
			['isHide',0],
		])->get();

        $now = Carbon::now();
		foreach ($projects as $project){
		    $start_registration_time = new Carbon($project->start_registration_time);
		    $end_registration_time = new Carbon($project->end_registration_time);
		    $start_test_time = new Carbon($project->start_test_time);
		    $start_report_time = new Carbon($project->start_report_time);
		    $end_project_time = new Carbon($project->end_project_time);


			if($start_registration_time <= $now && $end_registration_time >= $now && $project->status_id != 2){
				$project->status_id = 2;
				if($project->type != 'only-blogger' && $project->id != 263 && $project->audience->isUkraine()){
					$project->save();
					$queue = new Queue();
					$queue->project_id = $project->id;
					$queue->save();
					continue;
				}

			} elseif ($end_registration_time <=  $now && $start_test_time >= $now && $project->status_id != 7){
				$project->status_id = 7;
			} elseif ($start_test_time <=  $now && $start_report_time >= $now && $project->status_id != 6){
				$project->status_id = 6;

			} elseif ($start_report_time <=  $now && $end_project_time >= $now && $project->status_id != 5){
          $project->status_id = 5;
          $project->save();

          $projectRequests = $project->requests;

          $firstProjectRequest = $projectRequests->firstWhere('status_id', '>=', 7);

          if($firstProjectRequest){
              $queue = new Queue();
              $queue->project_id = $project->id;
              $queue->name = "project_report";
              $queue->start = $firstProjectRequest->id;
              $queue->save();
          }
			} elseif ($end_project_time <= $now && $project->status_id != 1){
				$project->status_id = 1;
			}

			$project->save();
		}
	}

	public static function queues(){
		$queue = Queue::first();
		if($queue){
			switch ($queue->name){
				case 'project':
					static::queueNewProject($queue);
					break;
				case 'project_membership':
					static::queueProjectMembership($queue);
					break;
				case 'project_contest':
					static::queueProjectContest($queue);
					break;
                case 'project_report':
                    static::queueProjectReport($queue);
                    break;
				/*case 'new_pass':
					static::queueNewPass($queue);
					break;*/
				case 'new_score':
					static::userRating($queue);
                    break;
				case 'new_account_form':
					static::newAccountForm($queue);
                    break;
				case 'viber':
					static::viber($queue);
                    break;
				case 'to_archive':
					static::toArchive($queue);
                    break;
				case 'phone_duplicate':
					static::phoneDuplicate($queue);
                    break;
				case 'user_custom_notification':
					static::customNotification($queue);
                    break;
			}


		}
	}

	public static function userRating($queue){
		$users = User::with(['history'])->where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 500],]
		)->orderBy('id','desc')->get();
		$ratingStatuses = UserRatingStatus::where([
			['rus_lang_id',0],
		])->get();

		foreach ($users as $user){
			$score = $user->history->sum('score');
			if($score < 0){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	51,
					'score'	=>	-$score,
				]);
				$score = 0;
			}

			$ratingStatus = $ratingStatuses->where('min','<=',$score)->where('max','>=',$score)->first();
			$user->current_rating = $score;
			$user->rang_id = $ratingStatus->id;
			$user->save();
		}
		if($queue->start + 500 > User::orderBy('id','desc')->first()->id){
			$queue->delete();
		}else{
			$queue->start += 500;
			$queue->save();
		}
	}

	public static function queueNewProject($queue){

		$project = Project::find($queue->project_id);

		$users = User::where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 1000],
			['status_id','<>',5],
		])->get();

		$lastUser = User::where([
            ['status_id','<>',5],
        ])->orderBy('id','DESC')->first();
		if($lastUser && $queue->start + 1000 > $lastUser->id){
			$queue->delete();
		}else{
			$queue->start += 1000;
			$queue->save();
		}
        $end_registration_time = Carbon::parse($project->end_registration_time)->format('H:i d.m.Y');
		foreach ($users as $user)
		{
            $link = "ru/projects/" . $project->url . '/';
            $projectName = $project->name;
            if ($user->lang !== "ru")
            {
                $projectTranslate = $project->translate->firstWhere('lang', $user->lang);
                if($projectTranslate){
                    $link = ($user->lang === "ua"?'':'/'.$user->lang)."projects/" . $projectTranslate->url . '/';
                    $projectName = $projectTranslate->name;
                }
            }
            Notification::send('project_start_register', $user, 1, $link, ['project' => $projectName]);

            $data['email'] = $user->email;
            $validator = Validator::make($data, [
                'email' => 'required|email',
            ]);

            if ($user->isNewsletter && $validator && (strripos($user->email,'@') !== false))
            {
                try {
                    Mail::to($user)->send(new UserNotificationMail($user, 'project_start_register', url('/') . $link, ['project' => $projectName, 'end_registration_time' => $end_registration_time]));
                }catch (Throwable $exception)
                {
                    Log::warning($exception->getMessage());
                }
            }
		}
        Log::warning('end action');
	}

	public static function queueProjectMembership($queue){

		$subpage = Project\Subpage::find($queue->project_id);
		$project = $subpage->project;

		$lastId = Project\ProjectRequest::where([
				['project_id', $subpage->project_id]
			])
			->orderBy('id','desc')
			->first();

		$projectRequests = Project\ProjectRequest::where([
				['id','>',$queue->start],
				['id','<=',$queue->start + 150],
				['project_id', $subpage->project_id]
			])
			->get();

		if($queue->start + 150 > $lastId->id){
			$queue->delete();
		}else{
			$queue->start += 150;
			$queue->save();
		}

		foreach ($projectRequests as $projectRequest)
		{
			$link = "/ru/projects/".$project->url."/".$subpage->url.'/';
			$projectName = $project->name;
			if ($projectRequest->user->lang !== "ru")
			{
                $projectTranslate = $project->translate->firstWhere('lang', $projectRequest->user->lang);
                $subpageTranslate = $subpage->translate->firstWhere('lang', $projectRequest->user->lang);
                if($projectTranslate && $subpageTranslate){
                    $link = ($projectRequest->user->lang === "ua"?'':'/'.$projectRequest->user->lang)."/projects/".$projectTranslate->url."/".$subpageTranslate->url.'/';
                    $projectName = $projectTranslate->name;
                }
			}

            Notification::send('project_members', $projectRequest->user, 1, $link, ['project' => $projectName]);

            if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter)
            {
                try {
                    Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 'project_members', url('/') . $link, ['project' => $projectName]));
                }catch (Throwable $exception)
                {

                }
            }
		}


	}

	public static function queueProjectContest($queue){

		$subpage = Project\Subpage::find($queue->project_id);
		$project = $subpage->project;

		$lastId = Project\ProjectRequest::where([
				['project_id', $subpage->project_id]
			])
			->orderBy('id','desc')
			->first();

		$projectRequests = Project\ProjectRequest::where([
				['id','>',$queue->start],
				['id','<=',$queue->start + 150],
				['project_id', $subpage->project_id]
			])
			->get();

		if($queue->start + 150 > $lastId->id){
			$queue->delete();
		}else{
			$queue->start += 150;
			$queue->save();
		}

		foreach ($projectRequests as $projectRequest)
		{
			$link = "/ru/projects/".$project->url."/".$subpage->url.'/';
			$projectName = $project->name;
			$contest = $subpage->name;
			if ($projectRequest->user->lang !== "ru")
			{
                $projectTranslate = $project->translate->firstWhere('lang', $projectRequest->user->lang);
                $subpageTranslate = $subpage->translate->firstWhere('lang', $projectRequest->user->lang);
                if($projectTranslate && $subpageTranslate){
                    $link = ($projectRequest->user->lang === "ua"?'':'/'.$projectRequest->user->lang)."/projects/".$projectTranslate->url."/".$subpageTranslate->url.'/';
                    $projectName = $projectTranslate->name;
                    $contest = $subpageTranslate->name;
                }
			}
            Notification::send('project_contest', $projectRequest->user, 0, $link, ['project' => $projectName]);

            if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter)
			{
                try{
                    Mail::to($projectRequest->user)->send(new UserNotificationMail($projectRequest->user, 'project_contest', url('/') . $link, ['contest' => $contest, 'project' => $projectName]));
                }catch (Throwable $exception)
                {
                }
			}
		}

	}

    public static function queueProjectReport($queue){

        $project = Project::find($queue->project_id);

        $lastId = Project\ProjectRequest::where([
            ['project_id', $project->id],
            ['status_id', '>=', 7],
        ])
            ->orderBy('id','desc')
            ->first();

        $projectRequests = Project\ProjectRequest::where([
            ['id','>',$queue->start],
            ['id','<=',$queue->start + 150],
            ['status_id', '>=', 7],
            ['project_id', $project->id]
        ])
            ->get();

        if($queue->start + 150 > $lastId->id){
            $queue->delete();
        }else{
            $queue->start += 150;
            $queue->save();
        }

        $questionnaire = $project->questionnaires->where('type_id',3)->first();

        foreach ($projectRequests as $projectRequest)
        {
            $link = "/ru/projects/questionnaire/".$questionnaire->id.'/';
            $projectName = $project->name;
            if ($projectRequest->user->lang !== "ru")
            {
                $projectTranslate = $project->translate->firstWhere('lang', $projectRequest->user->lang);
                if($projectTranslate){
                    $link = ($projectRequest->user->lang === "ua"?'':'/'.$projectRequest->user->lang)."/projects/questionnaire/".$questionnaire->id.'/';
                    $projectName = $projectTranslate->name;
                }

            }
            if(isset($projectRequest->user->email) && $projectRequest->user->isNewsletter){
                try{
                    Mail::to($projectRequest->user)
                        ->send(
                            new UserNotificationMail(
                                $projectRequest->user,
                                'questionnaire_report',
                                url('/').$link,
                                ['project' => $projectName]
                            )
                        );
                }catch (Throwable $exception)
                {
                }
            }
            Notification::send('questionnaire_report', $projectRequest->user, 1, $link, ['project' => $projectName]);

        }

    }

	public static function queueNewPass($queue){
		/*$users = User::where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 150],
			['email','<>',null],
			['isHide',0],
		])->whereNotIn('id',[1,2,7,8,9,11,12,13,14,15,16,17,18,43718,45645])->get();
		if($queue->start + 150 > User::count()){
			$queue->delete();
		}else{
			$queue->start += 150;
			$queue->save();
		}
		foreach ($users as $user){
			$data['email'] = $user->email;
			$validator = Validator::make($data, [
				'email' => 'required|email',
			]);
			if($validator && (strripos($user->email,'@') !== false)){
				$password = str_random(8);
				$user->password = Hash::make($password);
				$user->save();
				Mail::to($user)->send(new NewPassword($user,$password));
			}
		}*/
	}

	public static function newAccountForm($queue){
		$users = User::where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 150],
			['email','<>',null],
			['isHide',0],
		])->whereNotIn('id',[1,2,7,8,9,11,12,13,14,15,16,17,18,43718,45645, 45765, 45766, 46648, 47336, 47355, 47356, 48566, 66942, 106249, 139119])->get();


        $lastUser = User::where([
            ['email','<>',null],
            ['isHide',0],
        ])->orderBy('id','DESC')->first();
		if($lastUser && $queue->start + 150 > $lastUser->id){
			$queue->delete();
		}else{
			$queue->start += 150;
			$queue->save();
		}
        $link = "cabinet/";
		foreach ($users as $user){
            if ($user->lang !== "ua"){
                $link = $user->lang.'/'.$link;
            }
            if($user->email){
                try {
                    Mail::to($user)->send(new UserNotificationMail($user, 'new_form', url('/').$link));
                }catch (Throwable $exception)
                {
                }
            }
            Notification::send('new_form', $user, 0, $link);
		}
	}

	public static function viber($queue){
		$users = User::where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 1000],
			['email','<>',null],
			['new_form_status',false],
			['isHide',0],
		])->whereNotIn('id',[1,2,7,8,9,11,12,13,14,15,16,17,18,43718,45645, 45765, 45766, 46648, 47336, 47355, 47356, 48566, 66942, 106249, 139119])->get();

		$lastUser = User::where([
            ['email','<>',null],
            ['new_form_status',false],
            ['isHide',0],
        ])->orderBy('id','DESC')->first();
		if($lastUser && $queue->start + 1000 > $lastUser->id){
			$queue->delete();
		}else{
			$queue->start += 1000;
			$queue->save();
		}

		foreach ($users as $user){
		    if($user->phone){
                Viber::create([
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'first_name'  => $user->first_name,
                    'last_name' => $user->last_name,
                    'nickname' => $user->name,
                    'email' => $user->email,
                    'lang' => $user->lang
                ]);
            }else{
		        $user->delete();
            }
		}
	}

	public static function toArchive($queue)
    {
        $users = User::where([
            ['id','>',$queue->start],
            ['id','<=',$queue->start + 1000],
            ['email','<>',null],
            ['new_form_status',false],
            ['isHide',0],
        ])->whereNotIn('id',[1,2,7,8,9,11,12,13,14,15,16,17,18,43718,45645, 45765, 45766, 46648, 47336, 47355, 47356, 48566, 66942, 106249, 139119])->get();

        $lastUser = User::where([
            ['email','<>',null],
            ['new_form_status',false],
            ['isHide',0],
        ])->orderBy('id','DESC')->first();
        if($lastUser && $queue->start + 1000 > $lastUser->id){
            $queue->delete();
        }else{
            $queue->start += 1000;
            $queue->save();
        }

        foreach ($users as $user){
            $user->delete();
        }
    }

	public static function phoneDuplicate($queue){
		$users = User::where([
			['id','>',$queue->start],
			['id','<=',$queue->start + 150],
			['phone','<>',null],
		])->get();

        $lastUser = User::where([
            ['phone','<>',null],
        ])->orderBy('id','DESC')->first();
		if($lastUser && $queue->start + 150 > $lastUser->id){
			$queue->delete();
		}else{
			$queue->start += 150;
			$queue->save();
		}

		foreach ($users as $user){
		    $duplicatePhoneUsers = User::where([
		        ['phone',$user->phone],
		        ['phone','<>',''],
		        ['phone','<>',null],
            ])->orderBy('created_at','DESC')->get();

		    if($duplicatePhoneUsers->count() > 1){
                $cloneUsers = $duplicatePhoneUsers->where('first_name', $user->first_name)->where('last_name', $user->last_name);
                if($cloneUsers->count() === $duplicatePhoneUsers->count()){
                    if($user->id !== $duplicatePhoneUsers->first()->id){
                        $user->delete();
                    }
                }else{
                    PhoneVerify::firstOrCreate([
                        'phone' => $user->phone,
                        'duplicates' => $duplicatePhoneUsers->count(),
                        'status' => PhoneStatusEnum::NOT_VERIFIED,
                        'is_new_user' => 0
                    ]);
                }
            }
		}
	}

	public static function customNotification($queue)
    {
        $data = unserialize($queue->data);
        $message = $data['text'];
        $request = new Request($data['request']);

        $users = UserFilterServices::getFilteredUsersQuery($request);
        $users = $users->where([
                ['id','>',$queue->start],
                ['id','<=',$queue->start + 10000]
            ])
            ->orderBy('id')
            ->get();

        $lastUser = UserFilterServices::getFilteredUsersQuery($request)->orderBy('id','DESC')->first();
        if($queue->start + 10000 > $lastUser->id){
            $queue->delete();
        }else{
            $queue->start += 10000;
            $queue->save();
        }

        foreach ($users as $user){
            $notificationText = str_replace(':user_name:',$user->first_name,$message);
            Notification::send('custom',$user, 0, null, [], $notificationText);
        }

    }

	private static $instance;
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}
