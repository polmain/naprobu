@extends('layouts.main')
@section('head')
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
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('user_project') }}
        </div>
    </div>
</section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6  col-sm-8 offset-sm-2 offset-md-3 offset-lg-0">
                @include("user.include.sidebar")
            </div>
            <div class="col-lg-9">

                @include('user.include.cabinet_menu')

                <section class="project-list">
                    <div class="container">
                        <div class="row" id="ajax-list">
                            @include('project.include.project_item_user')
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


                <div class="user-page-block text-center">
                    <div class="user-page-title user-page-title-ref">
                        @lang('user.user_ref')
                    </div>
                    <div class="user-page-ref">
                        {{route('user.ref',[Auth::user()->id])}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

