<?php

namespace App\Model\Review;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public function user()
	{
		return $this->hasOne('App\User','id','user_id');
	}
	public function review()
	{
		return $this->hasOne('App\Model\Review','id','review_id');
	}
	public function status()
	{
		return $this->hasOne('App\Model\Review\StatusReview','id','status_id');
	}
}
