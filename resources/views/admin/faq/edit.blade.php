@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_faq_save',[$faqCategory->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры группы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название группы<span class="input-request">*</span></label>
                                <input type="text" id="name" name="name" class="form-control required" placeholder="Введите название группы..." value="{{$faqCategory->name}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название группы</label>
                                <input type="text" id="nameUA" name="nameUA" class="form-control" placeholder="Введите название группы..." value="{{ $faqCategory->translate->firstWhere('lang', 'ua')? $faqCategory->translate->firstWhere('lang', 'ua')->name : ''}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название группы</label>
                                <input type="text" id="nameEN" name="nameEN" class="form-control" placeholder="Введите название группы..." value="{{ $faqCategory->translate->firstWhere('lang', 'en')? $faqCategory->translate->firstWhere('lang', 'en')->name : ''}}">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Вопросы группы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="questions-list list-child">
                            @foreach($faqCategory->questions as $question)

                            <div class="question-item active" id="question_{{$question->id}}">
                                <input type="hidden" name="question[]" class="question_id" value="{{$question->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="drag-zone">
                                                <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                            </div>
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$question->question}}</span>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <i class="fa fa-times delete-question" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                                            <input type="text" name="question_name[]" class="form-control question-name required" placeholder="Введите вопрос..." value="{{$question->question}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос</label>
                                            <input type="text" name="question_name_ua[]" class="form-control" placeholder="Введите вопрос..." value="{{$question->translate->firstWhere('lang', 'ua')? $question->translate->firstWhere('lang', 'ua')->question : ''}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Вопрос</label>
                                            <input type="text" name="question_name_en[]" class="form-control" placeholder="Введите вопрос..." value="{{$question->translate->firstWhere('lang', 'en')? $question->translate->firstWhere('lang', 'en')->question : ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Ответ<span class="input-request">*</span></label>
                                            <textarea name="question_answer[]" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ...">{!! $question->answer !!}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Ответ</label>
                                            <textarea name="question_answer_ua[]" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ...">{!! $question->translate->firstWhere('lang', 'ua')? $question->translate->firstWhere('lang', 'ua')->answer : '' !!}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Ответ</label>
                                            <textarea name="question_answer_en[]" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ...">{!! $question->translate->firstWhere('lang', 'en')? $question->translate->firstWhere('lang', 'en')->answer : '' !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </div>
                        <div class="add-zone">
                            <i class="fa fa-plus" aria-hidden="true"></i>
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Опубликовать</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="submit" name="submit" value="save-hide" class="btn btn-block btn-primary btn-lg">Сохранить в черновик</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/faq/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Парамметры</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Порядок сортировки<span class="input-request">*</span></label>
                                <input type="number" name="sort" min="1" class="form-control required" placeholder="Введите порядковый номер группы" value="{{$faqCategory->sort}}">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Изображение группы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label ">Изображение<span class="input-request">*</span></label>
                            <div class="load-image-container project-img ">
                                @if(!empty($faqCategory->image))
                                    <div class="load-img active" style="background-image: url({{$faqCategory->image}});">
                                        <input type="hidden" class="upload_image_name" name="image" value="{{$faqCategory->image}}">
                                    </div>
                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                @else
                                    <div class="load-img">
                                        <input type="hidden" class="upload_image_name" name="image">
                                    </div>
                                    <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                @endif
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>
    </div><!-- /.row -->

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
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Вопрос<span class="input-request">*</span></label>
                        <input type="text" name="question_name[]" class="form-control question-name none-required" placeholder="Введите вопрос...">
                    </div>
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Вопрос</label>
                        <input type="text" name="question_name_ua[]" class="form-control" placeholder="Введите вопрос...">
                    </div>
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Вопрос</label>
                        <input type="text" name="question_name_en[]" class="form-control" placeholder="Введите вопрос...">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Ответ<span class="input-request">*</span></label>
                        <textarea name="question_answer[]" id="" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ..."></textarea>
                    </div>
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Ответ</label>
                        <textarea name="question_answer_ua[]" id="" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ..."></textarea>
                    </div>
                    <div class="col-md-4">
                        <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Ответ</label>
                        <textarea name="question_answer_en[]" id="" cols="30" rows="10" class="form-control editor" placeholder="Введите ответ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
