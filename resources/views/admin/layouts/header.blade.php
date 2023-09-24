<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/admin" class="logo">
        <span class="logo-mini">NA<b>P</b></span>
        <span class="logo-lg">NA-<b>PROBY</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href='{{ route('adm_feedback')}}?filter=["isNew",1]'>
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">{{ Request::Get('feedbackCount') }}</span>
                    </a>
                </li><!-- /.messages-menu -->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href='{{ route('adm_present')}}?filter=["isGet",1],["isSent",0]'>
                        <i class="fa fa-gift"></i>
                        <span class="label label-primary">{{ Request::Get('presentCount') }}</span>
                    </a>
                </li><!-- /.messages-menu -->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href='{{ route('adm_present')}}?filter=["isGet",1],["isSent",0]'>
                        <i class="fa fa-users"></i>
                        <span class="label label-default">{{ Request::Get('totalBloggerNotifications') }}</span>
                    </a>
                </li><!-- /.messages-menu -->

                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href='{{ route('admin.phone.all') }}?filter=["is_verify",0]'>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span class="label label-danger">{{ Request::Get('notVerifyPhoneCount') }}</span>
                    </a>
                </li><!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">{{ Request::Get('totalNotifications') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ Request::Get('totalNotifications') }} новых событий</li>
                        <li>
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href='{{ route('adm_project_request')}}?status%5B1%5D=1'>
                                        <i class="fa fa-users text-red"></i> {{ Request::Get('requestsCount') }} новых заявок для участия в проектах
                                    </a>
                                </li><!-- end notification -->
                                <li><!-- start notification -->
                                    <a href='{{ route('adm_review')}}?filter=["status_id",1]'>
                                        <i class="fa fa-comment-o text-blue"></i> {{ Request::Get('reviewsCount') }} новых отзывов
                                    </a>
                                </li><!-- end notification -->
                                <li><!-- start notification -->
                                    <a href='{{ route('adm_comment') }}?filter=["status_id",1]'>
                                        <i class="fa fa-comments text-yellow"></i> {{ Request::Get('commentsCount') }} новых комментариев к отзывам
                                    </a>
                                </li>
                                <li><!-- start notification -->
                                    <a href='{{ route('adm_post_comment') }}?filter=["status_id",1]'>
                                        <i class="fa fa-comments text-green"></i> {{ Request::Get('commentsBlogCount') }} новых комментариев к статьям
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i>
                        <span class="label label-info">{{ Request::Get('totalGeoNotifications') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ Request::Get('totalGeoNotifications') }} новых локаций</li>
                        <li>
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href='{{ route('admin.region.all') }}?filter=["is_verify",0]'>
                                        <i class="fa fa-globe text-navy" aria-hidden="true"></i> {{ Request::Get('noVerifyRegionCount') }} неверефицированных областей
                                    </a>
                                </li>
                                <li><!-- start notification -->
                                    <a href='{{ route('admin.city.all') }}?filter=["is_verify",0]'>
                                        <i class="fa fa-map-marker text-light-blue" aria-hidden="true"></i> {{ Request::Get('noVerifyCityCount') }} неверефицированных городов
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("/public/uploads/images/avatars/".Auth::user()->avatar) }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("/public/uploads/images/avatars/".Auth::user()->avatar) }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} - {{ Auth::user()->roles->first()->name }}
                                <small>Зарегистрирован {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d.m.Y h:i') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin/users/profile" class="btn btn-default btn-flat">Личный кабинет</a>
                            </div>
                            <div class="pull-right">
                                <a href="/admin/logout" class="btn btn-default btn-flat">Выход</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
