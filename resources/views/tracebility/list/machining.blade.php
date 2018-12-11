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
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h1>MACHINING</h1>
                <br><br>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                <thead >
                  <tr>
                    <th rowspan="2" style="text-align: center; vertical-align:middle;">NO</th>
                    <th rowspan="2" style="text-align: center; vertical-align:middle;">LINE</th>
                    <th colspan="4" style="text-align: center;">SHIFT</th>
                  </tr>
                  <tr>
                    <th style="text-align: center;">SHIFT 1</th>
                    <th style="text-align: center;">SHIFT 2</th>
                    <th style="text-align: center;">SHIFT 3</th>
                    <th style="text-align: center;">TOTAL</th>
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


<script type="text/javascript">
    // {{-- dev-1.0.0, Audi, 20181511, datatable filter --}}
 
    var table = $('#tabel_all').DataTable({
        "dom":'t',
        processing: true,
        serverSide: true,
        ajax: '{{ url ("/trace/reportdetail/machining") }}',
        columns: [
          {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {data: 'line', name: 'line'
          },
          {data: 'shift_1', name: 'shift_1'},
          {data: 'shift_2', name: 'shift_2'},
          {data: 'shift_3', name: 'shift_3'},
          {data: 'total', name: 'total'},
        ],
        language: {
          search: "Search :"
        },
      });

</script>

@endsection
