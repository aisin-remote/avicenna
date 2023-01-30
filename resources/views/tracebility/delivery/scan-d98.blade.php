@extends('layouts.delivery')

@section('content')
<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b><center> DELIVERY - D98E</center></b></span></b>
                </div>
                <div class="panel-body">
                    <input id="detail_no"required type="hidden" readonly>
                    <span style="float: left"><font size=2>Total Scan :</font></span>
                    <font size=4><strong><span style="float: left" id="total_scan">-</strong></font></span>
                    <br>
                    <span><font size=2>Customer :</font></span>
                    <strong><font size=4><span id="customer">-</span></font></strong>
                    <br>
                    <span><font size=2>Cycle :</font></span>
                    <strong><font size=4><span id="cycle">-</span></font></strong>
                    <br>
                    <span><font size=2>Kanban Internal :</font></span>
                    <br>
                    <strong><font size=4><span id="part-internal">-</span></font></strong>
                    <br>
                    <span><font size=2>Kanban Customer :</font></span>
                    <br>
                    <strong><font size=4><span id="part-cust">-</span></font></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
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
  var flag      =1;
  var total_scan = 0;
  $( document ).ready(function() {
        $("#cycle").html("-");
        $("#customer").html("-");
  });

  $(document).keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            barcodecomplete = barcode;
            barcode = "";
            if (barcodecomplete == "D98E") {
                window.location.replace("{{url('/trace/scan/delivery')}}");
                return;
            }
            if (barcodecomplete.length == 13) {
                clearCookie();
                window.location.replace("{{url('/trace/logout')}}");
            } else if (barcodecomplete.length == 2){
                if (barcodecomplete == "EN") {
                    clearAllCookie();
                    $("#cycle").html("-");
                    $("#customer").html("-");
                    notifMessege("success", "Yey Pulling Selesai, Ayo Scan Barcode Customer Lagi !");
                } else {
                    getAjaxCycle();
                }
            } else if( barcodecomplete.length > 2 && barcodecomplete.length < 10 ){
                if ($.cookie("cycle") != undefined) {
                    notifMessege("success", "Horee Pulling telah Siap, Ayo Scan Barcode Cycle !");
                } else {
                    notifMessege("success", "Kamu berhasil, Ayo Scan Cycle untuk Customer "+ barcodecomplete);
                }
                $.cookie("customer",""+barcodecomplete+"");
                $("#customer").html(barcodecomplete);
            } else if (barcodecomplete.length == 230) {
                barcodesub = barcodecomplete;
                if ($.cookie('customer') == null || $.cookie('customer') == undefined) {
                    notifMessege("error",  "Kamu salah, seharusnya Scan barcode customer dulu");
                    return;
                }
                if (checkDataCookie()) {
                    checkDataAjax(barcodesub);
                } else {
                    notifMessege("error", "Rescan Internal Kanban");
                    clearCookie();
                }
            } else if (barcodecomplete.length == 40) {
                if ($.cookie('avi_kanban_int') == null || $.cookie('avi_kanban_int') == undefined) {
                    notifMessege("error",  "Kamu salah, seharusnya Scan kanban internal dulu, lalu scan Kanban customer !");
                    return;
                }
                barcodesub = barcodecomplete
                $('#part-cust').text(barcodesub);
                notifMessege("success", barcodesub);
                sendDataAjax(barcodesub);
            }
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }

    });

    function getAjaxCycle() {
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
                    notifMessege("success", "Pulling telah Siap, Ayo Scan Kanban Internal !");
                    $.cookie("cycle",""+barcodecomplete+"");
                    $("#cycle").html(code);
                }else{
                    notifMessege("error", "Kamu salah, seharusnya Scan Customer dulu, lalu scan Cycle !");
                }
            },
            error: function (xhr) {
            }

        });
    };

    function clearCookie() {
        $.removeCookie('avi_kanban_int');
        $.removeCookie('avi_kanban_seri');
        $.removeCookie('avi_kanban_partnum');
        $('#part-internal').text('-');
        $('#part-cust').text('-');
    };
    
    function clearAllCookie() {
        $.removeCookie('avi_kanban_int');
        $.removeCookie('avi_kanban_seri');
        $.removeCookie('avi_kanban_partnum');
        $.removeCookie('customer');
        $.removeCookie('cycle');
        $('#part-internal').text('-');
        $('#customer').text('-');
        $('#cycle').text('-');
        $('#part-cust').text('-');
    };

    function notifMessege(type, messege) {
        if (type == "error") {
            $('#alert').removeClass('alert-success');
            $('#alert').addClass('alert-danger');
            $('#alert-body').text(messege);
        } else if (type == "success") {
            $('#alert').removeClass('alert-danger');
            $('#alert').addClass('alert-success');
            $('#alert-body').text(messege);
        }
    }

    function checkDataCookie() {
        let kanbanInt = $.cookie('avi_kanban_int');
        if (kanbanInt == null || kanbanInt == undefined) {
            return true;
        } else {
            return false;
        }
    }

    function checkDataAjax(barcodecomplete) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/delivery/d98/check-code') }}",
            data: {
                kbnint : barcodecomplete
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == "false") {
                    notifMessege("error", "Kanban masih kosong!");
                    return false;
                } else if(data.code == "error") {
                    alert("Please rescan kanban");
                    notifMessege("error", barcodesub);
                    return false;
                } else if(data.code == "notRegistered") {
                    notifMessege("error", "Kanban tidak ditemukan");
                    return false;
                } else {
                    notifMessege("success", "Horee kanban berhasil discan, ayo scan kanban cutomer");
                    $.cookie('avi_kanban_seri', data.seri);
                    $.cookie('avi_kanban_int', data.backnum);
                    $.cookie('avi_kanban_partnum', data.partnum);
                    $('#part-internal').text(data.backnum);
                    return true;
                }
            },
            error: function (xhr) {
                alert("Please rescan kanban");
                return false;
            }
        });
    }

    function sendDataAjax(code) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/delivery/d98/input-code') }}",
            data: {
                kbn_int : $.cookie('avi_kanban_int'),
                kbn_cust : code,
                seri : $.cookie('avi_kanban_seri'),
                customer : $.cookie('customer'),
                cycle : $.cookie('cycle'),
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == "error") {
                    notifMessege("error", "Kanban Supply Exist")
                    clearCookie();
                } else if (data.status == "partExist") {
                    notifMessege("error", "Part Sudah ada!")
                    clearCookie();
                } else if(data.status == "success") {
                    notifMessege("success", "Horee, Data telah tersimpan");
                    if ($.cookie('total_scan') == null || $.cookie('total_scan') == undefined || $.cookie('total_scan') == 0) {
                        total_scan = 1;
                        $.cookie('total_scan', total_scan);
                        clearCookie();
                    } else {
                        $.cookie('total_scan', ++total_scan);
                        clearCookie();
                    }
                    $('#total_scan').text($.cookie('total_scan'));
                    clearCookie();
                }
                $('#total_scan').text($.cookie('total_scan'));
                clearCookie();
            },
            error: function (xhr) {
                clearCookie();
                alert("Error sending data");
                notifMessege("error", xhr)
            }

        });
    }
</script>

@endsection
