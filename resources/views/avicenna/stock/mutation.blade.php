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
                    <label>Date range:</label>

                    <div class="input-group">
                        <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                        <input type="text" class="form-control pull-right" id="date_mutation">
                    </div>
                <!-- /.input group -->
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
              <h3 class="box-title">Inventory Summary</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblMutation" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>Part Number</th>
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
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>

<script id="details-template" type="text/x-handlebars-template">
    <div class="label label-info" style="font-size:15pt;">PART NUMBER:  @{{ part_number }} </div>
    <table class="table table-bordered table-striped" style="width: 100%" id="part-@{{ part_number }}">
        <thead>
        <tr>
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
    $('#date_mutation').daterangepicker()

    // {{-- dev-1.0, Ferry, 20171004, Atur tampilan datatable --}}
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

    function initTable(tableId, data) {
        $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            ajax: data.details_url,
            "bInfo": false,
            "bLengthChange":false,
            columns: [
                { data: 'back_number', name: 'back_number' },
                { data: 'part_name', name: 'part_name' },
                { data: 'desc', name: 'avi_mutation_types.desc' },
                { data: 'total_qty', name: 'total_qty', searchable:false }
            ]
        })
    }

</script>

@endsection
