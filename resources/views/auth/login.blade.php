@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-5">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('login') }}
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
            <div class="row justify-content-center  modal-auth">
                <div class="col-md-6">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-mail"  value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang('modal.password_placeholder')" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <label class="form-check">@lang('modal.remember_me')
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-8 offset-sm-2">
                                <button type="submit" class="btn-orange btn-block mb-0">
                                    @lang('modal.auth_button')
                                </button>
                                @if (Route::has('password.request'))
                                    <p class="text-center">
                                        <a class="btn btn-link " href="{{ route('password.request') }}">
                                            @lang('modal.remember_password')
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-block-title">
                                <span>@lang('modal.or')</span>
                            </div>
                        </div>
                        <div class="row auth-social-container">
                            <div class="col-12">
                                <a class="auth-social auth-facebook" href="/login/facebook/"><img src="{{asset('public/svg/icons/facebook-white.svg')}}" alt="Facebook Logo"></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
