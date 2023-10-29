@extends('layouts.main')
@section('body.attr')
    data-spy="scroll" data-target="#letter-list" data-offset="60"
@endsection
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('project_subpage',(App::getLocale() !== 'ru')?$project->category->translate->firstWhere('lang', App::getLocale()):$project->category,$project,$subpage) }}
        </div>
    </div>
</section>
<div class="container mb-3">
    <div class="row">
        <div class="col-md-9"><h1 class="button-right">{{$subpage->name}}</h1></div>
        <div class="col-md-3"><a href="{{route('project.level2',$project->url)}}" class="back-project">@lang('project.back_to_project')</a></div>
    </div>
</div>
<section class="alphabet">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alphabet-container">
                    <span class="alphabet-header">@lang('project.go_to_letter'):</span><nav class="letter-list list-group" id="letter-list">
                        @foreach($requests->groupBy(function($item,$key) {
                                return mb_substr(mb_strtolower($item->user->name),0,1);
                            }) as $request)
                            <a class="letter-item list-group-item list-group-item-action" href="#letter-{{mb_substr(mb_strtoupper($request->first()->user->name),0,1)}}">{{mb_substr(mb_strtoupper($request->first()->user->name),0,1)}}</a>
                        @endforeach
                    </nav>
                </div>
            </div>

        </div>
    </div>
</section>
    <section class="member-list">
        <div class="container">
            @php
                $letter = mb_substr(mb_strtoupper($requests->first()->user->name),0,1);
            @endphp
            <div class="row">
                <div class="col-12">
                    <div class="letter" id="letter-{{$letter}}">
                        {{$letter}}
                    </div>
                </div>
                @foreach($requests as $request)
                    @if($letter != mb_substr(mb_strtoupper($request->user->name),0,1))
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <div class="letter" id="letter-{{$letter= mb_substr(mb_strtoupper($request->user->name),0,1)}}">
                                {{$letter}}
                            </div>
                        </div>
                    @endif
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a class="member-item text-center" href="{{route('profile',[$request->user->id])}}">
                                <div class="user-avatar">
                                    <img src="{{ asset("/public/uploads/images/avatars/".$request->user->avatar) }}" alt="{{$request->user->name}}">
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{$request->user->name}}</div>
                                    @if(App::getLocale() == 'ru')
                                        <div class="user-role">{{$request->user->rang->name}} @if($request->user->isBlogger()) - @lang('user.blogger') @endif </div>
                                    @else
                                        <div class="user-role">{{$request->user->rang->translate->firstWhere('lang', App::getLocale())->name}}  @if($request->user->isBlogger()) - @lang('user.blogger') @endif </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                @endforeach
            </div>
        </div>
    </section>


@endsection

@section('scripts')
    @if($project->audience->isWord() && App::getLocale() === 'ru')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script>
            const googleTranslateConfig = {
                lang: "ru",
            };
            TranslateSetCookie("{{strtolower($project->country->getCode())}}")

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
