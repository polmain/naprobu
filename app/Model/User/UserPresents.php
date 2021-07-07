<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserPresents extends Model
{
	protected $fillable = [
		'user_id', 'rang_id'
	];

	public function user()
	{
		return $this->hasOne('App\User','id', 'user_id')->withTrashed();
	}
	public function rang()
	{
		return $this->hasOne('App\Model\User\UserRatingStatus','id', 'rang_id');
	}
}
