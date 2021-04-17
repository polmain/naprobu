<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User\UserRatingAction;
use App\Model\User\UserRatingStatus;
use App\Model\User\UserRatingHistory;

use App\User;

use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class UserRatingController extends Controller
{
    private const TRANSLATE_LANG = ['ua', 'en'];

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
			$ratingAction->name = $request->rating_action_name[$key];
			$ratingAction->points = $request->rating_action_points[$key];
			$ratingAction->save();

            foreach (self::TRANSLATE_LANG as $lang){
                $translate = UserRatingAction::where([
                    'rus_lang_id' => $ratingAction->id,
                    'lang' => $lang,
                ])->first();
                $translate->name = $request->input('rating_action_name_'.$lang)[$key];
                $translate->points = $ratingAction->points;
                $translate->save();
            }
		}

		foreach ($request->rating_status as $key=>$value){
			$ratingStatus = UserRatingStatus::find($request->rating_status[$key]);
			$ratingStatus->name = $request->rating_status_name[$key];
			$ratingStatus->min = $request->rating_status_min[$key];
			$ratingStatus->max = $request->rating_status_max[$key];
			$ratingStatus->save();


            foreach (self::TRANSLATE_LANG as $lang){
                $translate = UserRatingStatus::where([
                    'rus_lang_id' => $ratingStatus->id,
                    'lang' => $lang,
                ])->first();
                $translate->name = $request->input('rating_status_name_'.$lang)[$key];
                $translate->min = $ratingStatus->min;
                $translate->max = $ratingStatus->max;
                $translate->save();
            }
		}


		ModeratorLogs::addLog("Отредактировал рейтинг пользователей");

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
}
