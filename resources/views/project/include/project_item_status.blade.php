<div class="project-params">
    <div class="project-param-name">{{$project->status->name}}:</div>
    <div class="project-param-value">
        @switch($project->status_id)
            @case(4)
            @case(11)
            {{ Carbon::parse($project->start_registration_time)->format('H:i d.m.Y')}}
            @break
            @case(2)
            @case(9)
            {{ Carbon::parse($project->end_registration_time)->format('H:i d.m.Y')}}
            @break
            @case(7)
            @case(14)
            {{ Carbon::parse($project->start_test_time)->format('d.m.Y')}}
            @break
            @case(6)
            @case(13)
            {{ Carbon::parse($project->start_report_time)->format('H:i d.m.Y')}}
            @break
            @case(5)
            @case(12)
            {{ Carbon::parse($project->end_project_time)->format('d.m.Y')}}
            @break
            @case(1)
            @case(8)
            @case(3)
            @case(10)
            {{ Carbon::parse($project->end_project_time)->format('H:i d.m.Y')}}
            @break
        @endswitch
    </div>
</div>