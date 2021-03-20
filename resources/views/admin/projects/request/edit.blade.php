@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_request_save',['request_id'=>$request->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация о эксперте</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Никнейм
                                </th>
                                <td>
                                    {{$request->user->name}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    email
                                </th>
                                <td>
                                    {{$request->user->email}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    ФИО
                                </th>
                                <td>
                                    {{$request->user->last_name}} {{$request->user->first_name}} {{$request->user->patronymic}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Пол
                                </th>
                                <td>
                                    {{($request->user->sex)?"Мужской":"Женский"}}
                                </td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                @foreach($questionnaires as $questionnaire)
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ответы на вопросы анкеты: <em>{{$questionnaire->name}}</em></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped" width="100%">
                                <tr>
                                    <th width="40%">Вопрос</th>
                                    <th  width="60%">Ответ</th>
                                </tr>
                                @php
                                    $questionParent = 0;
                                @endphp
                                @foreach($request->answers as $answer)
                                    @if($answer->question)
                                        @if($answer->question->questionnaire_id == $questionnaire->id )
                                            @if(($answer->question->type_id == 7 || $answer->question->type_id == 9))
                                                @if($questionParent != $answer->question->parent )
                                                    <tr><th  width="40%" style="word-break: break-all;">{{$answer->question->parent_question->name}}</th><td  width="60%" style="word-break: break-all;">
                                                            {!!  ($answer->question->type_id == 9)?
                                                            ('<em>'.$answer->question->name.'</em>: '.$answer->answer):
                                                            $answer->question->name!!}
                                                            @else
                                                                , {{$answer->question->name}}
                                                            @endif

                                                            @php
                                                                $questionParent = $answer->question->parent;
                                                            @endphp

                                                            @else
                                                                @if($questionParent != 0 )
                                                        </td></tr>
                                                    @php
                                                        $questionParent = 0;
                                                    @endphp
                                                @endif
                                                <tr><th width="40%" style="word-break: break-all;">{{$answer->question->name}}</th><td width="60%" style="word-break: break-all;">{{$answer->answer}}</td></tr>
                                            @endif
                                        @endif
                                    @else
                                        {{--<tr><td colspan="2">
                                                {{$answer->question_id}}</td></tr>--}}
                                    @endif

                                @endforeach
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                @endforeach
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
                        <div class="form-group">
                            <label>Статус заявки<span class="input-request">*</span></label>
                            <select class="form-control required" name="type" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($statuses as $status)
                                    <option  value="{{$status->id}}"{{($request->status_id == $status->id)?" selected=selected":""}}>{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/requests/{{$request->project_id}}/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>

                @if($request->status_id >= 7)
                    <div class="col-md-3">
                        <!-- Box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Посылка</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            @if(empty($request->shipping))
                                <form action="{{route('adm_project_request_shipping',['request_id'=>$request->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                                    {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Номер ТТН<span class="input-request">*</span></label>
                                        <input type="text" id="ttn" name="ttn" class="form-control required" placeholder="Номер ТТН">
                                    </div>
                                    <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Отправить ТТН пользователю</button>
                                </div><!-- /.box-body -->
                                </form>

                            @else
                                <div class="box-body">
                                    <div class="form-group">
                                        <p>Номер ТТН: <strong>{{$request->shipping->ttn}}</strong></p>
                                    </div>
                                    <form action="{{route('adm_project_request_shipping',['request_id'=>$request->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Исправленный Номер ТТН<span class="input-request">*</span></label>
                                                <input type="text" id="ttn" name="ttn" class="form-control required" placeholder="Номер ТТН">
                                            </div>
                                            <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Изменить ТТН пользователю</button>
                                        </div><!-- /.box-body -->
                                    </form>
                                </div><!-- /.box-body -->
                            @endif
                        </div><!-- /.box -->
                    </div>
                @endif


    </div><!-- /.row -->
@endsection
