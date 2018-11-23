@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  LIST PRODUCT
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List Product Today</h3>
                <br><br>
                <div>
                  <label>Select Menu list:</label>
                  <div class="input-group">
                  <div class='input-group-addon'>
                    <select id="mySelect" name="mySelect" onchange="checkList()" class="form-control select2">
                      <option value="casting" id="casting">Casting</option>
                      <option value="machining" id="machining">Machining</option>
                      <option value="delivery" id="delivery">Delivery</option>
                    </select>  
                  </div>
                  </div>
              <div> <br>
              <!-- <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button> -->
          <!-- /.input group -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Part Code</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Back Number</th>
                    <th>Date Scan</th>
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

<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables2.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
    // {{-- dev-1.0.0, Audi, 20181511, datatable filter --}}
 
    var table = $('#tabel_all').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url ("/trace/view/list/casting") }}',
        columns: [
          {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {data: 'code', name: 'code',
            render: function ( data, type, row, meta ) {
              return '<a href="{{ url ("trace/view/part/search") }}/'+data+'">'+data+'</a>';
            }
          },
          {data: 'part_number', name: 'part_number'},
          {data: 'part_name', name: 'part_name'},
          {data: 'back_number', name: 'back_number'},
          {data: 'created_at', name: 'created_at'},
        ],
        language: {
          search: "Search :"
        },
      });

    function checkList(){
      var dropdown = document.getElementById('mySelect').value
      table.ajax.url( "{{ url('/trace/view/list') }}/"+dropdown ).load();
    }
</script>

@endsection
