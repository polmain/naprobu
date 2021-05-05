<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-4 order-1 logo">
                @if(Request::route())
                    @if(\Request::route()->getName() == 'home')
                        <img src="{{asset('/public/svg/naprobu-logo.svg')}}" alt="Лого Na-proby">
                    @else
                        <a href="{{route('home')}}"><img src="{{asset('/public/svg/naprobu-logo.svg')}}" alt="Лого Na-proby"></a>
                        @endif
                @else
                    <a href="{{route('home')}}"><img src="{{asset('/public/svg/naprobu-logo.svg')}}" alt="Лого Na-proby"></a>
                @endif
            </div>
            <div class="col-lg-5 col-md-1 col-2 order-lg-2 order-4 menu-container">
                <div class="menu-burger">
                </div>
                <nav class="header-menu">
                    @include('include.header_menu', ['items' => $HeaderMenu->roots()])
                </nav>
            </div>
            <div class="col-lg-5 col-md-7 col-6 offset-md-1 order-3 offset-lg-0">
                <div class="row position-relative">
                    <div class="col-md-2 col-2 header-search">
                        <div>Search</div>
                    </div>
                    <div class="col-md-2 col-3 lang">
                        <div class="current-lang"><img src="{{asset('public/svg/icons/'.App::getLocale().'.svg')}}" class="lang-flag" alt="{{App::getLocale()}}"/><span>{{strtoupper(App::getLocale())}}</span></div>
                        <div class="other-lang" style="display: none; height: {{100 * count($alternativeUrls)}}%">
                            @foreach(\Config::get('app.locales') as $lang)
                                @if((App::getLocale() !== $lang && isset($alternativeUrls[$lang]) && $lang !== 'en') || ($lang === 'en' && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator'))))
                                <a class="other-lang-item" href="{{$alternativeUrls[$lang]}}"><img src="{{asset('public/svg/icons/'.$lang.'.svg')}}" class="lang-flag" alt="{{$lang}}"/><span>{{strtoupper($lang)}}</span></a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @auth
                        <div class="col-md-2 col-3 auth-header user-notification">
                            @php($notifications = Request::get('userNotification'))
                            @if($notifications)
                                @if($notifications->isNotEmpty())
                                    <div class="user-notification-icon{{($notifications->first()->isNew)?' active':''}}">
                                        @if($notifications->first()->isNew)
                                            <img src="{{asset('/public/svg/icons/notify-active.svg')}}" alt="Notify" width="20" height="20">
                                        @else
                                            <img src="{{asset('/public/svg/icons/notify.svg')}}" alt="Notify" width="20" height="20">
                                        @endif
                                    </div>
                                    <div class="user-notification-list">
                                        @php($i = 1)
                                        @foreach($notifications as $notification)
                                            @include('user.include.notification')
                                            @if(++$i > 5)
                                                <div class="notification-item text-center notification-more">
                                                    <a href="{{route('user.notification')}}">@lang('user.all_notification')</a>
                                                </div>
                                                @break
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="user-notification-icon"><img src="{{asset('/public/svg/icons/notify.svg')}}" alt="Notify" width="20" height="20"></div>
                                    <div class="user-notification-list">
                                        <div class="notification-item text-center">
                                            @lang('user.empty')
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-6 col-3 auth-header user-header">
                                <div class="user-avatar"><img src="{{asset('/public/uploads/images/avatars/'.Auth::user()->avatar)}}" alt="{{Auth::user()->name}}"></div>
                                <div class="user-name">{{Auth::user()->name}}</div>
                            <nav class="user-header-menu">
                                <a href="{{ route('user.cabinet') }}">@lang('user.profile_link')</a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    @lang('user.exit')
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </nav>

                        </div>
                    @else
                            <a href="#" class="col-md-4 col-3 auth-header" data-toggle="modal" data-target="#login">
                                <div class="auth-modal-show autrorization-header">@lang('header.login')</div>
                            </a>

                            <a href="{{route('registration')}}" class="col-md-4 col-3 auth-header">
                                <div class="auth-modal-show registration-header">@lang('header.registration')</div>
                            </a>
                        {{--                            <a href="#" class="col-md-4 col-3 auth-header" data-toggle="modal" data-target="#registration">--}}
{{--                                <div class="auth-modal-show registration-header">@lang('header.registration')</div>--}}
{{--                            </a>--}}
                    @endauth
                </div>
            </div>

        </div>
    </div>
</header>

<div class="search-block ui search">
    <div class="container ui input">
        <form action="{{route('search')}}" method="GET">
            @csrf
            <button type="submit" class="search-btn"></button>
            <input class="prompt search-input" id="live_search" type="text" name="name" placeholder="@lang('search.placeholder_search')">
        </form>
    </div>
    <div class="search-result">
        <div class="container">
            <div id="live_search_result" class="row">

            </div>
        </div>
    </div>


</div>
