@extends('layouts.main')
@section('head')
    @if($notifications->previousPageUrl())
        @if($notifications->currentPage() == 2)
            <link rel="prev" href="{{$notifications->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$notifications->previousPageUrl()}}" />
        @endif
    @endif
    @if($notifications->nextPageUrl())
        <link rel="next" href="{{$notifications->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('user_notification') }}
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

                <section class="user-content mb-4">
                    <div class="notification-list mb-4" id="ajax-list">
                        @include("user.include.notification_page")
                    </div>
                    @if($notifications->nextPageUrl())
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <button class="load-more mb-0">@lang('global.load_more')</button>
                        </div>
                    </div>
                    @endif
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

