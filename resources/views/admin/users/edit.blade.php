@extends('admin.layouts.layout')

@section('content')
    {{--ini_get('post_max_size')--}}
    <div class='row'>
        <div class='col-md-6'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Редактировать пользователя</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <form action="{{route('adm_users_save',['user_id'=>$user->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <label>
                                    <input type="checkbox" class="minimal-red" name="isNewsletter" value="true"{{($user->isNewsletter)?" checked=checked":""}}>
                                    Рассылка на email
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="login" class="col-sm-3 control-label ">Логин</label>

                            <div class="col-sm-9">
                                <input name="login" type="text" class="form-control" id="login" placeholder="Логин" value="{{$user->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label ">Имя</label>

                            <div class="col-sm-9">
                                <input name="first_name" type="text" class="form-control" id="firstName" placeholder="Имя" value="{{$user->first_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="col-sm-3 control-label ">Фамилия</label>

                            <div class="col-sm-9">
                                <input name="last_name" type="text" class="form-control" id="lastName" placeholder="Фамилия" value="{{$user->last_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userSex" class="col-sm-3 control-label ">Пол</label>
                            <div class="col-sm-9">
                                <select name="sex" class="form-control select2" id="userSex" style="width: 100%;">
                                    <option {{($user->sex == 1)?'selected=selected ':''}}value="1">Мужской</option>
                                    <option {{($user->sex == 0)?'selected=selected ':''}}value="0">Женский</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birsday" class="col-sm-3 control-label ">Год рождения</label>
                            <div class="col-sm-9">
                                <input name="birsday" type="text" class="form-control" id="birsday" placeholder="Год рождения" value="{{$user->birsday}}">
                            </div>
                        </div>
                        @if($user->new_form_status)
                            <div class="form-group">
                                <label for="country_id" class="col-sm-3 control-label ">Страна</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="country_id" id="country_id">
                                        <option value="{{$user->country_model->id}}" selected="selected">{{$user->country_model->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="region_id" class="col-sm-3 control-label ">Область</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="region_id" id="region_id">
                                        @if($user->region_model)
                                        <option value="{{$user->region_model->id}}" selected="selected">{{$user->region_model->name}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city_id" class="col-sm-3 control-label ">Город</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="city_id" id="city_id">
                                        @if($user->city_model)
                                        <option value="{{$user->city_model->id}}" selected="selected">{{$user->city_model->name}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="birsday" class="col-sm-3 control-label ">Город</label>
                                <div class="col-sm-9">
                                    <input name="city" type="text" class="form-control" id="city" placeholder="Город" value="{{$user->city}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birsday" class="col-sm-3 control-label ">Область</label>
                                <div class="col-sm-9">
                                    <input name="region" type="text" class="form-control" id="region" placeholder="Область" value="{{$user->region}}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Email</label>
                            <div class="col-sm-9">
                                <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Телефон</label>
                            <div class="col-sm-9">
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="Телефон" value="{{$user->phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label ">Пароль</label>
                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" id="password" placeholder="Пароль" >
                            </div>
                        </div>
                        @if(Auth::user()->hasRole('admin'))
                        <div class="form-group">
                            <label for="userRole" class="col-sm-3 control-label ">Роль пользователя</label>
                            <div class="col-sm-9">
                                <select name="role" class="form-control select2" id="userRole" style="width: 100%;">
                                    <option {{($user->hasRole("user"))?'selected=selected ':''}}value="user">Пользователь</option>
                                    <option {{($user->hasRole("expert"))?'selected=selected ':''}}value="expert">Эксперт</option>
                                    <option {{($user->hasRole("moderator"))?'selected=selected ':''}}value="moderator">Модератор</option>
                                    <option {{($user->hasRole("admin"))?'selected=selected ':''}}value="admin">Администратор</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <label>
                                    <input type="checkbox" class="minimal-red" name="is_good_photo" value="true"{{($user->is_good_photo)?" checked=checked":""}}>
                                    Хорошие фотографии
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <label>
                                    <input type="checkbox" class="minimal-red" name="is_good_video" value="true"{{($user->is_good_video)?" checked=checked":""}}>
                                    Хорошие видео
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <label>
                                    <input type="checkbox" class="minimal-red" name="is_good_review" value="true"{{($user->is_good_review)?" checked=checked":""}}>
                                    Хорошие отзывы
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userRole" class="col-sm-3 control-label ">Аватар</label>
                            <div class="col-sm-9">
                                <div class="load-image-container avatar">
                                    <div class="load-img " style="background-image: url('/public/uploads/images/avatars/{{$user->avatar}}');"></div>
                                    <input type="file" name="avatar" id="avatar"/>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                    </div><!-- /.box-footer-->
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class='col-md-6'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Дополнительная иформация</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p><strong>Город НП:</strong> {{$user->nova_poshta_city}}</p>
                    <p><strong>Отделение НП:</strong> {{$user->nova_poshta_warehouse}}</p>
                    @if($user->education)
                    <p><strong>Образование:</strong> @lang("education.".$user->education)</p>
                    @endif
                    @if($user->employment)
                    <p><strong>Занятость:</strong> @lang("employment.".$user->employment)</p>
                    @endif
                    @if($user->work)
                    <p><strong>Кем работаете:</strong> @lang("work.".$user->work)</p>
                    @endif
                    @if($user->family_status)
                    <p><strong>Семейное положение:</strong> @lang("family_status.".$user->family_status)</p>
                    @endif
                    @if($user->has_child)
                    <p><strong>Есть ли у Вас дети?:</strong> {{$user->has_child?"Да":"Нет"}}</p>
                        @foreach($user->children as $key => $child)
                            <p><strong>Возраст ребенка {{$key+1}}:</strong> {{\Carbon\Carbon::parse($child->birthday)->format('d.m.Y')}}</p>
                        @endforeach
                    @endif
                    @if($user->material_condition)
                    <p><strong>Как бы Вы описали материальное состояние вашей семьи?:</strong> @lang("material_condition.".$user->material_condition)</p>
                    @endif
                    @if(is_array($user->hobbies))
                        <p><strong>Увлечения/интересы:</strong>
                        @foreach($user->hobbies as $hobby)
                            @lang("hobbies.".$hobby);
                        @endforeach
                        @if($user->hobbies_other)
                            {{$user->hobbies_other}}
                        @endif
                    </p>
                    @endif
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Расчётные поля</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p><strong>Приоритет:</strong> {{$user->getPriority()}}</p>
                    <p><strong>Возраст:</strong> {{is_numeric($user->birsday)? \Carbon\Carbon::now()->year - $user->birsday : 0}}</p>
                    <p><strong>Уровень пользователя:</strong> {{$ratingStatus->name}}</p>
                    <p><strong>Количество балов:</strong> {{$user->history->sum('score')}}</p>
                    <p><strong>Был на сайте:</strong> {{$user->last_active}}</p>
                    <p><strong>Дата регистрации:</strong> {{$user->created_at}}</p>
                    <p><strong>Дата учавстия в проекте:</strong> {{$user->lastApproveRequest()?$user->lastApproveRequest()->updated_at : '-' }}</p>
                    <p><strong>Количество участий в проектах:</strong> {{$user->approveRequestCount() }}</p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <!-- Box -->

            <!-- Blogger verification block -->
            @if($blogger)
            <form action="{{route('adm_blogger_verification',['user_id' => $user->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-warning collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Анкета блогера</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Количество подписчиков</label>
                                <input class="form-control" type="text" name="subscriber_count" value="{{$blogger->subscriber_count}}">
                            </div>
                            <div class="form-group">
                                <label>Тематика блога</label>
                                <input class="form-control" type="text" name="blog_subject" value="{{$blogger->blog_subject}}">
                            </div>
                            <div class="form-group">
                                <label>Платформа</label>
                                <input class="form-control" type="text" name="blog_platform" value="{{$blogger->blog_platform}}">
                            </div>
                            <div class="form-group">
                                <label>Ссылка на блог</label>
                                <input class="form-control" type="text" name="blog_url" value="{{$blogger->blog_url}}">
                            </div>
                            <div class="form-group">
                                <label>Статус<span class="input-request">*</span></label>
                                <select name="status" class="form-control select2" style="width: 100%;">
                                    <option value="{{\App\Entity\UserBloggerStatusEnum::REFUSED}}" @if(\App\Entity\UserBloggerStatusEnum::getInstance($blogger->status)->isRefused()) selected="selected" @endif>Отклонено</option>
                                    <option value="{{\App\Entity\UserBloggerStatusEnum::IN_MODERATE}}" @if(\App\Entity\UserBloggerStatusEnum::getInstance($blogger->status)->isInModerate()) selected="selected" @endif>На модерации</option>
                                    <option value="{{\App\Entity\UserBloggerStatusEnum::CONFIRMED}}" @if(\App\Entity\UserBloggerStatusEnum::getInstance($blogger->status)->isConfirmed()) selected="selected" @endif>Подтверждено</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </form>
            <!-- End Blogger verification block -->
            @endif

            <form action="{{route('adm_change_status',['user_id' => $user->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="box box-warning collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Сменить статус</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Новый статус<span class="input-request">*</span></label>
                                <select name="status" class="form-control select2" style="width: 100%;">
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Время действия статуса<span class="input-request">*</span></label>
                                <select name="unlock_time" class="form-control select2" style="width: 100%;">
                                    <option value="-1">Навсегда</option>
                                    <option value="43200">1 месяц</option>
                                    <option value="131400">3 месяца</option>
                                    <option value="262800">Полгода</option>
                                    <option value="525600">1 год</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Причина смены статуса</label>
                                <textarea name="note" class="form-control" rows="5" placeholder="Причина смены статуса.."></textarea>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Подтвердить</button>
                    </div>

            </div>
            </form>
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">История смены статусов</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Статус</th>
                                <th>Примечание</th>
                                <th>Время смены</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statusHistory as $status)
                                <tr>
                                    <td>{{$status->id}}</td>
                                    <td>{{$status->status->name}}</td>
                                    <td>{{$status->note}}</td>
                                    <td>{{$status->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Материалы пользователя</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p><a href="{{route('adm_review')}}?filter={{ $reviewFilter }}">Отзывы ({{$countReviews}})</a></p>
                    <p><a href="{{route('adm_comment')}}?filter={{ $commentFilter }}">Комментарии к отзывам ({{$countComments}})</a></p>
                    <p><a href="{{route('adm_user_request',['user_id' => $user->id])}}">Заявки к проектам ({{$user->requests_count}})</a></p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <form action="{{route('adm_delete_ratting',['user_id'    =>  $user->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-warning collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Снятие баллов</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> За что баллы<span class="input-request">*</span></label>
                                    <input type="text" class="form-control" name="name_ru" required>
                                </div>
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> За что баллы<span class="input-request">*</span></label>
                                    <input type="text" class="form-control" name="name_ua" required>
                                </div>
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> За что баллы<span class="input-request">*</span></label>
                                    <input type="text" class="form-control" name="name_en" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Колличество баллов<span class="input-request">*</span></label>
                                <input type="number" class="form-control" min="1" required name="score">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Подтвердить</button>
                    </div>

                </div>
            </form>

            <form action="{{route('adm_add_ratting',['user_id' => $user->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-warning collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Добавить баллы</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                        <div class="col-md-4">
                            <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> За что баллы<span class="input-request">*</span></label>
                            <input type="text" class="form-control" name="name_ru" required>
                        </div>
                        <div class="col-md-4">
                            <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> За что баллы<span class="input-request">*</span></label>
                            <input type="text" class="form-control" name="name_ua" required>
                        </div>
                        <div class="col-md-4">
                            <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> За что баллы<span class="input-request">*</span></label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Колличество баллов<span class="input-request">*</span></label>
                                <input type="number" class="form-control" min="1" required name="score">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Подтвердить</button>
                    </div>

                </div>
            </form>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Рейтинг пользователя</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <h4>{{$ratingStatus->name}}({{$user->current_rating}}) <strong>{{$user->history->sum('score')}}</strong></h4>
                    <div class="table-responsive">
                    <table id="user-history" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Действие</th>
                            <th width="60">Балы</th>
                            <th width="60">Балы</th>
                            <th>Время</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section("scripts")
    <script>
		var tableUsers = $('#user-history').DataTable({
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Все"]],
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_users_history',['user_id'=>$user->id]) !!}",
			"columns": [

				{
					data: 'action',
                    orderable:      false,
				},
				{
					data: 'points',
					orderable:      false,
                },
				{
					data: 'score',
					orderable:      false,
                },
				{
					data: "created_at",
				},

			],
			"fnDrawCallback": afterDrawTabel
		});

		tableUsers.on( 'draw', afterDrawTabel() );

        @if($user->new_form_status)
        $('#country_id').select2({
            placeholder: "Выберите страну...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.country.find') !!}',
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
        $('#region_id').select2({
            placeholder: "Выберите область...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.region.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
        $('#city_id').select2({
            placeholder: "Выберите город...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.city.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
        @endif
    </script>
@endsection
