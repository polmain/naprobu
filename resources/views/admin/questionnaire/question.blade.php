@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_question_save',['id'=>$question->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Вопросы анкеты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="question-item " id="question_{{$question->id}}" >
                            <input type="hidden" name="question" class="question_id" value="{{$question->id}}">

                            <div class="question-body">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                                        <input type="text" name="question_name" class="form-control question-name required" placeholder="Введите вопрос..." value="{{$question->name}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос</label>
                                        <input type="text" name="question_name_ua" class="form-control" placeholder="Введите вопрос..." value="{{($question->translate->firstWhere('lang','ua'))?$question->translate->firstWhere('lang','ua')->name:""}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Вопрос</label>
                                        <input type="text" name="question_name_en" class="form-control" placeholder="Введите вопрос..." value="{{($question->translate->firstWhere('lang','en'))?$question->translate->firstWhere('lang','en')->name:""}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Тип вопроса<span class="input-request">*</span></label>
                                    <select class="form-control required question_type" name="question_type">
                                        <option value="">Выберите тип вопроса</option>
                                        @foreach($questionTypes as $questionType)
                                            <option value="{{$questionType->id}}"{{($question->type_id == $questionType->id)?" selected=selected ":""}}>{{$questionType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="child-consructor @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)active @endif">
                                        @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)
                                            <label class="child-contructor-title">Варианты ответов</label>
                                            <div class="list-answers list-child list-sort">
                                                @foreach($question->options->sortBy("sort") as $child)
                                                    @if($child->rus_lang_id === 0 && $child->type_id === 7)
                                                        <div class="form-group form-child-item row item-sort bg-default">
                                                            <input type="hidden" name="question_{{$question->id}}_children_id[]" value="{{$child->id}}">
                                                            <div class="col-md-3">
                                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Значение варианта ответа<span class="input-request">*</span></label>
                                                                <input type="text" name="question_children_question_{{$question->id}}[]" class="form-control required" placeholder="Введите вариант ответа..." value="{{$child->name}}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Значение варианта ответа</label>
                                                                <input type="text" name="question_children_ua_question_{{$question->id}}[]" class="form-control" placeholder="Введите вариант ответа..." value="{{($child->translate->firstWhere('lang','ua'))?$child->translate->firstWhere('lang','ua')->name:""}}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Значение варианта ответа</label>
                                                                <input type="text" name="question_children_en_question_{{$question->id}}[]" class="form-control" placeholder="Введите вариант ответа..." value="{{($child->translate->firstWhere('lang','en'))?$child->translate->firstWhere('lang','en')->name:""}}">
                                                            </div>
                                                            <div class="col-md-3">
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
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подсказка к вопросу</label>
                                        <input type="text" name="question_help" class="form-control" placeholder="Введите подсказку..." value="{{$question->help}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подсказка к вопросу </label>
                                        <input type="text" name="question_help_ua" class="form-control" placeholder="Введите подсказку..." value="{{($question->translate->firstWhere('lang','ua'))?$question->translate->firstWhere('lang','ua')->help:""}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Подсказка к вопросу </label>
                                        <input type="text" name="question_help_en" class="form-control" placeholder="Введите подсказку..." value="{{($question->translate->firstWhere('lang','en'))?$question->translate->firstWhere('lang','en')->help:""}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal-red" name="question_required" value="true" {{($question->required)?" checked=checked ":""}}>
                                        Обязательно к заполнению?
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Минимум</label>
                                        <input type="number" class="form-control" name="question_min" min="0" value="{{$question->restrictions["min"]}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Максимум</label>
                                        <input type="number" class="form-control" name="question_max" min="0" value="{{$question->restrictions["max"]}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Показывать если</label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Вопрос</label>
                                            <select class="form-control" name="relation_questions" id="relation_questions">
                                                @foreach($relation_questions as $relation_question)
                                                    <option value="{{$relation_question->id}}"  {!! $question_relation?($question_relation->parent == $relation_question->id?'selected="selected"':''):'' !!} >{{$relation_question->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Вариант ответа</label>
                                            <select class="form-control" name="question_relation" id="question_relation">
                                                <option value="0">Не привязан</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-3">
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Действия</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/questionnaire/edit/{{$question->questionnaire_id}}';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->


@endsection

@section('scripts')
    <script>
		$('#relation_questions').change(function (e) {
			var route = '{{route('adm_question_find')}}'+$(this).val();
			var baseSelect = {{$question->question_relation_id}};

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "GET",
				url: route,
				success: function(resp)
				{
					$('#question_relation').html('<option value="0">Не привязан</option>');
					resp.forEach(function (e) {
						$('#question_relation').append('<option value="'+e.id+'" '+(baseSelect == e.id?'selected="selected"':'')+'>'+e.text+'</option>');
					})
					baseSelect = 0;
				},
				error:  function(xhr, str){
					console.log('Возникла ошибка: ' + xhr.responseCode);
				}
			});
		});

		$('#relation_questions').change();
    </script>
@endsection
