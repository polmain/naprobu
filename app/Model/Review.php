<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $casts = [
		'images' => 'array',
	];

	public function user()
	{
		return $this->hasOne('App\User','id','user_id')->withTrashed();
	}

	public function subpage()
	{
		return $this->hasOne('App\Model\Project\Subpage','id','subpage_id');
	}

	public function status()
	{
		return $this->hasOne('App\Model\Review\StatusReview','id','status_id');
	}

	public function comments()
	{
		return $this->hasMany('App\Model\Review\Comment','review_id');
	}

	public function likes()
	{
		return $this->hasMany('App\Model\Review\ReviewLike','review_id');
	}

	public function bookmarks()
	{
		return $this->hasMany('App\Model\Review\ReviewBookmark','review_id');
	}

	public function visibleComments()
	{
		return $this->hasMany('App\Model\Review\Comment','review_id')->where([
			['isHide',0],
			['status_id',2],
		])->orWhere([
			['isHide',0],
			['status_id',1],
		])->orderBy('id');
	}

	public function translate(){
		return $this->hasOne('App\Model\Review', 'rus_lang_id');
	}
}
