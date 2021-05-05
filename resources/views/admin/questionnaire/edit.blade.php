@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_questionnaire_save',['questionnaire_id'=>$questionnaire->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры анкеты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название анкеты<span class="input-request">*</span></label>
                                <input type="text" id="name" name="name" class="form-control required" value="{{$questionnaire->name}}" placeholder="Введите название анкеты...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название анкеты</label>
                                <input type="text" id="nameUA" name="nameUA" class="form-control" placeholder="Введите название анкеты..." value="{{($translate->firstWhere('lang', 'ua'))?$translate->firstWhere('lang', 'ua')->name:""}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название анкеты</label>
                                <input type="text" id="nameEN" name="nameEN" class="form-control" placeholder="Введите название анкеты..." value="{{($translate->firstWhere('lang', 'en'))?$translate->firstWhere('lang', 'en')->name:""}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Тип анкеты<span class="input-request">*</span></label>
                            <select class="form-control required" name="questionnaire_type" id="questionnaire_type">
                                <option value="">Выберите тип анкеты</option>
                                @foreach($questionnaireTypes as $questionnaireType)
                                    <option value="{{$questionnaireType->id}}" {{($questionnaire->type_id == $questionnaireType->id)?" selected=selected ":""}}>{{$questionnaireType->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group select-project" {!!  ($questionnaire->type_id == 1)?' style="display: none;"':""!!}>
                            <label>Проект<span class="input-request">*</span></label>
                            <select class="form-control select2" name="project_id" id="questionnaire_type">
                                <option value="">Выберите проект</option>
                                @foreach($projects->reverse() as $project)
                                    <option value="{{$project->id}}"{{($questionnaire->project_id == $project->id)?" selected=selected ":""}}>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#tab_3-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                    <li><a href="#tab_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#tab_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Описание анкеты</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1-1">
                                        <textarea class="editor" id="text" name="text" rows="10" cols="80">{{$questionnaire->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2-2">
                                        <textarea class="editor" id="textUA" name="textUA" rows="10" cols="80">{{($translate->firstWhere('lang', 'ua'))?$translate->firstWhere('lang', 'ua')->text : ''}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3-3">
                                        <textarea class="editor" id="textEN" name="textEN" rows="10" cols="80">{{($translate->firstWhere('lang', 'en'))?$translate->firstWhere('lang', 'en')->text : ''}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Вопросы анкеты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                       {{-- <input type="hidden" name="ajax_url" value="{{route('adm_question_ajax',[$questionnaire->id])}}">--}}
                        <div class="questions-list list-questions list-child ajax-questions">
                            @foreach($questions as $question)
                                <div class="question-item " id="question_{{$question->id}}" >
                                    <input type="hidden" name="question[{{$question->id}}]" class="question_id" value="{{$question->id}}">
                                    <div class="question-header">
                                        <div class="row">
                                            <a href="{{route('adm_question_edit',[$question->id])}}" class="col-md-8">
                                                <div class="drag-zone">
                                                    <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                                </div>
                                                <span class="question-title">{{$question->name}}</span>
                                            </a>
                                            <div class="col-md-3">
                                                <span class="question-type">{{$questionTypes->firstWhere('id',$question->type_id)->name}}</span>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <i class="fa fa-times delete-question" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a class="add-zone" href="{{route('adm_question_new',[$questionnaire->id])}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Опубликовать</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="submit" name="submit" value="save-hide" class="btn btn-block btn-primary btn-lg">Сохранить в черновик</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/questionnaire/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Материалы анкеты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if($questionnaire->type_id != 1 && $questionnaire->type_id != 5)
                            <p><a href="{{route('adm_select_project_request',['questionnaire_id'=>$questionnaire->project->id])}}{{($questionnaire->type_id == 3)?'?status%5B9%5D=9':''}}">Заполненных анкет ({{$answersCount}})</a></p>
                        @endif
                        <p><a href="{{route('adm_questionnaire_statistics',['questionnaire_id'=>$questionnaire->id])}}">Статистика по ответам</a></p>
                        @if($questionnaire->type_id != 1)
                            <p><a href="{{route('adm_questionnaire_pdf',['questionnaire_id'=>$questionnaire->id])}}">Диаграммы в PDF</a></p>
                            <p><a href="{{route('adm_questionnaire_excel',['questionnaire_id'=>$questionnaire->id])}}">Экспорт ответов exel</a></p>
                            @if($questionnaire->type_id == 3)
                                    <p><a href="{{route('adm_questionnaire_excel_registration',['questionnaire_id'=>$questionnaire->id])}}">Экспорт ответов exel (включая регистрационную анкету)-</a></p>
                            @endif
                        @endif
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>
    </div><!-- /.row -->
{{--
    <div class="hide new-template">
        <div class="question-item active">
            <input type="hidden" name="question[]" class="question_id">
            <div class="question-header">
                <div class="row">
                    <div class="col-md-11">
                        <div class="drag-zone">
                            <i class="fa fa-arrows-v" aria-hidden="true"></i>
                        </div>
                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        <span class="question-title">Текст вопроса</span>
                    </div>
                    <div class="col-md-1 text-right">
                        <i class="fa fa-times delete-question" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="question-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                        <input type="text" name="question_name[]" class="form-control question-name none-required" placeholder="Введите вопрос...">
                    </div>
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос<span class="input-request">*</span></label>
                        <input type="text" name="question_name_ua[]" class="form-control none-required" placeholder="Введите вопрос...">
                    </div>
                </div>

                <div class="form-group">
                    <label>Тип вопроса<span class="input-request">*</span></label>
                    <select class="form-control none-required question_type" name="question_type[]">
                        <option value="">Выберите тип вопроса</option>
                        @foreach($questionTypes as $questionType)
                            <option value="{{$questionType->id}}">{{$questionType->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="child-consructor">

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подсказка к вопросу</label>
                        <input type="text" name="question_help[]" class="form-control" placeholder="Введите подсказку...">
                    </div>
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подсказка к вопросу </label>
                        <input type="text" name="question_help_ua[]" class="form-control" placeholder="Введите подсказку...">
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" class="minimal-red" name="question_required[]" value="true">
                        Обязательно к заполнению?
                    </label>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Минимум</label>
                        <input type="number" class="form-control" name="question_min[]" min="0">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Максимум</label>
                        <input type="number" class="form-control" name="question_max[]" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>Показывать если</label>
                    <input type="text" class="form-control" name="question_relation[]">
                    <div class="note">укажите здесь id ответа на вопрос, только цифры</div>
                </div>
            </div>
        </div>
    </div>
--}}

@endsection
