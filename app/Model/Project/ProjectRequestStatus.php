<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectRequestStatus extends Model
{
	protected $fillable = ['name'];

	public function translate(){
		return $this->hasOne('App\Model\Project\ProjectRequestStatus', 'rus_lang_id');
	}
}
