@extends('layouts.main')

@php
    $lang = (App::getLocale() == 'ru')?'ua':'ru';
            //разбиваем на массив по разделителю
		    $segments = explode('/', route('home'));

            //Если URL (где нажали на переключение языка) содержал корректную метку языка
            if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
                unset($segments[3]); //удаляем метку
            }

            //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
            if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
                array_splice($segments, 3, 0, $lang);
            }

            //формируем полный URL
            $alternet_url = implode("/", $segments);
@endphp
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="error-number">
                500
            </div>
            <div class="error-text">
                @lang('page_message.500_text')
            </div>
        </div>
    </div>
@endsection