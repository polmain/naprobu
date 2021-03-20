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
                        <button class="btn btn-default" onclick="groupAjax('/admin/page/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/page/hide/--id--/')">Скрыть</button>
                    </div>
                    <a href="{{route('adm_page_new')}}" class="btn btn-primary pull-right">Создать страницу</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список страниц</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/page/--action--/--id--/">
                    <div class="table-responsive">

                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Название страницы</th>
                            <th width="20">Скрыт</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($pages->reverse() as $page)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$page->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_page_edit',['page_id'=>$page->id])}}">{{$page->id}}</a></td>
                                <td><a href="{{route('adm_page_edit',['page_id'=>$page->id])}}">{{$page->name}}</a></td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$page->id}}" {{($page->isHide)?" checked=checked":""}}>
                                    </label>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/page/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/page/hide/--id--/')">Скрыть</button>
                    </div>
                    <a href="{{route('adm_page_new')}}" class="btn btn-primary pull-right">Создать страницу</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection