<?php

namespace App\Model\Post;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
	public function user()
	{
		return $this->hasOne('App\User','id','user_id')->withTrashed();
	}
	public function post()
	{
		return $this->hasOne('App\Model\Post','id','post_id');
	}
	public function status()
	{
		return $this->hasOne('App\Model\Review\StatusReview','id','status_id');
	}
}
