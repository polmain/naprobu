<div class="col-md-4">
    <div class="review-item" id="review-{{$review->id}}">
        <a class="review-user" href="{{route('profile',[$review->user->id])}}">
            <div class="user-logo">
                <img src="{{ asset("/public/uploads/images/avatars/".$review->user->avatar) }}" alt="{{$review->user->name}}">
            </div>
            <div class="review-info">
                <div class="user-name">{{$review->user->name}}</div>
                <div class="rang-date"><span class="user-rang"> @if(App::getLocale() == 'ru')
                            {{$review->user->rang->name}}
                        @else
                            {{$review->user->rang->translate->firstWhere('lang', App::getLocale())->name}}
                        @endif
                        @if($review->user->isBlogger())
                            - @lang('user.blogger')
                        @endif</span>, {{$review->created_at}}</div>
            </div>
        </a>
        <div class="review-project">
            Проект
            @if(App::getLocale() == 'ru')
                <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->url])}}">{{$review->subpage->project->name}}</a>
            @else
                @if($review->subpage->project->translate->firstWhere('lang', App::getLocale()))
                    <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->translate->firstWhere('lang', App::getLocale())->url])}}">{{$review->subpage->project->translate->firstWhere('lang', App::getLocale())->name}}</a>
                @endif
            @endif
        </div>
        <div class="review-text">
            {!! $review->text !!}
        </div>
        <a href="{{route('review.level2',['url'=>$review->id])}}" class="read-more">@lang('global.read_more')</a>
        <div class="review-images">
            @if(isset($review->images) || (isset($review->video)  && $review->video != ""))
                @php
                    $i = 0;
                    $max_image = 3;
                @endphp
                @if(isset($review->video)  && $review->video != "")
                    @php
                        $i = 1;
                        $max_image = 2;
                    @endphp
                    <a href="#" class="review-image" data-fancybox="review_{{$review->id}}_video" style="background-image: url('/public/images/youtube.jpg')"  data-src="{{$review->video}}" ></a>
                @endif
                @if(isset($review->images))
                    @foreach($review->images as $image)
                        @if(++$i <= $max_image || count($review->images) <= $max_image)
                            <a class="review-image" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/reviews/{{$image[1]}}" style="background-image: url('/public/uploads/images/reviews/{{$image[0]}}')"></a>
                        @elseif(++$i == 4)
                            <a class="review-image" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/reviews/{{$image[1]}}" style="background-image: url('/public/uploads/images/reviews/{{$image[0]}}')"><div class="more-image">{{count($review->images) - 2}}</div></a>
                        @else
                            <a class="review-image review-image-hidden" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/reviews/{{$image[1]}}"></a>
                        @endif
                    @endforeach
                @endif
            @endif
        </div>
        <div class="review-bottom">
            <div class="review-actions">
                <div class="review-like @auth{{($review->likes->where('user_id',Auth::user()->id)->first())?' active':''}}@else disabled @endauth">
                    @auth
                        <span class="like-count">{{$review->likes->count()}}</span> <span class="like"></span>
                    @else
                        <a href="#" data-toggle="modal" data-target="#login"><span class="like-count">{{$review->likes->count()}}</span> <span class="like"></span></a>
                    @endauth
                </div>
                <div class="review-bookmark @auth{{($review->bookmarks->where('user_id',Auth::user()->id)->first())?' active':''}}@else disabled @endauth">
                    @auth
                        <span class="bookmark-count">{{$review->bookmarks->count()}}</span> <span class="bookmark"></span>
                    @else
                        <a href="#" data-toggle="modal" data-target="#login"><span class="bookmark-count">{{$review->bookmarks->count()}}</span> <span class="bookmark"></span></a>
                    @endauth
                </div>
            </div>
            <div class="review-share">
                <a href="https://www.facebook.com/sharer/sharer.php?u={!!   urlencode(route('review.level2',['url'=>$review->id])) !!}"
                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                   target="_blank" title="Share on Facebook">
                    <span class="facebook-share"></span>
                </a>
            </div>
        </div>
    </div>
</div>
