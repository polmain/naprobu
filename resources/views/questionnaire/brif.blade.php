@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('partner.brif',$questionnaire) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-9"><h1 class="button-right">{{$questionnaire->name}}</h1></div>
        </div>
    </div>
    @if( isset($questionnaire->text) && $questionnaire->text !== '')
        <section class="subpage-text">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="subpage-text-container">
                            {!! $questionnaire->text !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <form action="{{route('partner.brif_send')}}" method="post" class="questionnaire-form">
                        @csrf
                        @include('questionnaire.questions')
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn-orange btn-block mb-0">
                                @lang('questionnaire.submit')
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <script>
		var questionnaireValidate = {
			required: "@lang('questionnaire.required')",
			min_chars: "@lang('questionnaire.min_chars')",
			max_chars: "@lang('questionnaire.max_chars')",
			min_numb: "@lang('questionnaire.min_numb')",
			max_numb: "@lang('questionnaire.max_numb')",
			min_check: "@lang('questionnaire.min_check')",
			max_check: "@lang('questionnaire.max_check')",
		}
    </script>
@endsection