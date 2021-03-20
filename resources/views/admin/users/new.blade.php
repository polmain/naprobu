@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-6'>
            <!-- Box -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Новый пользователь</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                <form action="{{route('adm_users_new_create')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="login" class="col-sm-3 control-label ">Логин</label>

                            <div class="col-sm-9">
                                <input name="login" type="text" class="form-control" id="login" placeholder="Логин">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label ">Имя</label>

                            <div class="col-sm-9">
                                <input name="first_name" type="text" class="form-control" id="firstName" placeholder="Имя">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="col-sm-3 control-label ">Фамилия</label>

                            <div class="col-sm-9">
                                <input name="last_name" type="text" class="form-control" id="lastName" placeholder="Фамилия">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userSex" class="col-sm-3 control-label ">Пол</label>
                            <div class="col-sm-9">
                                <select name="sex" class="form-control select2" id="userSex" style="width: 100%;">
                                    <option value="1">Мужской</option>
                                    <option value="0">Женский</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Год рождения</label>
                            <div class="col-sm-9">
                                <input name="birsday" type="text" class="form-control" id="birsday" placeholder="Год рождения">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Город</label>
                            <div class="col-sm-9">
                                <input name="city" type="text" class="form-control" id="city" placeholder="Город">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Область</label>
                            <div class="col-sm-9">
                                <input name="region" type="text" class="form-control" id="region" placeholder="Область">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Email</label>

                            <div class="col-sm-9">
                                <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Телефон</label>
                            <div class="col-sm-9">
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="Телефон">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label ">Пароль</label>

                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
                                <div class="pass_gen">
                                    <div class="btn btn-default" id="pass_gen">Генерировать пароль</div>
                                    <div class="password_gen_view"></div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole('admin'))
                        <div class="form-group">
                            <label for="userRole" class="col-sm-3 control-label ">Роль пользователя</label>
                            <div class="col-sm-9">
                                <select name="role" class="form-control select2" id="userRole" style="width: 100%;">
                                    <option selected="selected" value="user">Пользователь</option>
                                    <option value="expert">Эксперт</option>
                                    <option value="moderator">Модератор</option>
                                    <option value="admin">Администратор</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="avatar" class="col-sm-3 control-label ">Аватар</label>
                            <div class="col-sm-9">
                                <div class="load-image-container avatar">
                                    <div class="load-img" style="background-image: url('/public/avatars/default.png');"></div>
                                    <input type="file" name="avatar" id="avatar"/>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" class="btn btn-primary pull-right">Создать пользователя</button>
                    </div><!-- /.box-footer-->
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection