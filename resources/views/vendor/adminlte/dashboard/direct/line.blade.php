@extends('layouts.delivery')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />
<div class="col-md-12" style="margin-bottom: 10px; margin-top: 10px; background-color: #2a374f; height: 100% "> 
  <span style="color: white; font-size: 25px "> BODY PLANT </span> <br>
  <span style="color: white; font-size: 15px "> All line in body plant </span>
</div>
        @foreach ($lines as $andon)

        <?php
          // special manipulation in looping
          if ($andon->status == 1) {
            $class= '#bf4848'; //merah
            $text= '#ffffff'; //putih
          }
          elseif ($andon->status == 2) {
            $class = '#5daa68'; //hijau
            $text= '#ffffff'; //putih
          }
          elseif ($andon->status == 3) {
            $class = '#ffff00' ; //kuning
            $text= '#000000'; //hitam
          }elseif ($andon->status == 4) {
            $class = '#ffffff'; //putih
            $text= '#000000'; //hitam
          }
          elseif ($andon->status == 5) {
            $class = '#000000'; //hitam
            $text = '#ffffff'; //putih
          }
        ?>

        <div  class="col-md-2" style="margin-bottom: 10px">

          <!-- DIRECT CHAT PRIMARY -->
          <div style="background-color: #2a374f ; color : #ffffff " >
            <!-- /.box-header -->

            <div>
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" style="height: 100%">
                <!-- Message. Default to the left -->
                <div class="table-bordered" >
                  <div  border="1" style="border-color: white ">
                    <div style="text-align: center; width: 100%; height: 50% ; font-size: 27px ; background-color: {{$class}} ; color: {{$text}} ; padding-right: : 10px ; padding-left: 10px; "> {{ $andon->line }} </div>
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->

            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        @endforeach
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="col-md-12" style="margin-bottom: 10px; margin-top: 10px; background-color: #2a374f; height: 100% "> 
  <span style="color: white; font-size: 25px "> UNIT PLANT </span> <br>
  <span style="color: white; font-size: 15px "> All line in unit plant </span>
</div>
        @foreach ($lines as $andon)

        <div  class="col-md-2" style="margin-bottom: 10px">

          <!-- DIRECT CHAT PRIMARY -->
          <div style="background-color: #2a374f ; color : #ffffff " >
            <!-- /.box-header -->

            <div>
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" style="height: 100%">
                <!-- Message. Default to the left -->
                <div class="table-bordered" >
                  <div  border="1" style="border-color: white ">
                    <div style="text-align: center; width: 100%; height: 50% ; font-size: 27px ; background-color: #ffff00 ; color: #000000 ; padding-right: : 10px ; padding-left: 10px; "> {{ $andon->line }} </div>
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->

            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        @endforeach


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

    $(document).ready(function(){
        document.body.style.backgroundColor = '#1f293a';
    
        // Start an interval to refresh page every 10 seconds
        setInterval(function(){
          location.reload();
        }, 10000); // 10 seconds
    });

  </script>

@endsection