<?php

namespace App\Model\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{

	use SoftDeletes;

	protected $casts = [
		'restrictions' => 'array',
	];
	public function type()
	{
		return $this->hasOne('App\Model\Questionnaire\FieldType','id','type_id');
	}
	public function answers(){
		return $this->hasMany('App\Model\Questionnaire\Answer', 'question_id');
	}

	public function questionnaire(){
		return $this->hasMany('App\Model\Questionnaire', 'id','questionnaire_id');
	}

	public function options(){
		return $this->hasMany('App\Model\Questionnaire\Question', 'parent')->where('lang','ru');
	}

	public function parent_question(){
		return $this->hasOne('App\Model\Questionnaire\Question', 'id','parent');
	}

	public function translate(){
		return $this->hasOne('App\Model\Questionnaire\Question', 'rus_lang_id');
	}
}
