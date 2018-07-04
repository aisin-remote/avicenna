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
  Tracebility
@endsection

@section('contentheader_description')
  Jejak para produk
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <form id="searchform">
                    <label>Input label:</label>
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" id="id_product" > 
                    </div>
                    <br>
                    <button type="button" class="btn btn-success" id="buttonsearch"> Search </button>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Summary</h3>
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
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-4">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Produk</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <img style="width: 100% " src="{{ asset('images/tcc.jpg') }}">
            </div>
            <!-- /.box-body -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <td style="width: 50% ">Program</td><td id="prog"></td>
                  </tr>
                  <tr>
                    <td>Dies</td><td id="dies"></td>
                  </tr>
                  <tr>
                    <td>Shox</td><td id="shox"></td>
                  </tr>
                  <tr>
                    <td>Mesin</td><td id="mesin"></td>
                  </tr>
                  <tr>
                    <td>Shift</td><td id="shift"></td>
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
    //search
    $('#buttonsearch').on('click', function(e){
        var id_product = $('#id_product').val();
        var prog  = id_product.substr(0, 2);
        var dies  = id_product.substr(2, 2);
        var mesin = id_product.substr(4, 2);
        var a = id_product.length ;
          if (a == 15) {
            var shift = id_product.substr(11, 1);
            var shox  = id_product.substr(12, 3);
          }else{
            var shift = id_product.substr(12, 1);
            var shox  = id_product.substr(13, 3);
          }      
        document.getElementById("prog").innerHTML  = prog;
        document.getElementById("dies").innerHTML  = dies;
        document.getElementById("shox").innerHTML  = shox;
        document.getElementById("mesin").innerHTML = mesin;
        document.getElementById("shift").innerHTML = shift;
           if (id_product == '' || id_product == '') {
            alert('Isi Id produk');
           }else{   
              console.log("SAMPAI SINI");
                var table = $('#tabel_part').DataTable({
                    paging: false ,
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: "{{ url ('trace/view/part').'/'}}"+id_product ,
                    columns: [

                        {data: 'location', name: 'location'},
                        {data: 'date', name: 'date', searchable:false},
                        {data: 'npk', name: 'npk', searchable:false},
                        {data: 'time', name: 'time', searchable:false},
                    ],

                });
            }

    });
      
    

</script>

@endsection
