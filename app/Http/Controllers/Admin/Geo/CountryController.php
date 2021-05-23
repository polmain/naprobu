<?php

namespace App\Http\Controllers\Admin\Geo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Geo\Country;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class CountryController extends Controller
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function all(){

		SEO::setTitle('Страны');
		AdminPageData::setPageName('Страны');
		AdminPageData::addBreadcrumbLevel('Страны');

		return view('admin.geo.country.all');
	}

    public function all_ajax(Request $request){
        $countries = Country::where('lang','ru');

        return datatables()->eloquent($countries)->toJson();
    }

	public function new(){
		SEO::setTitle('Новая страна');
		AdminPageData::setPageName('Новая страна');
		AdminPageData::addBreadcrumbLevel('Страны','countries');
		AdminPageData::addBreadcrumbLevel('Новая страна');

		return view('admin.geo.country.new');
	}

	public function edit($id){
		$country = Country::with(['translate'])->where('id',$id)->first();

		SEO::setTitle('Редактирование страны');
		AdminPageData::setPageName('Редактирование страны');
		AdminPageData::addBreadcrumbLevel('Страны','page');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.geo.country.edit',[
			'country'	=>	$country,
		]);
	}

	public function create(Request $request){
        $country = new Country();
		$this->saveOrCreate($country,$request);

		ModeratorLogs::addLog("Создал страну: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('admin.country.edit',$country->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('admin.country.all');
		}else{
			return redirect()->route('admin.country.new');
		}
	}

	public function save(Request $request,$id){
        $country = Country::find($id);
		$this->saveOrCreate($country,$request);


		ModeratorLogs::addLog("Отредактировал страницу: ".$request->name);

        if(($request->submit == "save-hide") || ($request->submit == "save")){
            return redirect()->route('admin.country.edit',$country->id);
        }
        elseif(($request->submit == "save-close")){
            return redirect()->route('admin.country.all');
        }else{
            return redirect()->route('admin.country.new');
        }
	}

	public function delete($id){
        Country::destroy($id);
        Country::where('rus_lang_id',$id)->delete();
		return "ok";
	}

	protected function saveOrCreate($page,$request){
        $this->saveOrCreateTranslate($page, $request);

        foreach (self::TRANSLATE_LANG as $lang){
                $this->saveOrCreateTranslate($page, $request, $lang);
        }
	}

	private function saveOrCreateTranslate(Country $country, Request $request, ?string $lang = ''): void
    {
        if($lang !== ''){
            $translate = Country::where([
                'rus_lang_id' => $country->id,
                'lang' => $lang,
            ])->first();

            if(empty($translate)){
                $translate = new Country();
                $translate->rus_lang_id = $country->id;
                $translate->lang = $lang;
            }
        }else{
            $translate = $country;
        }

        $upperLang = mb_strtoupper($lang);

        $translate->name = $request->input('name'.$upperLang);
        $translate->code = $request->input('code');
        $translate->save();

    }
}
