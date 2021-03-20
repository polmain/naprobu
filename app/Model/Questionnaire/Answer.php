<?php

namespace App\Model\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
	use SoftDeletes;

	public function request()
	{
		return $this->hasOne('App\Model\Project\ProjectRequest','id','project_request_id');
	}
	public function question()
	{
		return $this->hasOne('App\Model\Questionnaire\Question','id','question_id');
	}

}
