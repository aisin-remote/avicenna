@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="line" class="panel panel-default" >
                <span style="font-size : 50px "> <center> LINE TORIMETRON </center> </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="ng-banner" class="alert alert-danger" style="display :none">
                <h2><div style="font-size : 51px; text-align: center;"> <i class="icon fa fa-check"></i>SCAN PART NG</div></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">PART SCANNED</div>
                <div class="panel-body" style="height:110px;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                <input height=60 id="detail_no" class="form-control" name="detail_no" required autofocus>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <h4><div id="alert-header"> <i class="icon fa fa-check"></i>SCAN PART</div></h4>
                <div id="alert-body" style="font-size : 51px; text-align: center; ">{{ session('message')['text'] ? session('message')['text'] : ' ' }}</div>
            </div>

        </div>

        <div class="col-md-2">
            <!-- counter -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">TOTAL SCAN</div>
                <div class="panel-body" style="height:110px;">
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=60>
                                        <font size=35><div id="counter">0</div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end counter -->
            <!-- x_panel -->
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">KANBAN SCANNED</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=180 style="vertical-align: middle">
                                    <font size=5><div id="part-internal"></div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">CODE SCANNED</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=60><font size=5><div id="code1"></div></font></td>
                                </tr>
                                <tr>
                                    <td align="center" height=60><font size=5><div id="code2"></div></font></td>
                                </tr>
                                <tr>
                                    <td align="center" height=60><font size=5><div id="code3"></div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables2.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="{{ asset('/js/jquery-cookie.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', function() {
            $('#detail_no').focus();
        });

        if (localStorage.getItem('avi_torimetron_fg') != null) {
            $('#part-internal').text(localStorage.getItem('avi_torimetron_fg').substring(41,53).concat(' (',localStorage.getItem('avi_torimetron_fg').substring(100,104),')'));
        }
        $('#code1').text(localStorage.getItem('avi_torimetron_code1'));
        $('#code2').text(localStorage.getItem('avi_torimetron_code2'));
        $('#code3').text(localStorage.getItem('avi_torimetron_code3'));
        if (localStorage.getItem('avi_torimetron') != null) {
            $('#ng-banner').show();
        }

        $('#detail_no').prop('readonly', true);
        document.body.style.backgroundColor = '#dddddd';
        let barcode   = "";
        let rep2      = "";
        let detail_no = $('#detail_no');

        $('#detail_no').keypress( function(e) {
            e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            if(code==13) {
                barcodecomplete = barcode;
                barcode = "";
                $('#detail_no').val('');
                if (barcodecomplete.length == 15) {
                    if (checkDataLocal(barcodecomplete) == true ){
                        checkDataAjax(barcodecomplete, 'code');
                    }else{
                        notifMessege("error", barcodecomplete+" Already Exist");
                    }
                } else if(barcodecomplete.length > 25) {
                    checkDataAjax(barcodecomplete, 'kbnfg');
                } else if (barcodecomplete.length == 13) {
                    window.location.replace("{{url('/trace/logout')}}");
                } else if (barcodecomplete == "RELOAD") {
                    location.reload();
                } else if(barcodecomplete == "NG"){
                    if (localStorage.getItem('avi_torimetron') == null || localStorage.getItem('avi_torimetron') == undefined) {
                        modeNG("on");
                    } else {
                        modeNG("off");
                    }
                } else {
                    notifMessege("error", "Please Rescan");
                    $('#detail_no').prop('readonly', true);
                }
            } else {
                barcode=barcode+String.fromCharCode(e.which);
            }
        });

    });

    function checkDataLocal(barcodecomplete) {
        let partCode1 = localStorage.getItem('avi_torimetron_code1');
        let partCode2 = localStorage.getItem('avi_torimetron_code2');
        let partCode3 = localStorage.getItem('avi_torimetron_code3');
        if (barcodecomplete == partCode1 || barcodecomplete == partCode2 || barcodecomplete == partCode3) {
            return false;
        } else {
            return true;
        }
    }

    function checkDataAjax(barcodecomplete, type) {
        if (localStorage.getItem('avi_torimetron') == null || localStorage.getItem('avi_torimetron') == undefined) {
            ng = 0;
        } else {
            ng = 1;
        }
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/torimetron/check-code') }}",
            data: {
                type : type,
                code : barcodecomplete,
                isNg : ng
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == "false") {
                    notifMessege("error", data.codesubstr+" Already Exist");
                } else if(data.code == "unregistered") {
                    notifMessege("error", data.codesubstr+" Unregistered");
                } else if(data.code == "ng") {
                    notifMessege("success", data.codesubstr+" is NG");
                } else if (data.code == "ngnotfound") {
                    notifMessege("error", data.codesubstr+" Not Found");
                } else {
                    saveDataLocalStorage(data.type, data.code);
                    notifMessege("success", data.codesubstr);
                }
            },
            error: function (xhr) {

            }
        });
    };

    function saveDataLocalStorage(type, code) {
        let kanbanInt = localStorage.getItem('avi_torimetron_fg');
        let partCode1 = localStorage.getItem('avi_torimetron_code1');
        let partCode2 = localStorage.getItem('avi_torimetron_code2');
        let partCode3 = localStorage.getItem('avi_torimetron_code3');
        if (type == 'kbnfg') {
            localStorage.setItem('avi_torimetron_fg', code);
            $('#part-internal').text(code.substring(41,53).concat(' (',code.substring(100,104),')'));
        } else if (type == 'code') {
            if (partCode1 == null || partCode1 == undefined) {
                localStorage.setItem('avi_torimetron_code1', code);
                $('#code1').text(code);
            } else if (partCode2 == null || partCode2 == undefined) {
                localStorage.setItem('avi_torimetron_code2', code);
                $('#code2').text(code);
            } else if (partCode3 == null || partCode3 == undefined) {
                localStorage.setItem('avi_torimetron_code3', code);
                $('#code3').text(code);
            }
        }
        if (localStorage.getItem('avi_torimetron_fg') !== null && localStorage.getItem('avi_torimetron_code1') !== null && localStorage.getItem('avi_torimetron_code2') !== null && localStorage.getItem('avi_torimetron_code3') !== null ) {
            sendDataAjax();
            clearLocalStorage();
        }
    }

    function clearLocalStorage() {
        localStorage.removeItem('avi_torimetron_fg');
        $('#part-internal').text('');
        localStorage.removeItem('avi_torimetron_code1');
        $('#code1').text('');
        localStorage.removeItem('avi_torimetron_code2');
        $('#code2').text('');
        localStorage.removeItem('avi_torimetron_code3');
        $('#code3').text('');
    }

    function sendDataAjax() {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/torimetron/input-code') }}",
            data: {
                kbn_fg : localStorage.getItem('avi_torimetron_fg').substring(123,127),
                code : [
                    localStorage.getItem('avi_torimetron_code1'),
                    localStorage.getItem('avi_torimetron_code2'),
                    localStorage.getItem('avi_torimetron_code3')
                ]
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.status);
                notifMessege("success", "Data Saved");
            },
            error: function (xhr) {

            }

        });
    }

    function notifMessege(type, messege) {
        if (type == "error") {
            $('#alert').removeClass('alert-success');
            $('#alert').addClass('alert-danger');
            $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'ERROR');
            $('#alert-body').text(messege);
        } else if (type == "success") {
            $('#alert').removeClass('alert-danger');
            $('#alert').addClass('alert-success');
            $('#alert-header').html('<i class="icon fa fa-success"></i>'+'SUCCESS');
            $('#alert-body').text(messege);
        }
    }

    function modeNG(status) {
        if (status == "on") {
            localStorage.setItem('avi_torimetron', "1");
            $('#ng-banner').show();
            notifMessege("success", "Ready to Scan NG Part");
        } else if (status == "off") {
            localStorage.removeItem('avi_torimetron');
            $('#ng-banner').hide();
            notifMessege("success", "Ready to Scan OK Part");
        }
    }

</script>

@endsection
