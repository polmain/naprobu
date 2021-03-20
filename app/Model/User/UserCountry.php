<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserCountry extends Model
{
	protected $fillable = [
		'name_ru', 'name_ua', 'geohelper', 'iso'
	];
}
