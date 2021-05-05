<?php

namespace App\Model\Page;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Page\Brand', 'rus_lang_id');
	}
}
