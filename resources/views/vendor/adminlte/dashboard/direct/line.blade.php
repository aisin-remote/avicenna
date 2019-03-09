@extends('layouts.delivery')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />

        @foreach ($lines as $andon)

        <?php
          // special manipulation in looping
          if ($andon->status == 2) {
            $class= '#bf4848'; //merah
            $text= '#ffffff'; //putih
          }
          elseif ($andon->status == 1) {
            $class = '#5daa68'; //hijau
            $text= '#ffffff'; //putih
          }
          elseif ($andon->status == 5) {
            $class = '#ffff00' ; //kuning
            $text= '#000000'; //hitam
          }elseif ($andon->status == 3) {
            $class = '#ffffff'; //putih
            $text= '#000000'; //hitam
          }
          elseif ($andon->status == 0) {
            $class = '#000000'; //hitam
            $text = '#ffffff'; //putih
          }
        ?>
        @endforeach
<div class="table-bordered col-md-12" style="padding: 10px; margin: 10px">
    <div class="col-md-12" style="margin-bottom: 10px; background-color: #000000; height: 100% "> 
      <span style="color: white; font-size: 25px "> BODY PLANT </span> <br>
      <span style="color: white; font-size: 15px "> All line in body plant </span>
    </div>
    <div id="a" >
    </div>
    

</div>
<div >
      <br><br><br><br><br><br>
      <span id="c" style="color: white; font-size: 25px "> BODY PLANT </span>

</div>



<div class="modal fade" id="modal-alert" role="dialog">
  <div class="modal-dialog" style="width: 1150px; position: center; top: 38px;">
    <div class="modal-content" style="height: 500px">
<!--       <div class="modal-header" style="background-color: #bf1007;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
 -->      <div class="modal-body">
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

                      @foreach ($a as $status)
                        <div class="mySlides w3-container w3-xlarge w3-white w3-card-4">
                          <b><font id="myfont" size="7" >LINE &ensp;&ensp;&nbsp; : {{ $status->line }}</font></b><br>
                          <b><font size="7" >STATUS : STOP LINE</font></b><br>
                          <b><font size="7" >PIC &ensp;&ensp;&nbsp;&nbsp;&nbsp; : {{ $status->pic }}</font></b>
                        </div>

                        <div class="carousel-container">
                          <div id="myCarousel" class="carousel slide">
                              <!-- Indicators -->
                              <ol class="carousel-indicators" id="indicators">
                              </ol>
                              <div class="carousel-inner" id="homepageItems">
                              </div>
                              <div class="carousel-controls"> 
                                <a class="carousel-control left" href="#myCarousel" data-slide="prev"> 
                                  <span class="glyphicon glyphicon-chevron-left"></span> 
                                </a>
                                <a class="carousel-control right" href="#myCarousel" data-slide="next"> 
                                  <span class="glyphicon glyphicon-chevron-right"></span> 
                                </a>
                              </div>
                          </div>
                        </div>
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
          ajax();
         }else if(jalan==0 && mlakuModal==0){
           ShowModal(coba);
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
                      var response = '';
                      var array = '';
                      var mlaku=0;

                      for (var a = 0; a < data.length; a++) {
                        if ( data[a].status == 1 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                          // array += data[a];
                            // jalan = 1;
                        }else if ( data[a].status == 2 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #bf4848 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #bf4848 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                            mlaku = 1;
                        }else if ( data[a].status == 3 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                        }else if ( data[a].status == 4 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                        }else if ( data[a].status == 5 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #5daa68 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #5daa68 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                        }else if ( data[a].status == 0 ) {
                          response += "<div class='table-bordered col-md-2' style='background-color: #000000 ; color: #ffffff'> <div style='padding-top: 30px;padding-bottom: 30px'><div style='text-align: center; width: 100%; height: 50% ; font-size: 40px ; background-color: #000000 ; color: #ffffff ; padding-right: : 2px ; padding-left: 2px; '>"+data[a].line+"</div></div></div>";
                        }
                          
                      }
                      if(mlaku==1){
                        jalan=0;
                      }
                      $('#a').html(response);
                      // coba.push(array);
                      
                    },
                    error: function (xhr) {
                      console.log("no");
                        }
                 });
}

function ShowModal(a){
  mlakuModal=1;
  mdl_alert.modal();

  // if (mlakuModal==1){
    setInterval(function(){
      mdl_alert.modal('hide');
      jalan=1;
    },5000)
  }
// }
// end of ajax status line
//function modal


// carousel audi
    var slideIndex = 1;
    var z=0;
    // carousel();
    function carousel() {
      console.log('AYOO');
      var i;
      var x = document.getElementsByClassName("mySlides");

      //Blok semua
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
      }
      if (slideIndex > x.length){
        slideIndex = 1;

      }
      if(z==0){
        x[slideIndex-1].style.display = "block";
        z=1;
      }else{
        slideIndex++;
        z=0;
      }
      setTimeout(function(){
       carousel();
      }, 2000); 
    }
// end carousel audi

  </script>

@endsection