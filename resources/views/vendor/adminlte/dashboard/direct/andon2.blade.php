@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

<!-- < div class="container">
  <div class="col-md-4" style="background-color: #000;">
    <table class="" border="1" style="border-color:'#aa0523';" width="100%">
      <tbody>
        <tr>
          <td class="tag" width="120px">TARGET</td>
          <td class="value" align="right">10000</td>
        </tr>
         <tr>
          <td class="tag">TARGET QTY</td>
          <td class="value" align="right">10000</td>
        </tr>
        <tr>
          <td class="tag">ACTUAL QTY</td>
          <td class="value" align="right">10000</td>
        </tr>
        <tr>
          <td class="tag">BALANCE</td>
          <td class="value" align="right">10000</td>
        </tr>
        <tr>
          <td class="tag">ACHIEVE(%)</td>
          <td class="value" align="right">10000

        </tr>
          <tr>
          <td class="tag-yellow" align="center">LOSS TIME(sec)<br/>(QA)</td>
          <td class="value" align="right">0</td>
        </tr>
         <tr>
          <td class="tag-green" align="center">LOSS TIME(sec)<br/>(PARTS)</td>
          <td class="value" align="right">0</td>
        </tr>
        <tr>
          <td class="tag-red" align="center">LOSS TIME(sec)<br/>(M/C)</td>
          <td class="value" align="right">0</td>
        </tr>
        <tr>
          <td class="tag" align="center">DANDORI(sec)</td>
          <td class="value" align="right">0</td>
        </tr>
      </tbody>
    </table>
  </div>
</div> -->








<div  class="col-md-4">

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
                        <th style="text-align: center; width: 25% ; font-size: 11px"><span>07-05-2018<br>09:10:59</th>
                        <th style="text-align: center; width: 50% ; font-size: 27px ; background-color: #ffff00 ; color: #000000 "><span class="direct-chat-name pull-center">AS600</span></th>
                        <th style="text-align: center; width: 25%"><span style="text-align: center;" >SHIFT 1</th>
                      </tr>
                    </table>
                    <table border="0" style="border-color:#ffffff; background-color: #000000 ; padding: 10px " width="100%" >
                      <tr>
                        <td class="tag" style="width: 50%">TARGET<br>標的</td>
                        <td class="value" style="width: 50%">100</td>
                      </tr>
                      <tr>
                        <td class="tag">TARGET QTY<br>目標量</td>
                        <td class="value">100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACTUAL QTY<br>実際の数量</td>
                        <td class="value">1000</td>
                      </tr>
                      <tr>
                        <td class="tag">BALANCE<br>残高</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACHIVE (%)<br>達成する</td>
                        <td class="value">
                            100 %
                        </td>
                      </tr>
                      <tr><!-- 
                        <td class="tag-green">LOSS TIME(sec)<br/>(QA)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-yellow">LOSS TIME(sec)<br/>(PART)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-red">LOSS TIME(sec)<br/>(M/C)</td>
                        <td class="value">
                            100
                        </td>
                      </tr> -->
                      <tr>
                        <td class="tag">DANDORI(sec)<br>段取り</td>
                        <td class="value">
                            100
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
<div  class="col-md-4">

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
                        <th style="text-align: center; width: 25% ; font-size: 11px"><span>07-05-2018<br>09:10:59</th>
                        <th style="text-align: center; width: 50% ; font-size: 27px ; background-color: #ffff00 ; color: #000000 "><span class="direct-chat-name pull-center">AS751</span></th>
                        <th style="text-align: center; width: 25%"><span style="text-align: center;" >SHIFT 1</th>
                      </tr>
                    </table>
                    <table border="0" style="border-color:#ffffff; background-color: #000000 ; padding: 10px " width="100%" >
                      <tr>
                        <td class="tag" style="width: 50%">TARGET<br>標的</td>
                        <td class="value" style="width: 50%">100</td>
                      </tr>
                      <tr>
                        <td class="tag">TARGET QTY<br>目標量</td>
                        <td class="value">100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACTUAL QTY<br>実際の数量</td>
                        <td class="value">1000</td>
                      </tr>
                      <tr>
                        <td class="tag">BALANCE<br>残高</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACHIVE (%)<br>達成する</td>
                        <td class="value">
                            100 %
                        </td>
                      </tr>
                      <tr><!-- 
                        <td class="tag-green">LOSS TIME(sec)<br/>(QA)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-yellow">LOSS TIME(sec)<br/>(PART)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-red">LOSS TIME(sec)<br/>(M/C)</td>
                        <td class="value">
                            100
                        </td>
                      </tr> -->
                      <tr>
                        <td class="tag">DANDORI(sec)<br>段取り</td>
                        <td class="value">
                            100
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
<div  class="col-md-4">

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
                        <th style="text-align: center; width: 25% ; font-size: 11px"><span>07-05-2018<br>09:10:59</th>
                        <th style="text-align: center; width: 50% ; font-size: 27px ; background-color: #ffff00 ; color: #000000 "><span class="direct-chat-name pull-center">AS523</span></th>
                        <th style="text-align: center; width: 25%"><span style="text-align: center;" >SHIFT 1</th>
                      </tr>
                    </table>
                    <table border="0" style="border-color:#ffffff; background-color: #000000 ; padding: 10px " width="100%" >
                      <tr>
                        <td class="tag" style="width: 50%">TARGET<br>標的</td>
                        <td class="value" style="width: 50%">100</td>
                      </tr>
                      <tr>
                        <td class="tag">TARGET QTY<br>目標量</td>
                        <td class="value">100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACTUAL QTY<br>実際の数量</td>
                        <td class="value">1000</td>
                      </tr>
                      <tr>
                        <td class="tag">BALANCE<br>残高</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag">ACHIVE (%)<br>達成する</td>
                        <td class="value">
                            100 %
                        </td>
                      </tr>
                      <tr><!-- 
                        <td class="tag-green">LOSS TIME(sec)<br/>(QA)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-yellow">LOSS TIME(sec)<br/>(PART)</td>
                        <td class="value">
                            100
                        </td>
                      </tr>
                      <tr>
                        <td class="tag-red">LOSS TIME(sec)<br/>(M/C)</td>
                        <td class="value">
                            100
                        </td>
                      </tr> -->
                      <tr>
                        <td class="tag">DANDORI(sec)<br>段取り</td>
                        <td class="value">
                            100
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
      result = ''+days[day]+', '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;

      var elems = document.getElementsByClassName(id);
      for(var i = 0; i < elems.length; i++) {
          elems[i].innerHTML = result;
      }
      setTimeout('date_time("'+id+'");','1000');

      return true;
    }

    $(document).ready(function(){
        date_time('jam');
        // Start an interval to go to the "next" page every 10 seconds
        // setInterval(function(){
        //   location.reload();
        // }, 10000); // 10 seconds

    });

  </script>

@endsection