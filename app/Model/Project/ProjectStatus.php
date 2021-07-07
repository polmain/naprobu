<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
	protected $fillable = ['name'];

    public function translate(){
        return $this->hasMany('App\Model\Project\ProjectStatus', 'rus_lang_id');
    }
}
