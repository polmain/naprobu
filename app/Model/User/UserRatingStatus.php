<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserRatingStatus extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\User\UserRatingStatus', 'rus_lang_id', 'id');
	}
}
