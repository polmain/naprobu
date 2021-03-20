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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/category/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/category/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectCategories()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_category_new')}}" class="btn btn-primary pull-right">Создать категорию</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список категорий проектов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/category/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">#</th>
                            <th>Название категории</th>
                            <th width="20">Проектов</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$category->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_project_category_edit',['category_id'=>$category->id])}}">{{$category->id}}</a></td>
                                <td><a href="{{route('adm_project_category_edit',['category_id'=>$category->id])}}">{{$category->name}}</a></td>
                                <td class="text-center"><a href="{{route('adm_project_allCategory',['category_id'=>$category->id])}}">{{$category->projects->count()}}</a></td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$category->id}}" {{($category->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$category->id}}" onclick="deleteProjectCategory({{$category->id}})">Удалить</button>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/category/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/category/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectCategories()">Удалить</button>
                    </div>
                    <a href="{{route('adm_project_category_new')}}" class="btn btn-primary pull-right">Создать категорию</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection