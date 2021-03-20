@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список модераторов и их активности</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Логин</th>
                            <th>e-mail</th>
                            <th>Последний раз в сети</th>
                            <th>Активность за последний день</th>
                            <th>Список проделанной работы</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                @if(\App\Library\Users\ActiveUser::isOnline($user->last_active))
                                    <td><i class="fa fa-circle text-success" aria-hidden="true"></i> Online</td>
                                @else
                                    <td><i class="fa fa-circle text-danger" aria-hidden="true"></i> Был {{\App\Library\Users\ActiveUser::lastActive($user->last_active)}}</td>
                                @endif
                                <td>{{\App\Library\Users\ActiveUser::getLastDayActive($user->id)}}</td>
                                <td><a href="/admin/users/moderator/{{$user->id}}/log">log</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection