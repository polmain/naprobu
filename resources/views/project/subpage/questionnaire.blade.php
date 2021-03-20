@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('project_questionnaire',(App::getLocale() == 'ua')?$project->category->translate:$project->category,$project,$base) }}
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
                @foreach($questions as $question)
                    <div class="form-group {{($question->question_relation_id > 0)?"relation-question relation-question_".$question->question_relation_id:"" }}" id="question_group_{{$question->id}}"{!! ($question->question_relation_id > 0)?" relation-question='".$question->question_relation_id."'":""  !!}>

                        <label class="question_title {{($question->required == 1)?" required-title":"" }}" for="question_{{$question->id}}">{{($locale == "ru")? $question->name : $question->translate->name}}</label>
                        @switch($question->type_id)
                            @case(1)
                                <input id="question_{{$question->id}}" type="text" class="form-control{{($question->required == 1)?" required":"" }}" {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} name="question_{{$question->id}}">
                            @break
                            @case(2)
                                <textarea id="question_{{$question->id}}" class="form-control{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} rows="5" name="question_{{$question->id}}"></textarea>
                            @break
                            @case(3)
                                @foreach($question->options->sortBy('sort') as $option)
                                    @if($option->type_id == 7)
                                    <label class="form-check">{{($locale == "ru")? $option->name : $option->translate->name}}
                                        <input class="form-check-input{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} type="radio" name="question_{{$question->id}}" id="option_{{$option->id}}" value="{{$option->id}}">
                                        <span class="checkmark"></span>
                                    </label>
                                    @endif
                                @endforeach
                                @if($option = $question->options->where('type_id',9)->first())
                                    <label class="form-check">@lang('questionnaire.other')
                                        <input class="form-check-input other-answer{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} type="radio" name="question_{{$question->id}}" id="option_{{$option->id}}" value="{{$option->id}}">
                                        <span class="checkmark"></span>
                                    </label>

                                    <input id="question_{{$option->id}}" type="text" class="form-control other-answer-input" name="question_{{$option->id}}">
                                @endif
                            @break
                            @case(4)
                                @foreach($question->options->sortBy('sort')  as $option)
                                    @if($option->type_id == 7)
                                    <label class="form-check">{{($locale == "ru")? $option->name : $option->translate->name}}
                                        <input class="form-check-input{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} type="checkbox" name="question_{{$question->id}}[]" id="option_{{$option->id}}" value="{{$option->id}}">
                                        <span class="checkmark"></span>
                                    </label>
                                    @endif
                                @endforeach
                                @if($option = $question->options->where('type_id',9)->first())
                                    <label class="form-check">@lang('questionnaire.other')
                                        <input class="form-check-input other-answer" type="checkbox" name="question_{{$question->id}}[]" id="option_{{$option->id}}" value="{{$option->id}}">
                                        <span class="checkmark"></span>
                                    </label>

                                    <input id="question_{{$option->id}}" type="text" class="form-control other-answer-input" name="question_{{$option->id}}">
                                @endif
                            @break
                            @case(5)
                                <select name="question_{{$question->id}}" class="form-control{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} id="question_{{$question->id}}">
                                    <option value=""></option>
                                    @foreach($question->options->sortBy('sort') as $option)
                                        @if($option->type_id == 7)
                                        <option id="option_{{$option->id}}" value="{{$option->id}}">{{($locale == "ru")?
                                        $option->name :
                                        $option->translate->name}}</option>
                                        @endif
                                    @endforeach
                                    @if($option = $question->options->where('type_id',9)->first())
                                        <option class="other-answer" value="{{$option->id}}">@lang('questionnaire.other')</option>
                                    @endif
                                </select>
                                @if($option = $question->options->where('type_id',9)->first())
                                    <input id="question_{{$option->id}}" type="text" class="form-control other-answer-input" name="question_{{$option->id}}">
                                @endif
                            @break
                            @case(8)
                                <input id="question_{{$question->id}}" type="number" class="form-control{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} name="question_{{$question->id}}">
                            @break
                            @case(10)
                                <input id="question_{{$question->id}}" type="date" class="form-control{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} name="question_{{$question->id}}">
                            @break
                        @endswitch
                        @if(isset($question->help) && $question->help != "")
                        <button type="button" class="btn btn-secondary question-help" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{!!  preg_replace(array("/\r\n/", "/\r/", "/\n/"), ' &#xa; ',  $question->help)!!}">
                            ?
                        </button>
                        @endif
                    </div>
                @endforeach
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