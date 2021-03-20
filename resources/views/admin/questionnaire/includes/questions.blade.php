@foreach($questions as $question)
    <div class="question-item " id="question_{{$question->id}}" >
        <input type="hidden" name="question[{{$question->id}}]" class="question_id" value="{{$question->id}}">
        <div class="question-header">
            <div class="row">
                <div class="col-md-11">
                    <div class="drag-zone">
                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                    </div>
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    <span class="question-title">{{$question->name}}</span>
                </div>
                <div class="col-md-1 text-right">
                    <i class="fa fa-times delete-question" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="question-body" style="display: none">
            <div class="form-group row">
                <div class="col-md-6">
                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                    <input type="text" name="question_name[{{$question->id}}]" class="form-control question-name required" placeholder="Введите вопрос..." value="{{$question->name}}">
                </div>
                <div class="col-md-6">
                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос<span class="input-request">*</span></label>
                    <input type="text" name="question_name_ua[{{$question->id}}]" class="form-control required" placeholder="Введите вопрос..." value="{{($question->translate)?$question->translate->name:""}}">
                </div>
            </div>

            <div class="form-group">
                <label>Тип вопроса<span class="input-request">*</span></label>
                <select class="form-control required question_type" name="question_type[{{$question->id}}]">
                    <option value="">Выберите тип вопроса</option>
                    @foreach($questionTypes as $questionType)
                        <option value="{{$questionType->id}}"{{($question->type_id == $questionType->id)?" selected=selected ":""}}>{{$questionType->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="child-consructor active">
                    @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)
                        <label class="child-contructor-title">Варианты ответов</label>
                        <div class="list-answers list-child list-sort">
                            @foreach($question->options->sortBy("sort") as $child)
                                @if($child->rus_lang_id == 0 && $child->type_id == 7)
                                    <div class="form-group form-child-item row item-sort bg-default">
                                        <input type="hidden" name="question_{{$question->id}}_children_id[]" value="{{$child->id}}">
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Значение варианта ответа<span class="input-request">*</span></label>
                                            <input type="text" name="question_children_question_{{$question->id}}[]" class="form-control required" placeholder="Введите вариант ответа..." value="{{$child->name}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Значение варианта ответа<span class="input-request">*</span></label>
                                            <input type="text" name="question_children_ua_question_{{$question->id}}[]" class="form-control required" placeholder="Введите вариант ответа..." value="{{($child->translate)?$child->translate->name:""}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="child-other" style="margin-top: 25px">
                                                <input type="checkbox" class="minimal-red other" name="oldChildrenHide_{{$child->id}}" value="true" {{($child->isHide)?" checked=checked":""}}>
                                                Не отображать
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="btn btn-danger btn-block delete-child-ajax" id="delete-{{$child->id}}" style="margin-top: 25px">Удалить вариант</div>
                                        </div>
                                        <div class="col-md-12">id: <input type="text" value="{{$child->id}}" readonly></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div><div class="btn btn-default add-varrible">Добавить вариант</div>
                            <label class="child-other">
                                <input type="checkbox" class="minimal-red other" name="question_{{$question->id}}_other" value="true" {{(!empty($question->options->where('type_id',9)->first()))?" checked=checked":""}}>
                                Добавить вариант другое?
                            </label>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подсказка к вопросу</label>
                    <input type="text" name="question_help[{{$question->id}}]" class="form-control" placeholder="Введите подсказку..." value="{{$question->help}}">
                </div>
                <div class="col-md-6">
                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подсказка к вопросу </label>
                    <input type="text" name="question_help_ua[{{$question->id}}]" class="form-control" placeholder="Введите подсказку..." value="{{($question->translate)?$question->translate->help:""}}">
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" class="minimal-red" name="question_required[{{$question->id}}]" value="true" {{($question->required)?" checked=checked ":""}}>
                    Обязательно к заполнению?
                </label>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Минимум</label>
                    <input type="number" class="form-control" name="question_min[{{$question->id}}]" min="0" value="{{$question->restrictions["min"]}}">
                </div>
                <div class="form-group col-md-6">
                    <label>Максимум</label>
                    <input type="number" class="form-control" name="question_max[{{$question->id}}]" min="0" value="{{$question->restrictions["max"]}}">
                </div>
            </div>
            <div class="form-group">
                <label>Показывать если</label>
                <input type="text" class="form-control" name="question_relation[{{$question->id}}]" value="{{($question->question_relation_id != 0)?$question->question_relation_id:""}}">
                <div class="note">укажите здесь id ответа на вопрос, только цифры</div>
            </div>
        </div>
    </div>
@endforeach