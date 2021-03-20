<?php

namespace App\Model\Review;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
	public function review()
	{
		return $this->hasOne('App\Model\Review','id','review_id');
	}
}
