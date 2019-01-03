@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/daterangepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('contentheader_title')
  Stock Mutation
@endsection

@section('contentheader_description')
  Inventory Report
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
                        <input type="text" class="form-control pull-right" id="start_date" value="{{ date('Y-m-d') }}">
                        
                    </div>
                    <label>End Date:</label>
                    <div class="input-group">
                        <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                        <input type="text" class="form-control pull-right" id="end_date" value="{{ date('Y-m-d') }}">
                        
                    </div>
                    <br>
                    <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button>
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
              <h3 class="box-title" id="box-title">Inventory Summary - Today ({{ date('Y-m-d') }})</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblMutation" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>Part Number</th>
                    <th>Location</th>
                    <th>Stock Initial</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Ending Stock</th>
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

<script id="details-template" type="text/x-handlebars-template">
    <div class="label label-info" style="font-size:15pt;">PART NUMBER:  @{{ part_number }} </div>
    <table class="table table-bordered table-striped" style="width: 100%" id="part-@{{ part_number }}">
        <thead>
        <tr>
            <th>Tgl Mutasi</th>
            <th>Back No</th>
            <th>Nama Model</th>
            <th>Mutasi</th>
            <th>Total</th>
        </tr>
        </thead>
    </table>
</script>

<script type="text/javascript">
    // {{-- dev-1.0, Ferry, 20171004, Init all input --}}
    $('#start_date').datepicker({
        autoclose: true,  
        format: "yyyy-mm-dd"
    });
    $('#end_date').datepicker({
        autoclose: true,  
        format: "yyyy-mm-dd"
    });

    // {{-- dev-1.0, Ferry, 20171004, Atur tampilan datatable --}}
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var template = Handlebars.compile($("#details-template").html());
    var table = $('#tblMutation').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url ("avicenna/stock/mutation/ajax/getHeader") }}',
        columns: [
            {
                "className"       : 'details-control',
                "orderable"       : false,
                "searchable"      : false,
                "data"            : null,
                "defaultContent"  : ''
            },
            {
                "searchable"      : false,
                "data"            : 'DT_Row_Index',
            },
            {data: 'part_number', name: 'part_number'},
            {data: 'store_location', name: 'store_location', searchable:false},
            {data: 'stock_initial', name: 'stock_initial', searchable:false},
            {data: 'stock_in', name: 'stock_in', searchable:false},
            {data: 'stock_out', name: 'stock_out', searchable:false},
            {data: 'end_stock', name: 'end_stock', searchable:false},
        ],

    });

    // Add event listener for opening and closing details
    $('#tblMutation tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'part-' + row.data().part_number;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });
    //Filter
    $('#buttonfilter').on('click', function(e){
           var start_date = $('#start_date').val();
           var end_date = $('#end_date').val();
           var d1 = Date.parse(start_date);
           var d2 = Date.parse(end_date);
           if (start_date == '' || end_date == '') {
            alert('Isi Tanggal Filter');
           }else if(d1 > d2){
            alert('Start date harus lebih lampau dari end date');
           }
           else {
                table.ajax.url("{{ url('/avicenna/stock/mutation/filter').'/'}}"+start_date+'/'+end_date).load(); 
                $("#box-title")[0].innerHTML = "Inventory Summary - From <strong>"+start_date+"</strong> To <strong>"+end_date+"</strong>";
            }
        });

    function initTable(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            ajax: data.details_url,
            "bInfo": false,
            "bLengthChange":false,
            columns: [
                { data: 'mutation_date', name: 'mutation_date' },
                { data: 'back_number', name: 'back_number' },
                { data: 'part_name', name: 'part_name' },
                { data: 'desc', name: 'avi_mutation_types.desc' },
                { data: 'total_qty', name: 'total_qty', searchable:false }
            ]
        })
        }
        
    

</script>

@endsection
