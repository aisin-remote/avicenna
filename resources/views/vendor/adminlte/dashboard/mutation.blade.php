@extends('adminlte::layouts.app')

@section('main-content')

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@endsection

@section('contentheader_title')
  @lang('avicenna/dashboard.default_title')
@endsection

@section('contentheader_description')
  @lang('avicenna/dashboard.dashboard_mutation')
@endsection

@section('scripts')
@parent
<script src="{{ url('/js/highcharts/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/highcharts/modules/exporting.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var data = {  _token: "{{ csrf_token() }}" };   // keep csrf token for session
var i = 0;
   
            $.get("{{ url('dashboard/getAjaxMutation') }}", data, function (dataJSON) {
                    

                    var categories2=[];
                    var myseries = [];
                    for(var i=0;i<dataJSON.length;i++){
                       categories2.push(dataJSON[i].part_number);
                       myseries.push(parseInt(dataJSON[i].new_qty));
                    }
                     
                    $('#container').highcharts({
                        chart: {
                                type: 'column',
                                events: {
                                    load: function() {

                                        // set up the updating of the chart each second
                                        setInterval(function(){
                                            var chart = $("#container").highcharts();

                                            $.get("{{ url('dashboard/getAjaxMutation') }}", data, function(dataJSON) {  //dev-1.0, 20170905, by yudo, modify $getJSON
                                               
                                                var myseries = [];

                                                for(var i=0;i<dataJSON.length;i++){
                                                   myseries.push(parseInt(dataJSON[i].new_qty));
                                                }
                                                
                                                chart.series[0].update({data : myseries});
                                            
                                            });

                                        }, 5000);
                                    }              
                                }
                        },
                        title: {
                            text: 'Dashboard Stock'
                        },
                        xAxis: {
                            categories: categories2
                        },
                        credits: {
                            enabled: false
                        },
                        series: [
                        {       
                               name: ['Part Number'],
                               data: myseries
                        }
                         
                       ]
                    });

            });
       

</script>
@endsection