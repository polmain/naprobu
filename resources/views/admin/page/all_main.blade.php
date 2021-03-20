@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
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
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Название страницы</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{route('adm_page_main_home')}}">Главная страница</a></td>
                            </tr>
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection