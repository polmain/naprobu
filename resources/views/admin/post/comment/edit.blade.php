@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_post_comment_save',['comment_id'=>$comment->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Комментария</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Текст комментария<span class="input-request">*</span></label>
                                <textarea name="text" class="form-control required" rows="10" placeholder="Введите комментарий...">{{$comment->text}}</textarea>
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/post/comments/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Статус<span class="input-request">*</span></label>
                                <select class="form-control required" name="status" style="width: 100%;">
                                    <option value="">--</option>
                                    @foreach($statuses as $status)
                                        <option  value="{{$status->id}}"{{($comment->status_id == $status->id)?" selected=selected":''}}>{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Пользователь</label>
                                <select id="user" name="user" class="form-control required" disabled>
                                    <option  value="{{$comment->user->id}}" selected=selected >{{$comment->user->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Отзыв</label>
                                <select id="project" name="post" class="form-control" disabled>
                                    <option  value="{{$comment->post->id}}" selected=selected >{{$comment->post->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Проект</label>
                                <select id="project" name="project" class="form-control" disabled>
                                    @if($comment->post->project)
                                    <option  value="{{$comment->post->project->id}}" selected=selected >{{$comment->post->project->name}}</option>
                                        @endif
                                </select>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection

@section("scripts")
    <script>
		$('#user').select2({
			placeholder: "Выберите пользователя...",
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_users_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#project').select2({
			placeholder: "Выберите проект...",
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_project_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
    </script>
@endsection