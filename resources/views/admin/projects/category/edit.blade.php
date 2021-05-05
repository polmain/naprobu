@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_category_save',['category_id'=>$category->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры категории</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    @php
                        $categoryUA = $category->translate->firstWhere('lang','ua');
                        $categoryEN = $category->translate->firstWhere('lang','en');
                    @endphp
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название категории<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" value="{{$category->name}}" placeholder="Введите название категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название категории<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name required" value="{{$categoryUA? $categoryUA->name : ''}}" placeholder="Введите название категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название категории<span class="input-request">*</span></label>
                                <input type="text" id="name-en" name="nameEN" class="form-control project-name required" value="{{$categoryEN? $categoryEN->name : ''}}" placeholder="Введите название категории...">
                            </div>
                        </div>
                        <div class="form-group project-url edit" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/project/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/project/</span><span class="edit-part">{{$category->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/project/<input type="text" class="new-url" name="url" value="{{$category->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/project/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/project/</span><span class="edit-part">{{$categoryUA? $categoryUA->url : ''}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/project/<input type="text" class="new-url" name="urlUA" value="{{$categoryUA? $categoryUA->url : ''}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit" id="project-url-en"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/project/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/project/</span><span class="edit-part">{{$categoryEN? $categoryEN->url : ''}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/project/<input type="text" class="new-url" name="urlEN" value="{{$categoryEN? $categoryEN->url : ''}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <script>
					var isURLRoute = "{{route('adm_project_valid_url',[$category->id])}}";
                </script>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SEO категории</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{$category->seo_title}}" placeholder="Введите Title категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="titleUA" class="form-control" value="{{$categoryUA? $categoryUA->seo_title : ''}}" placeholder="Введите Title категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Title</label>
                                <input type="text" id="titleEN" name="titleEN" class="form-control" value="{{$categoryEN? $categoryEN->seo_title : ''}}" placeholder="Введите Title категории...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Введите Description категории...">{{$category->seo_description}}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="descriptionUA" rows="5" placeholder="Введите Description категории...">{{$categoryUA? $categoryUA->seo_description : ''}}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Description</label>
                                <textarea class="form-control" name="descriptionEN" rows="5" placeholder="Введите Description категории...">{{$categoryEN? $categoryEN->seo_description : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="keywords" value="{{$category->seo_keyword}}"  placeholder="Введите Keywords категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsUA" value="{{$categoryUA? $categoryUA->seo_keyword : ''}}"  placeholder="Введите Keywords категории...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsEN" value="{{$categoryEN? $categoryEN->seo_keyword : ''}}"  placeholder="Введите Keywords категории...">
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Опубликовать</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="submit" name="submit" value="save-hide" class="btn btn-block btn-primary btn-lg">Сохранить в черновик</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/category/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection
