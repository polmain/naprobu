<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectBlock extends Model
{
	public function project(){
		return $this->hasOne('App\Model\Project', 'id', 'project_id');
	}

	public function base(){
		return $this->hasOne('App\Model\Project\ProjectBlock', 'id','rus_lang_id');
	}

	public function translate(){
		return $this->hasMany('App\Model\Project\ProjectBlock', 'rus_lang_id');
	}
}
