<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerUserCategory extends Model
{
	protected $fillable = [
		'blogger_id','category_id',
	];
}
