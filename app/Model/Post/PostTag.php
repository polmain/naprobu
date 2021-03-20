<?php

namespace App\Model\Post;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
	public function tag(){
		return $this->hasOne('App\Model\Post\PostTagList', 'id', 'tag_id');
	}
	public function post(){
		return $this->hasOne('App\Model\Post', 'id', 'post_id');
	}
}
