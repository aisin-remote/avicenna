@extends('layouts.delivery')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />
<div class="table-bordered col-md-12" style="padding: 10px; margin: 10px">
  <div class="col-md-12" style="margin-bottom: 10px; background-color: #000000; height: 100% "> 
    <span style="color: white; font-size: 25px "> BODY PLANT </span> <br>
    <span style="color: white; font-size: 15px "> All line in body plant </span>
  </div>
  <div id="body" >
  </div>


</div>
<div class="table-bordered col-md-12" style="padding: 10px; margin: 10px">
  <div class="col-md-12" style="margin-bottom: 10px; background-color: #000000; height: 100% "> 
    <span style="color: white; font-size: 25px "> UNIT PLANT </span> <br>
    <span style="color: white; font-size: 15px "> All line in unit plant </span>
  </div>
  <div id="unit" >
  </div>


</div>



<div class="modal fade" id="modal-alert" role="dialog">
  <div class="modal-dialog" style="width: 1150px; position: center; top: 38px;">
    <div class="modal-content" style="height: 650px">
      <div class="modal-header" style="background-color: #bf1007;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
                        <img src="/images/emergency.gif" style="height: 100%;width: 100%">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9" style="padding-left: 100px;">

                    <div class="carousel-container">
                      <div id="konten">

                      </div>
                    </div>

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
var jalan = 1 ;
var coba = [];
var simpan = [];
var mlakuModal=0;

var mdl_alert = $("#modal-alert");
// document ready
$(document).ready(function(){
  document.body.style.backgroundColor = '#000000';
          // ajax per line
        //ajax(); 
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
              unit += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";  
            }
            jalan = 1;
          }else if ( data[a].status == 2 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered col-md-2' style='background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #bf4848 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #bf4848 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM MESIN",data[a].name,data[a].email,data[a].phone]);
            mlaku = 1;
          }else if ( data[a].status == 3 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered col-md-2' style='background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #bf4848 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #bf4848 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM QUALITY",data[a].name,data[a].email,data[a].phone]);
            mlaku = 1;
          }else if ( data[a].status == 4 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered col-md-2' style='background-color: #ffffff ; color: #000000'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #ffffff ; color: #000000ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #ffffff ; color: #000000'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #ffffff ; color: #000000 ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }
            coba.push([data[a].line,"PROBLEM SUPPLY PART",data[a].name,data[a].email,data[a].phone]);
            mlaku = 1;
          }else if ( data[a].status == 5 ) {

            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered col-md-2' style='background-color: #5daa68  ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";  
            }
            coba.push([data[a].line,"DANDORI",data[a].name,data[a].email,data[a].phone]);
            mlaku = 1;
          }else if ( data[a].status == 0 ) {
            if (data[a].plant == "UNIT") {
              unit += "<div class='table-bordered col-md-2' style='background-color: #000000 ; color: #ffffff '> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #000000 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
            }else if (data[a].plant == "BODY"){
              body += "<div class='table-bordered col-md-2' style='background-color: #000000 ; color: #ffffff '> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #000000 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
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
          konten.push("<div id='myCarousel' class='carousel slide'><b><font size='4'>LINE</font></b><br><b><font size='7' >"+simpan[h][0]+"</font></b><br><b><font size='4' >STATUS : </font></b><br><b><font size='7'>"+simpan[h][1]+"</font></b><br><b><font size='4' >PIC </font></b><br><b><font size='7' >"+simpan[h][2]+"</font></b><br><b><font size='4' >EMAIL</font></b><br><b><font size='7' >"+simpan[h][3]+"</font></b><br><b><font size='4' >PHONE    : </font></b><br><b><font size='7' >"+simpan[h][4]+"</font></b></div>");                          
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

@endsection