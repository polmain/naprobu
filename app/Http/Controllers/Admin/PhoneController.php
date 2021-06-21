<?php

namespace App\Http\Controllers\Admin;

use App\Entity\PhoneStatusEnum;
use App\Library\Queries\QueryBuilder;
use App\Model\Geo\City;
use App\Model\Geo\Country;
use App\Model\User\PhoneVerify;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class PhoneController extends Controller
{

	public function all(){

		SEO::setTitle('Верефикация телефонов');
		AdminPageData::setPageName('Верефикация телефонов');
		AdminPageData::addBreadcrumbLevel('Верефикация телефонов');

		return view('admin.users.phone.all');
	}

    public function all_ajax(Request $request){
        $filter = QueryBuilder::getFilter($request);
        $phones = PhoneVerify::where($filter);

        return datatables()->eloquent($phones)
            ->addColumn('status_name', function (PhoneVerify $phone) {
                return PhoneStatusEnum::getInstance($phone->status)->isVerified()? 'Верифицированно' : 'Не верифицированно';
            })
            ->addColumn('is_new_user_string', function (PhoneVerify $phone) {
                return $phone->is_new_user? 'Новый' : 'Старый';
            })
            ->toJson();
    }

	public function edit($id){
        $phone = PhoneVerify::with(['users'])->where('id',$id)->first();

		SEO::setTitle('Верефикация телефона');
		AdminPageData::setPageName('Верефикация телефона');
		AdminPageData::addBreadcrumbLevel('Телефоны','cities');
		AdminPageData::addBreadcrumbLevel('Верефикация');

		return view('admin.users.phone.edit',[
			'phone'	=>	$phone,
		]);
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
        PhoneVerify::destroy($id);
		return "ok";
	}
}
