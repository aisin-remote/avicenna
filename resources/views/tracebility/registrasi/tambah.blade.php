@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,600" rel="stylesheet">
@endsection

@section('contentheader_title')
  Registrasi Kanban
@endsection

@section('contentheader_description')
  Scan Kanban Untuk Registrasi
@endsection

@section('main-content')

      <div class="col-12">
        <div class="card">
         <div class="card-body">
          
            <!-- <div id="alert-container" class="w-100 alert alert-info mb-5  d-flex align-items-center justify-content-center" style="min-height: 20px">
              <h5 id="error" class="text-center">pilih tipe dan scan</h5>
            </div> -->

            @if(Session::get('type'))
                                  <div class="alert alert-{{Session::get('type')}}" role="alert">
                                    {{Session::get('message')}}
                                  </div>
                              @endif
          
            <form>
              <div class="col-md-8">
                <div class="form-group">
                  <span class="form-label">Scan Disini</span>
                  <input class="form-control" type="text" id="scan" name="scan" placeholder="masukkan no part">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <span class="form-label">Type Kanban</span>
                  <select class="form-control" name="tipe">
                    <option value="internal">internal</option>
                    <option value="buffer">buffer</option>
                  </select>
                  <span class="select-arrow"></span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
              <div class="col-md-4 ">
                <a href="/trace/regis-kanban" class="btn btn-primary">Kembali</a>
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


@endsection
