<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User\UserRatingAction;
use App\Model\User\UserRatingStatus;
use App\Model\User\UserRatingHistory;

use App\User;
use App\Model\Project\ProjectRequest;

use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class UserRatingController extends Controller
{
    public function settings(){
		$ratingActions = UserRatingAction::with(['translate'])
			->where([
				['rus_lang_id',0]
			])
			->get();
		$ratingStatuses = UserRatingStatus::with(['translate'])
			->where([
				['rus_lang_id',0]
			])
			->get();

		SEO::setTitle('Настройки рейтинга пользователей');
		AdminPageData::setPageName('Настройки рейтинга пользователей');
		AdminPageData::addBreadcrumbLevel('Настройки','settings');
		AdminPageData::addBreadcrumbLevel('Рейтинг пользователей');


		return view('admin.settings.user_rating',[
			'ratingActions'	=>	$ratingActions,
			'ratingStatuses'	=>	$ratingStatuses,
		]);
	}

	public function settings_save(Request $request){

		foreach ($request->rating_action as $key=>$value){
			$ratingAction = UserRatingAction::find($request->rating_action[$key]);
			$translate = UserRatingAction::where('rus_lang_id',$ratingAction->id)->first();
			$ratingAction->name = $request->rating_action_name[$key];
			$ratingAction->points = $request->rating_action_points[$key];
			$ratingAction->save();
			$translate->name = $request->rating_action_name_ua[$key];
			$translate->points = $ratingAction->points;
			$translate->save();
		}

		foreach ($request->rating_status as $key=>$value){
			$ratingStatus = UserRatingStatus::find($request->rating_status[$key]);
			$translate = UserRatingStatus::where('rus_lang_id',$ratingStatus->id)->first();
			$ratingStatus->name = $request->rating_status_name[$key];
			$ratingStatus->min = $request->rating_status_min[$key];
			$ratingStatus->max = $request->rating_status_max[$key];
			$ratingStatus->save();
			$translate->name = $request->rating_status_name_ua[$key];
			$translate->min = $ratingStatus->min;
			$translate->max = $ratingStatus->max;
			$translate->save();
		}


		ModeratorLogs::addLog("Отредактировал рейтинг пользователей");

		if($request->submit == "save-refresh"){
			$this->usersRatingRecalc();
		}
		return redirect()->route('adm_user_rating_settings');
	}

	public function ajax_history($user_id){
		$user = User::with(['history'])->find($user_id);
		$userRatings = UserRatingHistory::with(['rating_action'])->where('user_id',$user_id)->orderBy('id','desc');

		return datatables()->eloquent($userRatings)
			->addColumn('action', function (UserRatingHistory $userRating) {
				return $userRating->rating_action->name;
			})
			->addColumn('points', function (UserRatingHistory $userRating) use ($user) {
				/*if ($userRating->action_id == 51){
					$score = $user->history->where('created_at','<=', Carbon::parse('2020-06-04'))->sum('score');
					$userRating->score = -$score;
					$userRating->save();
				}*/

				return $userRating->rating_action->points;
			})

			->toJson();
	}

	public function generator(){
		$users = User::with(['requests','reviews.subpage','comments'])->where([
			['id','>',45643],
			['id','<=',50000],
		])->get();
		foreach ($users as $user){
			UserRatingHistory::where('user_id',$user->id)->delete();
			UserRatingHistory::create([
				'user_id'	=>	$user->id,
				'action_id'	=>	1,
			]);
			if(!empty($user->email)){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	7,
				]);
			}
			if(!empty($user->facebook_token)){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	5,
				]);
			}
			if(!empty($user->instagram_token)){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	5,
				]);
			}
			foreach ($user->requests as $request){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	11,
				]);
				if($request->status_id >= 9){
					UserRatingHistory::create([
						'user_id'	=>	$user->id,
						'action_id'	=>	27,
					]);
				}
			}
			foreach ($user->reviews as $review){
				if($review->subpage->type_id == 1){
					UserRatingHistory::create([
						'user_id'	=>	$user->id,
						'action_id'	=>	17,
					]);
					if($review->images){
						foreach($review->images as $image){
							UserRatingHistory::create([
								'user_id'	=>	$user->id,
								'action_id'	=>	23,
							]);
						}
					}
				}
			}

			foreach ($user->reviews->groupBy('subpage_id') as $reviews){
				foreach ($reviews as $review){
					if($review->subpage->type_id == 3){
						UserRatingHistory::create([
							'user_id'	=>	$user->id,
							'action_id'	=>	25,
						]);
					}
				}

			}

			foreach ($user->comments as $comment){
				UserRatingHistory::create([
					'user_id'	=>	$user->id,
					'action_id'	=>	19,
				]);
			}
			$this->userRatingRecalc($user);
		}
	}

	public function usersRatingRecalc(){
		$users = User::all();
		foreach ($users as $user){
			$this->userRatingRecalc($user);
		}
	}

	protected function userRatingRecalc($user){
		$rating = 0;
		$userRatings = UserRatingHistory::with(['rating_action'])->where('user_id',$user->id)->get();
		foreach ($userRatings as $userRating){
			$rating	+=	$userRating->rating_action->points;
		}
		$user->current_rating = $rating;
		$ratingStatus = UserRatingStatus::where([
			['rus_lang_id',0],
			['min','<=',$user->current_rating],
			['max','>=',$user->current_rating],
		])->first();


		$user->rang_id = $ratingStatus->id;
		$user->save();
	}

}
