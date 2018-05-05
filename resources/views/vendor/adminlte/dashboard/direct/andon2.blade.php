@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

<div class="container">
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