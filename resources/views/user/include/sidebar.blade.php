<aside class="sidebar-user">
    <div class="user-page-block text-center">
        <div class="user-avatar"><img src="{{asset('/public/uploads/images/avatars/'.Auth::user()->avatar)}}" alt="{{Auth::user()->name}}"></div>
        <div class="user-name">{{Auth::user()->name}}</div>
        <div class="user-rang">
            @if(App::getLocale() == 'ru')
                {{Auth::user()->rang->name}}
            @else
                {{Auth::user()->rang->translate->firstWhere('lang', App::getLocale())->name}}
            @endif
        </div>
    </div>
    <div class="user-page-block">
        <div class="user-page-block-title">
            @lang('user.user_id')
        </div>
        <div class="user-page-block-value">
            {{Auth::user()->id}}
        </div>
    </div>
    <div class="user-page-block">
        <div class="user-page-block-title">
            @lang('user.user_likes')
        </div>
        <div class="user-page-block-value user-page-block-value-orange">
            {{$userLikes}} <img src="{{asset('/public/svg/icons/like_full.svg')}}" height="14" width="14" alt="Like">
        </div>
    </div>
</aside>
