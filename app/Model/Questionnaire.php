<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

	public function base(){
		return $this->hasOne('App\Model\Questionnaire', 'id','rus_lang_id');
	}
	public function translate(){
		return $this->hasMany('App\Model\Questionnaire', 'rus_lang_id');
	}
	public function type()
	{
		return $this->hasOne('App\Model\Questionnaire\QuestionnaireType','id','type_id');
	}
	public function project()
	{
		return $this->hasOne('App\Model\Project','id','project_id');
	}
	public function questions()
	{
		return $this->hasMany('App\Model\Questionnaire\Question','questionnaire_id');
	}

}
