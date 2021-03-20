<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 03.04.2019
 * Time: 17:20
 */

namespace App\Library\Translate;

use App;
use App\Model\Page\LanguageString;

class StringTranslate
{

	private static $instance;
	private $strings;

	public static function translate($name){

		$instance = static::getInstance();
		$string = $instance->strings->where('name',$name)->first()->text;
		return $string;
	}

	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){
		$locale = App::getLocale();
		$this->strings = LanguageString::where('lang',$locale)->get();
	}
	private function __clone(){}
	private function __wakeup(){}
}