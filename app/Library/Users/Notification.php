<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 18.04.2019
 * Time: 16:00
 */

namespace App\Library\Users;

use App\Model\User\UserNotification;
use App\Model\User\UserNotificationType;

class Notification
{
	/**
	 * @param string $action Тип оповещения
	 * @param \App\User $user Пользователь
	 * @param int $isImportant Важное = 1
	 * @param string $link Ссылка
	 * @param array $params Параметры сообщения
	 * @param string $text Текст для произвольного оповещения
	 */
	public static function send($action, $user, $isImportant = 0, $link = null, $params = [], $text = ""){

		$type = UserNotificationType::where([
			['name',$action],
			['lang',$user->lang],
		])->first();

		$notification = new UserNotification();
		if($type->name == 'custom'){
			$notification->text = $text;
		}else{
			$notificationText = $type->template;
			foreach ($params as $key => $param){
                $notificationText = str_replace(':'.$key.':',$param,$notificationText);
			}
			$notification->text = $notificationText;
		}

		$notification->link = $link;
		$notification->isImportant = $isImportant;
		$notification->type_id = $type->id;
		$notification->user_id = $user->id;

		$notification->save();
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
