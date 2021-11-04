<a class="post-big" href="{{route('blog.level2',[(App::getLocale() == 'ru')?$post->url:$post->translate->firstWhere('lang', App::getLocale())->url])}}">
    <div class="post-big-image" style="background-image: url({{$post->image}})">

    </div>
    <div class="post-big-info">
        @if(App::getLocale() == 'ru')
            <div class="post-big-name">
                {{$post->name}}
            </div>
            <div class="post-big-description">
                {{$post->preview_text}}
            </div>
        @else
            <div class="post-big-name">
                {{$post->translate->firstWhere('lang', App::getLocale())->name}}
            </div>
            <div class="post-big-description">
                {{$post->translate->firstWhere('lang', App::getLocale())->preview_text}}
            </div>
        @endif
        <div class="row align-items-center post-big-bottom">
            <div class="col">
                <div class="post-big-date">{{Carbon::parse($post->created_at)->format('d.m.Y')}}</div>
            </div>
            <div class="col text-right">
                <div class="post-big-link">@lang('global.detail')</div>
            </div>
        </div>
    </div>
</a>
