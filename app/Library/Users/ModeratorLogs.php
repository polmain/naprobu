<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 15.01.2019
 * Time: 9:15
 */

namespace App\Library\Users;

use App\Model\Admin\UserLog;
use Request;
use Illuminate\Support\Facades\Auth;


class ModeratorLogs
{
	public static function addLog($action){
		$log = new UserLog();
		$log->user_id = Auth::user()->id;
		$log->action = $action;
		$log->url = Request::getHost() . "/" . Request::path();
		$log->save();
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