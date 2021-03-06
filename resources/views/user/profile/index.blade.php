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
<section class="breadcrumb-box mb-4 mb-lg-5 ">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('profile',$user) }}
        </div>
    </div>
</section>
<section class="profile-top mb-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-6 offset-xl-3 offset-lg-2 profile-user mb-3">
                <div class="user-avatar"><img src="{{asset('/public/uploads/images/avatars/'.$user->avatar)}}" alt="{{$user->name}}"></div>
                <div class="user-name">{{$user->name}}</div>
                <div class="user-rang">
                    @if(App::getLocale() == 'ru')
                        {{$user->rang->name}}
                    @else
                        {{$user->rang->translate->firstWhere('lang', App::getLocale())->name}}
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                <div class="profile-block profile-block-review">@lang('profile.review') {{$user->name}}</div>
                <a href="{{route('profile.comment',[$user->id])}}" class="profile-block profile-block-comment">@lang('profile.comment') {{$user->name}}</a>
                <div class="profile-block profile-block-like">
                    <div class="profile-block-title">
                        @lang('user.user_likes')
                    </div>
                    <div class="profile-block-value">
                        {{$userLikes}} <img src="{{asset('/public/svg/icons/like_full.svg')}}" height="14" width="14" alt="Like">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="profile-review review-list review-page">
        <div class="container">
            <div class="row" id="ajax-list">
                @include('review.include.review_item_profile')
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
@endsection

