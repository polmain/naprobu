<?php

namespace App\Model\Page;

use Illuminate\Database\Eloquent\Model;

class LanguageString extends Model
{
	public function translate(){
		return $this->hasOne('App\Model\Page\LanguageString', 'name','name')->where('lang','ua');
	}
}
