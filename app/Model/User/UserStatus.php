<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
	public function translate(){
		return $this->hasOne('App\Model\User\UserStatus', 'rus_lang_id', 'id');
	}
}
