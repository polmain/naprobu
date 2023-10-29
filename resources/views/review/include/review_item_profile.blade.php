@foreach($reviews as $review)
    <div class="col-md-12 review-item" id="review-{{$review->id}}">
        <div class="review-header">
            @if(App::getLocale() == 'ru')
                <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->url])}}">{{$review->subpage->project->name}}</a>
            @else
                @if($review->subpage->project->translate->firstWhere('lang', App::getLocale()))
                    <a class="review-project-name" href="{{route('project.level2',[$review->subpage->project->translate->firstWhere('lang', App::getLocale())->url])}}">{{$review->subpage->project->translate->firstWhere('lang', App::getLocale())->name}}</a>
                @endif
            @endif

            <div class="review-date">{{Carbon::parse($review->created_at)->format('H:i d.m.Y')}}</div>
        </div>
        <div class="review-content">
            <a class="review-user" href="{{route('profile',[$review->user->id])}}">
                <div class="user-avatar">
                    <img src="{{ asset("/public/uploads/images/avatars/".$review->user->avatar) }}" alt="{{$review->user->name}}">
                </div>
                <div class="user-info">
                    <div class="user-name">{{$review->user->name}}</div>
                    @if(App::getLocale() == 'ru')
                        <div class="user-role">{{$review->user->rang->name}} @if($review->user->isBlogger()) - @lang('user.blogger') @endif </div>
                    @else
                        <div class="user-role">{{$review->user->rang->translate->firstWhere('lang', App::getLocale())->name}} @if($review->user->isBlogger()) - @lang('user.blogger') @endif </div>
                    @endif
                </div>
            </a>

            @if(isset($review->name))
                <h4>{{$review->name}}</h4>
            @endif
            <div class="review-text" id="review-{{$review->id}}-text">
                @if(isset($review->images) || (isset($review->video)  && $review->video != ""))
                    <div class="review-images float-right">
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
                                    <a class="review-image" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/reviews/{{$image[1]}}" style="background-image: url('/public/uploads/images/reviews/{{$image[0]}}')"><div class="more-image">{{count($review->images) - 2}}+</div></a>
                                @else
                                    <a class="review-image review-image-hidden" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/reviews/{{$image[1]}}"></a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
                    {!!  $review->text!!}
            </div>
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
            <div class="review-comment-button">
                <span class="comments"></span> {{ Lang::choice('review.comment_count', $review->visibleComments->count(), ['count'=>$review->visibleComments->count()])}}
            </div>
            <div class="review-share">
                 <a href="https://www.facebook.com/sharer/sharer.php?u={!!   urlencode(route('review.level2',['url'=>$review->id])) !!}"
                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                   target="_blank" title="@lang('global.facebook_share')">
                    @lang('global.facebook_share')
                </a>

            </div>
        </div>
        <div class="review-comment" style="display: none">
            <div class="review-comment-list">
                @php
                    $i = 0;
                @endphp
                @foreach($review->visibleComments as $comment)
                    <div id="comment-{{$comment->id}}" class="review-comment-item"{!! (++$i < 3)?"":" style='display: none;'" !!}>
                        <a class="comment-user" href="{{route('profile',[$comment->user->id])}}">
                            <div class="user-avatar">
                                <img src="{{ asset("/public/uploads/images/avatars/".$comment->user->avatar) }}" alt="{{$comment->user->name}}">
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{$comment->user->name}}</div>
                                @if(App::getLocale() == 'ru')
                                    <div class="user-role">{{$comment->user->rang->name}} @if($comment->user->isBlogger()) - @lang('user.blogger') @endif </div>
                                @else
                                    <div class="user-role">{{$comment->user->rang->translate->firstWhere('lang', App::getLocale())->name}} @if($comment->user->isBlogger()) - @lang('user.blogger') @endif </div>
                                @endif
                            </div>
                        </a>
                        <div class="comment-text" {!! ($comment->reply_comment_id != 0)?'data-reply_id="'.$comment->reply_comment_id.'"':'' !!}>
                            {{$comment->text}}
                        </div>
                        @auth
                            <a class="comment-reply" data-comment_id="{{$comment->id}}" href="#">@lang('review.comment_reply')</a>
                        @endauth
                    </div>
                    @if($i==3)
                        <div class="more-comment">{{ Lang::choice('review.comment_more_count', $review->visibleComments->count()-2, ['count'=>$review->visibleComments->count()-2])}}</div>
                    @endif
                @endforeach
            </div>
            @auth
                <form class="review_comment_form" action="{{route('review.comment.create',['review_id'=>$review->id])}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="reply_id" value="0">
                    <input type="text" name="text" placeholder="@lang('review.comment_placeholder')">
                    <button type="submit" ></button>
                </form>
            @else
                <div class="review-comment-n_auth">
                    @lang('review.comment-n_auth') <a href="#" data-toggle="modal" data-target="#login">@lang('review.comment-n_auth_link')</a>
                </div>
            @endauth
        </div>
    </div>
@endforeach
