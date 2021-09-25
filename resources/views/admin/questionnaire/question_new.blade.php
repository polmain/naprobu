@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_question_create',['id'=>$questionnaire_id])}}" method="post" enctype="multipart/form-data" class="validation-form">
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
                        <div class="question-item " id="question_{{time()}}" >
                            <input type="hidden" name="question" class="question_id" value="{{time()}}">

                            <div class="question-body">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                                        <input type="text" name="question_name" class="form-control question-name required" placeholder="Введите вопрос...">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос</label>
                                        <input type="text" name="question_name_ua" class="form-control" placeholder="Введите вопрос...">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Вопрос</label>
                                        <input type="text" name="question_name_en" class="form-control" placeholder="Введите вопрос...">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Тип вопроса<span class="input-request">*</span></label>
                                    <select class="form-control required question_type" name="question_type">
                                        <option value="">Выберите тип вопроса</option>
                                        @foreach($questionTypes as $questionType)
                                            <option value="{{$questionType->id}}">{{$questionType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="child-consructor ">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подсказка к вопросу</label>
                                        <input type="text" name="question_help" class="form-control" placeholder="Введите подсказку...">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подсказка к вопросу </label>
                                        <input type="text" name="question_help_ua" class="form-control" placeholder="Введите подсказку...">
                                    </div>
                                    <div class="col-md-4">
                                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Подсказка к вопросу </label>
                                        <input type="text" name="question_help_en" class="form-control" placeholder="Введите подсказку...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal-red" name="question_required" value="true" checked="checked">
                                        Обязательно к заполнению?
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Минимум</label>
                                        <input type="number" class="form-control" name="question_min" min="0">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Максимум</label>
                                        <input type="number" class="form-control" name="question_max" min="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Показывать если</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Вопрос</label>
                                            <select class="form-control" name="relation_questions" id="relation_questions">
                                                @foreach($relation_questions as $relation_question)
                                                    <option value="{{$relation_question->id}}">{{$relation_question->name}}</option>
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
                                    {{--<input type="text" class="form-control" name="question_relation">
                                    <div class="note">укажите здесь id ответа на вопрос, только цифры</div>--}}
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/questionnaire/edit/{{$questionnaire_id}}';">Отмена</button>
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
						$('#question_relation').append('<option value="'+e.id+'">'+e.text+'</option>');
					})
				},
				error:  function(xhr, str){
					console.log('Возникла ошибка: ' + xhr.responseCode);
				}
			});
		});

		$('#relation_questions').change();
    </script>
@endsection
