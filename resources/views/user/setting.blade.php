@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('user_setting') }}
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
                    <div class="col-12">
                        <div class="row">
                        <form method="POST" action="{{ route('user.setting_save') }}" class="form-user-edit-data" enctype="multipart/form-data">
                            @csrf
                                <div class="form-block">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="load-image-container avatar">
                                                    <div class="load-img " style="background-image: url('/public/uploads/images/avatars/{{Auth::user()->avatar}}');"></div>
                                                    <label for="avatar" class="upload-avatar-button">@lang('user.change_avatar')<input type="file" name="avatar" id="avatar"/></label>
                                                    <small class="form-text text-muted" style="display: none">@lang("user.change_avatar_confirm_text")</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="user-page-title user-page-title-ref text-center">
                                                        @lang('user.add_social_network_to_user')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="modal-auth mb-2">
                                                        <a class="auth-social auth-facebook" href="/login/facebook/"><img src="{{asset('public/svg/icons/facebook-white.svg')}}" alt="Facebook Logo"></a>
                                                    </div>
{{--                                                    <div class="modal-auth">--}}
{{--                                                        <a class="auth-social auth-instagram" href="{{route('instagram.user')}}"><img src="{{asset('public/svg/icons/instagram_white.svg')}}" alt="Instagram Logo"></a>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            <div class="form-group mb-30">
                                <label class="form-check">@lang('user.get_notification_to_email')
                                    <input class="form-check-input"  type="checkbox" name="isNewsletter" id="isNewsletter" value="true"{{(Auth::user()->isNewsletter)?" checked=checked":""}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>


                            <div class="col-sm-6 offset-sm-3">
                                <button type="submit" class="btn-orange btn-block mb-0">
                                    @lang("user.setting_submit")
                                </button>
                            </div>
                        </form>
                        </div>
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

