@extends('layouts.main')
@php
    if(empty($alternet_url)){
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
    }

@endphp
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                @if(isset($header))
                    {{ Breadcrumbs::render('error', $header) }}
                @else
                    {{ Breadcrumbs::render('error',trans('page_message.default_header')) }}
                @endif
            </div>
        </div>
    </section>
    <div class="container mb-4">
        <div class="row">
            @if(isset($header))
                <div class="col-md-12"><h1>{{$header}}</h1></div>
            @else
                <div class="col-md-12"><h1>@lang('page_message.default_header')</h1></div>
            @endif
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                {!! $message !!}
            </div>
            <div class="col-md-4 col-xl-3 mb-5">
                <a href="{{route('home')}}" class="btn-orange btn-block">@lang('global.go_to_home')</a>
            </div>
        </div>
    </div>
@endsection
