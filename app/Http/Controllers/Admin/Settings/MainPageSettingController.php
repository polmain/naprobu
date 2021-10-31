<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Setting;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class MainPageSettingController extends Controller
{
    private const DEFAULT_LANG = 'ru';
    private const TRANSLATE_LANG = ['ua', 'en'];

    public function settings(){
		$settings = Setting::where([
			['page','main_page_blog'],
			['lang', self::DEFAULT_LANG],
		])->get();

		$posts = Post::whereIn('id', $settings->pluck('value'))->get();

		SEO::setTitle('Настройки Главной страницы');
		AdminPageData::setPageName('Настройки Главной страницы');
		AdminPageData::addBreadcrumbLevel('Настройки','settings');
		AdminPageData::addBreadcrumbLevel('Главная страница');


		return view('admin.settings.main_page',[
			'settings'	=>	$settings,
			'posts'	=>	$posts,
		]);
	}

	public function save(Request $request){
		foreach ($request->setting as $key=>$value){
			$this->editSetting($request,$key);
		}

		ModeratorLogs::addLog("Отредактировал настройки главной страницы");
		return redirect()->route('adm_seo_settings');
	}

	private function editSetting($request,$key){
		$setting = Setting::find($request->setting[$key]);
		$setting->value = $request->setting_content[$key];
		$setting->save();

		if ($setting->type_id != 4){
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
}
