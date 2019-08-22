@extends('layouts.delivery')

@push('css')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@if(request()->query('plant') !== 'unit')
<!-- Start Body Plant -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel table-bordered panel-line">
      <div class="panel-header">
        <h1 class="title">BODY PLANT</h1>
      </div>
      <div class="panel-body">
        <div class="row line-wrapper" id="body">
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@if(request()->query('plant') !== 'body')
<!-- Start Unit Plant -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel table-bordered panel-line">
      <div class="panel-header">
        <h1 class="title" >UNIT PLANT</h1>
      </div>
      <div class="panel-body">
        <div class="row line-wrapper" id="unit">
        </div>
      </div>
    </div>
  </div>
</div>
@endif


<div class="modal fade modal-line-error" id="modal-alert" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div id="err-message-insert" class="alert alert-success" style="display: none;"></div>
        <form id="frm-insert">
          <div class="box-body">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-3 hidden-xs">
                  <img src="/images/emergency.gif" class="img-responsive">
                </div>
                <div class="col-xs-12 visible-xs">
                   <div style="font-size: 14pt; font-weight:bold;" class="text-center"><span class="fa fa-bell"></span> ALERT </div>
                </div>
                <div class="col-xs-12 col-sm-9" id="konten">

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

@section('contentheader_title')
@lang('avicenna/dashboard.default_title')
@endsection
@section('contentheader_description')
@lang('avicenna/dashboard.dashboard_andon')
@endsection
@section('scripts')
@parent
<script type="text/javascript">
var jalan = 1 ;
var coba = [];
var simpan = [];
var mlakuModal=0;

var mdl_alert = $("#modal-alert");
// document ready
$(document).ready(function(){
  document.body.style.backgroundColor = '#000000';
          // ajax per line
        // ajax();
           // Start an interval to refresh page every 10 seconds
           setInterval(function(){
             if(jalan==1){
              coba = [];
              simpan = [];
              mdl_alert.modal('hide');
              ajax();
            }else if(jalan==0 ){
              if (simpan != coba) {
                simpan = coba;
              }
              ShowModal(simpan);
              // konten();
            }
        }, 1000); // 1 seconds
         });
// end document ready

// ajax status line
function ajax(){
  $.ajax( {
    type: 'GET',
    url: '{{ url ("direct/line/index") }}',
    _token: "{{ csrf_token() }}",
    dataType: 'json',
    async:false,
    success: function(data) {
      var unit = '';
      var body = '';
      var mlaku=0;
      if (data.length > 0) {
        for (var a = 0; a < data.length; a++) {

          if ( data[a].status == 1 ) {
            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line ok"><p class="line-title">' + data[a].line + '</p></div>';
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line ok"><p class="line-title">' + data[a].line + '</p></div>';
            }
            jalan = 1;
          }else if ( data[a].status == 2 ) {
            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line error"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'body')
                injectAlertValue('PROBLEM MESIN', data, a);
                mlaku = 1;
              @endif
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line error"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'unit')
                injectAlertValue('PROBLEM MESIN', data, a);
                mlaku = 1;
              @endif
            }
          }else if ( data[a].status == 3 ) {
            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line error"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'body')
                injectAlertValue('PROBLEM QUALITY', data, a);
                mlaku = 1;
              @endif
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line error"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'unit')
                injectAlertValue('PROBLEM QUALITY', data, a);
                mlaku = 1;
              @endif
            }
          }else if ( data[a].status == 4 ) {
            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line error-supply"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'body')
                injectAlertValue('PROBLEM SUPPLY PART', data, a);
                mlaku = 1;
              @endif
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line error-supply"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'unit')
                injectAlertValue('PROBLEM SUPPLY PART', data, a);
                mlaku = 1;
              @endif
            }
          }else if ( data[a].status == 5 ) {

            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line dandory"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'body')
                injectAlertValue('DANDORI', data, a);
                mlaku = 1;
              @endif
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line dandory"><p class="line-title">' + data[a].line + '</p></div>';

              @if(request()->query('plant') !== 'unit')
                injectAlertValue('DANDORI', data, a);
                mlaku = 1;
              @endif
            }
          }else if ( data[a].status == 0 ) {
            if (data[a].plant == "UNIT") {
              unit += '<div class="table-bordered col-xs-2 line"><p class="line-title">' + data[a].line + '</p></div>';
            }else if (data[a].plant == "BODY"){
              body += '<div class="table-bordered col-xs-2 line"><p class="line-title">' + data[a].line + '</p></div>';
            }
            jalan = 1;
          }

        }
      }
      if(mlaku==1){
        jalan=0;
      }
      @if(request()->query('plant') !== 'unit')
      $('#body').html(body);
      @endif
      @if(request()->query('plant') !== 'body')
      $('#unit').html(unit);
      @endif
    },
    error: function (xhr) {
      console.log("no");
    }
  });
}
// end of ajax status line
function injectAlertValue(title, data, index) {
  coba.push([data[index].line,title,data[index].name,data[index].email,data[index].phone,data[index].error_at]);
}

//function modal
function ShowModal(a){
  if (simpan.length > 0 ){

    jalan=0;
    coba = [];

      //tes carousel
      var slideIndex = 1;
      var z = 0;
      var akhir = 0 ;
      var konten = [];
      tes();

      function tes(){

        for (var h = 0; h < simpan.length; h++) {
          konten.push('<div class="modal-info"><p class="info-title">LINE</p><h2 class="info-value">'+simpan[h][0]+'</h2></div><div class="modal-info"><p class="info-title">STATUS</p><h2 class="info-value">'+simpan[h][1]+'</h2></div><div class="modal-info"><p class="info-title">PIC</p><h2 class="info-value">'+simpan[h][2]+'</h2></div><div class="modal-info"><p class="info-title">EMAIL</p><h2 class="info-value">'+simpan[h][3]+'</h2></div><div class="modal-info"><p class="info-title">PHONE</p><h2 class="info-value">'+simpan[h][4]+'</h2></div><div class="modal-info"><p class="info-title">ERROR AT</p><h2 class="info-value">'+simpan[h][5]+'</h2></div>');
        }
        if (slideIndex > konten.length){
          slideIndex = 1;
          akhir = 1;
          coba = [];
          simpan = [];
          mdl_alert.modal('hide');
          ajax();
        }else{
          if(z==0){
            var item ;
            setTimeout(function(){
              item = slideIndex-1;
              $('#konten').html(konten[item]);

              mdl_alert.modal('show');
              z=1;
              }, {{env('AVI_SLIDER_LINE', 3)*1000}}) ;
            }else{
              slideIndex++;
              setTimeout(function(){

              mdl_alert.modal('hide');

              z=0;

              }, {{env('AVI_SLIDER_LINE', 3)*1000}} ) ;
            }
            akhir = 0;
        }

        if (akhir == 0) {
          setTimeout(function(){
             tes();
            }, {{env('AVI_SLIDER_LINE', 3)*1000}}  ) ;
        }
      }
      //tes carousel
    }
  }
//end of function modal


</script>
<style>
      .dandori-blinking {
        animation:blinking 1s infinite;
      }
      @keyframes blinking{
        0%{   background-color: #5daa68;  }
        50%{  background-color: transparent;  }
        100%{ background-color: #5daa68;  }
      }
</style>

@endsection