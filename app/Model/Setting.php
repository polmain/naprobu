<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Setting', 'name', 'name')->where([
			['page',$this->page],
			['lang','<>',$this->lang],
		]);
	}
}
