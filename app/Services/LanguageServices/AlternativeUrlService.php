<?php

namespace App\Services\LanguageServices;

use Request;

class AlternativeUrlService
{
    public const DEFAULT_LANG = 'ua';
    public const LANGUAGE = ['ru', 'ua', 'en'];

    public static function getAlternativeUrls(string $currentLang, array $routes): array
    {
        $alternativeUrls = [];

        $baseUrl = ((Request::secure())?"https://":"http://").Request::getHost().'/';

        foreach (static::LANGUAGE as $lang){
            if($lang !== $currentLang && isset($routes[$lang])){
                $langPath = $lang === static::DEFAULT_LANG ? '' : $lang.'/';
                if(Request::get('international')){
                    $langPath = $langPath.'international/';
                }
                $alternativeUrls[$lang] = $baseUrl.$langPath.$routes[$lang];
            }
        }

        return $alternativeUrls;
    }

    public static function generateReplyRoutes(string $route): array
    {
        $routes = [];

        foreach (static::LANGUAGE as $lang){
            $routes[$lang] = $route;
        }

        return $routes;
    }
}
