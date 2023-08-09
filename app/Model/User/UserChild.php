<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserChild extends Model
{
	protected $fillable = [
		'user_id', 'birthday'
	];

	public function user()
	{
		return $this->hasOne('App\User','id', 'user_id')->withTrashed();
	}
}
