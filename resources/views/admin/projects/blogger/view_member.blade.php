@extends('admin.layouts.layout')

@section('content')

    <div class='row'>
            <form action="{{route('adm_project_blogger_export_member',['project_id'=>$project->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Действия</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <button type="submit" name="submit" class="btn btn-success pull-right">Экспорт</button>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-12">
                    <!-- Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Список блоггеров</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                            <div class="box-body" id="blogger_list">
								<div class="table-responsive">
								<table class="table table-bordered table-hover" style="overflow-x: auto; display: block;">
									<thead>
									<tr>
										<th width="40"></th>
										<th>Название</th>
										<th>Город</th>
										<th>Категории</th>
										<th>Тематика</th>
										<th>Соц. сети</th>
										<th>Подписчики (Всего)</th>
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
									@foreach($project->bloggers as $blogger_item)
										@php $blogger = $blogger_item->blogger;
										@endphp
										<tr>
											<td class="text-center">
												<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-member"
												   data-format="{{$blogger_item->format}}"
												   data-ohvat="{{$blogger_item->ohvat}}"
												   data-prise_without_nds="{{$blogger_item->prise_without_nds}}"
												   data-link_to_post="{{$blogger_item->link_to_post}}"
												   data-screen_post="{{$blogger_item->screen_post}}"
												   data-views="{{$blogger_item->views}}"
												   data-likes="{{$blogger_item->likes}}"
												   data-comments="{{$blogger_item->comments}}"
												   data-ohvat_fact="{{$blogger_item->ohvat_fact}}"
												   data-er="{{$blogger_item->er}}"
												   data-other="{{$blogger_item->other}}"
												   data-action="{{route('adm_project_blogger_edit_member',[$blogger_item->id])}}">
													редактировать
												</a>
											</td>
											<td><a href="{{route('adm_blogger_edit',[$blogger->id])}}" target="_blank">{{$blogger->name}}</a></td>
											<td>{{$blogger->city->name}}</td>
											<td>
												@php
													$categories= '';
                                                    foreach ($blogger->categories as $category){
                                                        $categories.= $category->name.', ';
                                                    }
                                                    $categories = substr($categories,0,-2);
												@endphp
												{{$categories}}
											</td>
											<td>
												@php
													$subjects = '';
                                                    foreach ($blogger->subjects as $subject){
                                                        $subjects.= $subject->name.', ';
                                                    }
                                                    $subjects = substr($subjects,0,-2);
												@endphp
												{{$subjects}}
											</td>
											<td>
												@php
													$socialnetwork = '';
                                                    if($blogger->instagram_link){
                                                        $socialnetwork .= 'instagram, ';
                                                    }
                                                    if($blogger->facebook_link){
                                                        $socialnetwork .= 'facebook, ';
                                                    }
                                                    if($blogger->youtube_link){
                                                        $socialnetwork .= 'YouTube, ';
                                                    }
                                                    $socialnetwork = substr($socialnetwork,0,-2);
												@endphp
												{{$socialnetwork}}
											</td>
											<td>
												@php
													$socialnetwork = 0;
                                                    if($blogger->instagram_subscriber){
                                                        $socialnetwork += intval($blogger->instagram_subscriber);
                                                    }
                                                    if($blogger->facebook_subscriber){
                                                        $socialnetwork += intval($blogger->facebook_subscriber);
                                                    }
                                                    if($blogger->youtube_subscriber){
                                                        $socialnetwork += intval($blogger->youtube_subscriber);
                                                    }
												@endphp
												{{$socialnetwork}}
											</td>
											<td>{{$blogger_item->format}}</td>
											<td>{{$blogger_item->ohvat}}</td>
											<td>{{$blogger_item->prise_without_nds}}</td>
											<td>{{$blogger_item->link_to_post}}</td>
											<td>{{$blogger_item->screen_post}}</td>
											<td>{{$blogger_item->views}}</td>
											<td>{{$blogger_item->likes}}</td>
											<td>{{$blogger_item->comments}}</td>
											<td>{{$blogger_item->ohvat_fact}}</td>
											<td>{{$blogger_item->er}}</td>
											<td>{{$blogger_item->other}}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
								</div>
                            </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </form>
    </div><!-- /.row -->
	<div class="modal modal-default fade" id="modal-edit-member" style="display: none;">
		<div class="modal-dialog" style="max-width: 400px">
			<div class="modal-content">
				<form action="" method="post" enctype="multipart/form-data" class="validation-form">
					{{ csrf_field() }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Изменить данные об активности блоггера</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="edit_format" class="col-form-label">Формат</label>
							<input type="text" class="form-control" id="edit_format" name="format" >
						</div>
						<div class="form-group">
							<label for="edit_ohvat" class="col-form-label">Охват</label>
							<input type="text" class="form-control" id="edit_ohvat" name="ohvat" >
						</div>
						<div class="form-group">
							<label for="edit_prise_without_nds" class="col-form-label">Цена</label>
							<input type="text" class="form-control" id="edit_prise_without_nds" name="prise_without_nds" >
						</div>
						<div class="form-group">
							<label for="edit_link_to_post" class="col-form-label">Ссылка на пост</label>
							<input type="text" class="form-control" id="edit_link_to_post" name="link_to_post" >
						</div>
						<div class="form-group">
							<label for="edit_screen_post" class="col-form-label">Ссылка на скрин</label>
							<input type="text" class="form-control" id="edit_screen_post" name="screen_post" >
						</div>
						<div class="form-group">
							<label for="edit_views" class="col-form-label">Показы</label>
							<input type="text" class="form-control" id="edit_views" name="views" >
						</div>
						<div class="form-group">
							<label for="edit_likes" class="col-form-label">Лайки</label>
							<input type="text" class="form-control" id="edit_likes" name="likes" >
						</div>
						<div class="form-group">
							<label for="edit_comments" class="col-form-label">Комментарии</label>
							<input type="text" class="form-control" id="edit_comments" name="comments" >
						</div>
						<div class="form-group">
							<label for="edit_ohvat_fact" class="col-form-label">Охват факт</label>
							<input type="text" class="form-control" id="edit_ohvat_fact" name="ohvat_fact" >
						</div>
						<div class="form-group">
							<label for="edit_er" class="col-form-label">ER</label>
							<input type="text" class="form-control" id="edit_er" name="er" >
						</div>
						<div class="form-group">
							<label for="edit_other" class="col-form-label">Прочая активность</label>
							<input type="text" class="form-control" id="edit_other" name="other" >
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
						<button type="submit" class="btn btn-primary" id="success">Сохранить</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
@endsection

@section("scripts")
    <script>
		$('#modal-edit-member').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			modal.find('form').attr('action', button.data('action'))
			modal.find('#edit_format').val(button.data('format'))
			modal.find('#edit_ohvat').val(button.data('ohvat'))
			modal.find('#edit_prise_without_nds').val(button.data('prise_without_nds'))
			modal.find('#edit_link_to_post').val(button.data('link_to_post'))
			modal.find('#edit_screen_post').val(button.data('screen_post'))
			modal.find('#edit_views').val(button.data('views'))
			modal.find('#edit_likes').val(button.data('likes'))
			modal.find('#edit_comments').val(button.data('comments'))
			modal.find('#edit_ohvat_fact').val(button.data('ohvat_fact'))
			modal.find('#edit_er').val(button.data('er'))
			modal.find('#edit_other').val(button.data('other'))
		})
    </script>
@endsection

