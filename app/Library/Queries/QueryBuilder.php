<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 12.02.2019
 * Time: 14:03
 */

namespace App\Library\Queries;

use Illuminate\Http\Request;

class QueryBuilder
{
	public static function getFilter(Request $request){
		$filter = [];
		$json =  json_decode($request->filter);
		if(!empty($json)){
			$filter[] = $json;
		}
		return $filter;
	}

	private static $instance;
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}