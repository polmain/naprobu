<?php

namespace App\Http\Controllers;

use App;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\Model\Geo\Region;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function countryFind(Request $request)
    {
        $name = $request->name;
        $locale = $request->lang;

        $countries = Country::where('lang',$locale)
            ->where('name','like',"%".$name."%")
            ->limit(5)
            ->get();

        $formatted_countries = [];

        foreach ($countries as $country) {
            $country_id = $locale === 'ru'? $country->id : $country->rus_lang_id;
            $formatted_countries[] = ['id' => $country_id, 'text' => $country->name];
        }

        return \Response::json($formatted_countries);
    }

    public function regionFind(Request $request)
    {
        $name = $request->name;
        $locale = $request->lang;
        $country_id = $request->country_id;

        $regions = Region::where('lang',$locale);
        if($country_id){
            $regions = $regions->where('country_id', $country_id);
        }

        $regions = $regions->where('name','like',"%".$name."%")
            ->where('is_verify',true)
            ->limit(20)
            ->get();

        $formatted_regions = [];

        foreach ($regions as $region) {
            $region_id = $locale === 'ru'? $region->id : $region->rus_lang_id;
            $formatted_regions[] = ['id' => $region_id, 'text' => $region->name];
        }

        return \Response::json($formatted_regions);
    }

	public function cityFind(Request $request){
        $name = $request->name;
        $locale = $request->lang;
        $country_id = $request->country_id;
        $region_id = $request->region_id;

        $cities = City::where('lang',$locale);
        if($country_id){
            $cities = $cities->where('country_id', $country_id);
        }
        if($region_id){
            $cities = $cities->where('region_id', $region_id);
        }

        $cities = $cities->where('name','like',"%".$name."%")
            ->where('is_verify',true)
            ->limit(20)
            ->get();

        $formatted_cities = [];

        foreach ($cities as $city) {
            $city_id = $locale === 'ru'? $city->id : $city->rus_lang_id;
            $formatted_cities[] = ['id' => $city_id, 'text' => $city->name];
        }

        return \Response::json($formatted_cities);
	}
}
