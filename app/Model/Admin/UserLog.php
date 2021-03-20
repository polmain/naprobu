<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
	protected $table = 'user_logs';
	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
}
