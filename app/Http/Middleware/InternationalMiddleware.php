<?php
namespace App\Http\Middleware;

use Closure;
use App;
use Request;

class InternationalMiddleware
{
	public const INTERNATIONAL = 'international';


	/*
	 * Проверяет наличие корректной метки языка в текущем URL
	 * Возвращает метку или значеие null, если нет метки
	 */
	public static function getInternational()
	{
		$uri = Request::path(); //получаем URI


		$segmentsURI = explode('/',$uri); //делим на части по разделителю "/"


		//Проверяем метку языка  - есть ли она среди доступных языков
		if (!empty($segmentsURI[0]) && $segmentsURI[0] === static::INTERNATIONAL) {
			return $segmentsURI[0];
		}

		return null;
	}

	/*
	* Устанавливает язык приложения в зависимости от метки языка из URL
	*/
	public function handle($request, Closure $next)
	{
		$locale = self::getLocale();

		if($locale) App::setLocale($locale);
		//если метки нет - устанавливаем основной язык $mainLanguage
		else App::setLocale(self::$mainLanguage);

		return $next($request); //пропускаем дальше - передаем в следующий посредник
	}

}
