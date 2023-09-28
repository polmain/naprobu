<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">Меню</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview{{ Request::segment(2) ==  'project' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Проекты</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->hasRole('admin'))
                        <li{{ (\Request::route()->getName() == 'adm_project') ? ' class=active' : '' }}><a href="{{route("adm_project")}}">Список проектов</a></li>
                        <li{{ (\Request::route()->getName() == 'adm_project_category') ? ' class=active' : '' }}><a href="{{route('adm_project_category')}}">Категории проектов</a></li>
                        <li{{ (\Request::route()->getName() == 'adm_project_subpage') ? ' class=active' : '' }}><a href="{{route('adm_project_subpage')}}">Подстраницы проектов</a></li>
                    @endif
                    <li{{ (\Request::route()->getName() == 'adm_project_request') ? ' class=active' : '' }}><a href="{{route('adm_project_request')}}">Все заявки</a></li>
                    @if(Auth::user()->hasRole('admin'))
                        <li{{ (\Request::route()->getName() == 'adm_project_blogger') ? ' class=active' : '' }}><a href="{{route('adm_project_blogger')}}">Проекты для блоггеров</a></li>
                    @endif
                </ul>
            </li>
            @if(Auth::user()->hasRole('admin'))
            <li class="treeview{{ Request::segment(2) ==  'questionnaire' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    <span>Анкеты</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() == 'adm_questionnaire') ? ' class=active' : '' }}><a href="{{route("adm_questionnaire")}}">Список анкет</a></li>
                </ul>
            </li>
            @endif
            <li class="treeview{{ Request::segment(2) ==  'reviews' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span>Отзывы</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() == 'adm_review') ? ' class=active' : '' }}><a href="{{route("adm_review")}}">Все отзывы</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_comment') ? ' class=active' : '' }}><a href="{{route("adm_comment")}}">Все комментарии</a></li>
                </ul>
            </li>
            <li class="treeview{{ Request::segment(2) ==  'blog' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    <span>Блог</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->hasRole('admin'))
                        <li{{ (\Request::route()->getName() == 'adm_post') ? ' class=active' : '' }}><a href="{{route("adm_post")}}">Все статьи</a></li>
                        <li{{ (\Request::route()->getName() == 'adm_post_tag') ? ' class=active' : '' }}><a href="{{route("adm_post_tag")}}">Все теги</a></li>
                    @endif
                    <li{{ (\Request::route()->getName() == 'adm_post_comment') ? ' class=active' : '' }}><a href="{{route("adm_post_comment")}}">Все комментарии</a></li>
                </ul>
            </li>
            @if(Auth::user()->hasRole('admin'))
            <li{!!  Request::segment(2) ==  'page' ? ' class="active"' : ''   !!}>
                <a href="{{route("adm_page")}}">
                    <i class="fa fa-file-o" aria-hidden="true">
                    </i> <span>Страницы</span></a>
            </li>
            <li{!! Request::segment(2) ==  'menu' ? ' class="active"' : '' !!}><a href="{{route("adm_menu")}}"><i class="fa fa-bars" aria-hidden="true"></i> <span>Меню</span></a></li>
            <li{!! Request::segment(2) ==  'brand' ? ' class="active"' : '' !!}><a href="{{route("adm_brand")}}"><i class="fa fa-suitcase" aria-hidden="true"></i> <span>Брэнды</span></a></li>
            <li{!! Request::segment(2) ==  'faq' ? ' class="active"' : '' !!}><a href="{{route("adm_faq")}}"><i class="fa fa-comments-o" aria-hidden="true"></i> <span>FAQ</span></a></li>
            @endif
            <li class="treeview{{ Request::segment(2) ==  'users' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Пользователи</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() == 'adm_users') ? ' class=active' : '' }}><a href="{{route("adm_users")}}">Все пользователи</a></li>
                    @if(Request::user()->hasRole('admin'))
                    <li{{ (\Request::route()->getName() == 'adm_users_moderators') ? ' class=active' : '' }}><a href="{{route('adm_users_moderators')}}">Модераторы</a></li>
                    @endif
                    <li{{ (\Request::route()->getName() == 'adm_users_bloger') ? ' class=active' : '' }}><a href="{{route('adm_users_bloger')}}">Блогеры</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_users_expert') ? ' class=active' : '' }}><a href="{{route('adm_users_expert')}}">Эксперты</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_users_statuses_log') ? ' class=active' : '' }}><a href="{{route('adm_users_statuses_log')}}">Лог смены статусов</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_present') ? ' class=active' : '' }}><a href="{{route('adm_present')}}">Подарки</a></li>
                    @if(Auth::user()->hasRole('admin'))
                    <li{{ (\Request::route()->getName() == 'adm_users_export') ? ' class=active' : '' }}><a href="{{route('adm_users_export')}}">Экспорт пользователей Excel</a></li>
                        @endif
                    <li{{ (\Request::route()->getName() == 'adm_blogger_requests') ? ' class=active' : '' }}><a href="{{route("adm_blogger_requests")}}">Верефикация блогеров</a></li>
                    <li{{ (\Request::route()->getName() == 'admin.phone.all') ? ' class=active' : '' }}><a href="{{route("admin.phone.all")}}">Верефикация телефонов</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_users_archive') ? ' class=active' : '' }}><a href="{{route("adm_users_archive")}}">Архив</a></li>
                </ul>
            </li>
            <li class="treeview{{ in_array (Request::segment(2),['countries','regions','cities']) ? ' active' : ''   }}">
                <a href="#"><i class="fa fa-globe" aria-hidden="true"></i>
                     <span>Локации</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() === 'admin.country.all') ? ' class=active' : '' }}><a href="{{ route('admin.country.all')}}">Страны</a></li>
                    <li{{ (\Request::route()->getName() === 'admin.region.all') ? ' class=active' : '' }}><a href="{{ route('admin.region.all')}}">Области/Штаты</a></li>
                    <li{{ (\Request::route()->getName() === 'admin.city.all') ? ' class=active' : '' }}><a href="{{ route('admin.city.all')}}">Город</a></li>
                </ul>
            </li>
            <li class="treeview{{ in_array (Request::segment(2),['feedback']) ? ' active' : ''   }}">
                <a href="#"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                     <span>Уведомления</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() == 'adm_feedback') ? ' class=active' : '' }}><a href="{{ route('adm_feedback')}}">Сообщения</a></li>
                </ul>
            </li>
            @if(Auth::user()->hasRole('admin'))
            <li class="treeview{{ Request::segment(2) ==  'settings' ? ' active' : ''  }}">
                <a href="#">
                    <i class="fa fa-sliders"></i>
                    <span>Настройки</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li{{ (\Request::route()->getName() == 'adm_mainpage_settings') ? ' class=active' : '' }}><a href="{{route("adm_mainpage_settings")}}">Настройки Главной страницы</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_seo_settings') ? ' class=active' : '' }}><a href="{{route("adm_seo_settings")}}">Настройки SEO</a></li>
                    <li{{ (\Request::route()->getName() == 'adm_user_rating_settings') ? ' class=active' : '' }}><a href="{{route("adm_user_rating_settings")}}">Рейтинг пользователей</a></li>
                </ul>
            </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
