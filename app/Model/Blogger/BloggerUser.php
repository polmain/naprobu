<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerUser extends Model
{
	public function city(){
		return $this->hasOne('App\Model\Blogger\BloggerCity', 'id', 'city_id');
	}
	public function categories(){
		return $this->belongsToMany('App\Model\Blogger\BloggerCategory','blogger_user_categories', 'blogger_id', 'category_id');
	}

	public function subjects(){
		return $this->belongsToMany('App\Model\Blogger\BloggerSubject','blogger_user_subjects', 'blogger_id', 'subject_id');
	}

	public function projects(){
		return $this->belongsToMany('App\Model\Project','blogger_user_projects', 'blogger_id', 'project_id');
	}

	public function categoriesId(){
		return $this->hasMany('App\Model\Blogger\BloggerUserCategory','blogger_id');
	}

	public function subjectsId(){
		return $this->hasMany('App\Model\Blogger\BloggerUserSubject','blogger_id');
	}

	public function userProject(){
		return $this->hasMany('App\Model\Blogger\BloggerUserProject','blogger_id');
	}


}
