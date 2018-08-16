@extends('adminlte::layouts.app')

@section('main-content')

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@endsection

@section('contentheader_title')
  @lang('avicenna/dashboard.default_title')
@endsection

@section('contentheader_description')
  @lang('avicenna/dashboard.dashboard_model')
@endsection

@section('scripts')
@parent
<script src="{{ url('/js/highcharts/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/highcharts/modules/exporting.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var data = {  _token: "{{ csrf_token() }}" };   // keep csrf token for session
var i = 0;
  
     $('#container').highcharts({
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Dashboard Part'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        title: {
            text: 'Temperature',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        opposite: true

    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 80,
        verticalAlign: 'top',
        y: 55,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Part(Back Number)',
        type: 'column',
        yAxis: 1,
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
        tooltip: {
            valueSuffix: ' mm'
        }

    }, {
        name: 'Min. Stock',
        type: 'spline',
        yAxis: 2,
        data: [1016, 1016, 1015.9, 1015.5, 1012.3, 1009.5, 1009.6, 1010.2, 1013.1, 1016.9, 1018.2, 1016.7],
        // marker: {
        //     enabled: false
        // },
        // dashStyle: 'shortdot',
        color: '#5cb85c'

    }, {
        name: 'Max. Stock',
        type: 'spline',
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
        color: '#d9534f'
    }]
});



</script>
@endsection