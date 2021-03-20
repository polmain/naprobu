@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-6'>
            <!-- Box -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Новый блоггер</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                <form action="{{route('adm_blogger_create')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="categories" class="col-sm-3 control-label ">Категории</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subjects" class="col-sm-3 control-label ">Тематики</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="subjects[]" id="subjects" multiple="multiple">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="login" class="col-sm-3 control-label ">Название канала</label>

                            <div class="col-sm-9">
                                <input name="name" type="text" class="form-control" id="login" placeholder="Название канала">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label ">ФИО</label>

                            <div class="col-sm-9">
                                <input name="fio" type="text" class="form-control" id="firstName" placeholder="ФИО">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="col-sm-3 control-label ">Link (самая крупная площадка)</label>

                            <div class="col-sm-9">
                                <input name="link" type="text" class="form-control" id="lastName" placeholder="Link (самая крупная площадка)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">сайт-блог (ссылка) - если есть</label>
                            <div class="col-sm-9">
                                <input name="site" type="text" class="form-control" id="birsday" placeholder="сайт-блог (ссылка) - если есть">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Instagram Link</label>
                            <div class="col-sm-9">
                                <input name="instagram_link" type="text" class="form-control" id="birsday" placeholder="Instagram Link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Instagram подписчики</label>
                            <div class="col-sm-9">
                                <input name="instagram_subscriber" type="text" class="form-control" id="birsday" placeholder="Instagram подписчики">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Facebook Link</label>
                            <div class="col-sm-9">
                                <input name="facebook_link" type="text" class="form-control" id="birsday" placeholder="Facebook Link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Facebook подписчики</label>
                            <div class="col-sm-9">
                                <input name="facebook_subscriber" type="text" class="form-control" id="birsday" placeholder="Facebook подписчики">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube Link</label>
                            <div class="col-sm-9">
                                <input name="youtube_link" type="text" class="form-control" id="birsday" placeholder="YouTube Link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube подписчики</label>
                            <div class="col-sm-9">
                                <input name="youtube_subscriber" type="text" class="form-control" id="birsday" placeholder="YouTube подписчики">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">YouTube среднее к-во просмотров (от-до)</label>
                            <div class="col-sm-9">
                                <input name="youtube_avg_views" type="text" class="form-control" id="birsday" placeholder="YouTube среднее к-во просмотров (от-до)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Другие Соц.сети</label>
                            <div class="col-sm-9">
                                <input name="other_network" type="text" class="form-control" id="birsday" placeholder="Другие Соц.сети">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Город</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="city_id" id="city">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Телефон</label>
                            <div class="col-sm-9">
                                <input name="phone" type="text" class="form-control" id="birsday" placeholder="Телефон">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12">Контакты</label>
                            <div class="col-sm-12">
                                <textarea name="contacts" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12  ">Нова пошта</label>
                            <div class="col-sm-12">
                                <textarea name="nova_poshta" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">описание блога</label>
                            <div class="col-sm-12">
                                <textarea name="description" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">Дети</label>
                            <div class="col-sm-12">
                                <textarea name="children" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12  ">Стоимость размещений</label>
                            <div class="col-sm-12">
                                <textarea name="price" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">Заметки</label>
                            <div class="col-sm-12">
                                <textarea name="note" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-12 ">участвовал в проектах (старое)</label>
                            <div class="col-sm-12">
                                <textarea name="old_member_in_project" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>


                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Добавить</button>
                    </div><!-- /.box-footer-->
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class='col-md-6'>
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