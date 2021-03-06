<?php

namespace App\Http\Controllers\Admin\Geo;

use App\Library\Queries\QueryBuilder;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Geo\Region;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class RegionController extends Controller
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function all(){

		SEO::setTitle('Области');
		AdminPageData::setPageName('Области');
		AdminPageData::addBreadcrumbLevel('Области');

		return view('admin.geo.region.all');
	}

    public function all_ajax(Request $request){
        $filter = QueryBuilder::getFilter($request);
        $regions = Region::where('lang','ru')->where($filter);

        return datatables()->eloquent($regions)
            ->addColumn('country_name', function (Region $region) {
                return $region->country->name;
            })->filterColumn('country_name', function($query, $keyword) {
                $query->whereHas('country', function ($country) use ($keyword){
                    $country->where('name','like',["%{$keyword}%"]);
                });
            })
            ->addColumn('verify', function (Region $region) {
                return $region->is_verify? "Да" : "Нет";
            })
            ->filter(function ($query) use ($request) {
                if (request()->has('id')) {
                    $query->where('id','like',"%" . request('name') . "%");
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

        $regions = Region::where('lang','ru');
        if($country_id){
            $regions = $regions->where('country_id', $country_id);
        }

        $regions = $regions->where('name','like',"%".$name."%")->where('is_verify',true)->limit(5)->get();

        $formatted_regions = [];

        foreach ($regions as $region) {
            $formatted_regions[] = ['id' => $region->id, 'text' => $region->name];
        }

        return \Response::json($formatted_regions);
    }

	public function new(){
		SEO::setTitle('Новая область');
		AdminPageData::setPageName('Новая область');
		AdminPageData::addBreadcrumbLevel('Области','regions');
		AdminPageData::addBreadcrumbLevel('Новая область');

		$defaultCountry = Country::where([
		    ['lang','ru'],
		    ['code','UA'],
        ])->first();

		return view('admin.geo.region.new',[
		    'defaultCountry' => $defaultCountry
        ]);
	}

	public function edit($id){
		$region = Region::with(['translate'])->where('id',$id)->first();

		SEO::setTitle('Редактирование области');
		AdminPageData::setPageName('Редактирование области');
		AdminPageData::addBreadcrumbLevel('Области','regions');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.geo.region.edit',[
			'region'	=>	$region,
		]);
	}

	public function create(Request $request){
        $region = new Region();
		$this->saveOrCreate($region,$request);

		ModeratorLogs::addLog("Создал область: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('admin.region.edit',$region->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('admin.region.all');
		}else{
			return redirect()->route('admin.region.new');
		}
	}

	public function save(Request $request,$id){
        $region = Region::find($id);

        if($request->has('new_region_id') && $request->new_region_id){
            $this->changeRegion($region,$request);
            $region = Region::find($request->new_region_id);
            ModeratorLogs::addLog("Заменил область: ".$request->name." на ". $region->name);
            return redirect()->route('admin.region.all',['filter=["is_verify",0]']);
        }else{
            $this->saveOrCreate($region,$request);
        }


		ModeratorLogs::addLog("Отредактировал область: ".$request->name);

        if(($request->submit == "save-hide") || ($request->submit == "save")){
            return redirect()->route('admin.region.edit',$region->id);
        }
        elseif(($request->submit == "save-close")){
            return redirect()->route('admin.region.all');
        }else{
            return redirect()->route('admin.region.new');
        }
	}

	public function delete($id){
        Region::destroy($id);
        Region::where('rus_lang_id',$id)->delete();
		return "ok";
	}

	private function saveOrCreate($region,$request){
        $this->saveOrCreateTranslate($region, $request);

        foreach (self::TRANSLATE_LANG as $lang){
                $this->saveOrCreateTranslate($region, $request, $lang);
        }
	}

	private function saveOrCreateTranslate(Region $region, Request $request, ?string $lang = ''): void
    {
        if($lang !== ''){
            $translate = Region::where([
                'rus_lang_id' => $region->id,
                'lang' => $lang,
            ])->first();

            if(empty($translate)){
                $translate = new Region();
                $translate->rus_lang_id = $region->id;
                $translate->lang = $lang;
            }
        }else{
            $translate = $region;
        }

        $upperLang = mb_strtoupper($lang);

        $translate->name = $request->input('name'.$upperLang);
        $translate->country_id = $request->input('country_id');
        $translate->is_verify = true;
        $translate->save();

    }

    private function changeRegion(Region $region, Request $request): void
    {
        User::where('region_id', $region->id)
            ->update(['region_id' => $request->new_region_id]);

        City::where('region_id', $region->id)
            ->update(['region_id' => $request->new_region_id]);

        $regions = Region::where('rus_lang_id', $region->id)->get();
        foreach ($regions as $region_item){
            $region_item->delete();
        }
        $region->delete();
    }
}
