<?php

namespace App\Model\Geo;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function country(){
        return $this->hasOne('App\Model\Geo\Country',  'id','country_id');
    }

    public function base(){
        return $this->hasOne('App\Model\Geo\Region',  'id','rus_lang_id');
    }

    public function translate(){
        return $this->hasMany('App\Model\Geo\Region', 'rus_lang_id');
    }
}
