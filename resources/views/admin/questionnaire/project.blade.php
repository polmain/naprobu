@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Панель управления</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary check_all">Отметить все</button>
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteQuestionnaires()">Удалить</button>
                    </div>
                    <a href="{{route('adm_questionnaire_new')}}" class="btn btn-primary pull-right">Создать анкету</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список анкет</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/questionnaire/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Анкета</th>
                            <th>Тип Анкеты</th>
                            <th>Проект</th>
                            <th>Вопросы</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($questionnaires as $questionnaire)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$questionnaire->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_questionnaire_edit',['questionnaire_id'=>$questionnaire->id])}}">{{$questionnaire->id}}</a></td>
                                <td><a href="{{route('adm_questionnaire_edit',['questionnaire_id'=>$questionnaire->id])}}">{{$questionnaire->name}}</a></td>
                                <td>{{$questionnaire->type->name}}</td>
                                <td>{{(!empty($questionnaire->project))?$questionnaire->project->name:'-'}}</td>
                                <td class="text-center">{{$questionnaire->questions_count}}</td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$questionnaire->id}}" {{($questionnaire->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <a href="{{route('adm_questionnaire_copy',['questionnaire_id'=>$questionnaire->id])}}" class="btn btn-success">Дублировать</a>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$questionnaire->id}}" onclick="deleteQuestionnaire({{$questionnaire->id}})">Удалить</button>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-primary check_all">Отметить все</button>
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteQuestionnaires()">Удалить</button>
                    </div>
                    <a href="{{route('adm_questionnaire_new')}}" class="btn btn-primary pull-right">Создать анкету</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection