<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Post\PostTagList;
use SEO;
use AdminPageData;

class TagController extends Controller
{
    private const UKRAINIAN_LANG = 'ua';
    private const ENGLISH_LANG = 'en';
    private const TRANSLATE_LANG = [self::UKRAINIAN_LANG, self::ENGLISH_LANG];

	public function __construct()
	{
		AdminPageData::addBreadcrumbLevel('Блог','blog');
	}

	public function all()
	{
		SEO::setTitle('Теги');
		AdminPageData::setPageName('Теги');
		AdminPageData::addBreadcrumbLevel('Теги');

		return view('admin.post.tag.all');
	}

	public function all_ajax(Request $request){
		$tags = PostTagList::with(['translate'])
			->where('lang','ru')
			->orderBy('id','desc');

		return datatables()
			->eloquent($tags)
			->addColumn('translate_ua', function (PostTagList $translate) {
				return $translate->translate->firstWhere('lang', self::UKRAINIAN_LANG)? $translate->translate->firstWhere('lang', self::UKRAINIAN_LANG)->name : '';
			})
			->addColumn('translate_en', function (PostTagList $translate) {
				return $translate->translate->firstWhere('lang', self::ENGLISH_LANG)? $translate->translate->firstWhere('lang', self::ENGLISH_LANG)->name : '';
			})
			->toJson();
	}

	public function find(Request $request)
	{
		$name = $request->name;

		$tags = PostTagList::with(['translate'])
			->where('lang','ru')
			->where('name','like',"%".$name."%")
			->limit(5)
			->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name
                .($tag->translate->firstWhere('lang',self::UKRAINIAN_LANG)?' (укр: '.$tag->translate->firstWhere('lang',self::UKRAINIAN_LANG)->name.')':'')
                .($tag->translate->firstWhere('lang',self::ENGLISH_LANG)?' (eng: '.$tag->translate->firstWhere('lang',self::ENGLISH_LANG)->name.')':'')
            ];
		}

		return \Response::json($formatted_tags);
	}

	public function create(Request $request){
		$tag = new PostTagList();
		$tag->name = $request->name_ru;
		$tag->url = $this->str2url($request->name_ru);
		$tag->save();

		foreach (self::TRANSLATE_LANG as $lang){
            $translate = new PostTagList();

            $name = $request->input('name_'.$lang);
            $translate->name = $name;
            $translate->url = $this->str2url($name);

            $translate->lang = $lang;
            $translate->rus_lang_id = $tag->id;

            $translate->save();
        }

		return redirect()->route('adm_post_tag');
	}

	public function delete($tag_id){
		PostTagList::destroy($tag_id);
		Post\PostTag::where('tag_id',$tag_id)->delete();
		PostTagList::where('rus_lang_id',$tag_id)->delete();
		return "ok";
	}

	private function rus2translit($string) {
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		return strtr($string, $converter);
	}
	private function str2url($str) {
		// переводим в транслит
		$str = $this->rus2translit($str);
		// в нижний регистр
		$str = strtolower($str);
		// заменям все ненужное нам на "-"
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		// удаляем начальные и конечные '-'
		$str = trim($str, "-");
		return $str;
	}
}
