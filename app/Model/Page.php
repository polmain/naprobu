<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	public function base(){
		return $this->hasOne('App\Model\Page',  'id','rus_lang_id');
	}
	public function translate(){
		return $this->hasMany('App\Model\Page', 'rus_lang_id');
	}
	public function template(){
		return $this->hasOne('App\Model\PageTemaplate', 'id', 'template_id');
	}
	public function blocks(){
		return $this->hasMany('App\Model\Page\Block','page_id');
	}

}
