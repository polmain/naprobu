<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserChangeStatuses extends Model
{
	public function user()
	{
		return $this->hasOne('App\User','id','user_id')->withTrashed();
	}
	public function status()
	{
		return $this->hasOne('App\Model\User\UserStatus','id','status_id');
	}
	public function next_status()
	{
		return $this->hasOne('App\Model\User\UserStatus','id','next_status_id');
	}
}
