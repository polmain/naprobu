<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page;
use App\Model\Page\Block;
use App\Model\PageTemplate;
use App\Library\Users\ModeratorLogs;
use SEO;
use AdminPageData;

class PageController extends Controller
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function all(){
		$pages = Page::where('rus_lang_id',0)->get();

		SEO::setTitle('Страницы');
		AdminPageData::setPageName('Страницы');
		AdminPageData::addBreadcrumbLevel('Страницы');

		return view('admin.page.all',[
			'pages'	=>	$pages
		]);
	}

	public function allMain(){
		SEO::setTitle('Основные страницы');
		AdminPageData::setPageName('Основные страницы');
		AdminPageData::addBreadcrumbLevel('Основные страницы');

		return view('admin.page.all_main');
	}

	public function new(){
		$templates = PageTemplate::all();

		SEO::setTitle('Новая страница');
		AdminPageData::setPageName('Новая страница');
		AdminPageData::addBreadcrumbLevel('Страницы','page');
		AdminPageData::addBreadcrumbLevel('Новая страница');

		return view('admin.page.new',[
			'templates'	=>	$templates
		]);
	}

	public function edit($page_id){
		$templates = PageTemplate::all();
		$page = Page::with(['translate','blocks'])->where('id',$page_id)->first();

		$pageUA = $page->translate->firstWhere('lang', 'ua');
		$pageEN = $page->translate->firstWhere('lang', 'en');

		SEO::setTitle('Редактирование страницы');
		AdminPageData::setPageName('Редактирование страницы');
		AdminPageData::addBreadcrumbLevel('Страницы','page');
		AdminPageData::addBreadcrumbLevel('Редактирование');

		return view('admin.page.edit',[
			'templates'	=>	$templates,
			'page'	=>	$page,
			'pageUA'	=>	$pageUA,
			'pageEN'	=>	$pageEN,
		]);
	}

	public function create(Request $request){
		$page = new Page();
		$this->saveOrCreate($page,$request);

		ModeratorLogs::addLog("Создал страницу: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_page_edit',$page->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_page');
		}else{
			return redirect()->route('adm_page_new');
		}
	}

	public function save(Request $request,$page_id){
		$page = Page::find($page_id);
		$this->saveOrCreate($page,$request);

		if($request->has('block')){
			foreach ($request->block as $key=>$value){
				$this->editBlock($request,$key);
			}
		}


		ModeratorLogs::addLog("Отредактировал страницу: ".$request->name);

		if(($request->submit == "save-hide") || ($request->submit == "save")){
			return redirect()->route('adm_page_edit',$page->id);
		}
		elseif(($request->submit == "save-close")){
			return redirect()->route('adm_page');
		}else{
			return redirect()->route('adm_page_new');
		}
	}

	public function delete($page_id){
		Page::destroy($page_id);
		Page::where('rus_lang_id',$page_id)->delete();
		return "ok";
	}

	public function hide($page_id){
		$page = Page::find($page_id);
		$page->isHide = true;
		$page->save();
		return "ok";
	}
	public function show($page_id){
		$page = Page::find($page_id);
		$page->isHide = false;
		$page->save();
		return "ok";
	}

	protected function saveOrCreate($page,$request){
        $this->translateSaveOrCreate($page, $request);

        foreach (self::TRANSLATE_LANG as $lang){
            if($this->checkRequiredForLang($request, $lang)){
                $this->translateSaveOrCreate($page, $request, $lang);
            }
        }
	}

	private function checkRequiredForLang(Request $request, string $lang): bool
    {
        $upperLang = mb_strtoupper($lang);
dd($request->input('name'.$upperLang));
	    return $request->input('name'.$upperLang) !== '';
    }

	private function translateSaveOrCreate(Page $page, Request $request, ?string $lang = ''): void
    {
        if($lang !== ''){
            $translate = Page::where([
                'rus_lang_id' => $page->id,
                'lang' => $lang,
            ])->first();

            if(empty($translate)){
                $translate = new Page();
                $translate->rus_lang_id = $page->id;
                $translate->lang = $lang;
            }
        }else{
            $translate = $page;
        }

        $upperLang = mb_strtoupper($lang);

        $translate->name = $request->input('name'.$upperLang);
        $translate->content = $request->input('content'.$upperLang);
        $translate->url = $request->input('url'.$upperLang);
        $translate->isHide = ($request->submit == "save-hide");
        $translate->template_id = 1;

        $translate->seo_title = $request->input('seo_title'.$upperLang);
        $translate->seo_description = $request->input('seo_description'.$upperLang);
        $translate->seo_keywords = $request->input('seo_keywords'.$upperLang);
        $translate->og_image = $request->og_image;
        $translate->save();

    }

	protected function editBlock($request,$key){
		$block = Block::find($request->block[$key]);
		$block->content = $request->block_content[$key];
		$block->save();

		$block_ua = $block->translate->first();
		$block_ua->content = $request->block_content_ua[$key];
		$block_ua->save();
	}

	/* Main page editors */
	public function validURL(Request $request)
	{
		$url = $request->url;
		return $url;
	}



}
