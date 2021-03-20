<?php

namespace App\Model\Page;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
	public function translate(){
		return $this->hasMany('App\Model\Page\Block', 'name', 'name')->where([
			['page_id',$this->page_id],
			['lang','<>',$this->lang],
		]);
	}
	public function type(){
		return $this->hasOne('App\Model\Page\BlockType',  'id','type_id');
	}
	public function page(){
		return $this->hasOne('App\Model\Page',  'page_id');
	}
}
