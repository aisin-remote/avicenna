@extends('layouts.delivery')

@section('content')
<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b><center> DELIVERY DOWA</center></b></span></b>
                </div>
                <div class="panel-body">
                    {{-- <span style="float: left"><font size=2>Total Scan :</font></span>
                    <br>
                    <font size=4><strong><span style="float: left" id="total_scan">-</strong></font></span>
                    <br> --}}
                    <input id="detail_no"required type="hidden" readonly>
                    <span><font size=2>Kanban Internal :</font></span>
                    <br>
                    <strong><font size=4><span id="part-internal">-</span></font></strong>
                    <br>
                    <span><font size=2>Kanban Supply :</font></span>
                    <br>
                    <strong><font size=4><span id="part-supply">-</span></font></strong>
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
  var flag=1;
  $(document).keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            barcodecomplete = barcode;
            barcode = "";
            if (barcodecomplete == "DOWA") {
                window.location.replace("{{url('/trace/scan/delivery')}}");
                return;
            }
            if (barcodecomplete.length == 13) {
                clearCookie();
                window.location.replace("{{url('/trace/logout')}}");
            } else if (barcodecomplete.length == 230) {
                barcodesub = barcodecomplete.substring(123,127)
                if (checkDataCookie()) {
                    checkDataAjax(barcodesub);
                } else {
                    notifMessege("error", "Rescan Internal Kanban");
                    clearCookie();
                }
            } else if (barcodecomplete.length == 234) {
                if ($.cookie('avi_kanban_int') == null || $.cookie('avi_kanban_int') == undefined) {
                    notifMessege("error", "Scan Internal Kanban First !");
                    return;
                }
                barcodesub = barcodecomplete.substring(119,124);
                notifMessege("success", barcodesub);
                $('#part-supply').text(barcodesub);
                sendDataAjax(barcodesub);
                clearCookie();
            }
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }

    });
    function clearCookie() {
        $.removeCookie('avi_kanban_int');
        $('#part-internal').text('-');
        $('#part-supply').text('-');
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
            url: "{{ url('/trace/scan/delivery/dowa/check-code') }}",
            data: {
                kbnint : barcodecomplete
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == "false") {
                    notifMessege("error", data.codesubstr+" Not Found");
                    return false;
                } else if(data.code == "error") {
                    alert("Please resecan kanban");
                    notifMessege("error", barcodesub);
                    return false;
                } else {
                    notifMessege("success", barcodesub);
                    $.cookie('avi_kanban_int', barcodesub);
                    $('#part-internal').text(barcodesub);
                    return true;
                }
            },
            error: function (xhr) {
                alert("Please resecan kanban");
                return false;
            }
        });
    }

    function sendDataAjax(code) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/delivery/dowa/input-code') }}",
            data: {
                kbn_int : $.cookie('avi_kanban_int'),
                kbn_sup : code
            },
            dataType: 'json',
            success: function (data) {
                notifMessege("success", "Data Saved");
                if ($.cookie('total_scan') == null || $.cookie('total_scan') == undefined ) {
                    $.cookie('total_scan', 1);
                } else {
                    $.cookie('total_scan', $.cookie('total_scan')+1);
                }
                $('#total_scan').text($.cookie('total_scan'));
            },
            error: function (xhr) {
                alert("Error sending data");
                notifMessege("error", xhr)
            }

        });
    }
</script>

@endsection
