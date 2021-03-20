<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerSubject extends Model
{
	protected $fillable = [
		'name',
	];

	public function bloggers(){
		return $this->hasMany('App\Model\Blogger\BloggerUserSubject', 'subject_id');
	}
}
