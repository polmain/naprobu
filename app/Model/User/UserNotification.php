<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
	public function type(){
		return $this->hasOne('App\Model\User\UserNotificationType','id', 'type_id');
	}
}
