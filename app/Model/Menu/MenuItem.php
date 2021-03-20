<?php

namespace App\Model\Menu;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
	public function translates(){
		return $this->hasMany('App\Model\Menu\MenuItem', 'name','name')->where('id','<>',$this->id)->where('menu_id',$this->menu_id);
	}
}
