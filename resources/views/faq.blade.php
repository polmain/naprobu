@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('faq') }}
        </div>
    </div>
</section>
<div class="faq-page">


<div class="container mb-4">
    <div class="row">
        <div class="col-md-12"><h1 class="mb-0 text-center">{{$page->name}}</h1></div>
    </div>
</div>

    <section class="faq-category">
        <div class="container">
            <div class="row">
                @php($i=0)
                @foreach($faqCategories as $faqCategory)
                <div class="faq-category-item col {{(0 == $i++)?'active':''}}" id="faq-category-{{$faqCategory->id}}">
                    <div class="faq-category-item-img" style="background-image: url('{{$faqCategory->image}}')"></div>
                    <div class="faq-category-item-text">{{ (App::getLocale() == 'ru')? $faqCategory->name : $faqCategory->translate->name }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="faq-category-questions">
        <div class="container">
                @php($i=0)
                @foreach($faqCategories as $faqCategory)
                    <div class="faq-category-question-container {{(0 == $i++)?'active':''}}" id="faq-category-{{$faqCategory->id}}-questions">
                        @foreach($faqCategory->questions as $question)
                        <div class="faq-category-question-item">
                           @if(App::getLocale() == 'ru')
                               <div class="faq-category-question-item-question">{{$question->question}}</div>
                               <div class="faq-category-question-item-answer">{!!  $question->answer !!}</div>
                           @else
                                <div class="faq-category-question-item-question">{{$question->translate->question}}</div>
                                <div class="faq-category-question-item-answer">{!! $question->translate->answer !!}</div>
                           @endif
                        </div>
                        @endforeach
                    </div>
                @endforeach
        </div>
    </section>
</div>
@endsection

