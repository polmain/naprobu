<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.01.2019
 * Time: 10:33
 */

namespace App\Library\Users;


use Carbon\Carbon;
use App\Model\Admin\ModeratorActiveTime;
use Carbon\CarbonInterval;

class ActiveUser
{
	public static function isOnline($lastTime){
		if($lastTime){
			$lastTimeCb = new Carbon($lastTime);
			if(Carbon::now()->subMinutes(5)->lte($lastTimeCb)){
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	public static function lastActive($lastTime){
		if($lastTime){
			$lastTimeCb = new Carbon($lastTime);
			$now = Carbon::now();
			if(Carbon::now()->subMinutes(60)->lte($lastTimeCb)){
				return $lastTimeCb->diffInMinutes($now, false)." минут назад";
			}elseif(Carbon::now()->subHours(24)->lte($lastTimeCb)){
				return $lastTimeCb->diffInHours($now, false)." часа назад";
			}else{
				return $lastTimeCb->format("d.m.Y H:i");
			}
		}
		return "в сети ни разу.";
	}

	public static function getLastDayActive($user_id){
		$activeTimes = ModeratorActiveTime::where('user_id',$user_id)->orderBy('id','desc')->get();
		$workTime = 0;
		$lastTime = null;
		$today = Carbon::now()->startOfDay();
		foreach ($activeTimes as $activeTime){
			if(empty($lastTime)){
				$lastTime = new Carbon($activeTime->updated_at);
				$workTime = static::to_seconds($lastTime->diff($activeTime->created_at));
			}else{
				$currentTime = new Carbon($activeTime->updated_at);

				if($today->lte($currentTime)){
					$workTime +=  static::to_seconds($currentTime->diff($activeTime->created_at));
				}
			}
		}
		return CarbonInterval::create(0,0,0,0,0,0,$workTime)->cascade()->forHumans();
	}

	public static function getLastDaysActive($user_id,$days){
		$activeTimes = ModeratorActiveTime::where('user_id',$user_id)->orderBy('id','desc')->get();
		$workTime = 0;
		$lastTime = null;
		$today = Carbon::now()->startOfDay();
		foreach ($activeTimes as $activeTime){
			if(empty($lastTime)){
				$lastTime = new Carbon($activeTime->updated_at);
				$workTime = static::to_seconds($lastTime->diff($activeTime->created_at));
			}else{
				$currentTime = new Carbon($activeTime->updated_at);
				if(Carbon::now()->subDays($days)->startOfDay()->lte($currentTime)){
					$workTime +=  static::to_seconds($currentTime->diff($activeTime->created_at));
				}else{
					break;
				}
			}
		}
		return CarbonInterval::create(0,0,0,0,0,0,$workTime)->cascade()->forHumans();
	}

	public static function avgDaysActive($user_id,$days){
		$activeTimes = ModeratorActiveTime::where('user_id',$user_id)->orderBy('id','desc')->get();
		$workTime = 0;
		$currentDay = null;
		$i=1;
		foreach ($activeTimes as $activeTime){
			if(empty($currentDay)){
				$currentDay = (new Carbon($activeTime->updated_at))->subDay(1);
			}
			$currentTime = new Carbon($activeTime->updated_at);
			if(Carbon::now()->subDays($days)->lte($currentTime)){
				if($currentTime->lte($currentDay)){
					$i++;
					$currentDay = (new Carbon($currentTime))->subDay(1);
				}
				$workTime +=  static::to_seconds($currentTime->diff($activeTime->created_at));
			}
		}
		$workTime = (int)($workTime/$i);
		return CarbonInterval::create(0,0,0,0,0,0,$workTime)->cascade()->forHumans();
	}

	protected static function to_seconds($interval)
	{
		return ($interval->y * 365 * 24 * 60 * 60) +
			($interval->m * 30 * 24 * 60 * 60) +
			($interval->d * 24 * 60 * 60) +
			($interval->h * 60 * 60) +
			($interval->i * 60) +
			$interval->s;
	}
}