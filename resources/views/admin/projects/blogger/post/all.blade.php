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
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/post/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/post/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectPosts()">Удалить</button>
                    </div>
                    <a data-toggle="modal" data-target="#modal-add-post"class="btn btn-primary pull-right">Добавить пост</a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список постов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/post/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Пост</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$post->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center">{{$post->id}}</td>
                                <td>{!! $post->code !!}</td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$post->id}}" {{($post->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$post->id}}" onclick="deleteProjectPost({{$post->id}})">Удалить</button>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/post/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/post/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteProjectPosts()">Удалить</button>
                    </div>
                    <a data-toggle="modal" data-target="#modal-add-post"class="btn btn-primary pull-right">Добавить пост</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->

    <div class="modal modal-default fade" id="modal-add-post" style="display: none;">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <form action="{{route('adm_project_blogger_post_create',[$project->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Добвить Пост</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name_ru" class="col-form-label">Код поста<span class="input-request">*</span></label>
                            <textarea class="form-control required" id="code" name="code" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary" id="success">Добавить</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection