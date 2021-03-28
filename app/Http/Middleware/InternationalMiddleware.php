<?php
namespace App\Http\Middleware;

use Closure;
use App;
use Request;

class InternationalMiddleware
{
	public const INTERNATIONAL = 'international';


	/*
	 * Проверяет наличие корректной метки типа языка в текущем URL
	 * Возвращает метку или значеие null, если нет метки
	 */
	public static function getInternational()
	{
		$uri = Request::path(); //получаем URI


		$segmentsURI = explode('/',$uri); //делим на части по разделителю "/"
		//Проверяем метку типа страниц  - в первом сегменте (для базового языка)
		if (!empty($segmentsURI[0]) && $segmentsURI[0] === static::INTERNATIONAL) {
			return $segmentsURI[0];
		}
		//Проверяем метку типа страниц  - во втором сегменте (для второстипенного языка)
		if (!empty($segmentsURI[1]) && $segmentsURI[1] === static::INTERNATIONAL) {
			return $segmentsURI[1];
		}

		return null;
	}

	public function handle($request, Closure $next)
	{
		if(self::getInternational()){
            $request->attributes->add(['international' => true]);
            view()->share('international',true);
        }else{
            $request->attributes->add(['international' => false]);
            view()->share('international',false);
        }

		return $next($request);
	}

}
