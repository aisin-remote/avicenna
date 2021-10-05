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
  Registrasi Kanban
@endsection

@section('contentheader_description')

@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">

            <div class="box-header">
                <a href="/trace/regis-kanban/tambah" class="btn btn-primary">
                  <i class="fa fa-plus" style="margin-right: 1rem"></i>Registrasi Kanban
                </a>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No. Seri</th>
                    <th>Jenis Kanban</th>
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
        ajax: '{{ url ("/trace/regis-kanban/getData") }}',
        columns: [
          {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {data: 'no_seri', name: 'no_seri'},
          {data: 'jenis_kanban', name: 'jenis_kanban'},
          {data: 'created_at', name: 'created_at'},
          {data: 'actions', name: 'actions'}
        ],
        language: {
          search: "Search :"
        },
      });

      function delete_regis(id) {
        var r = confirm("Apakah anda yakin akan menghapus data ini?");
        if (r == true) {
          window.location.href = "{{ url('trace/regis-kanban/delete') }}" + '/' + id;
        }
    };

</script>

@endsection