<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    {!! SEO::generate() !!}

    <meta content="{{csrf_token()}}" name="csrf-token">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{{ asset('public/favicon.ico') }}}">
    <link href="{{ asset("/public/css/app.min.css")}}?v=1.2.1" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    @foreach($alternativeUrls as $lang => $alternet_url)
        <link rel="alternate" href="{{$alternet_url}}" hreflang="{{ $lang }}" />
    @endforeach

    @yield('head')

    <script src="{{ asset("/public/js/adriver.core.2.js")}}" ></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- Facebook Pixel Code -->
    <script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window,document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '2322802264650799');
		fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=2322802264650799&ev=PageView
&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M9NHR9R');</script>
    <!-- End Google Tag Manager -->
    <script charset="UTF-8" src="//cdn.sendpulse.com/js/push/b48a6079ac0072c301321ef62e162254_1.js" async></script>
    <meta name="google-site-verification" content="BvggnO6NVND8oMj9BNV-yVHaQlPkiopHJTd1urn4evc" />
</head>
<body @yield('body.attr')>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9NHR9R"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@include('layouts.header')

<div class="content-container">
    @yield('content')
</div>
@include('layouts.footer')

<ul class="social-links-fixed">
    <li class="facebook-fixed">
        <a href="https://www.facebook.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/facebook.svg')}}" alt="Facebook"></a>
    </li>
    <li class="telegram-fixed">
        <a href="https://t.me/naprobu_ua" target="_blank"><img src="{{asset('public/svg/icons/telegram.svg')}}" alt="Telegram"></a>
    </li>
    <li class="instagram-fixed">
        <a href="https://www.instagram.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/instagram.svg')}}" alt="Instagram"></a>
    </li>
</ul>

<div class="to-up"></div>

<!-- Messenger Плагин чата Code -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v10.0'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ru_RU/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Your Плагин чата code -->
<div class="fb-customerchat"
     attribution="page_inbox"
     page_id="255194487920301">
</div>
@auth
    @if(!env('APP_DEBUG', false))
    <div class="push-container">

    </div>
    @endif
