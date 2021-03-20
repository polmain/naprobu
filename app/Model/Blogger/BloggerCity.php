<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerCity extends Model
{
	protected $fillable = [
		'name',
	];

	public function bloggers(){
		return $this->hasMany('App\Model\Blogger\BloggerUser', 'city_id');
	}
}
