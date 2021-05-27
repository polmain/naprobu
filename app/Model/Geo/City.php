<?php

namespace App\Model\Geo;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function country(){
        return $this->hasOne('App\Model\Geo\Country',  'id','country_id');
    }

    public function region(){
        return $this->hasOne('App\Model\Geo\Region',  'id','region_id');
    }

    public function base(){
        return $this->hasOne('App\Model\Geo\City',  'id','rus_lang_id');
    }

    public function translate(){
        return $this->hasMany('App\Model\Geo\City', 'rus_lang_id');
    }
}
