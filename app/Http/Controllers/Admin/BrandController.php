<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page\Brand;
use SEO;
use AdminPageData;
use App\Library\Users\ModeratorLogs;

class BrandController extends Controller
{
    private const TRANSLATE_LANG = ['ua', 'en'];

    public function all(){
		SEO::setTitle('Все Брэнды');
		AdminPageData::setPageName('Все Брэнды');
		AdminPageData::addBreadcrumbLevel('Брэнды');

		$brands = Brand::where([
			['lang','ru']
		])->get();
		return view('admin.brand.all',[
			'brands'	=>	$brands,
		]);
	}

	public function new(){

		SEO::setTitle('Новый Брэнд');
		AdminPageData::setPageName('Новый Брэнд');
		AdminPageData::addBreadcrumbLevel('Брэнды','brand');
		AdminPageData::addBreadcrumbLevel('Новый Брэнд');

		return view('admin.brand.new');
	}

	public function edit($brand_id){
		$brand = Brand::with(['translate'])->where('id',$brand_id)->first();

		SEO::setTitle('Редактирование Брэнда');
		AdminPageData::setPageName('Редактирование Брэнда');
		AdminPageData::addBreadcrumbLevel('Брэнды','brand');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.brand.edit',[
			'brand'	=>	$brand,
		]);
	}

	public function create(Request $request){
		$brand = new Brand();
		$this->saveOrCreate($brand,$request);

		ModeratorLogs::addLog("Добавил Брэнд: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_brand_edit',$brand->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_brand');
		}else{
			return redirect()->route('adm_brand_new');
		}
	}

	public function save(Request $request,$brand_id){
		$brand = Brand::find($brand_id);
		$this->saveOrCreate($brand,$request);

		ModeratorLogs::addLog("Отредактировал Брэнд: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_brand_edit',$brand->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_brand');
		}else{
			return redirect()->route('adm_brand_new');
		}
	}

	public function delete($brand_id){
		Brand::destroy($brand_id);
		Brand::where('rus_lang_id',$brand_id)->delete();
		return "ok";
	}

	public function hide($brand_id){
		$brand = Brand::find($brand_id);
		$brand->isHide = true;
		$brand->save();
		$brand = Brand::where('rus_lang_id',$brand_id)->first();
		$brand->isHide = true;
		$brand->save();
		return "ok";
	}

	public function show($brand_id){
		$brand = Brand::find($brand_id);
		$brand->isHide = false;
		$brand->save();
		$brand = Brand::where('rus_lang_id',$brand_id)->first();
		$brand->isHide = false;
		$brand->save();
		return "ok";
	}

	public function saveOrCreate(Brand $brand, Request $request){

		$brand->name = $request->name;
		$brand->alt = $request->alt;
		$brand->logo = $request->image;
		$brand->review = $request->review;
		$brand->save();

        foreach (self::TRANSLATE_LANG as $lang){
            if($this->checkRequiredForLang($request, $lang)){
                $this->translateSaveOrCreate($brand, $request, $lang);
            }
        }
	}

    private function checkRequiredForLang(Request $request, string $lang): bool
    {
        return (bool) $request->input('name_'.$lang);
    }

    private function translateSaveOrCreate(Brand $brand, Request $request, string $lang): void
    {
        $translate = Brand::where([
            'rus_lang_id' => $brand->id,
            'lang' => $lang,
        ])->first();

        if(empty($translate)){
            $translate = new Brand();
            $translate->rus_lang_id = $brand->id;
            $translate->lang = $lang;
        }

        $translate->name = $request->input('name_'.$lang);
        $translate->alt = $request->input('alt_'.$lang);
        $translate->review = $request->input('review_'.$lang);
        $translate->logo = $request->image;
        $translate->save();

    }
}
