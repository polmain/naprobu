<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
	public function user()
	{
		return $this->hasOne('App\User','id','user_id')->withTrashed();
	}
	public function project()
	{
		return $this->hasOne('App\Model\Project','id','project_id');
	}
	public function status()
	{
		return $this->hasOne('App\Model\Project\ProjectRequestStatus','id','status_id');
	}
	public function answers()
	{
		return $this->hasMany('App\Model\Questionnaire\Answer','project_request_id');
	}
	public function shipping()
	{
		return $this->hasOne('App\Model\User\UserShipping','request_id', 'id');
	}
}
