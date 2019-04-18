@extends('layouts.delivery')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />
<div class="table-bordered" style="padding: 10px; margin: 10px; float: left; width: 100%; display: table-cell;">
  <div style=" width: 100% ;margin-bottom: 10px; background-color: #000000; height: 100% "> 
    <span style="color: white; font-size: 25px "> BODY PLANT </span> <br>
    <span style="color: white; font-size: 15px "> All line in body plant </span>
  </div>
  <div id="body" >
  </div>


</div>
<div class="table-bordered" style="width: 100%; padding: 10px; margin: 10px;float: left; width: 100%; display: table-cell;">
  <div style="width: 100%;margin-bottom: 10px; background-color: #000000; height: 100% "> 
    <span style="color: white; font-size: 25px "> UNIT PLANT </span> <br>
    <span style="color: white; font-size: 15px "> All line in unit plant </span>
  </div>
  <div id="unit" >
  </div>


</div>



<div class="modal fade" id="modal-alert" role="dialog">
  <div class="modal-dialog" style="width: 96%; position: center;">
    <div class="modal-content" style="">
      <div class="modal-header" style="background-color: #bf1007;">
      </div>
      <div class="modal-body">
            <div class="panel-body" style="">
                <div class="row">
                  <div class="col-md-3">
                    <center><div style="font-size: 14pt; font-weight:bold;"><span class="fa fa-bell"></span> ALERT </div></center>
                    <div class="carousel-container">
                      <div id="konten">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
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
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #5daa68 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #5daa68 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";  
            }
            jalan = 1;
          }else if ( data[a].status == 2 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #bf4848 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #bf4848 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM MESIN",data[a].name,data[a].email,data[a].phone,data[a].error_at]);
            mlaku = 1;
          }else if ( data[a].status == 3 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #bf4848 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #bf4848 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM QUALITY",data[a].name,data[a].email,data[a].phone,data[a].error_at]);
            mlaku = 1;
          }else if ( data[a].status == 4 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #ffffff ; color: #000000'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #ffffff ; color: #000000ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #ffffff ; color: #000000'> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #ffffff ; color: #000000 ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM SUPPLY PART",data[a].name,data[a].email,data[a].phone,data[a].error_at]);
            mlaku = 1;
          }else if ( data[a].status == 5 ) {

            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;animation:blinking 1s infinite; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px;'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; color: #ffffff ; padding-right:2px ; padding-left: 2px;'>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;animation:blinking 1s infinite; color: #ffffff'> <div style='padding-top: 3px;padding-bottom: 3px;'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; color: #ffffff ; padding-right:2px ; padding-left: 2px;'>"+data[a].line+"</div></div></div>";  
            }
            coba.push([data[a].line,"DANDORI",data[a].name,data[a].email,data[a].phone,data[a].error_at]);
            mlaku = 1;
          }else if ( data[a].status == 0 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #000000 ; color: #ffffff '> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #000000 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered' style='float: left;display: table-cell;width: 20%;background-color: #000000 ; color: #ffffff '> <div style='padding-top: 3px;padding-bottom: 3px'><div style='text-align: center; width: 100%; height: 100% ; font-size: 20px ; background-color: #000000 ; color: #ffffff ; padding-right:2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            jalan = 1;
          }

        }
      } 
      if(mlaku==1){
        jalan=0;
      }
      $('#body').html(body);
      $('#unit').html(unit);



    },
    error: function (xhr) {
      console.log("no");
    }
  });
}
// end of ajax status line

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
          konten.push("<div id='myCarousel' class='carousel slide'><font size='3'>LINE: </font><br><b><font size='4' >"+simpan[h][0]+"</font></b><br><br><font size='3'>STATUS: </font><b><br><font size='4'>"+simpan[h][1]+"</font></b><br><br><font size='3' >PIC: </font><b><br><font size='4' >"+simpan[h][2]+"</font></b><br><br><font size='3' >EMAIL: </font><b><br><font size='4' >"+simpan[h][3]+"</font></b><br><br><font size='3'>PHONE: </font><b><br><font size='4' >"+simpan[h][4]+"</font></b><br><br><font size='3'>ERROR AT: </font><b><br><font size='4' >"+simpan[h][5]+"</font></b></div>");                          
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
              }, {{env('AVI_SLIDER_LINE', 3)*1000}}  ) ;
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