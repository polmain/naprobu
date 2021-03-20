<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
   <!--<title>{{  Request::Get('pageName')  }}</title>-->
    {!! SEO::generate() !!}

    <meta content="{{csrf_token()}}" name="csrf-token">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset ("/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset ("/bower_components/select2/dist/css/select2.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset ("/bower_components/admin-lte/plugins/iCheck/all.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset ("/public/css/admin/bootstrap-datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset ("/public/css/admin/bootstrap-tagsinput.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-red.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/public/css/admin/admin.css")}}?ver=1.0.3" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <!-- Header -->
@include('admin.layouts.header')

<!-- Sidebar -->
@include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ AdminPageData::getPageName() }}

            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {!!   AdminPageData::renderBreadcrumbs() !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('admin.layouts.footer')

</div><!-- ./wrapper -->

<div class="modal modal-warning fade" id="modal-warning" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-outline" id="success">Подтвердить</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
<script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->

<script src="{{ asset ("/bower_components/datatables.net/js/jquery.dataTables.min.js") }}" type="text/javascript"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/natural.js" type="text/javascript"></script>

<script src="{{ asset ("/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}"></script>
<script src="{{ asset ("/bower_components/chart.js/dist/Chart.bundle.min.js") }}"></script>
<script src="{{ asset ("/bower_components/chart.js/dist/Chart.min.js") }}"></script>
<script src="{{ asset ("/bower_components/chartjs-plugin-labels/src/chartjs-plugin-labels.js") }}"></script>
<!-- FastClick -->

<script src="{{ asset ("/bower_components/fastclick/lib/fastclick.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/dist/js/adminlte.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/ckeditor/adapters/jquery.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/select2/dist/js/select2.full.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/public/js/admin/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/public/js/admin/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.ru.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/node_modules/transliterate-cyrillic-text-to-latin-url/module/index.js") }}"></script>
<script src="{{ asset ("/public/js/admin/url_slug.js") }}"></script>
<script src="{{ asset ("/public/js/admin/bootstrap-tagsinput.js") }}"></script>
<script src="{{ asset ("/public/vendor/laravel-filemanager/js/stand-alone-button.js") }}"></script>

<script src="{{ asset ("/public/js/admin/admin.js") }}?=1.2.1" type="text/javascript"></script>
@yield('scripts')



</body>
</html>
