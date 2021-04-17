<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserRatingAction extends Model
{
	protected $fillable = [
		'name', 'points', 'lang', 'rus_lang_id',
	];

	public function translate(){
		return $this->hasMany('App\Model\User\UserRatingAction', 'rus_lang_id');
	}
}
