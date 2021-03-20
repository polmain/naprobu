@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <form id="find_bloggers_form" action="{{route('adm_project_blogger')}}" method="get" enctype="multipart/form-data" class="validation-form">
                {{ csrf_field() }}
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Фильтр проектов</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                    <div class="box-body">

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="name" class=" control-label ">Название</label>
                                <div class="">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Введите запрос" value="{{Request::input('name')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class=" control-label ">Статус</label>
                                <div class="">
                                    <select class="form-control" name="status" id="status" >
                                        <option value="">Выберите статус</option>
                                        <option value="1"{{Request::input('status') == 1?' selected=selected':''}}>Активен</option>
                                        <option value="2"{{Request::input('status') == 2?' selected=selected':''}}>Завершён</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="subjects" class=" control-label ">Период от - до</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <input class="form-control" name="date_from" id="date_from" type="date" placeholder="Введите дату от" value="{{Request::input('date_from')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <input class="form-control" name="date_to" id="date_to" type="date"  placeholder="Введите дату до" value="{{Request::input('date_to')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <button type="submit" name="submit" value="save-close" class="btn btn-block btn-success btn-lg">Фильтровать</button>
                            </div>
                        </div>
                    </div>
            </div><!-- /.box -->
            </form>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список проектов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/project/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>Проект</th>
                            <th>Статус</th>
                            <th>Кол-во участников</th>
                            <th>Показы</th>
                            <th>Лайки</th>
                            <th>Комментарии</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td class="text-center"><a href="{{route('adm_project_edit',['project_id'=>$project->id])}}">{{$project->id}}</a></td>
                                <td><a href="{{route('adm_project_edit',['project_id'=>$project->id])}}">{{$project->name}}</a></td>
                                <td>{{$project->status->name}}</td>
                                <td>{{$project->bloggers->count()}}</td>
                                <td>{{$project->bloggersView()}}</td>
                                <td>{{$project->bloggersLike()}}</td>
                                <td>{{$project->bloggersComment()}}</td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{route('adm_project_new')}}" class="btn btn-primary pull-right">Создать проект</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection

@section("scripts")
    <script>
		$('#status').select2({
			placeholder: "Выберите тематики...",
			tegs: true,
			minimumInputLength: -1,
		});
    </script>
@endsection