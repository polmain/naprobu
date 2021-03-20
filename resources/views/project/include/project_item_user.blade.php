@foreach($projects as $request)
    @php($project = $request->project)
    @if(App::getlocale() == 'ua')
        @if(empty($project->translate))
            @continue
        @endif
    @endif
    <div class="col-lg-6 col-md-6 col-sm-10 offset-md-0 offset-sm-1">
        <div class="project-item{{(($project->status_id) == 1)?" project-item-end":''}}" >
            <a class="project-item-image" style="background-image: url({{$project->preview_image}})" href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}">
                <div class="project-status-icon project-status-{{$project->status_id}}">
                    <svg id="icon_новый_проект" data-name="icon новый проект" xmlns="http://www.w3.org/2000/svg" width="50.312" height="56.44" viewBox="0 0 50.312 56.44">
                        <defs>
                            <style>
                                .cls-1, .cls-5 {
                                    fill: #052b5f;
                                }

                                .cls-1, .cls-4, .cls-6 {
                                    fill-rule: evenodd;
                                }

                                .cls-2 {
                                    fill: #e4e4e4;
                                }

                                .cls-3 {
                                    fill: #ededed;
                                }
                                .cls-6 {
                                    fill: none;
                                    stroke: #052b5f;
                                    stroke-width: 3px;
                                }
                            </style>
                        </defs>
                        <path id="Прямоугольник_скругл._углы_1" data-name="Прямоугольник, скругл. углы 1" class="cls-1" d="M412.974,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.786,0.786,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,412.974,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                        <path id="Прямоугольник_скругл._углы_1_копия" data-name="Прямоугольник, скругл. углы 1 копия" class="cls-1" d="M448.337,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.788,0.788,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,448.337,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                        <ellipse id="Эллипс_2_копия" data-name="Эллипс 2 копия" class="cls-2" cx="24.812" cy="31.22" rx="21.75" ry="21.75"/>
                        <rect id="Прямоугольник_скругл._углы_2" data-name="Прямоугольник, скругл. углы 2" class="cls-5" x="20.625" width="8.594" height="6.22" rx="2" ry="2"/>
                        <path id="Эллипс_1" data-name="Эллипс 1" class="cls-6" d="M434.5,1558.66a23.655,23.655,0,1,1-23.656,23.65A23.654,23.654,0,0,1,434.5,1558.66Z" transform="translate(-409.344 -1551.03)"/>
                    </svg>
                </div>
            </a>
            <a class="project-info" href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}">

                <div class="project-name">{{(App::getLocale() == "ru")?$project->name:$project->translate->name}}</div>

                <div class="project-params"><div class="project-param-name">@lang('project.member_count'):</div><div class="project-param-value">{{$project->count_users}}</div></div>
                @include('project.include.project_item_status')
{{--                <div class="project-params"><div class="project-param-name">@lang('project.register_before'):</div><div class="project-param-value">{{Carbon::parse($project->end_registration_time)->format('H:i d.m.Y')}}</div></div>--}}
                <div class="project-description">{{ (mb_strlen($project->short_description)>60)?mb_substr($project->short_description, 0, 60).'...' : $project->short_description}}</div>
            </a>
            <div class="project-bottom">
                @switch($project->status_id)
                    @case(2)
                        {{--<a href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}" class="project-action-link">@lang('user.get_status_request')</a>--}}
                        @break
                    @case(7)
                    @if($request->status_id == 7)
                        @if(empty($request->shipping))
                            <div class="project-action-link">@lang('user.not_shipping')</div>
                        @else
                            <div class="project-action-link">@lang('user.ttn_shipping') {{$request->shipping->ttn}}</div>
                        @endif
                        @break
                    @endif
                    @case(6)
                    @if($request->status_id == 7)
                        <a href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}" class="project-action-link">@lang('user.send_review')</a>
                        @break
                    @endif
                    @case(5)
                    @if($request->status_id == 7)
                        <a href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}" class="project-action-link">@lang('user.write_report')</a>
                        @break
                    @endif
                @endswitch

                    @if($project->questionnaires->where('type_id',4)->first() && $request->status_id == 9)
                        <a href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}" class="project-action-link">@lang('user.write_post_report')</a>
                    @endif
                    <a href="{{route('project.level2',[(App::getLocale() == "ru")?$project->url:$project->translate->url])}}">@lang('project.detail_project')</a>
            </div>
        </div>
    </div>
@endforeach
