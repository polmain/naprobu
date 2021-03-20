@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список меню</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="questionnaire-table">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th  width="150">Название</th>
                            <th>Колечетсво пунктов</th>
                        </tr>
                        </thead>
                        <tbody>
							@foreach($menus as $menu)
								<tr>
									<td>
										<a href="{{route('adm_menu_edit',[$menu->id])}}">{{$menu->id}}</a>
									</td>
									<td>
										<a href="{{route('adm_menu_edit',[$menu->id])}}">{{$menu->name}}</a>
									</td>
									<td>
										{{ $menu->items_count / 2}}
									</td>
								</tr>
							@endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection