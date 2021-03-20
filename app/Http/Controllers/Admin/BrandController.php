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

	protected function saveOrCreate($brand,$request){
		$brand->name = $request->name;
		$brand->alt = $request->alt;
		$brand->logo = $request->image;
		$brand->review = $request->review;
		$brand->save();

		$translate = Brand::where('rus_lang_id',$brand->id)->first();
		if(empty($translate)){
			$translate = new Brand();
			$translate->rus_lang_id = $brand->id;
			$translate->lang = 'ua';
		}
		$translate->name = $request->name_ua;
		$translate->alt = $request->alt_ua;
		$translate->logo = $request->image;
		$translate->review = $request->review_ua;
		$translate->save();
	}
}
