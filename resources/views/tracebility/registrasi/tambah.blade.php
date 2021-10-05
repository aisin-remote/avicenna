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
  Scan Kanban Untuk Registrasi
@endsection

@section('main-content')

<div class="card-body bg-white">
    <div class="row">
      <div class="col-md-12">
        <span id="value" hidden></span> 
          <div class="mb-4 mt-4">
            <div class="card">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="scan">Scan Kanban</label>
                  <input type="text" id="scan" name="scan" class="form-control" placeholder="No Kanban">
                </div>
                <div class="form-group col-md-2">
                  <label for="tipe">Tipe Kanban</label>
                  <select id="tipe" name="tipe" class="form-control">
                    <option value="reguler">Reguler</option>
                    <option value="buffer">Buffer</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <div id="alert-container" class="w-100 alert alert-info mb-5  d-flex align-items-center justify-content-center" style="min-height: 20px">
                    <h4 id="error" class="text-center">Pilih Tipe Kanban Lalu Scan</h4>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                <a href="/trace/regis-kanban" class="btn btn-info">Kembali</a>
                </div>
              </div>  
            </div>
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

<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script type="text/javascript">
  
  $(document).ready(function() {

    function sendAjax(scan, tipe) {
      $.ajax({
        type: 'post',
        url: "{{ route('tambah-ajax') }}",
        dataType: 'json',
          data: {
            _token: "{{ csrf_token() }}",
            scan : scan,
            tipe : tipe

          } ,
        success: function (data) {
          if (data.error == false ) {
              $('#error').html(data.messege);
              $('#alert-container').removeClass('alert-danger');
                        $('#alert-container').addClass('alert-info');
                        $('#tipe').val("");
                        $('#scan').val("");
                        $('#scan').focus();
            } else if (data.error == true) {
              $('#error').html(data.messege);
              $('#alert-container').removeClass('alert-info');
                        $('#alert-container').addClass('alert-danger');
                        $('#tipe').val("");
                        $('#scan').val("");
            }
        },

      });
    }

      $('#scan').focus();

      $('#scan').on('keypress', function(event) {

        if (event.keyCode == 13) {
          sendAjax($('#scan').val(), $('#tipe').val());
          // console.log('masuk sini');
        }
      });



  });
</script>


@endsection
