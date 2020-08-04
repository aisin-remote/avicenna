@extends('layouts.delivery')

@push('css')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />
<style>
  body {
    background: #000;
  }
  .dandori-blinking {
    animation:blinking 1s infinite;
  }
  @keyframes blinking{
    0%{   background-color: #5daa68;  }
    50%{  background-color: transparent;  }
    100%{ background-color: #5daa68;  }
  }
</style>
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
                  <img src="{{ asset('images/emergency.gif') }}" class="img-responsive">
                </div>
                <div class="col-xs-12 visible-xs">
                   <div style="font-size: 14pt; font-weight:bold;" class="text-center"><span class="fa fa-bell"></span> ALERT </div>
                </div>
                <div class="col-xs-12 col-sm-9" id="konten">
                  <div class="modal-info">
                    <p class="info-title">LINE</p>
                    <h2 class="info-value" id="line-wrapper"></h2>
                  </div>
                  <div class="modal-info">
                    <p class="info-title">STATUS</p>
                    <h2 class="info-value" id="status-wrapper"></h2>
                  </div>
                  <div class="modal-info">
                    <p class="info-title">PIC</p>
                    <h2 class="info-value" id="pic-wrapper"></h2>
                  </div>
                  <div class="modal-info">
                    <p class="info-title">EMAIL</p>
                    <h2 class="info-value" id="email-wrapper"></h2>
                  </div>
                  <div class="modal-info">
                    <p class="info-title">PHONE</p>
                    <h2 class="info-value" id="phone-wrapper"></h2>
                  </div>
                  <div class="modal-info">
                    <p class="info-title">ERROR AT</p>
                    <h2 class="info-value" id="error-wrapper"></h2>
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

@section('contentheader_title')
    @lang('avicenna/dashboard.default_title')
@endsection
@section('contentheader_description')
    @lang('avicenna/dashboard.dashboard_andon')
@endsection
@section('scripts')
@parent
<script type="text/javascript">
  var errorList = [];
  var inProcess = false;

  function initPage() {
    $.ajax({
      type: 'GET',
      url: '{{ url ("direct/line/index") }}',
      _token: "{{ csrf_token() }}",
      dataType: 'json',
      async:false,
      success: function(data) {
        var lines = {
          body : '',
          unit : ''
        };

        for(var i = 0; i < data.length; i++) {
          var plant = data[i].plant.toLowerCase();
          if(data[i].status > 4) {
            // dandori
            lines[plant] += '<div class="table-bordered col-xs-2 line dandory"><p class="line-title">' + data[i].line + '</p></div>';
          } else if (data[i].status > 1) {
            // error
            lines[plant] += '<div class="table-bordered col-xs-2 line error"><p class="line-title">' + data[i].line + '</p></div>';
          } else if (data[i].status > 0) {
            // OK
            lines[plant] += '<div class="table-bordered col-xs-2 line ok"><p class="line-title">' + data[i].line + '</p></div>';
          } else {
            // Machine off
            lines[plant] += '<div class="table-bordered col-xs-2 line"><p class="line-title">' + data[i].line + '</p></div>';
          }

          if (data[i].status > 1) {
            @if(request()->query('plant') !== 'unit')
              // insert body
              if (plant == 'body') {
                errorList.push(data[i]);
              }
            @endif
            @if(request()->query('plant') !== 'body')
              if (plant == 'unit') {
                errorList.push(data[i]);
              }
            @endif
          }
        }

        @if(request()->query('plant') !== 'unit')
          $('#body').html(lines.body);
        @endif
        @if(request()->query('plant') !== 'body')
          $('#unit').html(lines.unit);
        @endif
      },
      error: function (xhr) {
        console.log("Ops, something wrong !!");
      }
    });
  }

  function generateError() {
    inProcess  = true;
    var modalShown = false;
    $('#line-wrapper').text(errorList[0].line);
    $('#status-wrapper').html(errorList[0].message.replace(',', '& <br>'));
    $('#pic-wrapper').html(errorList[0].name.replace(',', ' & <br>'));
    $('#email-wrapper').html(errorList[0].email.replace(',', ' & <br>'));
    $('#phone-wrapper').html(errorList[0].phone.replace(',', ' & <br>'));
    $('#error-wrapper').html(errorList[0].error_at.replace(',', ' & <br>'));
    $("#modal-alert").modal('show');
    setTimeout(function() {
      $("#modal-alert").modal('hide');
      errorList.shift();
      if (errorList.length > 0) {
        setTimeout(function() {generateError()}, 1000);
      } else {
        inProcess = false;
      }
    }, 3000);

  }

  $(function() {
    setInterval(function(){
      if (!inProcess) {
        if (errorList.length > 0) {
          generateError();
        } else {
          initPage();
        }
      }
    }, 1000);
  });
</script>
@endsection