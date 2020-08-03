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
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">List Product</h3>
        <br><br>
        <button id="detailreport" class="btn btn-primary" data-toggle="modal" data-target="#modal-insert">View Detail report</button>
      </div>
      <div class="box-body">
        <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
          <thead>
            <tr>
              <th>No</th>
              <th>description</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-insert" role="dialog">
  <div class="modal-dialog" style="width: 1150px; position: center; top: 38px;">
    <div class="modal-content" style="height: 100%">
      <div class="modal-header" style="background-color: #bf1007;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <center><b><font size="7" color="white">WARNING !</font></b></center>
      </div>
      <div class="modal-body">
        <div id="err-message-insert" class="alert alert-success" style="display: none;"></div>
        <form id="frm-insert">
          <div class="box-body">
            <div class="panel-body" style="">
              <div class="col-md-12" >
                <div class="row">
                    <div class="col-md-3" >
                      <div class="row">
                        <div>
                          <img src="https://upload.wikimedia.org/wikipedia/commons/8/83/Emergency_Light.gif">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9" style="padding-left: 100px;">
                      @foreach ($p as $view)
                        <b><font size="3" color="#bf1007">LINE : {{ $view->line }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                        <b><font size="3" color="#bf1007">STATUS : {{ $view->status }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                        <b><font size="3" color="#bf1007">PIC LDR : {{ $view->pic_ldr }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                        <b><font size="3" color="#bf1007">PIC SPV : {{ $view->pic_spv }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                        <b><font size="3" color="#bf1007">PIC MGR : {{ $view->pic_mgr }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                        <b><font size="3" color="#bf1007">PIC GM : {{ $view->pic_gm }}</font></b>
                        <hr style="height:2px;border:none;color:#bf1007;background-color:#bf1007;" />
                      @endforeach
                    </div>
                </div>
              </div>
            </div>
          </div>
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
        ajax: '{{ url ("/andon/view/list") }}',
        columns: [
          {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }},
          {data: 'description', name: 'description'},
        ],
        language: {
          search: "Search :"
        },
      });

    var table = $('#tabel_status').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        info:false,
        processing: true,
        serverSide: true,
        ajax: '{{ url ("/andon/view/status") }}',
        columns: [
          {data: 'line', name: 'line'},
          {data: 'status', name: 'status'},
          {data: 'pic_ldr', name: 'pic_ldr'},
          {data: 'pic_spv', name: 'pic_spv'},
          {data: 'pic_mgr', name: 'pic_mgr'},
          {data: 'pic_gm', name: 'pic_gm'},
        ],
        language: {
          search: "Search :"
        },
      });

    // function checkList(){
    //   var dropdown = document.getElementById('mySelect').value
    //   table.ajax.url( "{{ url('/trace/view/list') }}/"+dropdown ).load();
    // }

    // $('#detailreport').on('click', function(e){
    //   e.preventDefault();
    //     var type = $('#mySelect').val();
    //     window.open("{{ url('trace/reportdetail/list').'/'}}"+type);

    //   });
</script>

@endsection
