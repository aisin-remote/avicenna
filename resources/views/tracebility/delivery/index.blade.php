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
  Delivered Pruduct
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">

        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Delivered Product Today</h3>
                        <br><br>

                        <div>

                                <label>Start Date:</label>

                                <div class='input-group date' >
                                    <input type='text' class="form-control" id='date'/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <div> <br>
                                <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button>
                            <!-- /.input group -->
                                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_part" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Id Product</th>
                    <th>Name Product</th>
                    <th>Tanggal</th>
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
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet" id="bootstrap-css">
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


<script type="text/javascript">
    // {{-- dev-1.0.0, Handika, 20180703, datatable filter --}}
        var date = $('#date').val();
        var table = $('#tabel_part').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        dom: 'Bfrtip',
        button : ['csv',
                 ],
        paging: false,
        ajax: '{{ url ("trace/view/delivered/data") }}',
        columns: [
            
            {data: 'no', name: 'no'},
            {data: 'code', name: 'code', searchable:false},
            {data: 'name', name: 'name', searchable:false},
            {data: 'date', name: 'date', searchable:false},
        ],

        });
        $('.date').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
    //search
        
        $('#buttonfilter').on('click', function(e){
          e.preventDefault();
          var date = $('#date').val();
          table.ajax.url("{{ url('/trace/view/delivered/filter').'/'}}"+date).load();      
        });
    
      
    

</script>

@endsection
