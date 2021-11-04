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
                    <a class="col-md-6 col-lg-4 project-item" href="{{ $project->url === 'libero-touch'? 'https://liberoam.naprobu.ua/' : route('project.level2',[$project->url])}}">
                        <div class="project-item-image" style="background-image: url({{$project->preview_image}})">
                            @if($project->country && $project->audience->isWord())
                                <div class="project-country">
                                    <img src="/public/images/country/{{strtolower($project->country->getCode())}}.png" alt="{{$project->country->getName()}}">
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
                    @include('review.include.review_item_slide')
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{route('review')}}" class="btn-orange text-center">@lang('home.all_reviews')</a>
            </div>
        </div>
    </section>
    @endif
    @if($posts->count() > 0 && !$international)
    <section class="main-blog">
        <div class="container">
            <h2>{{trans('home.blog_mainpage')}}</h2>
            <div class="row post-list">
                <div class="col-lg-6 mb-lg-0 mb-5">
                    @php
                        $bigPostSetting = $mainPageBlogSettings->firstWhere('name', 'post_1');
                        if($bigPostSetting->value != 0){
                           $post = $mainPagePosts->firstWhere('id', $bigPostSetting->value);
                        } else {
                            $post = null;
                        }
                    @endphp
                    @include('blog.include.big_post',['post' =>  $post?: $posts->first() ])
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
                                @php
                                    $smallPostSetting = $mainPageBlogSettings->firstWhere('name', 'post_'.$i);
                                    if($smallPostSetting->value != 0){
                                       $settingPost = $mainPagePosts->firstWhere('id', $smallPostSetting->value);
                                    } else {
                                        $settingPost = null;
                                    }
                                @endphp
                                @include('blog.include.small_post',['post' =>  $settingPost?: $post ])
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
