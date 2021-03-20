@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
<link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
    @if($projects->previousPageUrl())
        @if($projects->currentPage() == 2)
            <link rel="prev" href="{{$projects->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$projects->previousPageUrl()}}" />
        @endif
    @endif
    @if($projects->nextPageUrl())
        <link rel="next" href="{{$projects->nextPageUrl()}}" />
    @endif
@endsection

@section('content')
<section class="breadcrumb-box">
    <div class="container">
        <div class="row">
            @if($page instanceof App\Model\Page)
                {{ Breadcrumbs::render('projects') }}
            @else
                {{ Breadcrumbs::render('category',$page) }}
            @endif
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12"><h1>{{$page->name}}</h1></div>
    </div>
</div>
    <div class="container">
        <nav class="category-list categories-project ">
            <ul class="row">
                @foreach($categories as $category)
                    <li class="category-item col-md col-12{{($page instanceof App\Model\Project\ProjectCategory)?($page->id == $category->id?" active":""):""}}">
                        <a href="{{route('project.level2',['url' =>  $category->url])}}">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <section class="project-list">
        <div class="container">
            <div class="row" id="ajax-list">
                @include('project.include.project_item')
            </div>
            @if($projects->nextPageUrl())
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <button class="load-more">@lang('global.load_more')</button>
                </div>
            </div>
                @endif
        </div>
    </section>
@endsection

