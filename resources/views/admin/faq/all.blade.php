@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Панель управления</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary check_all">Отметить все</button>
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/faq/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/faq/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteFaqCategories()">Удалить</button>
                    </div>
                    <a href="{{route('adm_faq_new')}}" class="btn btn-primary pull-right">Создать группу</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список групп</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/faq/--action--/--id--/">
                    <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="questionnaire-table">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th class="text-center">Название</th>
                            <th width="60" class="text-center">Колечетсво вопросов</th>
                            <th width="20" class="text-center">Порядок</th>
                            <th width="20">Скрыта</th>
                            <th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
							@foreach($faqCategories as $category)
								<tr>
									<td class="text-center">
										<label>
											 <input type="checkbox" class="minimal-red checkbox-item" id="item-{{$category->id}}"  value="true">
										</label>
									</td>
									<td>
										<a href="{{route('adm_faq_edit',[$category->id])}}">{{$category->name}}</a>
									</td>
									<td class="text-center">
										{{ $category->questions_count}}
									</td>
									<td class="text-center">
										{{ $category->sort}}
									</td>
									<td class="text-center">
										<label>
											<input type="checkbox" class="minimal-red show-hide" id="show-hide-{{$category->id}}"  value="true" {{($category->isHide == 1)?'checked':''}}>
										</label>
									</td>
									<td class="text-center">
										<button class="btn btn-danger delete-ajax" id="delete-{{$category->id}}" onclick="deleteFaqCategory({{$category->id}})">Удалить</button>
									</td>
								</tr>
							@endforeach
                        </tbody>
                    </table>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-primary check_all">Отметить все</button>
                    <div class="inline">С выбранными:
                        <button class="btn btn-default" onclick="groupAjax('/admin/faq/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/faq/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteFaqCategories()">Удалить</button>
                    </div>
                    <a href="{{route('adm_faq_new')}}" class="btn btn-primary pull-right">Создать группу</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection