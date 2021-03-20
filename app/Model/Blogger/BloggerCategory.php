<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerCategory extends Model
{
	protected $fillable = [
		'name',
	];

	public function bloggers(){
		return $this->hasMany('App\Model\Blogger\BloggerUserCategory', 'category_id');
	}
}
