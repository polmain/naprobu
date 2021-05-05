@foreach($posts as $post)
    <div class="col-md-12 blog-item @if($post->project_id == 0)blog-item_news @endif">
        <a class="" href="{{route('blog.level2',[$post->url])}}">
            <div class="row">
                <div class="col-md-3">
                    <div class="blog-image" style="background-image: url('{!!  ($locale == 'ru')? $post->image : $post->base->image!!}')"></div>
                    <div class="blog-date">
                        {{Carbon::parse($post->created_at)->format('d.m.Y')}}
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="blog-item-info">
                        <div class="blog-name">{{$post->name}}</div>
                        <div class="blog-desctiption">{{$post->preview_text}}</div>
                        <div class="blog-bottom">
                            <div class="blog-info blog-item-comment">{{(App::getLocale() == 'ru')?$post->visible_comments_count:$post->base->visible_comments->count()}} {{trans_choice('global.comments',$post->visible_comments_count)}}</div>
                            <div class="blog-info blog-item-project">
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
                            <div class="blog-info blog-item-detail">@lang('global.detail')</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
