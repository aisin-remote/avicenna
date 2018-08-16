@extends('adminlte::layouts.app')

@section('main-content')

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@endsection

@section('contentheader_title')
  @lang('avicenna/dashboard.default_title')
@endsection

@section('contentheader_description')
  @lang('avicenna/dashboard.dashboard_genba')
@endsection

@section('scripts')
@parent
<script src="{{ url('/js/highcharts/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/highcharts/modules/exporting.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var data = {  _token: "{{ csrf_token() }}" };   // keep csrf token for session
var i = 0;
  
    $.get("{{ url('dashboard/getAjaxGenba') }}", data, function (dataJSON) {
            

            var categories   =[];
            var normal       =[];
            var abnormality  =[];
            var myseries = [];

            for(var i=0;i<dataJSON.length;i++){
               categories.push(dataJSON[i].categories);
               normal.push(parseInt(dataJSON[i].normal));
               abnormality.push(parseInt(dataJSON[i].abnormality));
            }

             
            $('#container').highcharts({

               chart: {
                    // type: 'column'
                    type: 'column',
                    events: {
                        load: function() {

                            // set up the updating of the chart each second
                            setInterval(function(){
                                var chart = $("#container").highcharts();

                                $.get("{{ url('dashboard/getAjaxGenba') }}", data, function(dataJSON) {  //dev-1.0, 20170905, by yudo, modify $getJSON
                                   
                                    var categories   =[];
                                    var normal       =[];
                                    var abnormality  =[];
                                    var myseries = [];

                                    for(var i=0;i<dataJSON.length;i++){
                                       categories.push(dataJSON[i].categories);
                                       normal.push(parseInt(dataJSON[i].normal));
                                       abnormality.push(parseInt(dataJSON[i].abnormality));
                                    }

                                    chart.series[0].update({data : normal});
                                    chart.series[1].update({data : abnormality});

                                });
                            }, 5000);
                        }              
                    }
                },
                title: {
                    text: 'Dashboard Part Model'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Quantity'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        }
                    }
                },
                series: [{
                    name: 'Normal',
                    data: normal,
                    color: '#5cb85c'
                }, {
                    name: 'Abnormality',
                    data: abnormality,
                    color: '#d9534f'
                }]
                });

            });

</script>
@endsection