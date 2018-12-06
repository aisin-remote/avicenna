@extends('adminlte::layouts.out')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  Jejak para produk
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-8">

        <div class="box box-primary">
            <div class="box-body" style="display: none;">
                <div class="form-group" >
                    <div id="searchform">
                    <label>Input Id Produk:</label>
                    <div>
                        <input type="text" class="form-control pull-right" value="{{ $barcode }}" id="id_product" placeholder="Id produk harus 15 karakter" > 
                    </div>
                    <br><br>
                    <button type="button" class="btn btn-success" id="buttonsearch"> Search </button>
                    </div>
                </div>
            </div>

            <div class="box-header">
              <h3 class="box-title">Detail of</h3>
              <h1> <b>{{ $barcode }}</b> </h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_part" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Scanned By</th>
                    <th>Time</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="box-body">
              <button id="print" class="btn btn-success">Print Report</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-4">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Produk </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="imageDiv">

            </div>
            <!-- /.box-body -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <td style="width: 50% ">Product Name</td><td id="product"></td>
                  </tr>
                  <tr>
                    <td>Program</td><td id="prog"></td>
                  </tr>
                  <tr>
                    <td>Dies</td><td id="dies"></td>
                  </tr>
                  <tr>
                    <td>Shot</td><td id="shot"></td>
                  </tr>
                  <tr>
                    <td>Mesin</td><td id="mesin"></td>
                  </tr>
                  <tr>
                    <td>Shift</td><td id="shift"></td>
                  </tr>
                  <tr>
                    <td>Cycle</td><td id="cycle"></td>
                  </tr>
                  <tr>
                    <td>Customer</td><td id="customer"></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"></script>


<script type="text/javascript">

    // {{-- dev-1.0.0, Handika, 20180703, datatable filter --}}
        var table = $('#tabel_part').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        ajax: '{{ url ("trace/view/part/index") }}',
        columns: [
            
            {data: 'location', name: 'location'},
            {data: 'date', name: 'date', searchable:false},
            {data: 'npk', name: 'npk', searchable:false},
            {data: 'time', name: 'time', searchable:false},
        ],

    });

    //search
    $('#buttonsearch').on('click', function(e){
      e.preventDefault();
        var id_product = $('#id_product').val();
        
        var a = id_product.length ;
           if (a < 15 ){
            alert('Id produk yang anda masukan hanya '+a+' karakter, Id produk harus 15 karakter');
           }else if ( a > 15 ) {
            alert('Id produk yang anda masukan sebanyak '+a+' karakter, Id produk hanya boleh 15 karakter saja');
           }else if (id_product == '' ) {
            alert('Isi Id produk');
           }else{
            var prog  = id_product.substr(0, 2);
            var dies  = id_product.substr(2, 2);
            var mesin = id_product.substr(4, 2);
            var shift = id_product.substr(11, 1);
            if (shift == "A") {
              shift = " Shift 1" ;
            }if (shift == "B") {
              shift = " Shift 2" ;
            }if (shift == "C") {
              shift = " Shift 3" ;
            }
            
            var shot  = id_product.substr(12, 3);      
            document.getElementById("prog").innerHTML  = prog;
            document.getElementById("dies").innerHTML  = dies;
            document.getElementById("shot").innerHTML  = shot;
            document.getElementById("mesin").innerHTML = mesin;
            document.getElementById("shift").innerHTML = shift;

            table.ajax.url("{{ url ('trace/view/part').'/'}}"+id_product).load();

            $.ajax({
               url:"{{ url('trace/view/product').'/'}}"+id_product,
               success:function(data){
                  document.getElementById("product").innerHTML  = data.product;
                  document.getElementById("cycle").innerHTML  = data.cycle;
                  document.getElementById("customer").innerHTML  = data.customer;
                  $("#imageDiv").html("<img src='"+data.img_path+"' style='width: 100%'/>");
               }
            });
            }

    });

    $('#print').on('click', function(e){
      e.preventDefault();
        var id_product = $('#id_product').val();
        
            $.ajax({
               url:"{{ url('trace/report/list').'/'}}"+id_product,
               success:function(data){
               }
            });

    });
      
    $(document).ready(function () {
      $('#buttonsearch').click();
    });
</script>

@endsection
