<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page\LanguageString;

use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class LanguageController extends Controller
{
    public function settings(){
		SEO::setTitle('Настройки переводов');
		AdminPageData::setPageName('Настройки переводов');
		AdminPageData::addBreadcrumbLevel('Настройки','settings');
		AdminPageData::addBreadcrumbLevel('Настройки переводов');

    	$strings = LanguageString::with(['translate'])->where('lang','ru')->get();

    	return view('admin.settings.language',[
    		'strings' => $strings
		]);
	}

	public function settings_save(Request $request){

		foreach ($request->strings as $key=>$value){
			$string = LanguageString::find($request->strings[$key]);
			$translate = LanguageString::where([
				['name',$string->name],
				['lang','ua'],
			])->first();
			$string->text = $request->string_ru[$key];
			$string->save();
			$translate->text = $request->string_ua[$key];
			$translate->save();
		}

		ModeratorLogs::addLog("Отредактировал перевод строк");

		return redirect()->route('adm_language_settings');
	}
}
