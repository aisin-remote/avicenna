<?php use App\Http\Controllers\Avicenna\IoTController; ?>

@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/datatables/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/dataTables.fixedColumns.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/daterangepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('contentheader_title')
  IoT Master
@endsection

@section('contentheader_description')
  Production Planning
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <!-- Date range -->
                
                <div class="form-group">
                    {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                    <label>Posting Bulan:</label>

                    <div class="input-group">
                        <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                        <input type="text" class="form-control pull-right" id="posting" name="posting" value="{{ $posting }}">
                        
                    </div>
                    <br>
                    <span class='label label-info' id="upload-file-info"></span>
                    <br>
                    <span class="btn btn-success btn-file">
                        Pilih File 
                        <input type="file" id="fplan" name="fplan" onchange='$("#upload-file-info").html($(this).val());' autofocus required>
                    </span>
                    <input name="tipe" type="hidden" value="verify">
                    <input type="submit" class="btn btn-warning" id="buttonfilter" value="Verifikasi" />
                    <a href="{{ url('download/templates/prod_plan.xlsx') }}" class="pull-right">Klik download untuk template</a>
                    <!-- /.input group -->
                    {!! Form::close() !!}
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
              <h3 class="box-title" id="box-title">Verifikasi Upload</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl-plan" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Line</th>
                    <th>Part Number</th>
                    <th>Total</th>
                    
                    @for ($i = 1; $i <= $days; $i++)
                        
                        <th>{{ $i }}</th>
                    
                    @endfor
                  </tr>
                </thead>
                <tbody>
                    <?php $j=1 ?>
                    @foreach ($rows as $row)
                    <tr>
                        
                        <td>{{ $j++ }}</td>
                        <td>{{ $row['line'] }}</td>
                        <td>{{ $row['partno'] }}</td>
                        <td>{{ $row['total'] }}</td>
                        
                        @for ($i = 1; $i <= $days; $i++)
                            <td>{{ IoTController::countDaily($row['total'], $days, $i) }}</td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
        </div>
        <br />
        {!! Form::open() !!}
            <input name="tipe" type="hidden" value="upload">
            <input name="posting" type="hidden" value="{{ $posting }}">
            <input name="myfile" type="hidden" value="{{ $path }}" required>
            <button type="submit" class="btn btn-primary" id="buttonfilter"> Upload </button>
        {!! Form::close() !!}
        <!-- /.box -->
    </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/dataTables.fixedColumns.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">

    // {{-- dev-1.0, Ferry, 20171004, Atur tampilan datatable --}}

    // var table = $('#tblMutation').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{{ url ("avicenna/stock/mutation/ajax/getHeader") }}',
    //     columns: [
    //         {
    //             "className"       : 'details-control',
    //             "orderable"       : false,
    //             "searchable"      : false,
    //             "data"            : null,
    //             "defaultContent"  : ''
    //         },
    //         {
    //             "searchable"      : false,
    //             "data"            : 'DT_Row_Index',
    //         },
    //         {data: 'part_number', name: 'part_number'},
    //         {data: 'store_location', name: 'store_location', searchable:false},
    //         {data: 'stock_initial', name: 'stock_initial', searchable:false},
    //         {data: 'stock_in', name: 'stock_in', searchable:false},
    //         {data: 'stock_out', name: 'stock_out', searchable:false},
    //         {data: 'end_stock', name: 'end_stock', searchable:false},
    //     ],

    // });     

// function get_days(mydate) {
//     var arrdate = mydate.split("-");
//     var d = new Date(arrdate[0], arrdate[1], 0).getDate();

//     return d;
// }

$( document ).ready(function() {
    // var table = document.getElementById("tbl-plan");
    // var header = table.createTHead();
    // var row = header.insertRow(0);

    // var headerCell = document.createElement("th");
    // headerCell.innerHTML = "No";
    // row.appendChild(headerCell);

    // headerCell = document.createElement("th");
    // headerCell.innerHTML = "Back Number";
    // row.appendChild(headerCell);

    // headerCell = document.createElement("th");
    // headerCell.innerHTML = "Part Number";
    // row.appendChild(headerCell);

    // headerCell = document.createElement("th");
    // headerCell.innerHTML = "Part Name";
    // row.appendChild(headerCell);

    // for (var i = 1; i <= get_days($("#posting").val()); i++) {
    //     headerCell = document.createElement("th");
    //     headerCell.innerHTML = i;
    //     row.appendChild(headerCell);
    // }

    var table = $('#tbl-plan').DataTable({
        "scrollX": true,
        fixedColumns:   {
            leftColumns: 2,
        }
    });

});

</script>

@endsection
