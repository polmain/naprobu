<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Viber extends Model
{
	protected $fillable = [
		'user_id', 'phone'
	];

	/**
	 * @return array
	 */
	public function user()
	{
		return $this->hasOne(User::class,'id', 'user_id');
	}
}
