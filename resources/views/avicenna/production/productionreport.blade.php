@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
PRODUCTION REPORT
@endsection

@section('contentheader_description')

@endsection

@section('main-content')

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="form-row">
            <div class="box-body">
                <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label >DATE</label>
                            <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input type="text" class="form-control pull-right" id="date" name="date" >
                                
                            </div>
                        <label >LINE</label>
                            <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <select class="form-control" id="line" name="line">
                                    <option>AS600</option>
                                </select>
                                
                            </div>
                        <label>PERIODE</label>
                             <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <select class="form-control" id="time" name="time">
                                    <option value="1" class="form-control">PAGI</option>
                                    <option value="2" class="form-control">MALAM</option>
                                </select>
                                
                            </div>
                    <br>
                    <button class="btn btn-success" id="buttonfilter" onclick="addCookies()"> Filter </button>
                    <button class="btn btn-success" id="buttonfilter" onclick="filter()"> Export </button>
                <!-- /.input group -->
                </div>
                
                <!-- /.form group -->
            </div>
            <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
    </div>

</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">PRODUCTION REPORT</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div style="overflow-y: scroll;">
              <table id="tblreport" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th rowspan="2" >Back Number</th>
                    <th rowspan="2">Part Number</th>
                    <th rowspan="2">CT</th>
                    <th colspan="2">01:00</th>
                    <th colspan="2">02:00</th>
                    <th colspan="2">03:00</th>
                    <th colspan="2">04:00</th>
                    <th colspan="2">05:00</th>
                    <th colspan="2">06:00</th>
                    <th colspan="2">07:00</th>
                    <th colspan="2">08:00</th>
                    <th colspan="2">09:00</th>
                    <th colspan="2">10:00</th>
                    <th colspan="2">11:00</th>
                    <th colspan="2">12:00</th>
                    <th colspan="2">13:00</th>
                    <th colspan="2">14:00</th>
                    <th colspan="2">15:00</th>
                    <th colspan="2">16:00</th>
                    <th colspan="2">17:00</th>
                    <th colspan="2">18:00</th>
                    <th colspan="2">19:00</th>
                    <th colspan="2">20:00</th>
                    <th colspan="2">21:00</th>
                    <th colspan="2">22:00</th>
                    <th colspan="2">23:00</th>
                    <th colspan="2">24:00</th>
                  </tr>
                  <tr>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                    <th>QTY</th>
                    <th>TIME</th>
                  </tr>
                </thead>
                    @foreach ($hours as $hour)
                    <tr>
                        <td>{{$hour->back_number}}</td>
                        <td>{{$hour->part_number}}</td>
                        <td>{{$hour->ct}}</td>
                        <td>{{$hour->qty_1}}</td>
                        <td>{{$hour->time_1}}</td>
                        <td>{{$hour->qty_2}}</td>
                        <td>{{$hour->time_2}}</td>
                        <td>{{$hour->qty_3}}</td>
                        <td>{{$hour->time_3}}</td>
                        <td>{{$hour->qty_4}}</td>
                        <td>{{$hour->time_4}}</td>
                        <td>{{$hour->qty_5}}</td>
                        <td>{{$hour->time_5}}</td>
                        <td>{{$hour->qty_6}}</td>
                        <td>{{$hour->time_6}}</td>
                        <td>{{$hour->qty_7}}</td>
                        <td>{{$hour->time_7}}</td>
                        <td>{{$hour->qty_8}}</td>
                        <td>{{$hour->time_8}}</td>
                        <td>{{$hour->qty_9}}</td>
                        <td>{{$hour->time_9}}</td>
                        <td>{{$hour->qty_10}}</td>
                        <td>{{$hour->time_10}}</td>
                        <td>{{$hour->qty_11}}</td>
                        <td>{{$hour->time_11}}</td>
                        <td>{{$hour->qty_12}}</td>
                        <td>{{$hour->time_12}}</td>
                        <td>{{$hour->qty_13}}</td>
                        <td>{{$hour->time_13}}</td>
                        <td>{{$hour->qty_14}}</td>
                        <td>{{$hour->time_14}}</td>
                        <td>{{$hour->qty_15}}</td>
                        <td>{{$hour->time_15}}</td>
                        <td>{{$hour->qty_16}}</td>
                        <td>{{$hour->time_16}}</td>
                        <td>{{$hour->qty_17}}</td>
                        <td>{{$hour->time_17}}</td>
                        <td>{{$hour->qty_18}}</td>
                        <td>{{$hour->time_18}}</td>
                        <td>{{$hour->qty_19}}</td>
                        <td>{{$hour->time_19}}</td>
                        <td>{{$hour->qty_20}}</td>
                        <td>{{$hour->time_20}}</td>
                        <td>{{$hour->qty_21}}</td>
                        <td>{{$hour->time_21}}</td>
                        <td>{{$hour->qty_22}}</td>
                        <td>{{$hour->time_22}}</td>
                        <td>{{$hour->qty_23}}</td>
                        <td>{{$hour->time_23}}</td>
                        <td>{{$hour->qty_24}}</td>
                        <td>{{$hour->time_24}}</td>
                    </tr>
                    @endforeach
              </table>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection

@section('scripts')
@parent
<script src="{{ asset('/js/jquery-cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"></script>

<script type="text/javascript">
    // {{-- dev-1.0, Ferry, 20171004, Init all input --}}
    $( document ).ready(function() {

    });

    $('#date').datepicker({
        autoclose: true,  
        format: "yyyy-mm-dd"
    });

    function addCookies() {
        var date = $('#date').val(); 
        var line = $('#line').val(); 
        var time = $('#time').val();
        $.cookie("date",""+date+"");
        $.cookie("line",""+line+"");
        $.cookie("time",""+time+"");

                $('#btn-submit').attr('disabled','disabled');
                var path="{{ url('/production/report/filter') }}";
                document.body.innerHTML += '<form id="Form" action='+path+' method="post">'+
                '<input type="hidden" name="date" value="'+$('#date').val()+'">'+
                '<input type="hidden" name="line" value="'+$('#line').val()+'">'+
                '<input type="hidden" name="time" value="'+$('#time').val()+'">'+
                '<input type="hidden" name="_token" value="{{csrf_token() }}">'+
                '</form>';
                $("#Form").submit().remove();
    };

    function filter() {
        var date = $.cookie("date"); 
        var line = $.cookie("line");  
        var time = $.cookie("time");
                $('#btn-submit').attr('disabled','disabled');
                var path="{{ url('/production/report/export') }}";
                document.body.innerHTML += '<form id="Form" action='+path+' method="post">'+
                '<input type="hidden" name="date" value="'+date+'">'+
                '<input type="hidden" name="line" value="'+line+'">'+
                '<input type="hidden" name="time" value="'+time+'">'+
                '<input type="hidden" name="_token" value="{{csrf_token() }}">'+
                '</form>';
                $("#Form").submit().remove();

    };




    

</script>

@endsection
