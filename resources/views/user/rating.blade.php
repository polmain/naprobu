@extends('layouts.main')
@section('head')
    @if($userRatings->previousPageUrl())
        @if($userRatings->currentPage() == 2)
            <link rel="prev" href="{{$userRatings->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$userRatings->previousPageUrl()}}" />
        @endif
    @endif
    @if($userRatings->nextPageUrl())
        <link rel="next" href="{{$userRatings->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('user_rating') }}
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

                <section class="user-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="user-page-block">
                                <div class="user-page-block-title">
                                    @lang('user.user_rating_count')
                                </div>
                                <div class="user-page-block-value">
                                    {{Auth::user()->history->sum('score')}} {{Lang::choice('user.rating_point',Auth::user()->history->sum('score'))}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 rating-scale">
                        <div class="row">
                            @include("user.include.rating_scale")
                        </div>
                    </div>
                    <div class="rating-history">
                        <div class="user-page-title">
                            @lang('user.rating_history')
                        </div>

                        <div class="rating-history-list" id="ajax-list">
                            @include("user.include.rating_item")
                        </div>
                        @if($userRatings->nextPageUrl())
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

