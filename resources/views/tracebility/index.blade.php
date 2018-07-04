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
              <h3 class="box-title">OPN</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <img src="aisin.jpg">
            </div>
            <!-- /.box-body -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <td style="width: 50% ">Part Number</td><td></td>
                  </tr>
                  <tr>
                    <td>Shift</td><td></td>
                  </tr>
                  <tr>
                    <td>Date</td><td></td>
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
           if (id_product == '' || id_product == '') {
            alert('Isi Id produk');
           }else{   
                var table = $('#tabel_part').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url ('trace/view/part').'/'}}"+id_product ,
                    columns: [
                        {data: 'location', name: 'location'},
                        {data: 'date', name: 'date', searchable:false},
                        {data: 'npk', name: 'npk', searchable:false},
                        {data: 'created_at', name: 'created_at', searchable:false},
                    ],

                });
            }
    });
      
    

</script>

@endsection
