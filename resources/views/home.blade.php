@extends('layouts.main')
@section('head')
    @foreach($alternativeUrls as $lang => $alternet_url)
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{ $lang }}" />
    @endforeach
@endsection
@section('content')
<div class="home-page">
    <section class="banner">
        <div class="container">
            <h1><strong class="orange-text">{{trans('home.independent_testing')}}</strong><br>
                {{trans('home.famous_brands')}}</h1>
            @auth
                @if(Auth::user()->hasRole('expert'))
                    <div class="row banner-action">
                        <div class="expert-steps col-lg-12">
                            <div class="row">
                                <div class="expert-step col-sm-4">
                                    <div class="image-container">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_1.svg')}}" alt="{{trans('home.sign_up_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.sign_up_mainpage')}}</p>
                                </div>
                                <div class="expert-step col-sm-4">
                                    <div class="image-container image-container-bottom">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_2.svg')}}" alt="{{trans('home.test_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.test_mainpage')}}</p>
                                </div>
                                <div class="expert-step col-sm-4">
                                    <div class="image-container">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_3.svg')}}" alt="{{trans('home.share_your_opinion_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.share_your_opinion_mainpage')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row banner-action">
                        <div class="expert-steps col-lg-9">
                            <div class="row">
                                <div class="expert-step col-sm-4">
                                    <div class="image-container">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_1.svg')}}" alt="{{trans('home.sign_up_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.sign_up_mainpage')}}</p>
                                </div>
                                <div class="expert-step col-sm-4">
                                    <div class="image-container image-container-bottom">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_2.svg')}}" alt="{{trans('home.test_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.test_mainpage')}}</p>
                                </div>
                                <div class="expert-step col-sm-4">
                                    <div class="image-container">
                                        <div class="img-circle"></div>
                                        <img src="{{asset('public/svg/main/step_3.svg')}}" alt="{{trans('home.share_your_opinion_mainpage')}}">
                                    </div>
                                    <p>{{trans('home.share_your_opinion_mainpage')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-10 offset-1 offset-sm-3 offset-lg-0 go-to-expert mb-3">
                            <a href="{{route('user.cabinet')}}" class="go-to-expert-link">{{trans('home.become_expert_mainpage')}}</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="row banner-action">
                    <div class="expert-steps col-lg-9">
                        <div class="row">
                            <div class="expert-step col-sm-4">
                                <div class="image-container">
                                    <div class="img-circle"></div>
                                    <img src="{{asset('public/svg/main/step_1.svg')}}" alt="{{trans('home.sign_up_mainpage')}}">
                                </div>
                                <p>{{trans('home.sign_up_mainpage')}}</p>
                            </div>
                            <div class="expert-step col-sm-4">
                                <div class="image-container image-container-bottom">
                                    <div class="img-circle"></div>
                                    <img src="{{asset('public/svg/main/step_2.svg')}}" alt="{{trans('home.test_mainpage')}}">
                                </div>
                                <p>{{trans('home.test_mainpage')}}</p>
                            </div>
                            <div class="expert-step col-sm-4">
                                <div class="image-container">
                                    <div class="img-circle"></div>
                                    <img src="{{asset('public/svg/main/step_3.svg')}}" alt="{{trans('home.share_your_opinion_mainpage')}}">
                                </div>
                                <p>{{trans('home.share_your_opinion_mainpage')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-10 offset-1 offset-sm-3 offset-lg-0 go-to-expert mb-3">
                        <a href="{{route('registration')}}" class="go-to-expert-link">{{trans('home.become_expert_mainpage')}}</a>
                    </div>
                </div>
            @endauth
        </div>
        <div class="banner-image-container container">
            <img class="banner-image" src="{{asset('public/svg/banner_image.svg')}}" alt="Кафе">
        </div>
    </section>
    <section class="main-projects">
        <div class="container">
            <h2>{{trans('home.last_project_mainpage')}}</h2>
            <div class="row project-list">
                @foreach($projects  as  $project)
                    <a class="col-md-6 col-lg-4 project-item" href="{{route('project.level2',[$project->url])}}">
                        <div class="project-item-image" style="background-image: url({{$project->preview_image}})">
                            @if($project->country && $project->audience->isWord())
                                <div class="project-country">
                                    <img src="{{$project->country->getFlag()}}" alt="{{$project->country->getName()}}">
                                </div>
                            @endif
                        </div>
                        <div class="project-item-info">
                            <div class="project-item-name">{{$project->name}}</div>
                            <div class="project-item-date">{{Carbon::parse($project->start_registration_time)->format('d.m.Y')}}</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{route('project')}}" class="btn-orange text-center">@lang('home.all_projects')</a>
            </div>
        </div>
    </section>
    <section class="who-we">
        <div class="container">
            <h2>{{trans('home.number_block_title')}}</h2>
            <div class="row ">
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="number numscroller" data-min='0' data-max='{{Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('2010-10-01')) }}' data-delay='1' data-increment='1'>0</div>
                    <div class="number-title">{!! trans('home.year_number_title') !!}</div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="number numscroller" data-min='0' data-max='{{$project_count}}' data-delay='5' data-increment='{{$project_count/15}}'>0</div>
                    <div class="number-title">{!! trans('home.project_number_title') !!}</div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="number numscroller" data-min='0' data-max='{{$review_count}}' data-delay='1' data-increment='{{$review_count/200}}'>0</div>
                    <div class="number-title">{!! trans('home.review_number_title') !!}</div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="number numscroller" data-min='0' data-max='{{$expert_count}}' data-delay='10' data-increment='{{$expert_count/200}}'>0</div>
                    <div class="number-title">{!! trans('home.expert_number_title') !!}</div>
                </div>
            </div>
        </div>
    </section>
    @if(!$international)
    <section class="main-reviews">
        <div class="container">
            <h2>{{trans('home.current_reviews_mainpage')}}</h2>
            <div class="review-list">
                @foreach($reviews as $review)
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
                                                {{$review->user->rang->translate->name}}
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
                                <div class="review-like @auth{{($review->likes->where('user_id',Auth::user()->id)->first())?' active':''}}@else disabled @endauth">
                                    @auth
                                        <span class="like-count">{{$review->likes->count()}}</span> <span class="like"></span>
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#login"><span class="like-count">{{$review->likes->count()}}</span> <span class="like"></span></a>
                                            @endauth
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
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{route('review')}}" class="btn-orange text-center">@lang('home.all_reviews')</a>
            </div>
        </div>
    </section>
    @endif
    @if($posts->count() > 0)
    <section class="main-blog">
        <div class="container">
            <h2>{{trans('home.blog_mainpage')}}</h2>
            <div class="row post-list">
                <div class="col-lg-6 mb-lg-0 mb-5">
                    <a class="post-big" href="{{route('blog.level2',[(App::getLocale() == 'ru')?$posts->first()->url:$posts->first()->translate->firstWhere('lang', App::getLocale())->url])}}">
                        <div class="post-big-image" style="background-image: url({{$posts->first()->image}})">

                        </div>
                        <div class="post-big-info">
                            @if(App::getLocale() == 'ru')
                            <div class="post-big-name">
                                {{$posts->first()->name}}
                            </div>
                            <div class="post-big-description">
                                {{$posts->first()->preview_text}}
                            </div>
                            @else
                                <div class="post-big-name">
                                    {{$posts->first()->translate->firstWhere('lang', App::getLocale())->name}}
                                </div>
                                <div class="post-big-description">
                                    {{$posts->first()->translate->firstWhere('lang', App::getLocale())->preview_text}}
                                </div>
                            @endif
                            <div class="row align-items-center post-big-bottom">
                                <div class="col">
                                    <div class="post-big-date">{{Carbon::parse($posts->first()->created_at)->format('d.m.Y')}}</div>
                                </div>
                                <div class="col text-right">
                                    <div class="post-big-link">@lang('global.detail')</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 ">
                    <div class="d-flex align-content-between flex-wrap post-small-list" >
                        @php
                        $i=0;
                        @endphp
                        @foreach($posts as $post)
                            @if($i++ == 0)
                                @continue
                            @endif
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
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{route('blog')}}" class="btn-orange text-center">@lang('home.all_posts')</a>
            </div>
        </div>
    </section>
    @endif
    <section class="main-our-clients">
        <div class="container">
            <h2>{{trans('home.partners_mainpage')}}</h2>
            <div class="brand-list row">
                @foreach($brands as $brand)
                    <div class="col-md-2 brand-item">
                        <img src="{{asset($brand->logo)}}" alt="{{$brand->name}}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection

{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $('.content-container').load('https://naprobu.ua/inc/page15043753.html');--}}
{{--    </script>--}}
{{--@endsection--}}
