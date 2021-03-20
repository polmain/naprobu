<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class Subpage extends Model
{
	protected $fillable = ['name','project_id','type_id','url'];


	public function project(){
		return $this->hasOne('App\Model\Project', 'id', 'project_id');
	}

	public function type(){
		return $this->hasOne('App\Model\Project\SubpageType', 'id', 'type_id');;
	}

	public function translate(){
		return $this->hasOne('App\Model\Project\Subpage', 'rus_lang_id');
	}

	public function base(){
		return $this->hasOne('App\Model\Project\Subpage', 'id','rus_lang_id');
	}
	public function reviews(){
		return $this->hasMany('App\Model\Review', 'subpage_id');
	}
}
