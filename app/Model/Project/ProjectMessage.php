<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectMessage extends Model
{
	protected $fillable = [
		'rus_lang_id','lang'
	];

	protected $casts = [
		'images' => 'array',
	];

	public function project(){
		return $this->hasOne('App\Model\Project', 'id', 'project_id');
	}
	public function translate(){
		return $this->hasOne('App\Model\Project\ProjectMessage', 'rus_lang_id');
	}
}
