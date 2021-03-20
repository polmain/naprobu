
<nav class="user-page-menu">
    <ul class="row">
        <li class="col-md col-sm-4">
            <a href="{{route('user.cabinet')}}"{!! (\Request::route()->getName() == 'user.cabinet') ?' class="active"':"" !!}>@lang('user.menu_questionnaire')</a>
        </li>
        <li class="col-md col-sm-4">
            <a href="{{route('user.project')}}"{!! (\Request::route()->getName() == 'user.project') ?' class="active"':"" !!}>@lang('user.menu_project')</a>
        </li>
        <li class="col">
            <a href="{{route('user.review')}}"{!! (\Request::route()->getName() == 'user.review') ?' class="active"':"" !!}>@lang('user.menu_review')</a>
        </li>
        <li class="col-md col-sm-4">
            <a href="{{route('user.rating')}}"{!! (\Request::route()->getName() == 'user.rating') ?' class="active"':"" !!}>@lang('user.menu_rating')</a>
        </li>
        <li class="col-md col-sm-4">
            <a href="{{route('user.notification')}}"{!! (\Request::route()->getName() == 'user.notification') ?' class="active"':"" !!}>@lang('user.menu_notification')</a>
        </li>
        <li class="col">
            <a href="{{route('user.setting')}}"{!! (\Request::route()->getName() == 'user.setting') ?' class="active"':"" !!}>@lang('user.menu_setting')</a>
        </li>
    </ul>
</nav>