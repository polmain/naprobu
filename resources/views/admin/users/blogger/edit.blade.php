@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-4'>
            <!-- Box -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Редактировать пользователя</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                <form action="{{route('adm_blogger_save',['blogger_id'=>$blogger->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="categories" class="col-sm-3 control-label ">Категории</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                                    @foreach($blogger->categories as $category)
                                    <option value="{{$category->id}}" selected="selected">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subjects" class="col-sm-3 control-label ">Тематики</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="subjects[]" id="subjects" multiple="multiple">
                                    @foreach($blogger->subjects as $subject)
                                        <option value="{{$subject->id}}" selected="selected">{{$subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="login" class="col-sm-3 control-label ">Название канала</label>

                            <div class="col-sm-9">
                                <input name="name" type="text" class="form-control" id="login" placeholder="Название канала" value="{{$blogger->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label ">ФИО</label>

                            <div class="col-sm-9">
                                <input name="fio" type="text" class="form-control" id="firstName" placeholder="ФИО" value="{{$blogger->fio}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="col-sm-3 control-label ">Link (самая крупная площадка)</label>

                            <div class="col-sm-9">
                                <input name="link" type="text" class="form-control" id="lastName" placeholder="Link (самая крупная площадка)" value="{{$blogger->link}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">сайт-блог (ссылка) - если есть</label>
                            <div class="col-sm-9">
                                <input name="site" type="text" class="form-control" id="birsday" placeholder="сайт-блог (ссылка) - если есть" value="{{$blogger->site}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Instagram Link</label>
                            <div class="col-sm-9">
                                <input name="instagram_link" type="text" class="form-control" id="birsday" placeholder="Instagram Link" value="{{$blogger->instagram_link}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Instagram подписчики</label>
                            <div class="col-sm-9">
                                <input name="instagram_subscriber" type="text" class="form-control" id="birsday" placeholder="Instagram подписчики" value="{{$blogger->instagram_subscriber}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Facebook Link</label>
                            <div class="col-sm-9">
                                <input name="facebook_link" type="text" class="form-control" id="birsday" placeholder="Facebook Link" value="{{$blogger->facebook_link}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Facebook подписчики</label>
                            <div class="col-sm-9">
                                <input name="facebook_subscriber" type="text" class="form-control" id="birsday" placeholder="Facebook подписчики" value="{{$blogger->facebook_subscriber}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube Link</label>
                            <div class="col-sm-9">
                                <input name="youtube_link" type="text" class="form-control" id="birsday" placeholder="YouTube Link" value="{{$blogger->youtube_link}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube подписчики</label>
                            <div class="col-sm-9">
                                <input name="youtube_subscriber" type="text" class="form-control" id="birsday" placeholder="YouTube подписчики" value="{{$blogger->youtube_subscriber}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube среднее к-во просмотров (от-до)</label>
                            <div class="col-sm-9">
                                <input name="youtube_avg_views" type="text" class="form-control" id="birsday" placeholder="YouTube среднее к-во просмотров (от-до)" value="{{$blogger->youtube_avg_views}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Другие Соц.сети</label>
                            <div class="col-sm-9">
                                <input name="other_network" type="text" class="form-control" id="birsday" placeholder="Другие Соц.сети" value="{{$blogger->other_network}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Город</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="city_id" id="city">
                                    <option value="{{$blogger->city_id}}">{{$blogger->city->name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Телефон</label>
                            <div class="col-sm-9">
                                <input name="phone" type="text" class="form-control" id="birsday" placeholder="Телефон" value="{{$blogger->phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12">Контакты</label>
                            <div class="col-sm-12">
                                <textarea name="contacts" id="" class="form-control" cols="30" rows="5">{!!  $blogger->contacts !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12  ">Нова пошта</label>
                            <div class="col-sm-12">
                                <textarea name="nova_poshta" id="" class="form-control" cols="30" rows="5">{!!  $blogger->nova_poshta !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">описание блога</label>
                            <div class="col-sm-12">
                                <textarea name="description" id="" class="form-control" cols="30" rows="5">{!!  $blogger->description !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">Дети</label>
                            <div class="col-sm-12">
                                <textarea name="children" id="" class="form-control" cols="30" rows="5">{!!  $blogger->children !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12  ">Стоимость размещений</label>
                            <div class="col-sm-12">
                                <textarea name="price" id="" class="form-control" cols="30" rows="5">{!!  $blogger->price !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">Заметки</label>
                            <div class="col-sm-12">
                                <textarea name="note" id="" class="form-control" cols="30" rows="5">{!!  $blogger->note !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">участвовал в проектах (старое)</label>
                            <div class="col-sm-12">
                                <textarea name="old_member_in_project" id="" class="form-control" cols="30" rows="5">{!!  $blogger->old_member_in_project !!}</textarea>
                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                    </div><!-- /.box-footer-->
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class='col-md-8'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Участие в проектах</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Проект</th>
                            <th>Формат</th>
                            <th>Охват</th>
                            <th>Цена</th>
                            <th>Ссылка на пост</th>
                            <th>Ссылка на скрин</th>
                            <th>Показы</th>
                            <th>Лайки</th>
                            <th>Комментарии</th>
                            <th>Охват факт</th>
                            <th>ER</th>
                            <th>Прочая активность</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($blogger->userProject as $project)
                            <tr>
                                <td><a href="{{route('adm_project_edit',$project->project->id)}}">{{$project->project->name}}</a></td>
                                <td>{{$project->format}}</td>
                                <td>{{$project->ohvat}}</td>
                                <td>{{$project->prise_without_nds}}</td>
                                <td>{{$project->link_to_post}}</td>
                                <td>{{$project->screen_post}}</td>
                                <td>{{$project->views}}</td>
                                <td>{{$project->likes}}</td>
                                <td>{{$project->comments}}</td>
                                <td>{{$project->ohvat_fact}}</td>
                                <td>{{$project->er}}</td>
                                <td>{{$project->other}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section("scripts")
    <script>
		$('#city').select2({
			placeholder: "Выберите город..",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_city_find') !!}',
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
		$('#categories').select2({
			placeholder: "Выберите категории...",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_category_find') !!}',
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
		$('#subjects').select2({
			placeholder: "Выберите тематики...",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_subject_find') !!}',
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