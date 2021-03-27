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

		//Проверяем метку типа страниц  - есть ли она среди доступных языков
		if (!empty($segmentsURI[0]) && $segmentsURI[0] === static::INTERNATIONAL) {
			return $segmentsURI[0];
		}

		return null;
	}

	public function handle($request, Closure $next)
	{
		if(self::getInternational()){
            $request->attributes->add(['international', true]);
        }else{
            $request->attributes->add(['international', false]);
        }

		return $next($request);
	}

}
