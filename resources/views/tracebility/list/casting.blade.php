@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  Jejak para produk
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Select parameters :</h3>
            </div>
            <div class="box-body">
                <!-- Date range -->
                
                <div class="form-group">
                    <form id="filterform">
                    <label>Start Date:</label>

                    <div class="input-group">
                        <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                        <input type="text" class="form-control pull-right" id="start_date">
                        
                    </div>
                    <label>End Date:</label>
                    <div class="input-group">
                        <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                        <input type="text" class="form-control pull-right" id="end_date">
                        
                    </div>
                    <br>
                    <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button>
                    <button type="button" class="btn btn-default" onclick="ClearFields();"> Reset </button>
                <!-- /.input group -->
                </form>
                </div>
                
                <!-- /.form group -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h1>CASTING</h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                <thead >
                  <tr>
                    <th rowspan="2" style="text-align: center; vertical-align:middle;">NO</th>
                    <th rowspan="2" style="text-align: center; vertical-align:middle;">LINE</th>
                    <th colspan="4" style="text-align: center;">SHIFT</th>
                  </tr>
                  <tr>
                    <th style="text-align: center;">DATE</th>
                    <th style="text-align: center;">SHIFT 1</th>
                    <th style="text-align: center;">SHIFT 2</th>
                    <th style="text-align: center;">SHIFT 3</th>
                    <th style="text-align: center;">TOTAL</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
  </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
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
    // {{-- dev-1.0.0, Audi, 20181511, datatable filter --}}
 
    var table = $('#tabel_all').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url ("/trace/reportdetail/casting") }}',
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
          {data: 'line', name: 'line'},
          {data: 'date', name: 'date'},
          {data: 'shift_1', name: 'shift_1'},
          {data: 'shift_2', name: 'shift_2'},
          {data: 'shift_3', name: 'shift_3'},
          {data: 'total', name: 'total'},
        ],
        language: {
          search: "Search :"
        },
      });

    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    $('#buttonfilter').on('click', function(e){
           var start_date = $('#start_date').val();
           var end_date = $('#end_date').val();
           var d1 = Date.parse(start_date);
           var d2 = Date.parse(end_date);
           if (start_date == '' || end_date == '') {
            alert('Isi Tanggal Filter');
           }else if(d1 > d2){
            alert('Start date harus lebih lampau dari end date');
           }else{
           table.ajax.url("{{ url('/trace/reportdetail/list/casting/filter').'/'}}"+start_date+'/'+end_date).load(); 
            }
        });

    function ClearFields() {

        document.getElementById("start_date").value = "";
        document.getElementById("end_date").value = "";
        // window.location.reload(true);
    }

</script>

@endsection
