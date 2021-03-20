@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
    @if($posts->previousPageUrl())
        @if($posts->currentPage() == 2)
            <link rel="prev" href="{{$posts->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$posts->previousPageUrl()}}" />
        @endif
    @endif
    @if($posts->nextPageUrl())
    <link rel="next" href="{{$posts->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('project_subpage',(App::getLocale() == 'ua')?$project->category->translate:$project->category,$project,$subpage) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-9"><h1 class="button-right">{{$subpage->name}}</h1></div>
            <div class="col-lg-3"><a href="{{route('project.level2',$project->url)}}" class="back-project">@lang('project.back_to_project')</a></div>
        </div>
    </div>
    @if( isset($subpage->text) && $subpage->text !== '')
    <section class="subpage-text">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subpage-text-container">
                        {!! $subpage->text !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="blogger-post-list">
        <div class="container">
            <div class=" row" id="ajax-list">
                @include('project.include.post_item')
            </div>
            @if($posts->nextPageUrl())
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <button class="load-more">@lang('global.load_more')</button>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

