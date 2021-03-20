@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
<section class="breadcrumb-box mb-0">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('partner') }}
        </div>
    </div>
</section>
<div class="about-page">
<section class="partner-banner mb-5" style="background-image: url({{ asset( PageBlock::getBlockContent('banner') ) }});"></section>
    <section class="why-this-interesting mb-5">
        <div class="container">
            <h2 class="text-center font-weight-light mb-5">{{  PageBlock::getBlockContent('number_block_top_title') }}<br>
                <strong>{{  PageBlock::getBlockContent('number_block_bottom_title') }}</strong>
            </h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="why-this-interesting-block">
                        <div class="why-this-interesting-block-number">
                            <div class="progress" data-percentage="{{  PageBlock::getBlockContent('number_block_1_procent') }}">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                                <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                                <div class="progress-value">{{  PageBlock::getBlockContent('number_block_1_procent') }}%</div>
                            </div>
                        </div>
                        <div class="why-this-interesting-block-text">
                            {!!   PageBlock::getBlockContent('number_block_1_text') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="why-this-interesting-block">
                        <div class="why-this-interesting-block-number">
                            <div class="progress" data-percentage="{{  PageBlock::getBlockContent('number_block_2_procent') }}">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                                <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                                <div class="progress-value">{{  PageBlock::getBlockContent('number_block_2_procent') }}%</div>
                            </div>
                        </div>
                        <div class="why-this-interesting-block-text">
                            {!!   PageBlock::getBlockContent('number_block_2_text') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="why-this-interesting-block">
                        <div class="why-this-interesting-block-number">
                            <div class="progress" data-percentage="{{  PageBlock::getBlockContent('number_block_3_procent') }}">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                                <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                                <div class="progress-value">{{  PageBlock::getBlockContent('number_block_3_procent') }}%</div>
                            </div>
                        </div>
                        <div class="why-this-interesting-block-text">
                            {!!   PageBlock::getBlockContent('number_block_3_text') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="what-influencer-marketing">
        <h2 class="mb-5">{{ PageBlock::getBlockContent('influencer_marketing_title') }}</h2>
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <p class="text-center fsz-16 fw-600">{{ PageBlock::getBlockContent('influencer_marketing_text') }}</p>
                </div>
            </div>
            <div class="row what-influencer-marketing-list">
                <div class="col-lg-4 mb-3">
                    <div class="what-influencer-marketing-block">
                        <div class="what-influencer-marketing-block-title">{{ PageBlock::getBlockContent('influencer_marketing_1_title') }}</div>
                        <div class="what-influencer-marketing-block-text">
                            {!!   PageBlock::getBlockContent('influencer_marketing_1_text') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="what-influencer-marketing-block">
                        <div class="what-influencer-marketing-block-title">{{ PageBlock::getBlockContent('influencer_marketing_2_title') }}</div>
                        <div class="what-influencer-marketing-block-text">
                            {!!   PageBlock::getBlockContent('influencer_marketing_2_text') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="what-influencer-marketing-block">
                        <div class="what-influencer-marketing-block-title">{{ PageBlock::getBlockContent('influencer_marketing_3_title') }}</div>
                        <div class="what-influencer-marketing-block-text">
                            {!!   PageBlock::getBlockContent('influencer_marketing_3_text') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



<section class="top-jobs-marketing">
    <div class="container">
        <h2 class="text-center font-weight-light mb-5">{{  PageBlock::getBlockContent('top_task_marketing_top_title') }}<br>
            <strong>{{  PageBlock::getBlockContent('top_task_marketing_bottom_title') }}</strong>
        </h2>
        <ul class="top-jobs-marketing-list">
            <li class="col-12 top-jobs-marketing-item">
                <h4>{{  PageBlock::getBlockContent('top_task_marketing_1_title') }}</h4>
                {!! PageBlock::getBlockContent('top_task_marketing_1_text') !!}
            </li>
            <li class="col-12 top-jobs-marketing-item">
                <h4>{{  PageBlock::getBlockContent('top_task_marketing_2_title') }}</h4>
                {!! PageBlock::getBlockContent('top_task_marketing_2_text') !!}
            </li>
            <li class="col-12 top-jobs-marketing-item">
                <h4>{{  PageBlock::getBlockContent('top_task_marketing_3_title') }}</h4>
                {!! PageBlock::getBlockContent('top_task_marketing_3_text') !!}
            </li>
            <li class="col-12 top-jobs-marketing-item">
                <h4>{{  PageBlock::getBlockContent('top_task_marketing_4_title') }}</h4>
                {!! PageBlock::getBlockContent('top_task_marketing_4_text') !!}
            </li>
            <li class="col-12 top-jobs-marketing-item">
                <h4>{{  PageBlock::getBlockContent('top_task_marketing_5_title') }}</h4>
                {!! PageBlock::getBlockContent('top_task_marketing_5_text') !!}
            </li>
        </ul>

    </div>
</section>
<section class="get-question">
    <div class="container-fluid">
        <div class="row">
            <a class="col-sm-6 get-question-button" href="#" data-toggle="modal" data-target="#feedback_form_modal">
                <img src="{{asset('/public/svg/icons/qa.svg')}}" width="200"  alt="">
                <p>@lang('global.ask_question')</p>
            </a>
            <div class="col-sm-6 	d-none d-sm-block get-question-background" style="background-image: url('{!!  asset('/public/images/partner/get-question-background.jpg') !!}')"></div>
        </div>
    </div>
</section>
<section class="partner-cases mb-30">
    <div class="container">
        <h2 class="mb-4">{{  PageBlock::getBlockContent('case_block_title') }}</h2>
        
        <div class="partner-cases-list">
            {!! PageBlock::getBlockContent('case_block_images') !!}
        </div>
        
    </div>
</section>
<section class="our-partners mb-5">
    <div class="container">
        <h2 class="mb-4">{{  PageBlock::getBlockContent('our_partners_block_title') }}</h2>
        <div class="brand-list our-partners-list row">
            @php
                $brc = 1;
            @endphp
            @foreach($brands as $brand)
                <div class="col-md-2  @if($brc == 7 || $brc == 8) d-none d-md-block @else col-4 @endif brand-item brand-item-partner{{($brc == 1)?' active':''}}">
                    <img src="{{asset($brand->logo)}}" alt="{{$brand->name}}">
                    <div class="brand-review">
                        {!! $brand->review !!}
                    </div>
                </div>
                @if($brc++ == 7)
                    <div class="col-md-8 brand-item brand-item-text">
                    </div>
                @endif
                @if($brc == 15)
                    @break
                @endif
            @endforeach
        </div>
    </div>
</section>
    <section class="get-brif">
        <div class="container">
            <form id="brif_form" class="row" method="POST" action="{{route('feedback')}}">
                    @csrf
                <input type="hidden" name="subject" value="Запрос на Бриф">
                <input type="hidden" name="text" value="Запрос на Бриф">

                <div class="col-md-4 mb-3 mb-md-0">
                    <input id="name" type="text" class="form-control" name="name" required placeholder="@lang('contact.name')">
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <input id="email" type="email" class="form-control" name="email" required placeholder="E-mail">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-orange btn-block mb-0">
                        @lang('global.get_brif')
                    </button>
                </div>
            </form>
        </div>
    </section>
    <section class="go-to-project">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <a href="{{route('project')}}" class="btn-orange btn-block mb-0">@lang('global.go_to_project')</a>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="brif_sends" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('modal.brif_message_sends_title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                </button>
            </div>
            <div class="modal-body">
                @lang('modal.brif_message_sends_text')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

