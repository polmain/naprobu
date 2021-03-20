<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserCity extends Model
{
	protected $fillable = [
		'name_ru', 'name_ua', 'geohelper', 'region_id'
	];
}
