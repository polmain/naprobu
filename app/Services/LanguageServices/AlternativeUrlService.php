<?php

namespace App\Services\LanguageServices;

use Request;

class AlternativeUrlService
{
    public const DEFAULT_LANG = 'ru';
    public const LANGUAGE = ['ru', 'ua', 'en'];

    public static function getAlternativeUrls(string $currentLang, array $routes): array
    {
        $alternativeUrls = [];

        $baseUrl = ((Request::secure())?"https://":"http://").Request::getHost().'/';

        foreach (static::LANGUAGE as $lang){
            if($lang !== $currentLang && $routes[$lang]){
                $langPath = $lang === static::DEFAULT_LANG ? '' : $lang.'/';
                $alternativeUrls[$lang] = $baseUrl.$langPath.$routes['lang'];
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
