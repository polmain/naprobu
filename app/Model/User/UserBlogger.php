<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserBlogger extends Model
{
	protected $fillable = [
		'user_id', 'status', 'subscriber_count', 'blog_subject', 'blog_platform', 'blog_url'
	];

	public function user()
	{
		return $this->hasOne('App\User','id', 'user_id')->withTrashed();
	}
}
