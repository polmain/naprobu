<?php

namespace App\Model\Geo;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function base(){
        return $this->hasOne('App\Model\Geo\Country',  'id','rus_lang_id');
    }
    public function translate(){
        return $this->hasMany('App\Model\Geo\Country', 'rus_lang_id');
    }
}
