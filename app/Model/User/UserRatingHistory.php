<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserRatingHistory extends Model
{
	protected $fillable = [
		'user_id', 'action_id', 'score'
	];

	/**
	 * @return array
	 */
	public function rating_action()
	{
		return $this->hasOne('App\Model\User\UserRatingAction','id', 'action_id');
	}
}
