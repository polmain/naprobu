<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = ['name'];

    public function projects(){
		return $this->hasMany('App\Model\Project', 'category_id');
	}

	public function base(){
		return $this->hasOne('App\Model\Project\ProjectCategory', 'id','rus_lang_id');
	}

	public function translate(){
		return $this->hasOne('App\Model\Project\ProjectCategory', 'rus_lang_id');
	}
}
