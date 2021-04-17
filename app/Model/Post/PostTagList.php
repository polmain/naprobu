<?php

namespace App\Model\Post;

use Illuminate\Database\Eloquent\Model;

class PostTagList extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Post\PostTagList', 'rus_lang_id');
	}
	public function base(){
		return $this->hasOne('App\Model\Post\PostTagList', 'id','rus_lang_id');
	}
	public function posts(){
		return $this->hasMany('App\Model\Post\PostTag','tag_id');
	}
}
