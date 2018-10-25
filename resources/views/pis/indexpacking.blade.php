@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('avicenna/pis.part_numb')</div>
                    <div class="panel-body">       
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <input id="detail_no" class="form-control" name="detail_no" required >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <!-- counter -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">@lang('avicenna/pis.counter')</div>
                <div class="panel-body" style="height:110px;">       
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=100> 
                                        <font size=40><div id="counter">TRIAL</div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-body" >@lang('avicenna/pis.date')</div>
            </div>
            <!-- end counter -->

            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">@lang("avicenna/pis.last_scan_title")</div>
                <div class="panel-body">       
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr> 
                                    <th>@lang('avicenna/pis.last_scan_part')</th>
                                </tr>
                                <tr>
                                    <td id="last_scan">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td id="last_scan">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td id="last_scan">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td id="last_scan">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td id="last_scan">&nbsp;</td>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!-- end last scan -->
            
            <!-- x_panel -->
        </div>

        <div class="col-md-9">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <h4><div id="alert-header"> <i class="icon fa fa-check"></i>Alert!</div></h4>
                <div id="alert-body">{{ session('message')['text'] ? session('message')['text'] : 'Ready to Scan !!' }}</div>
            </div>

            <div id="imageDiv">
            
            <!-- x_content -->
            </div>
        </div>

        <div class="col-md-1">
            <div id="delivery" class="form-group">
                <button id="btnOEM" value="OEM" type="button" class="btn btn-block btn-primary" onclick="func_change_delivery(this);">OEM</button>
                <button id="btnGNP" value="GNP" type="button" class="btn btn-block btn-default" onclick="func_change_delivery(this);">GNP</button>
                <button id="btnGNP" value="DANDORI" type="button" class="btn btn-block btn-default" onclick="func_change_delivery(this);">DANDORI</button>
                <input id="delivery_type" value="OEM" type="hidden"></input>
            </div>

            <div id="dock" class="form-group">
                <label>Dock :</label>
                <button id="btnOTHER" value="OTHER" type="button" class="btn btn-block btn-primary" onclick="func_change_dock(this);">OTHER</button>
                <button id="btn1L" value="1L" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">1L</button>
                <button id="btn1N" value="1N" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">1N</button>
                <button id="btn1S" value="1S" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">S1</button>
                <button id="btnTAMTAM" value="TAMTAM" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">TAM-TAM</button>
                <button id="btnTAMADM" value="TAMADM" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">TAM-ADM</button>
                <button id="btnTAMHINO" value="TAMHINO" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">TAM-HINO</button>
                <button id="btnADMKP" value="YHA" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">YHA</button>
                <button id="btnADMAS" value="ADM" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">ADM</button>
                <button id="btnADMKP" value="TTI" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">TTI</button>
                <button id="btnADMKP" value="S1-TAM" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">S1-TAM</button>
                <input id="dock_type" value="OTHER" type="hidden"></input>
            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript">
  
  function func_change_delivery(obj) {
    $('#delivery').find('button').removeClass('btn-primary');
    $('#delivery').find('button').addClass('btn-default');
    $(obj).addClass('btn-primary');
    $('#delivery_type').val(obj.value);
  }

  function func_change_dock(obj) {
    $('#dock').find('button').removeClass('btn-primary');
    $('#dock').find('button').addClass('btn-default');
    $(obj).addClass('btn-primary');
    $('#dock_type').val(obj.value);  
  }

  var barcode   ="";
  var rep2      = "";
  var old_html  = $("#imageDiv").html();
  var detail_no = $('#detail_no');
  
  $(document).keypress(function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            $('#detail_no').val('');
            
            $.ajax({
                    type: 'get',           // {{-- POST Request --}}
                    url: "{{ url('pis/getAjaxImage') }}"+'/'+barcode+'/'+$('#delivery_type').val()+'/'+$('#dock_type').val(),  
                    _token: "{{ csrf_token() }}",
                    dataType: 'json',       // {{-- Data Type of the Transmit --}}
                    success: function (data) {

                        rep2 = data.part_number_customer;
                        
                        if(rep2 == "" ){
                            $('#detail_no').prop('readonly', false);
                            $('#detail_no').val(barcode);

                            {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                            $('#alert').removeClass('alert-success');
                            $('#alert').addClass('alert-danger');
                            $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'@lang("avicenna/pis.alert_error")');
                            $('#alert-body').text('@lang("avicenna/pis.part_not_found")');
                            
                            $('#detail_no').prop('readonly', true);
                            barcode = "";
                            rep2    = "";

                            // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                            $("#imageDiv").html("");
                        }
                        else{
                            {{-- dev-1.0, ferry, 20170913, alert jika success scan --}}
                            $('#alert').removeClass('alert-danger');
                            $('#alert').addClass('alert-success');
                            $('#alert-header').html('<i class="icon fa fa-check"></i>'+'@lang("avicenna/pis.alert_success")');
                            $('#alert-body').text(rep2+'@lang("avicenna/pis.part_found")');

                            $('#detail_no').prop('readonly', false);
                            $('#detail_no').val(rep2);
                            $('#imageDiv').show();

                            // {{-- dev-1.0, 20170816, by yudo, fungsi menampilkan gambar --}}
                            $("#imageDiv").html("<img src='"+data.img_path+"' width='990px' height='560px' />");
                            $('#detail_no').prop('readonly', true);

                            // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                            $('#counter').text(data.counter);

                            $('[id^=last_scan]').html('&nbsp;');
                            for (var i=0; i < data.last_scan.length; i++) {
                                $('[id^=last_scan]').eq(i).text(data.last_scan[i].back_number+" - "+
                                                                data.last_scan[i].part_kind+" - "+
                                                                data.last_scan[i].total_kanban);
                            };

                            barcode = "";
                            rep2    = "";
                        }
                    },
                    error: function (xhr) {

                            // {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                            $('#alert').removeClass('alert-success');
                            $('#alert').addClass('alert-danger');
                            $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'@lang("avicenna/pis.error_scan")'+xhr.status+" - "+xhr.statusText);
                            $('#alert-body').text('@lang("avicenna/pis.part_not_found")');
                            
                            barcode = "";
                            rep2    = "";

                            // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                            $("#imageDiv").html("");
                            // location.reload();
                    }
                                      
                });
               
                
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }    
    });

    $(document).ready(function() {
        $('#detail_no').prop('readonly', true);
    } );

</script>

@endsection
