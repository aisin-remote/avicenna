@extends('adminlte::layouts.app')

@section('main-content')
  <div class="row">
      @foreach ($andons as $andon)
        <div class="col-md-3">

          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $andon->line }}</h3>

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
                    <span class="direct-chat-name pull-left">CT: 40 Seconds</span>
                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                  </div>
                  <div>
                    <table class="table table-bordered">
                      <tr>
                        <th colspan="3" style="text-align: center">ALL Part Model</th>
                      </tr>
                      <tr>
                        <td>Target Qty</td>
                        <td>
                            520
                        </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Actual Qty</td>
                        <td>
                            495
                        </td>
                        <td><span class="badge bg-green">80%</span></td>
                      </tr>
                      <tr>
                        <th colspan="3" style="text-align: center">Running Model</th>
                      </tr>
                      <tr>
                        <td>Part #</td>
                        <td colspan="3">
                            439430-12511
                        </td>
                      </tr>
                      <tr>
                        <td>Actual Qty</td>
                        <td>
                            500
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
                    <p>NORMAL</p>
                </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        <!-- /.col -->
      @endforeach
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

@endsection