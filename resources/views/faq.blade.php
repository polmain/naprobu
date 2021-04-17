@extends('layouts.main')
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
                    @if((App::getLocale() == 'ru') || $faqCategory->translate->firstWhere('lang', App::getLocale()))
                        <div class="faq-category-item col {{(0 == $i++)?'active':''}}" id="faq-category-{{$faqCategory->id}}">
                            <div class="faq-category-item-img" style="background-image: url('{{$faqCategory->image}}')"></div>
                            <div class="faq-category-item-text">{{ (App::getLocale() == 'ru')? $faqCategory->name : $faqCategory->translate->firstWhere('lang', App::getLocale())->name }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <section class="faq-category-questions">
        <div class="container">
                @php($i=0)
                @foreach($faqCategories as $faqCategory)
                    @if((App::getLocale() == 'ru') || $faqCategory->translate->firstWhere('lang', App::getLocale()))
                        <div class="faq-category-question-container {{(0 == $i++)?'active':''}}" id="faq-category-{{$faqCategory->id}}-questions">
                            @foreach($faqCategory->questions as $question)
                                @if((App::getLocale() == 'ru') || $question->translate->firstWhere('lang', App::getLocale()))
                                    <div class="faq-category-question-item">
                                       @if(App::getLocale() == 'ru')
                                           <div class="faq-category-question-item-question">{{$question->question}}</div>
                                           <div class="faq-category-question-item-answer">{!!  $question->answer !!}</div>
                                       @else
                                            <div class="faq-category-question-item-question">{{$question->translate->firstWhere('lang', App::getLocale())->question}}</div>
                                            <div class="faq-category-question-item-answer">{!! $question->translate->firstWhere('lang', App::getLocale())->answer !!}</div>
                                       @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
        </div>
    </section>
</div>
@endsection

