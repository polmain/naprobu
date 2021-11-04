<a href="{{route('blog.level2',[(App::getLocale() == 'ru')?$post->url:$post->translate->firstWhere('lang', App::getLocale())->url])}}" class="post-small-item">
    <div class="row">
        <div class="col-md-3">
            <div class="post-small-image" style="background-image: url({{$post->image}})"></div>
            <div class="post-small-date">{{Carbon::parse($post->created_at)->format('d.m.Y')}}</div>
        </div>
        <div class="col-md-9">
            <div class="post-small-name">
                @if(App::getLocale() == 'ru')
                    {{$post->name}}
                @else
                    {{$post->translate->firstWhere('lang', App::getLocale())->name}}
                @endif
            </div>
            <div class="post-small-description">
                @if(App::getLocale() == 'ru')
                    {{$post->preview_text}}
                @else
                    {{$post->translate->firstWhere('lang', App::getLocale())->preview_text}}
                @endif
            </div>
            <div class="post-small-bottom">
                <div class="post-small-info">{{$post->visible_comments_count}} {{trans_choice('global.comments',$post->visible_comments_count)}}</div>
                <div class="post-small-info">
                    @if($post->project_id != 0)
                        @if(App::getLocale() == 'ru')
                            {{$post->project->category->name}}
                        @else
                            {{$post->project->category->translate->firstWhere('lang', App::getLocale())->name}}
                        @endif
                    @else
                        @lang('blog.news')
                    @endif
                </div>
                <div class="post-small-info">@lang('global.detail')</div>
            </div>
        </div>
    </div>
</a>
