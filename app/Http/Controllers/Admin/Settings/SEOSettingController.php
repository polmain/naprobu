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
    private const DEFAULT_LANG = 'ru';
    private const TRANSLATE_LANG = ['ua', 'en'];

    public function settings(){
		$settings = Setting::where([
			['page','seo'],
			['lang', self::DEFAULT_LANG],
		])->get();

		$blog_settings = Setting::where([
			['page','seo_blog'],
			['lang', self::DEFAULT_LANG],
		])->get();

		$revew_settings = Setting::where([
			['page','seo_review'],
			['lang', self::DEFAULT_LANG],
		])->get();

		$user_settings = Setting::where([
			['page','seo_user'],
			['lang', self::DEFAULT_LANG],
		])->get();

		$profile_settings = Setting::where([
			['page','seo_profile'],
			['lang', self::DEFAULT_LANG],
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

		foreach (self::TRANSLATE_LANG as $lang){
            $translate = $setting->translate->firstWhere('lang', $lang);
            if($translate){
                $translate = new Setting();
                $translate->lang = $lang;
                $translate->name = $setting->name;
                $translate->label = $setting->label;
                $translate->page = $setting->page;
                $translate->type_id = $setting->type_id;
            }
            $translate->value = $request->input('setting_content_'.$lang)[$key];
            $translate->save();
        }
	}
}
