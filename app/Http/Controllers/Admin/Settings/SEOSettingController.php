<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Setting;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class SEOSettingController extends Controller
{
	public function settings(){
		$settings = Setting::where([
			['page','seo'],
			['lang','ru'],
		])->get();

		$blog_settings = Setting::where([
			['page','seo_blog'],
			['lang','ru'],
		])->get();

		$revew_settings = Setting::where([
			['page','seo_review'],
			['lang','ru'],
		])->get();

		$user_settings = Setting::where([
			['page','seo_user'],
			['lang','ru'],
		])->get();

		$profile_settings = Setting::where([
			['page','seo_profile'],
			['lang','ru'],
		])->get();

		SEO::setTitle('Настройки SEO');
		AdminPageData::setPageName('Настройки SEO');
		AdminPageData::addBreadcrumbLevel('Настройки','settings');
		AdminPageData::addBreadcrumbLevel('SEO');


		return view('admin.settings.seo',[
			'settings'	=>	$settings,
			'blog_settings'	=>	$blog_settings,
			'revew_settings'	=>	$revew_settings,
			'user_settings'	=>	$user_settings,
			'profile_settings'	=>	$profile_settings,
		]);
	}

	public function settings_save(Request $request){
		foreach ($request->setting as $key=>$value){
			$this->editSetting($request,$key);
		}

		ModeratorLogs::addLog("Отредактировал настройки SEO");
		return redirect()->route('adm_seo_settings');
	}

	protected function editSetting($request,$key){
		$setting = Setting::find($request->setting[$key]);
		$setting->value = $request->setting_content[$key];
		$setting->save();

		$setting_ua = $setting->translate->first();
		$setting_ua->value = $request->setting_content_ua[$key];
		$setting_ua->save();
	}
}
