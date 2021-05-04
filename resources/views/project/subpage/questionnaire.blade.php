@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('project_questionnaire',(App::getLocale() !== 'ru')?$project->category->translate->firstWhere('lang', App::getLocale()):$project->category,$project,$base) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-9"><h1 class="button-right">{{$questionnaire->name}}</h1></div>
            <div class="col-lg-3"><a href="{{route('project.level2',$project->url)}}" class="back-project">@lang('project.back_to_project')</a></div>
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

            <form action="{{route('project.questionnaire.send',[$base->id])}}" method="post" class="questionnaire-form">
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
