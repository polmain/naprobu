@extends('layouts.main')
@section('head')
    @if($reviews->previousPageUrl())
        @if($reviews->currentPage() == 2)
            <link rel="prev" href="{{$reviews->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$reviews->previousPageUrl()}}" />
        @endif
    @endif
    @if($reviews->nextPageUrl())
    <link rel="next" href="{{$reviews->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
<section class="breadcrumb-box">
    <div class="container">
        <div class="row">
            @if($page instanceof App\Model\Page)
                {{ Breadcrumbs::render('review') }}
            @else
                {{ Breadcrumbs::render('review_category',$page) }}
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
            <ul class="row ">
                @foreach($categories as $category)
                    <li class="category-item category-item-parent col-md col-12{{($page instanceof App\Model\Project\ProjectCategory)?($page->id == $category->id?" active":""):""}}">
                        <a href="{{route('review.level2',['url' =>  $category->url])}}">{{$category->name}}</a>
                        <ul class="category-projects">
                            @foreach( (($locale == "ru")? $category->projects->reverse() : $category->base->projects->reverse()) as $project)
                                @php
                                    $subpages = ($project->lang == "ru") ? $project->subpages->where('lang','ru')->where('type_id',1)->first() : $project->base->subpages->where('lang',$project->lang)->where('type_id',1)->first();
                                @endphp
                                @if( !($project->isHide) && $subpages && $project->lang == $locale)
                                    <li>
                                        <a href="{{route('project.subpage',[$project->url,$subpages->url])}}">{{$project->name}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <div class="container mb-4">
        <div class="row">
            <div class="col-lg-3 col-sm-6 offset-lg-9 offset-sm-6">
                @include('review.include.review_sort')
            </div>
        </div>
    </div>
    <section class="review-list review-page">
        <div class="container">
            <div class="row" id="ajax-list">
                @include('review.include.review_item')
            </div>
            @if($reviews->nextPageUrl())
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <button class="load-more">@lang('global.load_more')</button>
                </div>
            </div>
            @endif
        </div>
    </section>

@include('review.include.review_comment_success_modal')
@endsection

