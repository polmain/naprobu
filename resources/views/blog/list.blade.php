@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
    @if($posts->previousPageUrl())
        <link rel="prev" href="{{$posts->previousPageUrl()}}" />
    @endif
    @if($posts->nextPageUrl())
        <link rel="next" href="{{$posts->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
<section class="breadcrumb-box mb-0">
    <div class="container">
        <div class="row">
            @if(empty($page))
                {{ Breadcrumbs::render('blog_news') }}
                @else
            @if($page instanceof App\Model\Page)
                {{ Breadcrumbs::render('blog') }}
            @elseif($page instanceof App\User)
                {{ Breadcrumbs::render('blog_user',$page) }}
            @else
                {{ Breadcrumbs::render('blog_category',$page) }}
            @endif
                @endif
        </div>
    </div>
</section>
<div class="blog-content">
    <div class="container">
        <div class="row">
            @if(empty($page))
                <div class="col-md-12"><h1>@lang('blog.news')</h1></div>
                @else
            <div class="col-md-12"><h1>{{$page->name}}</h1></div>
                @endif
        </div>
    </div>
    <div class="container">
        <nav class="category-list categories-blog ">
            <ul class="row ">
                @foreach($categories as $category)
                    <li class="category-item  category-item-parent col-md col-12{{($page instanceof App\Model\Project\ProjectCategory)?($page->id == $category->id?" active":""):""}}">
                        <a href="{{route('blog.level2',['url' =>  $category->url])}}">{{$category->name}}</a>
                        <ul class="category-projects">
                            @foreach( ($locale == "ru")? $category->projects->reverse() : $category->base->projects->reverse() as $project)
                                @if( !($project->isHide) && $project->lang == $locale && $project->type != 'only-blogger')
                                    <li>
                                        <a href="{{route('blog.level2',[$project->url])}}">{{$project->name}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                @if(isset($lastPost))
                <section class="last-post">
                    <div class="row">
                        @if(($locale == 'ru')? $lastPost->image : $lastPost->base->image)
                        <div class="col-md-6">
                            <img src="{{($locale == 'ru')? $lastPost->image : $lastPost->base->image}}" alt="{{$lastPost->name}}" class="post-preview">
                        </div>
                        @endif
                        <div class="col-md-{{(($locale == 'ru')? $lastPost->image : $lastPost->base->image)?'6':'12'}} last-post-info">
                            <div class="post-name">
                                {{$lastPost->name}}
                            </div>
                            <div class="post-date">{{Carbon::parse($lastPost->created_at)->format('d.m.Y')}}</div>
                            <div class="post-comment-count">{{($locale == "ru")?$lastPost->visible_comments_count:$lastPost->base->visible_comments->count()}}</div>
                            <div class="post-text">
                                {{$lastPost->preview_text}}
                            </div>
                            <a href="{{route('blog.level2',[$lastPost->url])}}" class="post-link">@lang('global.detail')</a>
                        </div>
                    </div>
                </section>

                <section class="blog-list">
                    <div class="col-12">
                        <div class="row" id="ajax-list">
                            @include('blog.include.blog_item')
                        </div>
                    </div>
                    @if($posts->nextPageUrl())
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <button class="load-more">@lang('global.load_more')</button>
                        </div>
                    </div>
                    @endif
                </section>
                @else
                    @lang('blog.post_not_found')
                @endif
            </div>

            <div class="col-lg-4">
                @include('blog.include.sidebar')
            </div>
        </div>
    </div>
</div>



@endsection

