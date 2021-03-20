<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserRegion extends Model
{
	protected $fillable = [
		'name_ru', 'name_ua', 'geohelper', 'iso', 'country_id'
	];
}
