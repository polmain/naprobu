@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('about') }}
        </div>
    </div>
</section>
<div class="about-page">


<div class="container mb-4">
    <div class="row">
        <div class="col-md-12"><h1 class="mb-0">{{$page->name}}</h1></div>
    </div>
</div>
<section class="about-banner mb-5" style="background-image: url({{ asset( PageBlock::getBlockContent('banner') ) }});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div class="banner-text">
                    <div class="banner-top-text text-right ">
                        {{ PageBlock::getBlockContent('banner_top_text') }}
                    </div>
                    <div class="banner-bottom-text text-right">
                        {{ PageBlock::getBlockContent('banner_bottom_text') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="causes">
    <div class="container">
        <h2 class="text-center font-weight-light sm-5">{{ PageBlock::getBlockContent('can_block_title_top') }}<br>
            <strong>{{ PageBlock::getBlockContent('can_block_title_bottom') }}</strong>
        </h2>
        <div class="row cause-list">
            <div class="col-xl col-md-4 text-center">
                <div class="cause text-center">
                    <img src="{{asset(PageBlock::getBlockContent('can_block_1_icon'))}}" alt="{{ strip_tags(PageBlock::getBlockContent('can_block_1_text')) }}" style="height: 120px; margin-bottom: 20px;">
                    <div class="cause-text">
                        {!! PageBlock::getBlockContent('can_block_1_text') !!}
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 text-center">
                <div class="cause text-center"><img src="{{asset(PageBlock::getBlockContent('can_block_2_icon'))}}" alt="{{ strip_tags(PageBlock::getBlockContent('can_block_2_text')) }}" style="margin-top: 10px;">
                    <div class="cause-text">
                        {!! PageBlock::getBlockContent('can_block_2_text') !!}
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 text-center">
                <div class="cause text-center"><img src="{{asset(PageBlock::getBlockContent('can_block_3_icon'))}}" alt="{{ strip_tags(PageBlock::getBlockContent('can_block_3_text')) }}" style="margin-top: 10px;">
                    <div class="cause-text">
                        {!! PageBlock::getBlockContent('can_block_3_text') !!}
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 offset-md-2 offset-xl-0 text-center">
                <div class="cause text-center"><img src="{{asset(PageBlock::getBlockContent('can_block_4_icon'))}}" alt="{{ strip_tags(PageBlock::getBlockContent('can_block_4_text')) }}" style="height: 120px; margin-bottom: 20px;">
                    <div class="cause-text">
                        {!! PageBlock::getBlockContent('can_block_4_text') !!}
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 text-center">
                <div class="cause text-center"><img src="{{asset(PageBlock::getBlockContent('can_block_5_icon'))}}" alt="{{ strip_tags(PageBlock::getBlockContent('can_block_5_text')) }}" style="height: 120px; margin-bottom: 20px;">
                    <div class="cause-text">
                        {!! PageBlock::getBlockContent('can_block_5_text') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-5 banner-registration">
    <div class="container">
        <div class="banner" style="background-image: url({{ asset('/public/images/about/banner-2.jpg') }});">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6 col-10 offset-0 offset-sm-1 offset-lg-1">
                    <div class="go-to-expert">
                        <a href="{{route('registration')}}" class="go-to-expert-link">@lang('global.expert_register')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="our-expert">
    <h2 class="mb-5">{!! PageBlock::getBlockContent('expert_block_title') !!}</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6 mb-30">
                <div class="our-expert-image our-expert-image-h2" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_1_image')) }});"></div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-30">
                <div class="our-expert-image our-expert-image-h2" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_2_image')) }});"></div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-30">
                <div class="row">
                    <div class="col-sm-6 mb-30">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_3_image')) }});"></div>
                    </div>
                    <div class="col-sm-6 mb-30">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_4_image')) }});"></div>
                    </div>
                    <div class="col-12">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_5_image')) }});"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="row">
                    <div class="col-sm-6 mb-30">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_6_image')) }});"></div>
                    </div>
                    <div class="col-sm-6 mb-30">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_7_image')) }});"></div>
                    </div>
                    <div class="col-12">
                        <div class="our-expert-image our-expert-image-h1" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_8_image')) }});"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="our-expert-image our-expert-image-h2" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_9_image')) }});"></div>
            </div>
            <div class="col-lg-5 col-sm-6">
                <div class="our-expert-image our-expert-image-h2" style="background-image: url({{ asset(PageBlock::getBlockContent('expert_10_image')) }});"></div>
            </div>
        </div>
    </div>
</section>

    <section class="mb-5">
        <div class="banner-review banner" style="background-image: url({{ asset('/public/images/about/banner-3.jpg') }});">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-6 col-10 offset-1 offset-sm-3 offset-lg-4 go-to-expert">
                        <a href="{{route('review')}}" class="go-to-expert-link">@lang('global.read_review')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="main-our-clients">
        <div class="container">
            <h2>{{PageBlock::getBlockContent('brend_block_title')}}</h2>
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

@section('scripts')
    @if(App::getLocale() === 'en')
        <script>
            $('.content-container').load('https://naprobu.ua/inc/about_us_eng/page19888448.html');
        </script>
    @else
        <script>
            $('.content-container').load('https://naprobu.ua/inc/about_us/page16203292.html');
        </script>
    @endif
@endsection
