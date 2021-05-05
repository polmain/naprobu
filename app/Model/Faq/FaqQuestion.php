<?php

namespace App\Model\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Faq\FaqQuestion', 'rus_lang_id');
	}
}
