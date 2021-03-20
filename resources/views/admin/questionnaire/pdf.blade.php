<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$questionnaire->name}}: {{$questionnaire->project->name}}</title>
    <style>
        th{
            text-align: left;
        }
        .legends:after{
            display: block;
            content: '';
            clear: both;
        }
        .doughnut-legend{
            list-style: none;
            padding-left: 0;
        }
        .doughnut-legend li{
            width: 100%;
        }
        .pie-legend {
            list-style: none;
        }

        .indicator_box {
            width: 55px;
            height: 5px;
            padding: 5px;
            margin: 5px 10px 5px 10px;
            padding-left: 5px;
            display: block;
            float: left;
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        table, tr, td, th, tbody, thead, tfoot {
            page-break-inside: avoid !important;
        }
        td,th{
            padding: 5px 10px;
        }
    </style>
    <script src="http://www.bezanilla-solar.cl/libs/jscripts/DevExpressChartJS/Demos/js/jquery-1.10.2.min.js"></script>
    <script src="http://www.bezanilla-solar.cl/libs/jscripts/DevExpressChartJS/Demos/js/knockout-3.0.0.js"></script>
    <script src="http://www.bezanilla-solar.cl/libs/jscripts/DevExpressChartJS/Demos/js/globalize.min.js"></script>
    <script src="http://www.bezanilla-solar.cl/libs/jscripts/DevExpressChartJS/Demos/js/dx.chartjs.js"></script>

</head>
<body>
<h1 style="text-align: center">{{$questionnaire->name}}: {{$questionnaire->project->name}}</h1>
<h2 style="text-align: center">Диаграммы</h2>
@php
    $i=0;
    $count = $questions->whereIn('type_id',[3,4,5])->count();
@endphp
@foreach($questions as $question)
    @if(($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5))
        <h2>{{$question->name}}</h2>
        <table width="100%">
            <tr>
                <td>
                    <div id="chart_{{$question->id}}" style="width: 900px; height: 400px;"></div>
                </td>
            </tr>
        </table>
        @if(++$i%2==0 && $i<$count)
            <div class="page"></div>
        @endif
    @endif
@endforeach
<script src="{{ asset ("/public/js/admin/Chart.min.js") }}"></script>
<script>

</script>
@foreach($questions as $question)
    @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)
        <script>
			var dataSource = [
			];
            @foreach($question->options as $child)
            @if($child->rus_lang_id == 0)
			dataSource.push({
				answer: "{{$child->name}}",
				count: {{$child->answers->count()}},
			});
                    @endif
                    @endforeach

             @if($question->type_id != 4)
			$("#chart_{{$question->id}}").dxPieChart({
				dataSource: dataSource,
				legend: {
					orientation: "horizontal",
					itemTextPosition: "right",
					horizontalAlignment: "center",
					verticalAlignment: "top",
					rowCount: 2
				},
				series: [{
					argumentField: "answer",
					valueField: "count",
					palette: "soft",
					label: {
						visible: true,
						font: {
							size: 14
						},
						connector: {
							visible: true,
							width: 0.5
						},
						position: "rows",
						customizeText: function(arg) {
							//return arg.valueText + " ( " + arg.percentText + ")";
							return arg.percentText;
						}
					}
				}]
			});
            @else
			$("#chart_{{$question->id}}").dxChart({
				dataSource: dataSource,
				rotated: true,
				series: [{
					argumentField: "answer",
					valueField: "count",

                    type: "bar",
					selectionMode: "allArgumentPoints",

				}],
				legend: {
					visible: false,
				},


			});
            @endif
        </script>
    @endif
@endforeach
</body>
</html>