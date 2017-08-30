@extends('adminlte::layouts.app')

@section('main-content')

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@endsection

@section('scripts')
@parent
<script src="{{ url('/js/highcharts/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/highcharts/modules/exporting.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var data = {  _token: "{{ csrf_token() }}" };   // keep csrf token for session
var i = 0;
        setInterval(function(){
            $.get("{{ url('dashboard/getAjaxMutation') }}", data, function (dataJSON) {
                    

                    var categories2=[];
                    var myseries = [];
                    for(var i=0;i<dataJSON.length;i++){
                       categories2.push(dataJSON[i].part_number);
                       myseries.push(parseInt(dataJSON[i].new_qty));
                    }
                     
                    $('#container').highcharts({
                        chart: {
                            type: 'column'
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
        }, 5000);

</script>
@endsection