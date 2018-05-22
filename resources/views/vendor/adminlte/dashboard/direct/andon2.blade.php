@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/css/aisya/andon.css') }}" rel="stylesheet" type="text/css" />

        @foreach ($andons as $andon)
        <div  class="col-md-4" style="margin-bottom: 10px">

          <!-- DIRECT CHAT PRIMARY -->
          <div style="background-color: #000000 ; color : #ffffff " >
            <!-- /.box-header -->

            <div>
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" style="height: 100%">
                <!-- Message. Default to the left -->
                <div class="table-bordered" >
                  <div  border="1" style="border-color: white ">
                    <table style="background-color: #000000 ;" class="table table-bordered">
                      <tr>
                        <th style="text-align: center; width: 25% ; font-size: 11px"><div class="jam"></div></th>
                        <th style="text-align: center; width: 50% ; font-size: 27px ; background-color: #ffff00 ; color: #000000 ; padding-right: : 20px ; padding-left: 20px "><span class="direct-chat-name pull-center">{{ $andon->line }}</span></th>
                        <th style="text-align: center; width: 25%"><span style="text-align: center;" >MODEL<br>{{$andon->running->back_number}}</th>
                      </tr>
                    </table>
                    <table border="0" style="border-color:#ffffff; background-color: #000000 ; padding: 10px " width="100%" >
                      <tr>
                        <td class="tag" style="width: 50%">TARGET<br>標的</td>
                        <td class="value" style="width: 50%">{{ $andon->target }}</td>
                      </tr>
                      <tr>
                        <td class="tag">TARGET QTY<br>目標量</td>
                        <td class="value">
                          {{ $andon->target_qty }}
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACTUAL QTY<br>実際の数量</td>
                        <td class="value">
                          {{ $andon->actual_qty }}
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">BALANCE<br>残高</td>
                        <td class="value">
                            {{ $andon->actual_qty - $andon->target_qty  }}
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACHIVE (%)<br>達成する</td>
                        <td class="value">
                            {{ number_format((empty($andon->target_qty) || ($andon->target_qty==0)) ? 0 : round($andon->actual_qty / $andon->target_qty, 2) * 100 , 1) }} %
                        </td>
                      </tr>
                      <tr>
                      <tr>
                        <td class="tag">DANDORI(sec)<br>段取り</td>
                        <td class="value">
                            {{ $andon->dandori }}
                        </td>
                      </tr>
                      <tr>
                        <td style="background-color: #000000 ; width: 100% ; text-align: center; color: #000000 " colspan="2">A</td>
                      </tr>
                      <tr>
                        <td style=" background-color: #ffff00 ; width: 100% ; text-align: center; color: #000000" colspan="2">PT AISIN INDONESIA AUTOMOTIVE</td>
                      </tr>
                    </table>
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

    function date_time(id) {
      date = new Date;
      year = date.getFullYear();
      month = date.getMonth();
      months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');
      d = date.getDate();
      day = date.getDay();
      days = new Array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');
      h = date.getHours();
      if(h<10)
      {
              h = "0"+h;
      }
      m = date.getMinutes();
      if(m<10)
      {
              m = "0"+m;
      }
      s = date.getSeconds();
      if(s<10)
      {
              s = "0"+s;
      }
      result = +d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;

      var elems = document.getElementsByClassName(id);
      for(var i = 0; i < elems.length; i++) {
          elems[i].innerHTML = result;
      }
      setTimeout('date_time("'+id+'");','1000');

      return true;
    }

    $(document).ready(function(){
        date_time('jam');
        document.body.style.backgroundColor = '#212121';
    
        // Start an interval to refresh page every 10 seconds
        setInterval(function(){
          location.reload();
        }, 10000); // 10 seconds
    });

  </script>

@endsection