<aside class="blog-sidebar">
    <div class="sidebar-block last-projects">
        <div class="sidebar-header">@lang('blog.last_project')</div>
        @foreach($sidebar['projects'] as $project)
            <a href="{{route('project.level2',[$project->url])}}" class="sidebar-content">
                @if( null !== $project->preview_image)
                    <img src="{{$project->preview_image}}" alt="{{$project->name}}">
                @endif
                <div class="sidebar-title">{{$project->name}}</div>
            </a>
            <div class="sidebar-footer">
                <a href="{{route('project.level2',[$project->url])}}" class="sidebar-more-link">@lang('blog.project_deteil')</a>
            </div>
        @endforeach
    </div>
    <div class="sidebar-block blog-news">
            <div class="sidebar-footer">
                <a href="{{route('blog.level2',['news'])}}" class="sidebar-more-link">@lang('blog.news')</a>
            </div>
    </div>
    <div class="sidebar-block popular-tag">
        <div class="sidebar-header">@lang('blog.popular_tag')</div>
        <div class="sidebar-content blog-tag-list massonry-list">
            @foreach($sidebar['tags'] as $tag)
                <a href="{{route('blog.level2',[(App::getLocale() == 'ru')?$tag->url:$tag->translate->url])}}" class="blog-tag-item" data-count="{{$tag->posts_count}}">{{(App::getLocale() == 'ru')?$tag->name:$tag->translate->name}}</a>
            @endforeach
        </div>
    </div>
    <div class="sidebar-block sidebar-review-list">
        <div class="sidebar-header">@lang('blog.last_reviews')</div>
        @foreach($sidebar['reviews'] as $review)
        <div class="sidebar-content sidebar-review-item">
            <a class="review-user" href="{{route('profile',[$review->user->id])}}">
                <div class="user-avatar">
                    <img src="{{ asset("/public/uploads/images/avatars/".$review->user->avatar) }}" alt="{{$review->user->name}}">
                </div>
                <div class="user-info">
                    <div class="user-name">{{$review->user->name}}</div>
                    @if(App::getLocale() == 'ru')
                        <div class="user-role">{{$review->user->rang->name}}</div>
                    @else
                        <div class="user-role">{{$review->user->rang->translate->name}}</div>
                    @endif
                </div>
            </a>
            <div class="review-date">{{Carbon::parse($review->created_at)->format('d.m.Y')}}</div>
            @if(App::getLocale() == 'ru')
                <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->url])}}">{{$review->subpage->project->name}}</a>
            @else
                @if($review->subpage->project->translate)
                    <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->translate->url])}}">{{$review->subpage->project->translate->name}}</a>
                @endif
            @endif
            <div class="review-text">
                {!! $review->text !!}
            </div>
        </div>
        @endforeach
    </div>
</aside>
