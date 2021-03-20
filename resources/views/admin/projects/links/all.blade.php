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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/links/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/links/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectLinks()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_links_new',['project_id' => $project_id])}}" class="btn btn-primary pull-right">Добавить ссылку</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список ссылок проекта</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/links/--action--/--id--/">
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
                            @foreach($links->reverse() as $link)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$link->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_project_links_edit',['subpage_id'=>$link->id])}}">{{$link->id}}</a></td>
                                <td><a href="{{route('adm_project_links_edit',['subpage_id'=>$link->id])}}">{{$link->text}}</a></td>
                                <td>{{$link->project->name}}</td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$link->id}}" {{($link->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$link->id}}" onclick="deleteProjectLink({{$link->id}})">Удалить</button>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/links/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/links/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectLinks()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_links_new',['project_id' => $project_id])}}" class="btn btn-primary pull-right">Добавить ссылку</a>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection