<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectLink extends Model
{
	public function project(){
		return $this->hasOne('App\Model\Project', 'id', 'project_id');
	}
	public function translate(){
		return $this->hasOne('App\Model\Project\ProjectLink', 'rus_lang_id');
	}
}