@else

    <div class="modal fade modal-auth" id="login" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('modal.auth_name')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}" id="auth_form">
                        @csrf
                        <input type="hidden" name="lang" value="{{ App::getLocale()}}">
                        <div class="error-message">

                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" required placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="@lang('modal.password_placeholder')">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <label class="form-check">@lang('modal.remember_me')
                                    <input class="form-check-input" type="checkbox" name="remember">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="d-none">login</button>
                                <button type="button" class="btn-blue btn-block" id="btn_login">
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
                            {{--
                            <div class="col-6">
                                <a class="auth-social auth-instagram" href="/login/instagram/"><img src="{{asset('public/svg/icons/instagram_white.svg')}}" alt="Instagram Logo"></a>
                            </div>
                            --}}
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-auth" id="registration" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('modal.registration_name')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}" id="register_form">
                        @csrf
                        <input type="hidden" name="lang" value="{{ App::getLocale()}}">
                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="@lang('modal.nickname')">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="@lang('modal.make_passord')">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('modal.repeat_passord')">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-12">
                                <p class="text-center small-text">
                                    {!!  trans('modal.user_agreement',['url' => route('simple',['legal'])]) !!}
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn-blue btn-block mb-0">
                                    @lang('modal.registration_button')
                                </button>
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
                            {{--
                            <div class="col-6">
                                <a class="auth-social auth-instagram" href="/login/instagram/"><img src="{{asset('public/svg/icons/instagram_white.svg')}}" alt="Instagram Logo"></a>
                            </div>
                            --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="adriver_banner_361480379"></div>
    <script type="text/javascript">
		new adriver("adriver_banner_361480379", {sid:222433, bt:52, bn:9});
		var panels = [
				{swf: '0.swf', width: '400', height: '400', x: '0.5', y: '0.5', abs_x: '0', abs_y: '0', wmode: 'transparent'},
				{swf: '1.swf', width: '400', height: '400', x: '1', y: '0', abs_x: '0', abs_y: '0', wmode: 'opaque'}
			],
			ar_flashver		= '8',
			ar_zeropixel	= '';
		/*------- no edit -------*/

		var a = adriver("adriver_banner_361480379", {sid:222433, bt:52, bn:9});

		new adriver.Plugin.require(	"pixel.adriver", "functions.adriver", "checkFlash.adriver",
			"makeFlash.adriver", "animate.adriver").onLoadComplete(function(){
			a.onDomReady(function(){
				a.sendPixel(ar_zeropixel);

				if (a.hasFlash(ar_flashver)) {
					for(var i=0; i<panels.length; i++){
						var o = panels[i];
						adriver.animate.richMedia(a,
							a.addDiv(document.body, {zIndex: 65000, position: 'absolute', visibility: 'hidden',
									left: a.normalize(o.abs_x), top: a.normalize(o.abs_y), width:a.normalize(o.width), height:a.normalize(o.height)},
								a.makeFlash(o.swf, {flashvars: {richId: i}, wmode: o.wmode})),
							o.x, o.y);
					}
					a.panels[0].start(true);
				}

				a.loadComplete();
			})
		});
    </script>
    <script>
        var password_confirmation = "@lang('auth.password_confirmation')"
    </script>
@endauth

    <script>
		var registerValidate = {
			required: '{!!  trans('registration.required') !!}',
			minlength: '{!!  trans('registration.minlength') !!}',
			maxlength: '{!!  trans('registration.maxlength') !!}',
			email: '{!!  trans('registration.email') !!}',
			isName: '{!!  trans('registration.isName') !!}',
			isEmail: '{!!  trans('registration.isEmail') !!}',
			equalTo: '{!!  trans('registration.equalTo') !!}',
		}
    </script>
    <div class="modal fade" id="feedback_form_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('modal.feedback_name')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="feedback_form" action="{{route('feedback')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="error-message">

                        </div>
                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="@lang('modal.your_name')">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="@lang('modal.your_email')">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject"  placeholder="@lang('modal.subject')">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-md-12">
                                <textarea name="text" class="form-control" cols="30" rows="5" placeholder="@lang('modal.your_message')" required></textarea>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-md-12 text-center">
                                <div class="g-recaptcha" data-sitekey="6LeAUsAUAAAAAB9d9NaItHRkVJehXCNMsst70vKf"></div>
                                <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn-modal-submit">@lang('modal.send')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="feedback_sends" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('modal.message_sends_title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    @lang('modal.message_sends_text')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="social_subscribe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('modal.social_subscribe_header')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="social-modal">
                        <li class="facebook-modal">
                            <a href="https://www.facebook.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/facebook.svg')}}" alt="Facebook"> <span>Facebook</span></a>
                        </li>
                        <li class="telegram-modal">
                            <a href="https://t.me/naprobu_ua" target="_blank"><img src="{{asset('public/svg/icons/telegram.svg')}}" alt="Telegram"> <span>Telegram</span></a>
                        </li>
                        <li class="instagram-modal">
                            <a href="https://www.instagram.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/instagram.svg')}}" alt="Instagram"> <span>Instagram</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
		var feedbackValidate = {
			required:  "@lang('validation.required')",
			recaptcha:  "@lang('validation.recaptcha')",
			maxlength: "@lang('validation.maxlength')",
			email: "@lang('validation.email')",
		};

		var readMore = {
			more: "@lang('global.read_more')",
			less: "@lang('global.read_less')",
        };

        var purecookie = {
            title: "@lang('global.purecookieTitle')",
            desc: "@lang('global.purecookieDesc')",
            link: '@lang('global.purecookieLink')',
            button: "@lang('global.purecookieButton')",
        };

    </script>
    <script src="{{ asset ("/public/js/app.min.js") }}?v=1.2.4" type="text/javascript"></script>
@yield('scripts')
</body>
</html>
