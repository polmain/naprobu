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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/messages/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/messages/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectMessages()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_message_new',['project_id' => $project_id])}}" class="btn btn-primary pull-right">Добавить сообщение</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список сообщений проекта</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/messages/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Текст</th>
                            <th>Проект</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($messages->reverse() as $message)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$message->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_project_message_edit',['subpage_id'=>$message->id])}}">{{$message->id}}</a></td>
                                <td><a href="{{route('adm_project_message_edit',['subpage_id'=>$message->id])}}">{{$message->text}}</a></td>
                                <td>{{$message->project->name}}</td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$message->id}}" {{($message->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$message->id}}" onclick="deleteProjectMessage({{$message->id}})">Удалить</button>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/messages/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/messages/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectMessages()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_message_new',['project_id' => $project_id])}}" class="btn btn-primary pull-right">Добавить сообщение</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection