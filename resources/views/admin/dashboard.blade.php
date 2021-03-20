@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$projects}}</h3>

                    <p>Проектов</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                @if(Auth::user()->hasRole('admin'))
                <a href="{{route("adm_project")}}" class="small-box-footer">Все проекты <i class="fa fa-arrow-circle-right"></i></a>
                    @endif
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$reviews}}</h3>

                    <p>Отзывов</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route("adm_review")}}" class="small-box-footer">Все отзывы <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$requests}}</h3>

                    <p>Анкет</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route("adm_project_request")}}" class="small-box-footer">Все анкеты <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$users}}</h3>

                    <p>Пользователей</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route("adm_users")}}" class="small-box-footer">Все пользователи <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection