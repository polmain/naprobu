@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('admin.phone.save',['phone_id'=>$phone->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Данные для верефикации</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Номер телефона: <strong>{{$phone->phone}}</strong></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <p>Список пользователей</p>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Ник</th>
                                        <th>Email</th>
                                        <th>Фамилия</th>
                                        <th>Имя</th>
                                        <th>Отчество</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($phone->users as $user)
                                            <td><a href="{{route('adm_users_save',[$user->id])}}" target="_blank">{{$user->id}}</a></td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->last_name}}</td>
                                            <td>{{$user->first_name}}</td>
                                            <td>{{$user->patronymic}}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->


            </div>
            <div class="col-md-3">
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Действия</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Верефицировать</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Верефицировать и закрыть</button>
                        <button type="submit" name="submit" value="save-next" class="btn btn-block btn-primary btn-lg">Верифицировать и перейти дальше</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/users/phones/';">Закрыть</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection
