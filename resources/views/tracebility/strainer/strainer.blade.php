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
  Strainers
@endsection

@section('contentheader_description')

@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                    <i class="fa fa-plus" style="margin-right: 1rem"></i>Tambah Data
                </button>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Line</th>
                    <th>Start At</th>
                    <th>Finish At</th>
                    <th>Color</th>
                    <th>Strainer</th>
                    <th>Created At</th>
                    <th>Delete</th>
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModalCenter" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Strainer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="GET" action="{{url ('/trace/view/strainer/create')}}">
          <div class="form-row p-0">
            <div class="form-group col-md-6" style="padding-left: 0px">
              <label for="inputEmail4">Tanggal mulai</label>
              <input name="start_at" type='date' class="form-control" />
            </div>
            <div class="form-group col-md-6" style="padding-left: 0px">
              <label for="inputEmail4">Tanggal Akhir</label>
              <input name="end_at" type='date' class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="inputAddress">Strainer</label>
            <select class="form-control" name="strainer">
              @foreach ($strainers as $strainer)
                <option value="{{ $strainer->id }}">{{ $strainer->customer }} - ({{ $strainer->name }})</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="inputAddress">Line</label>
            <select class="form-control" name="line">
              @foreach ($lines as $line)
                <option value="{{ $line->line }}" >{{ $line->line }}</option>
              @endforeach
            </select>
          </div>
          <hr>
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
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
        ajax: '{{ url ("/trace/view/strainer/getData") }}',
        columns: [
          {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {data: 'line', name: 'line'},
          {data: 'start_at', name: 'start_at'},
          {data: 'end_at', name: 'end_at'},
          {data: 'strainer.name', name: 'name'},
          {data: 'strainer.customer', name: 'customer'},
          {data: 'created_at', name: 'created_at'},
        ],
        language: {
          search: "Search :"
        },
      });

</script>

@endsection
