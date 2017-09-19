@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Part Number</div>
                    <div class="panel-body">       
                        <div class="form-group">
                           <!--  <div class="row">
                                <label class="col-md-8 control-label">Detail No</label>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <input id="detail_no" class="form-control" name="detail_no" required >
                                </div>
                               <!--  <div class="col-md-3">
                                    <button id="btnReset" class="btn btn-primary">
                                     Reset
                                    </button>
                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- counter -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">Counter (Total Scan)</div>
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
                <div class="panel-body" >Date : </div>
            </div>
            <!-- end counter -->

            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">Last scan</div>
                <div class="panel-body">       
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr> 
                                    <th>Part Number</th>
                                </tr>
                                <tr>
                                    <td>TRIAL - 800A</td>
                                </tr>
                                <tr>
                                    <td>TRIAL - 4L45W</td>
                                </tr>
                                <tr>
                                    <td>TRIAL - 4L45W</td>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!-- end last scan -->
            
            <!-- x_panel -->
        </div>

        <div class="col-md-8">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <h4><div id="alert-header"> <i class="icon fa fa-check"></i>Alert!</div></h4>
                <div id="alert-body">{{ session('message')['text'] ? session('message')['text'] : 'Ready to Scan !!' }}</div>
            </div>

            <div id="imageDiv">
            
            <!-- x_content -->
            </div>
        </div>

        <div class="col-md-2">
            <button id="btnOEM" value="OEM" type="button" class="btn btn-block btn-primary" onclick="func_change_delivery(this);">Mode : OEM Activated</button>
            <button id="btnGNP" value="GNP" type="button" class="btn btn-block btn-default" onclick="func_change_delivery(this);">GNP</button>
            <input id="delivery_type" value="OEM" type="hidden"></input>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript">
  
  function func_change_delivery(obj) {
    if ($(obj).val() == "OEM") {
        $(obj).removeClass('btn-default');
        $(obj).addClass('btn-primary');
        $(obj).text('Mode : OEM Activated');
        
        $('#btnGNP').removeClass('btn-primary');
        $('#btnGNP').addClass('btn-default');
        $('#btnGNP').text("GNP");
    }
    else if ($(obj).val() == "GNP") {
        $(obj).removeClass('btn-default');
        $(obj).addClass('btn-primary');
        $(obj).text('Mode : GNP Activated');
        
        $('#btnOEM').removeClass('btn-primary');
        $('#btnOEM').addClass('btn-default');
        $('#btnOEM').text("OEM");
        
    }
    $('#delivery_type').val(obj.value);
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
                    type: 'get',           // POST Request
                    url: "{{ url('pis/getAjaxImage') }}"+'/'+barcode+'/'+$('#delivery_type').val(),  
                    _token: "{{ csrf_token() }}",
                    dataType: 'json',       // Data Type of the Transmit
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

                            // dev-1.0, 20170913, Ferry, Fungsi informasi display
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

                            //dev-1.0, 20170816, by yudo, fungsi menampilkan gambar
                            $("#imageDiv").html("<img src='"+data.img_path+"' width='1100px' height='560px' />");
                            $('#detail_no').prop('readonly', true);

                            // dev-1.0, 20170913, Ferry, Fungsi informasi display
                            $('#counter').text(data.counter);

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

                            // dev-1.0, 20170913, Ferry, Fungsi informasi display
                            $("#imageDiv").html("");
                            location.reload();
                    }
                                      
                });
               
                
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }    
    });

    $("#btnReset").click(function(){
           rep2    = "";
           $('#table_hide').hide();
           $('#imageDiv').html(old_html);
           $(this).blur();
           detail_no.val("");
        });

    $(document).ready(function() {
        // $('#table_hide').hide();
        // $('#imageDiv').hide();
        $('#detail_no').prop('readonly', true);
    } );

</script>

@endsection
