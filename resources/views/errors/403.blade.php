@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="error-number">
                403
            </div>
            <div class="error-text">
                @lang('page_message.403_text')
            </div>
        </div>
    </div>

    <section class="main-projects error-project">
        <div class="container">
            <h2 class="text-center">{{StringTranslate::translate('last_project_mainpage')}}</h2>
            <div class="row project-list">
                @foreach($projects  as  $project)
                    <a class="col-md-6 col-lg-4 project-item" href="{{route('project.level2',[$project->url])}}">
                        <div class="project-item-image" style="background-image: url({{(App::getLocale() == 'ru')?$project->preview_image:$project->base->preview_image}})">

                        </div>
                        <div class="project-item-info">
                            <div class="project-item-name">{{$project->name}}</div>
                            <div class="project-item-date">{{Carbon::parse($project->start_registration_time)->format('d.m.Y')}}</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{route('project')}}" class="btn-orange text-center">@lang('home.all_projects')</a>
            </div>
        </div>
    </section>
@endsection