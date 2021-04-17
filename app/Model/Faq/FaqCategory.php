<?php

namespace App\Model\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Faq\FaqCategory', 'rus_lang_id');
	}

    public function questions(){
		return $this->hasMany('App\Model\Faq\FaqQuestion','faq_category_id')->where('lang','ru');
	}
}
