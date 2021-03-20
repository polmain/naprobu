@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Время активности модератора</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Общая статистика активности</h4>
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Время</th>
                                    <th>Среднее время в день</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th>Активность за сегодня</th>
                                    <td>{{\App\Library\Users\ActiveUser::getLastDayActive($user->id)}}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>Активность за неделю (последние 7 дней)</th>
                                    <td>{{\App\Library\Users\ActiveUser::getLastDaysActive($user->id,7)}}</td>
                                    <td>{{\App\Library\Users\ActiveUser::avgDaysActive($user->id,7)}}</td>
                                </tr>
                                <tr>
                                    <th>Активность за месяц (последние 30 дней)</th>
                                    <td>{{\App\Library\Users\ActiveUser::getLastDaysActive($user->id,30)}}</td>
                                    <td>{{\App\Library\Users\ActiveUser::avgDaysActive($user->id,30)}}</td>
                                </tr>
                                <tr>
                                    <th>Активность за год (последние 365 дней)</th>
                                    <td>{{\App\Library\Users\ActiveUser::getLastDaysActive($user->id,365)}}</td>
                                    <td>{{\App\Library\Users\ActiveUser::avgDaysActive($user->id,365)}}</td>
                                </tr>
                            </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Промежутки работы модератора за сегодня</h4>
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Начало</th>
                                        <th>Конец</th>
                                        <th>Время работы</th>
                                        <th>Перерыв</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $prevTime = null;
                                @endphp
                                    @foreach($activeTimes as $activeTime)
                                        @if(\Carbon\Carbon::now()->startOfDay()->lte($activeTime->created_at))
                                        <tr>
                                            <td>{{$activeTime->created_at}}</td>
                                            <td>{{$activeTime->updated_at}}</td>
                                            <td>{{\Carbon\CarbonInterval::instance((new \Carbon\Carbon($activeTime->updated_at))->diff(new \Carbon\Carbon($activeTime->created_at)))->cascade()->forHumans()}}</td>
                                            <td>{{(!empty($prevTime))?(\Carbon\CarbonInterval::instance((new \Carbon\Carbon($activeTime->updated_at))->diff(new \Carbon\Carbon($prevTime)))->cascade()->forHumans()):''}}</td>
                                        </tr>
                                            @php
                                                $prevTime = $activeTime->created_at
                                                @endphp
                                            @else
                                                @php
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- /.box-footer-->
            </div><!-- /.box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Log действий модератора</h3>
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
                            <th>Действие</th>
                            <th>Время</th>
                            <th>Ссылка</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td class="text-center">{{$log->id}}</td>
                                <td>{{$log->action}}</td>
                                <td>{{$log->created_at}}</td>
                                <td><a href="{{(Request::secure())?"https://":"http://"}}{{$log->url}}">{{$log->url}}</a></td>
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