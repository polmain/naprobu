<?php

namespace App\Model\Blogger;

use Illuminate\Database\Eloquent\Model;

class BloggerUserSubject extends Model
{
	protected $fillable = [
		'subject_id','blogger_id',
	];
}
