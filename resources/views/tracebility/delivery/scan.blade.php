@extends('layouts.delivery')

@section('content')
<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b>DELIVERY</b>&nbsp&nbsp >> Total Scan :    <b><span style="font-size: 20pt " id="total-scan"></span></b></div>

                    <div class="panel-body">
                       <center> <span id="wimcycle"></span> - <span id="customer"> </span></center>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                    <input height=60 id="detail_no" class="form-control" name="detail_no" required type="hidden" >
                                    <center><label id="batman" style="font-size: 20pt;font-weight: bold;"></label></center>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <!-- <h4><div id="alert-header"><center> SCAN PART</center></div></h4> -->
                <div id="alert-body" style="font-size : 14px; text-align: center; ">{{ session('message')['text'] ? session('message')['text'] : ' ' }}</div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
@parent

<script src="{{ asset('/js/jquery-cookie.js') }}"></script>
<script type="text/javascript">


  var barcode   ="";
  var rep2      = "";
  var detail_no = $('#detail_no');
  var flag=1;

  $(document).keypress(function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            barcodecomplete = barcode;
            barcode = "";
            if (barcodecomplete == "DOWA") {
                window.location.replace("{{url('/trace/scan/delivery/dowa')}}");
                return;
            }
            if (barcodecomplete == "D98E") {
                window.location.replace("{{url('/trace/scan/delivery/d98')}}");
                return;
            }
            // remove * from qr
            if (barcodecomplete.length == 17) {
                if (barcodecomplete[0] == '*' && barcodecomplete[16] == '*') {
                    barcodecomplete = barcodecomplete.slice(1).slice(0, -1);
                }
            }

            if (barcodecomplete.length == 2) {
                if(barcodecomplete=="EN"){
                    $.removeCookie("wimcycle");
                    $.removeCookie("customer");
                    $("#wimcycle").html("");
                    $("#customer").html("");
                    $('#batman').html("");
                    $('#alert').removeClass('alert-danger');
                    $('#alert').removeClass('alert-success');
                    $('#alert').addClass('alert-success');
                    $('#alert-body').text('SCAN CYCLE DAN CUSTOMER');
                    $('#alert-body').text('SELESAI');
                }else{
                    $.ajax({
                        type: 'get',           // {{-- POST Request --}}
                        url: "{{ url('/trace/scan/delivery/getAjaxcycle') }}"+'/'+barcodecomplete,
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // {{-- Data Type of the Transmit --}}
                        success: function (data) {
                            code = data.cycle;
                            $('#alert').removeClass('alert-danger');
                            $('#alert').addClass('alert-success');
                            if ($.cookie("customer") != undefined) {
                                $('#alert-body').text('SCAN PART/KANBAN TRACEABILITY');
                            }else{
                                $('#alert-body').text('SILAHKAN SCAN CUSTOMER');
                            }
                            $.cookie("wimcycle",""+barcodecomplete+"");
                            $("#wimcycle").html(code);
                        },
                        error: function (xhr) {
                        }

                    });
                }

            }else if(barcodecomplete.length > 2 && barcodecomplete.length < 10){
                $('#alert').removeClass('alert-danger');
                if ($.cookie("wimcycle") != undefined) {
                    $('#alert-body').text('SCAN PART/KANBAN TRACEABILITY');
                }else{
                    $('#alert-body').text('SILAHKAN SCAN CYCLE');
                }
                $('#alert').addClass('alert-success');
                $.cookie("customer",""+barcodecomplete+"");
                $("#customer").html(barcodecomplete);
            }
            else if( barcodecomplete.length == 15 || barcodecomplete.length == 230 )
            {
                if($.cookie("wimcycle") != undefined && $.cookie("customer") != undefined ){
                $.ajax({
                        type: 'get',           // {{-- POST Request --}}
                        url: "{{ url('/trace/scan/delivery/getAjax') }}"+'/'+barcodecomplete+"/"+$.cookie("wimcycle")+"/"+$.cookie("customer"),
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // {{-- Data Type of the Transmit --}}
                        success: function (data) {
                            code = data.code;
                            if(code == "" ){
                                $('#detail_no').prop('readonly', false);
                                $('#detail_no').val(barcodecomplete);
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#batman').html(barcodecomplete);
                                $('#alert-body').text('Data sudah ada');
                                $('#detail_no').prop('readonly', true);
                            } else if(code == "not found" ){
                                $('#detail_no').prop('readonly', false);
                                $('#detail_no').val(barcodecomplete);
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#batman').html(barcodecomplete);
                                $('#alert-body').text('Not Found');
                                $('#detail_no').prop('readonly', true);
                            } else {
                                $('#alert').removeClass('alert-danger');
                                $('#alert').addClass('alert-success');
                                $('#alert-body').text(data.code);
                                $('#detail_no').val(rep2);
                                $('#detail_no').prop('readonly', true);
                                $('#total-scan').html(data.counter);
                                $.cookie("counter", data.counter);
                                $('#batman').html(data.code);
                            }

                        },
                        error: function (xhr) {

                                // {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                // $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'@lang("avicenna/pis.error_scan")'+xhr.status+" - "+xhr.statusText);
                                $('#alert-body').text('@lang("avicenna/pis.part_not_found")');

                                console.log("flag 1 ajax eror");
                        }

                    });
                }else if($.cookie("wimcycle") == undefined && $.cookie("customer") == undefined){
                                $('#alert').removeClass('alert-danger');
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-body').text('SCAN CYCLE DAN CUSTOMER');
                                $('#detail_no').prop('readonly', true);
                }else if($.cookie("wimcycle") == undefined){
                                $('#alert').removeClass('alert-danger');
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-body').text('SCAN CYCLE');
                                $('#detail_no').prop('readonly', true);
                }else if($.cookie("customer") == undefined){
                                $('#alert').removeClass('alert-danger');
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-warning');
                                $('#alert-body').text('SCAN CUTOMER');
                                $('#detail_no').prop('readonly', true);
                }

            }else if (barcodecomplete.length == 13) {

                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                // $('#alert-header').html('PERHATIAN !!');
                                $('#alert-body').text('SCAN GAGAL MOHON ULANGI');
                                $('#detail_no').prop('readonly', true);

            }
            else {
                    $.removeCookie("wimcycle");
                    $.removeCookie("customer");
                    window.location.replace("{{url('/trace/logout')}}");

            }

        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }

    });

    $(document).ready(function() {
        $('#detail_no').prop('readonly', true);
        document.body.style.backgroundColor = '#dddddd';
        if($.cookie("wimcycle") != undefined) {
            $.ajax({
                        type: 'get',           // {{-- POST Request --}}
                        url: "{{ url('/trace/scan/delivery/getAjaxcycle') }}"+'/'+$.cookie("wimcycle"),
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // {{-- Data Type of the Transmit --}}
                        success: function (data) {
                            code = data.cycle;
                            $('#alert').removeClass('alert-danger');
                            $('#alert').addClass('alert-success');
                            if ($.cookie("customer") != undefined) {
                                $('#alert-body').text('SCAN PART/KANBAN TRACEABILITY');
                            }else{
                                $('#alert-body').text('SILAHKAN SCAN CUSTOMER');
                            }
                            $("#wimcycle").html(code);
                        },
                        error: function (xhr) {
                        }

                    });
        }
        if ($.cookie("customer") != undefined) {
            $('#customer').html($.cookie("customer"));
        }

        if ($.cookie("counter") != undefined) {
            $('#total-scan').html($.cookie("counter"));
        }

    } );

</script>

@endsection
