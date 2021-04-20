@foreach($questions as $question)
    @php
        $translate = $question->translate->firstWhere('lang', $locale);
    @endphp

    @if($locale == "ru" || $translate)
        <div class="form-group {{($question->question_relation_id > 0)?"relation-question relation-question_".$question->question_relation_id:"" }}" id="question_group_{{$question->id}}"{!! ($question->question_relation_id > 0)?" relation-question='".$question->question_relation_id."'":""  !!}>
            <label class="question_title {{($question->required == 1)?" required-title":"" }}" for="question_{{$question->id}}">{{($locale == "ru")? $question->name : $translate->name}}</label>
            @switch($question->type_id)
                @case(1)
                <input id="question_{{$question->id}}" type="text" class="form-control{{($question->required == 1)?" required":"" }}" {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} name="question_{{$question->id}}">
                @break
                @case(2)
                <textarea id="question_{{$question->id}}" class="form-control{{($question->required == 1)?" required":"" }}"  {!! ($question->restrictions["min"])?'valid-min="'.$question->restrictions["min"].'"':'' !!} {!! ($question->restrictions["max"])?'valid-max="'.$question->restrictions["max"].'"':'' !!} rows="5" name="question_{{$question->id}}"></textarea>
                @break
                @case(3)
                @foreach($question->options->sortBy('sort') as $option)
                    @if($option->type_id == 7 && ($locale == "ru" || $option->translate->firstWhere('lang', $locale)))
                        <label class="form-check">{{($locale == "ru")? $option->name : $option->translate->firstWhere('lang', $locale)->name}}
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
                    @if($option->type_id == 7 && ($locale == "ru" || $option->translate->firstWhere('lang', $locale)))
                        <label class="form-check">{{($locale == "ru")? $option->name : $option->translate->firstWhere('lang', $locale)->name}}
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
                        @if($option->type_id == 7 && ($locale == "ru" || $option->translate->firstWhere('lang', $locale)))
                            <option id="option_{{$option->id}}" value="{{$option->id}}">{{($locale == "ru")?
                                            $option->name :
                                            $option->translate->firstWhere('lang', $locale)->name}}</option>
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
            @if(isset($question->help) && $question->help != "" && ($locale == "ru" || $translate))
                <button type="button" class="btn btn-secondary question-help" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{!!  preg_replace(array("/\r\n/", "/\r/", "/\n/"), ' &#xa; ',  $locale == "ru"? $question->help : $translate->help)!!}">
                    ?
                </button>
            @endif
        </div>
    @endif
@endforeach
