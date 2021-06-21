<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PhoneVerify extends Model
{
	protected $fillable = [
        'phone', 'duplicates', 'status', 'is_new_user'
	];

	/**
	 * @return array
	 */
	public function users()
	{
		return $this->hasMany(User::class,'phone', 'phone');
	}
}
