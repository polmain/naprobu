@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class="col-md-6">
            @php
            $i = 1;
            @endphp
        @foreach($questions as $question)
            @if(($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5) && ($i%2!=0))

            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$question->name}}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart_{{$question->id}}" style="height:250px"></canvas>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            @endif
                @php
                    $i ++;
                @endphp
        @endforeach
        </div><!-- /.col -->
        <div class="col-md-6">
            @php
            $i = 1;
            @endphp
        @foreach($questions as $question)
            @if(($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5) && ($i%2==0))

            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$question->name}}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart_{{$question->id}}" style="height:250px"></canvas>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            @endif
                @php
                    $i ++;
                @endphp
        @endforeach
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section('scripts')
    <script>
        var colors = [
            "#00c0ef",
            "#00a65a",
            "#f39c12",
            "#f56954",
            "#39CCCC",
            "#d2d6de",
            "#605ca8",
			"#ff851b",
            "#3c8dbc",
			"#D81B60",
			"#001F3F",

            "#00efc0",
            "#005aa6",
            "#f3129c",
            "#f55469",
            "#CC39CC",
            "#ded2d6",
            "#60a85c",
			"#ff1b85",
            "#3cbc8d",
			"#60D81B",
			"#3F441F",

        ];
    </script>
    @foreach($questions as $question)
        @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)
            <script>
                var datasetsData = [];
                var labels = [];
                var bgc = [];
				var doughnutData = [];
                @php
                $i = 0;
                @endphp
                @foreach($question->options as $child)
                @if($child->rus_lang_id == 0)
					labels.push("{{$child->name}}");
				    datasetsData.push({{$child->answers->count()}});
				    doughnutData.push({
						value: {{$child->answers->count()}},
						color:  colors[{{$i}}],
						highlight: colors[{{$i}}],
						label: "{{$child->name}}"
					});
                @php
                    $i ++;
                @endphp
                @endif
                @endforeach

				var data = {

					datasets: [{
						data: datasetsData,
						backgroundColor: colors
					}],

					// These labels appear in the legend and in the tooltips when hovering different arcs
					labels: labels,

				};
				var ctx{{$question->id}} = document.getElementById("chart_{{$question->id}}").getContext('2d');
				var myDoughnutChart{{$question->id}} = new Chart(ctx{{$question->id}}, {
					type: 'doughnut',
					data: data,
					options: {
						plugins: {
							labels: {
								render: 'percentage',
								fontColor: function (data) {
									var rgb = hexToRgb(data.dataset.backgroundColor[data.index]);
									var threshold = 140;
									var luminance = 0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b;
									return luminance > threshold ? 'black' : 'white';
								},
								precision: 2
							}
						}
					}
				});
            </script>
        @endif
    @endforeach
@endsection