@extends('layouts.main')
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

@section('scripts')
    @if(Request::hasCookie('project_lang') && App::getLocale() === 'ru')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script>
            const googleTranslateConfig = {
                lang: "ru",
            };
            TranslateSetCookie("{{strtolower(Cookie::get('project_lang'))}}")

            function TranslateInit() {
                // Инициализируем виджет с языком по умолчанию
                new google.translate.TranslateElement({
                    pageLanguage: googleTranslateConfig.lang,
                });
            }

            function TranslateGetCode() {
                // Если куки нет, то передаем дефолтный язык
                let lang = ($.cookie('googtrans') != undefined && $.cookie('googtrans') != "null") ? $.cookie('googtrans') : googleTranslateConfig.lang;
                return lang.substr(-2);
            }

            function TranslateClearCookie() {
                $.cookie('googtrans', null);
                $.cookie("googtrans", null, {
                    domain: "." + document.domain,
                });
            }

            function TranslateSetCookie(code) {
                // Записываем куки /язык_который_переводим/язык_на_который_переводим
                $.cookie('googtrans', "/auto/" + code);
                $.cookie("googtrans", "/auto/" + code, {
                    domain: "." + document.domain,
                });
            }

        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>
    @endif
@endsection
