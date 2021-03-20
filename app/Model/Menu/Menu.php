<?php

namespace App\Model\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public function items(){
		return $this->hasMany('App\Model\Menu\MenuItem', 'menu_id')->orderBy('sort');
	}

}
