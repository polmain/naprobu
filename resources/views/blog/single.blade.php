@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-0">
        <div class="container">
            <div class="row">
                {{ ($post->project_id != 0)? Breadcrumbs::render('blog_single',(App::getLocale() == 'ru')?$post->project->category:$post->project->category->translate->firstWhere('lang',App::getLocale()),$post): Breadcrumbs::render('blog_single_news',$post) }}
            </div>
        </div>
    </section>
    <div class="blog-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h1>{{$post->name}}</h1></div>
            </div>
        </div>
        <div class="container">
            <nav class="category-list categories-blog ">
                <ul class="row ">
                    @foreach($categories as $category)
                        <li class="category-item  category-item-parent col{{ ($post->project_id != 0)?($post->project->category->id == $category->id?" active":""):'' }}">
                            <a href="{{route('blog.level2',['url' =>  $category->url])}}">{{$category->name}}</a>
                            <ul class="category-projects">
                                @foreach( ($locale == "ru")? $category->projects->reverse() : $category->base->projects->reverse() as $project)
                                    @if( !($project->isHide) && $project->lang == $locale)
                                        <li>
                                            <a href="{{route('blog.level2',[$project->url])}}">{{$project->name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-single-container">
                        <div class="blog-header">
                            @if($post->project_id != 0)
                                @if($locale == "ru")
                                    <div class="blog-project">@lang('blog.project'): <a href="{{route('project.level2',[$post->project->url])}}">{{$post->project->name}}</a></div>
                                @else
                                    @if($post->project->translate->firstWhere('lang', $locale))
                                    <div class="blog-project">@lang('blog.project'): <a href="{{route('project.level2',[$post->project->translate->firstWhere('lang', $locale)->url])}}">{{$post->project->translate->firstWhere('lang', $locale)->name}}</a></div>
                                    @endif
                                @endif
                            @else
                                <div class="blog-project">@lang('blog.news')</div>
                            @endif

                                <div class="blog-date-author">
                                <div class="blog-date">{{Carbon::parse($post->created_at)->format('d.m.Y')}}</div>
                                <div class="blog-author">@lang('blog.author'): <a href="{{route('blog.level2',[$post->author->name])}}">{{$post->author->name}}</a></div>
                            </div>
                        </div>
                        @if(($locale == "ru")? $post->image : $post->base->image)
                        <img src="{{($locale == "ru")? $post->image : $post->base->image}}" alt="{{$post->name}}" class="post-image">
                        @endif
                        <div class="blog-text">
                            {!!  $post->content !!}
                        </div>
                        <div class="blog-bottom">
                            <div class="blog-tag">
                                <div class="blog-tag-title">@lang('blog.tags'):</div><div class="blog-tag-list">@foreach($base->tags as $tag) @if($locale == "ru")<a href="{{route('blog.level2',[$tag->url])}}" class="blog-tag-item">{{$tag->name}}</a>@else @if($tag->translate->firstWhere('lang', $locale))<a href="{{route('blog.level2',[$tag->translate->firstWhere('lang', $locale)->url])}}" class="blog-tag-item">{{$tag->translate->firstWhere('lang', $locale)->name}}</a>@endif @endif @endforeach</div>
                            </div>
                            <div class="blog-share">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={!!   urlencode(route('blog.level2',['url'=>$post->url])) !!}"
                                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                   target="_blank" title="@lang('global.facebook_share')">
                                    @lang('global.facebook_share')
                                </a>
                            </div>
                        </div>
                        <div class="blog-comment">
                            <div class="blog-comment-header">{{$base->visible_comments_count}} {{trans_choice('global.comments',$base->visible_comments_count)}}</div>
                            <div class="blog-comment-list">
                                @foreach($base->visible_comments as $comment)
                                    @if($comment->status_id != 3)
                                <div class="blog-comment-item">
                                    <div class="comment-blog-header">
                                        <a class="comment-user" href="{{route('profile',[$comment->user->id])}}">
                                            <div class="user-avatar">
                                                <img src="{{ asset("/public/uploads/images/avatars/".$comment->user->avatar) }}" alt="{{$comment->user->name}}">
                                            </div>
                                            <div class="user-info">
                                                <div class="user-name">{{$comment->user->name}}</div>
                                                @if(App::getLocale() == 'ru')
                                                    <div class="user-role">{{$comment->user->rang->name}}</div>
                                                @else
                                                    <div class="user-role">{{$comment->user->rang->translate->firstWhere('lang', App::getLocale())->name}}</div>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="comment-date">
                                            {{Carbon::parse($comment->created_at)->format('d.m.Y')}}
                                        </div>
                                    </div>

                                    <div class="comment-text">
                                        {{$comment->text}}
                                    </div>
                                </div>
                                    @endif
                                @endforeach
                            </div>
                            @auth
                                <form class="blog-comment-form" action="{{route('blog.comment.create',['post_id'=>$base->id])}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="mb-3">
                                        <div class="blog-comment-form-header">@lang('blog.comment_form_header')</div>
                                        <textarea class="form-control" name="text" id="comment_text" cols="30" rows="5" placeholder="@lang('blog.comment_form_text_placeholder')"></textarea>
                                    </div>
                                    <div class="recaptcha-container mb-3">
                                        <div class="g-recaptcha" data-sitekey="6LeAUsAUAAAAAB9d9NaItHRkVJehXCNMsst70vKf"></div>
                                        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                                    </div>
                                    <button type="submit">@lang('blog.comment_form_submit')</button>
                                </form>
                            @else
                                <div class="blog-comment-n_auth">
                                    @lang('review.comment-n_auth') <a href="#" data-toggle="modal" data-target="#login">@lang('review.comment-n_auth_link')</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('blog.include.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('review.include.review_comment_success_modal')
@endsection

