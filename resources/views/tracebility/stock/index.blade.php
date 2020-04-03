@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/daterangepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
  <style>
      th {
        text-align: center;
        vertical-align: middle;
      }
  </style>
@endsection

@section('contentheader_title')
    Traceability Stock
@endsection

@section('contentheader_description')
  Inventory Report
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="form-group">
                <div class="box-header">
                <h3 class="box-title">Filter :</h3>
            </div>
            <div class="box-body">
                <form id="filterform">
                    <div class="form-group col-md-6">
                        <label>Product:</label>
                        <div class="input-group">
                            <div class="input-group-addon"> <i class="fa fa-wrench"></i> </div>
                            <select id="product" class="form-control pull-right" style="width: 100% ">
                                <option value="ALL"> ALL </option>
                                @foreach( $models as $model)
                                <option value="{{$model->back_number}}"> {{$model->back_number}} </option>
                                @endforeach
                            </select>
                        </div>

                        <label>Start Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                            <input type="text" class="form-control pull-right" id="start_date" value="{{ date('Y-m-d') }}">
                        </div>

                        <label>End Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                            <input type="text" class="form-control pull-right" id="end_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <br>
                        <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Part Number:</label>
                        <div class="input-group">
                            <label style="font-style: bold; font-size: 20px"> - </label>
                        </div>
                    </div>
                </form>
                <!-- /.form group -->
            </div>
            </div>

            <!-- /.box-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title" id="box-title">Inventory Summary - Today ({{ date('Y-m-d') }})</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblStock" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                    <tr>
                        <th valign="middle" rowspan="2">Back No</th>
                        <th colspan="2">Casting<br>Lastman</th>
                        <th colspan="2">Machining<br>Lastman</th>
                        <th colspan="2">Assembling<br>Lastman</th>
                        <th colspan="2">PPIC<br>Pulling</th>
                    </tr>
                    <tr>
                        <th>Qty</th>
                        <th>Var</th>
                        <th>Qty</th>
                        <th>Var</th>
                        <th>Qty</th>
                        <th>Var</th>
                        <th>Qty</th>
                        <th>Var</th>
                    </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('#start_date').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });
    $('#end_date').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();
    //table
    let table = $('#tblStock').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('trace/stock/index')}}",
        column: [
            { data : 'back_no', name : 'back_no' },
            { data : 'casting_qty', name : 'casting_qty' },
            { data : 'casting_var', name : 'casting_var' },
            { data : 'machining_qty', name : 'machining_qty' },
            { data : 'machining_var', name : 'machining_var' },
            { data : 'assembly_qty', name : 'assembly_qty' },
            { data : 'assembly_var', name : 'assembly_var' },
            { data : 'pulling_qty', name : 'pulling_qty' },
            { data : 'pulling_var', name : 'pulling_var' },
        ]

    });
    //Filter
    $('#buttonfilter').on('click', function(e){
           let product = $('#product' ).val();
           let start_date = $('#start_date').val();
           let end_date = $('#end_date').val();
           let d1 = Date.parse(start_date);
           let d2 = Date.parse(end_date);
           if (start_date == '' || end_date == '') {
            alert('Isi Tanggal Filter');
           }else if(d1 > d2){
            alert('Start date harus lebih lampau dari end date');
           }
           else {
                table.ajax.url("{{ url('/avicenna/stock/mutation/filter').'/'}}"+start_date+'/'+end_date+'/'+line).load();
                $("#box-title")[0].innerHTML = "Inventory Summary - From <strong>"+start_date+"</strong> To <strong>"+end_date+"</strong>";
            }
        });
</script>

@endsection
