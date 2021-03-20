@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <section class="breadcrumb-box mb-5">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('password_recover') }}
            </div>
        </div>
    </section>
    <div class="registration-page">
        <div class="container mb-30">
            <div class="row">
                <div class="col-md-12 text-center"><h1 class="mb-0">{{$page->name}}</h1></div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="E-mail">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="@lang("registration.password")">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="@lang("registration.password_confirmation")">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn-orange btn-block mb-0">
                                @lang('passwords.password_reset_submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
