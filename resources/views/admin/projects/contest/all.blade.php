@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список конкурсов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/contest/--action--/--id--/">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Проект</th>
                            <th>Категория</th>
                            <th>Анкеты</th>
                            <th>Статус</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($projects->reverse() as $project)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$project->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_project_edit',['project_id'=>$project->id])}}">{{$project->id}}</a></td>
                                <td><a href="{{route('adm_project_edit',['project_id'=>$project->id])}}">{{$project->name}}</a></td>
                                <td>{{$project->category->name}}</td>
                                <td class="text-center">3798</td>
                                <td>{{$project->status->name}}</td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$project->id}}" {{($project->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$project->id}}" onclick="deleteContest({{$project->id}})">Удалить</button>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/contest/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/contest/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteContests()">Удалить</button>
                    </div>
                    <a href="{{route('adm_contest_new')}}" class="btn btn-primary pull-right">Создать проект</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection