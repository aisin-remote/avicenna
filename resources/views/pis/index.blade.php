@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Part Number</div>
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
                <input id="delivery_type" value="OEM" type="hidden"></input>
            </div>

            <div id="dock" class="form-group">
                <label>Dock :</label>
                <button id="btn43" value="43" type="button" class="btn btn-block btn-primary" onclick="func_change_dock(this);">43</button>
                <button id="btn53" value="53" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">53</button>
                <button id="btn4L45W" value="4L45W" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">4L45W</button>
                <button id="btn1L" value="1L" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">1L</button>
                <button id="btn1N" value="1N" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">1N</button>
                <button id="btn1S" value="1S" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">1S</button>
                <button id="btn6I" value="6I" type="button" class="btn btn-block btn-default" onclick="func_change_dock(this);">6I</button>
                <input id="dock_type" value="43" type="hidden"></input>
            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript">
  
  function func_change_delivery(obj) {
    // if ($(obj).val() == "OEM") {
    //     $(obj).removeClass('btn-default');
    //     $(obj).addClass('btn-primary');
        
    //     $('#btnGNP').removeClass('btn-primary');
    //     $('#btnGNP').addClass('btn-default');
    // }
    // else if ($(obj).val() == "GNP") {
    //     $(obj).removeClass('btn-default');
    //     $(obj).addClass('btn-primary');
        
    //     $('#btnOEM').removeClass('btn-primary');
    //     $('#btnOEM').addClass('btn-default');    
    // }
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
                    url: "{{ url('pis/getAjaxImage') }}"+'/'+barcode+'/'+$('#delivery_type').val(),  
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
                            location.reload();
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
