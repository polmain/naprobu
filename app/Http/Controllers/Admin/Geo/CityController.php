<?php

namespace App\Http\Controllers\Admin\Geo;

use App\Library\Queries\QueryBuilder;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class CityController extends Controller
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function all(){

		SEO::setTitle('Города');
		AdminPageData::setPageName('Города');
		AdminPageData::addBreadcrumbLevel('Города');

		return view('admin.geo.city.all');
	}

    public function all_ajax(Request $request){
        $filter = QueryBuilder::getFilter($request);
        $cities = City::where('lang','ru')->where($filter);

        return datatables()->eloquent($cities)
            ->addColumn('region_name', function (City $city) {
                return $city->region? $city->region->name : '---';
            })
            ->addColumn('country_name', function (City $city) {
                return $city->country->name;
            })
            ->addColumn('verify', function (City $city) {
                return $city->is_verify? "Да" : "Нет";
            })
            ->filterColumn('region_name', function($query, $keyword) {
                $query->whereHas('region', function ($region) use ($keyword){
                    $region->where('name','like',["%{$keyword}%"]);
                });
            })
            ->filterColumn('country_name', function($query, $keyword) {
                $query->whereHas('country', function ($country) use ($keyword){
                    $country->where('name','like',["%{$keyword}%"]);
                });
            })
            ->filter(function ($query) use ($request) {
                if (request()->has('id')) {
                    $query->where('id','like',"%" . request('name') . "%");
                }
                if (request()->has('region_name')) {
                    $query->whereHas('region', function ($region){
                        $region->where('name','like',"%" . request('name') . "%");
                    });
                }
                if (request()->has('country_name')) {
                    $query->whereHas('country', function ($country){
                        $country->where('name','like',"%" . request('name') . "%");
                    });
                }

            }, true)
            ->toJson();
    }

    public function find(Request $request)
    {
        $name = $request->name;
        $country_id = $request->country_id;

        $cities = City::where('lang','ru');
        if($country_id){
            $cities = $cities->where('country_id', $country_id);
        }

        $cities = $cities->where('name','like',"%".$name."%")->where('is_verify',true)->limit(5)->get();

        $formatted_cities = [];

        foreach ($cities as $city) {
            $formatted_cities[] = ['id' => $city->id, 'text' => $city->name];
        }

        return \Response::json($formatted_cities);
    }

	public function new(){
		SEO::setTitle('Новый город');
		AdminPageData::setPageName('Новый город');
		AdminPageData::addBreadcrumbLevel('Города','cities');
		AdminPageData::addBreadcrumbLevel('Новый город');

		$defaultCountry = Country::where([
		    ['lang','ru'],
		    ['code','UA'],
        ])->first();

		return view('admin.geo.city.new',[
		    'defaultCountry' => $defaultCountry
        ]);
	}

	public function edit($id){
		$city = City::with(['translate'])->where('id',$id)->first();

		SEO::setTitle('Редактирование города');
		AdminPageData::setPageName('Редактирование города');
		AdminPageData::addBreadcrumbLevel('Города','cities');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.geo.city.edit',[
			'city'	=>	$city,
		]);
	}

	public function create(Request $request){
        $city = new City();
		$this->saveOrCreate($city,$request);

		ModeratorLogs::addLog("Создал город: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('admin.city.edit',$city->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('admin.city.all');
		}else{
			return redirect()->route('admin.city.new');
		}
	}

	public function save(Request $request,$id){
        $city = City::find($id);

        if($request->has('new_city_id') && $request->new_city_id){
            $this->changeCity($city,$request);
            $city = City::find($request->new_city_id);
            ModeratorLogs::addLog("Заменил город: ".$request->name." на ". $city->name);
            return redirect()->route('admin.city.all',['filter=["is_verify",0]']);
        }else{
            $this->saveOrCreate($city,$request);
        }

		ModeratorLogs::addLog("Отредактировал город: ".$request->name);

        if(($request->submit == "save-hide") || ($request->submit == "save")){
            return redirect()->route('admin.city.edit',$city->id);
        }
        elseif(($request->submit == "save-close")){
            return redirect()->route('admin.city.all');
        }else{
            return redirect()->route('admin.city.new');
        }
	}

	public function delete($id){
        City::destroy($id);
        City::where('rus_lang_id',$id)->delete();
		return "ok";
	}

    private function saveOrCreate($city,$request){
        $this->saveOrCreateTranslate($city, $request);

        foreach (self::TRANSLATE_LANG as $lang){
                $this->saveOrCreateTranslate($city, $request, $lang);
        }
	}

	private function saveOrCreateTranslate(City $city, Request $request, ?string $lang = ''): void
    {
        if($lang !== ''){
            $translate = City::where([
                'rus_lang_id' => $city->id,
                'lang' => $lang,
            ])->first();

            if(empty($translate)){
                $translate = new City();
                $translate->rus_lang_id = $city->id;
                $translate->lang = $lang;
            }
        }else{
            $translate = $city;
        }

        $upperLang = mb_strtoupper($lang);

        $translate->name = $request->input('name'.$upperLang);
        $translate->country_id = $request->input('country_id');
        $translate->region_id = $request->input('region_id');
        $translate->save();

    }

    private function changeCity(City $city, Request $request): void
    {
        User::where('city_id', $city->id)
            ->update(['city_id' => $request->new_city_id]);

        $city->delete();
    }
}
