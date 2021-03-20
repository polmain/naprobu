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
                        <button class="btn btn-default" onclick="groupAjax('/admin/brand/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/brand/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteBrands()">Удалить</button>
                    </div>
                    <a href="{{route('adm_brand_new')}}" class="btn btn-primary pull-right">Добавит Брэнд</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список Брэндов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/brand/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Брэнд</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($brands->reverse() as $brand)
                            <tr>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$brand->id}}"  value="true">
                                    </label>
                                </td>
                                <td class="text-center"><a href="{{route('adm_brand_edit',['brand_id'=>$brand->id])}}">{{$brand->id}}</a></td>
                                <td><a href="{{route('adm_brand_edit',['brand_id'=>$brand->id])}}">{{$brand->name}}</a></td>
                                <td class="text-center">
                                    <label>
                                        <input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$brand->id}}" {{($brand->isHide)?" checked=checked":""}}>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger delete-ajax" id="delete-{{$brand->id}}" onclick="deleteBrand({{$brand->id}})">Удалить</button>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/brand/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/brand/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteBrands()">Удалить</button>
                    </div>
                    <a href="{{route('adm_brand_new')}}" class="btn btn-primary pull-right">Добавит Брэнд</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection