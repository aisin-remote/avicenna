@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
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
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Filter</h3>
          <br>
        </div>
        <div class="box-body">
          <div class="col-xs-12">
              <div class="col-xs-12">
                <label>Process:</label>
                <div class="input-group">
                  <div class='input-group-addon'>
                    <select id="mySelect" name="mySelect" onchange="checkList()" class="form-control select2">
                      <option value="casting" id="casting">Casting</option>
                      <option value="machining" id="machining">Machining</option>
                      <option value="assembling" id="assembling">Assembling</option>
                      <option value="delivery" id="delivery">Delivery</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="input-group">
                  <button id="detailreport" class="btn btn-primary">View Detail report</button>
                </div>
                <br>
              </div>

              <div class="col-xs-6">
                <div class="form-group">
                  <label for="formGroupExampleInput">Start Date</label>
                  <input type="text" class="form-control" id="start_date" placeholder="Start Date">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2">End Date</label>
                  <input type="text" class="form-control" id="end_date" placeholder="End Date">
                </div>
                <button id="filter" class="btn btn-success">Filter</button>
                <button id="clearFilter" class="btn btn-default">Clear Filter</button>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="formGroupExampleInput">Back Number</label>
                  <input type="text" class="form-control" id="back_no" placeholder="Back Number">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2">Line</label>
                  <input type="text" class="form-control" id="line" placeholder="Line">
                </div>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
    </div>
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List Product</h3>
              <br>
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
                    <th>Line</th>
                    <th>Status</th>
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

</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables2.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
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

    $('#start_date').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "yyyy-mm-dd"
    });
    $('#end_date').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "yyyy-mm-dd"
    });
    // {{-- dev-1.0.0, Audi, 20181511, datatable filter --}}

    var table = $('#tabel_all').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url ("/trace/view/list/casting") }}',
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
          {data: 'code', name: 'code',
            render: function ( data, type, row, meta ) {
              return '<a href="{{ url ("trace/view/part/searchout") }}/'+data+'">'+data+'</a>';
            }
          },
          {data: 'part_number', name: 'part_number'},
          {data: 'part_name', name: 'part_name'},
          {data: 'back_number', name: 'back_number'},
          {data: 'line', name: 'line'},
          {data: 'status', name: 'status'},
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

    $('#detailreport').on('click', function(e){
      e.preventDefault();
        var type = $('#mySelect').val();
        window.open("{{ url('trace/reportdetail/list').'/'}}"+type);

      });

    $('#filter').on('click', function(e) {
      e.preventDefault();
      table.ajax.url( "{{ url('/trace/view/filter?start_date=')}}"+$('#start_date').val()
      +"&process="+$('#mySelect').val()
      +"&line="+$('#line').val()
      +"&back_no="+$('#back_no').val()
      +"&end_date="+$('#end_date').val())
      .load();
    });

    $('#clearFilter').on('click', function(e) {
      e.preventDefault();
      $('#start_date').val('');
      $('#end_date').val('');
      $('#back_no').val('');
      $('#line').val('');
      var dropdown = document.getElementById('mySelect').value
      table.ajax.url( "{{ url('/trace/view/list') }}/"+dropdown ).load();
    })
</script>

@endsection
