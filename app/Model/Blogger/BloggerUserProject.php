<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerUserProject extends Model
{
	public function blogger(){
		return $this->hasOne('App\Model\Blogger\BloggerUser','id', 'blogger_id');
	}
	public function project(){
		return $this->hasOne('App\Model\Project','id', 'project_id');
	}
}
