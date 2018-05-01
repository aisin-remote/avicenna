@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

  <div class="row">
     <div id="container" style="min-width: 200px; height: 400px;"></div>
  </div>
@endsection

@section('scripts')
  @parent
    <script src="{{ url('/js/highcharts/highcharts.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/highcharts/modules/exporting.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    var data = {  _token: "{{ csrf_token() }}" };   // keep csrf token for session
    var i = 0;
        $.get("{{ url('dashboard/dataunittools') }}", data, function (dataJSON) {
                var categories   =[];
                var std          =[];
                var actual       =[];
                var myseries     =[];

                for(var i=0;i<dataJSON.length;i++){
                   categories.push(dataJSON[i].tools_no);
                   std.push(parseInt(dataJSON[i].std_life_time));
                   actual.push(parseInt(dataJSON[i].actual_life_time));
                }

                $('#container').highcharts({
                   chart: {
                        type: 'column',
                        events: {
                            load: function() {
                                // set up the updating of the chart each second
                                setInterval(function(){
                                    var chart = $("#container").highcharts();

                                    $.get("{{ url('dashboard/dataunittools') }}", data, function(dataJSON) {  //dev-1.0, 20170905, by yudo, modify $getJSON
                                       
                                        var categories   =[];
                                        var std          =[];
                                        var actual       =[];
                                        var myseries = [];

                                        for(var i=0;i<dataJSON.length;i++){
                                         categories.push(dataJSON[i].tools_no);
                                         std.push(parseInt(dataJSON[i].std_life_time));
                                         actual.push(parseInt(dataJSON[i].actual_life_time));
                                        }
                                        chart.series[0].update({data : std});
                                        chart.series[1].update({data : actual});
                                    });
                                }, 5000);
                            }              
                        }
                    },
                    title: {
                        text: 'Tools Machining Status'
                    },
                    xAxis: {
                        categories: categories
                    },
                    series: [{
                        name: 'Standard Life Time',
                        data: std,
                        color: '#5cb85c'
                    }, {
                        name: 'Actual Life Time',
                        data: actual,
                        color: '#d9534f'
                    }]
                    });
                });
  </script>

@endsection