@foreach($projects as $project)
    <a href="{{route('project.level2',[$project->url])}}" class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1">
        <div class="project-item ">
            <div class="project-item-image" style="background-image: url({{$project->preview_image}})">
                <div class="project-status-icon project-status-{{(App::getlocale() == 'ru')?$project->status_id:$project->base->status_id}}">
                    <img src="{{asset('public/svg/icons/project_timer.svg')}}" alt="timer">
                </div>
            </div>
            <div class="project-info">
                <div class="project-name">{{$project->name}}</div>
                <div class="project-params"><div class="project-param-name">@lang('project.member_count'):</div><div class="project-param-value">{{$project->count_users}}</div></div>
                @include('project.include.project_item_status')
{{--                <div class="project-params">--}}
{{--                    <div class="project-param-name">@lang('project.register_before'):</div>--}}
{{--                    <div class="project-param-value">{{Carbon::parse($project->end_registration_time)->format('H:i d.m.Y')}}</div>--}}
{{--                </div>--}}
                <div class="project-description">{{ (mb_strlen($project->short_description)>60)?mb_substr($project->short_description, 0, 60).'...' : $project->short_description}}</div>
            </div>
            <div class="project-bottom">
                @if(((App::getlocale() == 'ru')?$project->status_id:$project->base->status_id) == 1)
                    <div>@lang('project.end_project')</div>
                @else
                    <div>@lang('project.detail_project')</div>
                @endif
            </div>
        </div>
    </a>
@endforeach
