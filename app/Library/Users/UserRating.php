<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 18.04.2019
 * Time: 16:00
 */

namespace App\Library\Users;

use App\User;
use App\Model\User\UserRatingHistory;
use App\Model\User\UserRatingAction;
use App\Model\User\UserRatingStatus;
use App\Model\User\UserPresents;
use DB;

class UserRating
{
	protected $statuses = [
		'register'	=> 1,
		'authorization'	=> 3,
		'social_network'	=> 5,
		'email'	=> 7,
		'friend'	=> 9,
		'project_request'	=> 11,
		'share_project'	=> 13,
		'share_review'	=> 15,
		'send_review'	=> 17,
		'comment'	=> 19,
		'video_review'	=> 21,
		'image_review'	=> 23,
		'contest'	=> 25,
		'send_report'	=> 27,
		'delete_review'	=> 29,
		'delete_comment'	=> 31,
		'delete_video'	=> 33,
		'delete_image'	=> 35,
		'delete_contest'	=> 37,
		'delete_5'	=> 39,
		'delete_10'	=> 41,
		'delete_20'	=> 43,
		'delete_50'	=> 45,
		'delete_100'	=> 47,
		'delete_500'	=> 49,
	];

	protected function addActionToUser($action, $user){
		DB::transaction(function () use ($action, $user){
			UserRatingHistory::create([
				'user_id' => $user->id,
				'action_id' => $action->id,
				'score' => $action->points,
			]);
			$score = $user->history->sum('score');
			if ($score < 0)
			{
				UserRatingHistory::create([
					'user_id' => $user->id,
					'action_id' => 51,
					'score' => -$score,
				]);
				$score = 0;
			}
			$user->current_rating = $score;
			$user->save();

			$projects_count = $user->requests->where('status_id', '>=', 7)->count();

			$ratingStatus = UserRatingStatus::where([
				['rus_lang_id', 0],
				['min', '<=', $user->current_rating],
				['max', '>=', $user->current_rating],
				['min_projects', '<=', $projects_count],
			])->first();

			if (empty($ratingStatus))
			{
				$ratingStatus = UserRatingStatus::where([
					['rus_lang_id', 0],
					['min', '<=', $user->current_rating],
					['min_projects', '<=', $projects_count],
				])->orderBy('min', 'desc')->first();
			}

			if ($ratingStatus->id != $user->rang_id)
			{
				$statusName = $user->lang == 'ru' ? $ratingStatus->name : $ratingStatus->translate->name;
				Notification::send('new_rang', $user, 0, null, ['rang' => $statusName]);
			}

			if ($ratingStatus->id >= 7)
			{
				UserPresents::updateOrCreate([
					'user_id' => $user->id,
					'rang_id' => $ratingStatus->id
				]);
			}
			elseif ($user->rang_id >= 7 && $ratingStatus->id < $user->rang_id)
			{
				UserPresents::where([
					['user_id', $user->id],
					['rang_id', $user->rang_id],
				])->delete();
			}

			$user->rang_id = $ratingStatus->id;
			$user->save();
		});
	}

	public static function addAction($action_name,$user){
		$instance = static::getInstance();
		$action_id = $instance->statuses[$action_name];
		$action = UserRatingAction::find($action_id);

		$instance->addActionToUser($action,$user);
	}

	public static function newAction($request,$user){
		$instance = static::getInstance();

		$action = UserRatingAction::where([
			['name',$request->name_ru],
			['points',$request->score],
			['lang','ru']
		])->first();

		if(empty($action)){
			$action = UserRatingAction::create([
				'name' => $request->name_ru,
				'points' => $request->score,
				'lang' => 'ru',
				'rus_lang_id' => 0
			]);

			UserRatingAction::create([
				'name' => $request->name_ua,
				'points' => $request->score,
				'lang' => 'ua',
				'rus_lang_id' => $action->id
			]);
		}

		$instance->addActionToUser($action,$user);
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
