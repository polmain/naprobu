@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('archive') }}
        </div>
    </div>
</section>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12"><h1>{{$page->name}}</h1></div>
    </div>
</div>
<section class="archive-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-11">
                        <h2>@lang('archive.projects')</h2>
                        <ul class="list-unstyled">
                            @php
                                $year = 0;
                            @endphp
                            @foreach($projects as $project)
                                @if(Carbon::parse($project->start_registration_time)->year != $year )
                                    <li class="archive-year">{{$year=Carbon::parse($project->start_registration_time)->year}}</li>
                                @endif
                                <li>
                                    - <a href="{{route('project.level2',[$project->url])}}">{{$project->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-11 offset-md-1">
                        <h2>@lang('archive.posts')</h2>
                        <ul class="list-unstyled">
                            @php
                                $year = 0;
                            @endphp
                            @foreach($posts as $post)
                                @if(Carbon::parse($post->created_at)->year != $year )
                                    <li class="archive-year">{{$year=Carbon::parse($post->created_at)->year}}</li>
                                @endif
                                <li>
                                    - <a href="{{route('blog.level2',[$post->url])}}">{{$post->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

