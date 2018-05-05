@extends('adminlte::layouts.app')

@section('main-content')
<link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

  <div class="row">

        <div class="col-md-3">

          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">AS600</h3>

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages" style="height: 100%">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">LIVE</span>
                    <span class="direct-chat-timestamp pull-right"><div class="jam"></div></span>
                  </div>
                  <div>
                    <table class="table table-bordered">
                      <tr>
                        <th colspan="3" style="text-align: center">ALL Part Model</th>
                      </tr>
                      <tr>
                        <td>Target Qty</td>
                        <td>
                            100
                        </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Actual Qty</td>
                        <td>
                            100
                        </td>
                        <td><span class="badge bg-green">100%</span></td>
                      </tr>
                      <tr>
                        <th colspan="3" style="text-align: center">Running Model</th>
                      </tr>
                      <tr>
                        <td>Part #</td>
                        <td colspan="3">
                            Back no
                        </td>
                      </tr>
                      <tr>
                        <td>Actual Qty</td>
                        <td>
                            100
                        </td>
                        <td></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="callout callout-success" align="center">
                    <p>Normal</p>
                </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        <!-- /.col -->

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
        setInterval(function(){
          location.reload();
        }, 10000); // 10 seconds

    });

  </script>

@endsection