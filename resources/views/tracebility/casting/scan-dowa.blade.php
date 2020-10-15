@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="line" class="panel panel-default" >
                <span style="font-size : 50px "> <center> LINE CASTING DOWA <span id="line-display"></span> </center> </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
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


<div id="modalLineScan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><strong>Scan Barcode Line</strong></h4>
            </div>
            <div class="modal-body">
                <h3 class="text-warning text-center"><b>Tolong Scan Barcode Line Untuk Melanjutkan</b></h3>
                <br>
                <input type="text" class="form-control" id="input-line">
                <br>
            </div>
            <div class="modal-footer">
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

    let line = '';

    function initApp() {
        let line_number = localStorage.getItem('avi_line_number');
        if (line_number == null || line_number == undefined) {
            $('#modalLineScan').on('shown.bs.modal', function () {
                $('#input-line').focus();
            })
            $('#modalLineScan').modal('show');
        } else {
            $('#line-display').text(line_number);
            line = line_number;
            $('#detail_no').focus();
        }

        if (localStorage.getItem('avi_casting_kanban_int') !== null && localStorage.getItem('avi_casting_code1') !== null && localStorage.getItem('avi_casting_code2') !== null && localStorage.getItem('avi_casting_code3') !== null ) {
            sendDataAjax();
        }
    }

    $(document).ready(function() {
        var dowaParts = "{!! config('traceability.dowa_part_code') !!}".split(',');
        initApp();

        $(document).on('click', function() {
            $('#detail_no').focus();
        });

        $('#input-line').keypress(function(e) {
            let code = (e.keyCode ? e.keyCode : e.which);
            if(code==13) {
                localStorage.setItem('avi_line_number', $(this).val());
                initApp();
                $('#modalLineScan').modal('hide');
                $('#detail_no').focus();
            }
        });

        if (localStorage.getItem('avi_casting_kanban_int') != null) {
            $('#part-internal').text(localStorage.getItem('avi_casting_kanban_int').substring(41,53).concat(' (',localStorage.getItem('avi_casting_kanban_int').substring(100,104),')'));
        }

        $('#code1').text(localStorage.getItem('avi_casting_code1'));
        $('#code2').text(localStorage.getItem('avi_casting_code2'));
        $('#code3').text(localStorage.getItem('avi_casting_code3'));

        $('#detail_no').prop('readonly', true);
        document.body.style.backgroundColor = '#dddddd';
        // end of dev-1.1.0 : 20190801 Handika , Optimasi line,
        let barcode   = "";
        let rep2      = "";
        let detail_no = $('#detail_no');

        $('#detail_no').keypress( function(e) {
            e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            // key enter
            if(code==13) {
                barcodecomplete = barcode;
                barcode = "";
                // end of isi dengan line
                $('#detail_no').val('');
                if (barcodecomplete == "DOWA") {
                    window.location.replace("{{url('/trace/scan/casting')}}");
                    return;
                }
                if (barcodecomplete.length == 15) {
                    var partType = barcodecomplete.substring(0,2);
                    if (!dowaParts.includes(partType)) {
                        notifMessege("error", "Is not a CSH D05");
                        return;
                    }

                    if (checkDataLocal(barcodecomplete, 'code') == true ){
                        checkDataAjax(barcodecomplete, 'code');
                    }else{
                        notifMessege("error", barcodecomplete+" Already Exist");
                    }
                } else if(barcodecomplete.length == 230) {
                    if (checkDataLocal(barcodecomplete, 'kbnint') == true ){
                        checkDataAjax(barcodecomplete, 'kbnint');
                    }else{
                        notifMessege("error", "Scan Part First");
                    }

                } else if (barcodecomplete.length == 13) {
                    window.location.replace("{{url('/trace/logout')}}");
                } else if (barcodecomplete == "RELOAD") {
                    location.reload();
                } else {
                    notifMessege("error", "Please Rescan");
                    $('#detail_no').prop('readonly', true);
                }
            } else {
                barcode=barcode+String.fromCharCode(e.which);
            }
        });

    });

    function checkDataLocal(barcodecomplete, type) {
        let partCode1 = localStorage.getItem('avi_casting_code1');
        let partCode2 = localStorage.getItem('avi_casting_code2');
        let partCode3 = localStorage.getItem('avi_casting_code3');
        if (type == "code") {
            if (barcodecomplete == partCode1 || barcodecomplete == partCode2 || barcodecomplete == partCode3) {
                return false;
            } else {
                return true;
            }
        } else if (type == "kbnint") {
            if (!partCode1 || !partCode2 || !partCode3) {
                return false;
            } else {
                return true;
            }
        }

    }

    function checkDataAjax(barcodecomplete, type) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/dowa/check-code') }}",
            data: {
                type : type,
                code : barcodecomplete,
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == "false") {
                    notifMessege("error", data.codesubstr+" Already Exist");
                } else if(data.code == "unregistered") {
                    notifMessege("error", data.codesubstr+" Unregistered");
                } else {
                    saveDataLocalStorage(data.type, data.code);
                }
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    notifMessege("error", '@lang("avicenna/pis.connection_error")');
                    return;
                }
                notifMessege("error", '@lang("avicenna/pis.fatal_error")');
            }
        });
    };

    function saveDataLocalStorage(type, code) {
        let kanbanInt = localStorage.getItem('avi_casting_kanban_int');
        let partCode1 = localStorage.getItem('avi_casting_code1');
        let partCode2 = localStorage.getItem('avi_casting_code2');
        let partCode3 = localStorage.getItem('avi_casting_code3');
        if (type == 'kbnint') {
            localStorage.setItem('avi_casting_kanban_int', code);
            $('#part-internal').text(code.substring(41,53).concat(' (',code.substring(100,104),')'));
            notifMessege("success", code.substring(100,104));
        } else if (type == 'code') {
            if (partCode1 == null || partCode1 == undefined) {
                localStorage.setItem('avi_casting_code1', code);
                $('#code1').text(code);
                notifMessege("success", code);
            } else if (partCode2 == null || partCode2 == undefined) {
                localStorage.setItem('avi_casting_code2', code);
                $('#code2').text(code);
                notifMessege("success", code);
            } else if (partCode3 == null || partCode3 == undefined) {
                localStorage.setItem('avi_casting_code3', code);
                $('#code3').text(code);
                notifMessege("success", code);
            } else {
                notifMessege("error", "Parts is Complete, Scan Kanban!");
            }
        }
        if (localStorage.getItem('avi_casting_kanban_int') !== null && localStorage.getItem('avi_casting_code1') !== null && localStorage.getItem('avi_casting_code2') !== null && localStorage.getItem('avi_casting_code3') !== null ) {
            sendDataAjax();
        }
    }

    function clearLocalStorage() {
        localStorage.removeItem('avi_casting_kanban_int');
        $('#part-internal').text('');
        localStorage.removeItem('avi_casting_code1');
        $('#code1').text('');
        localStorage.removeItem('avi_casting_code2');
        $('#code2').text('');
        localStorage.removeItem('avi_casting_code3');
        $('#code3').text('');
    }

    function sendDataAjax() {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/dowa/input-code') }}",
            data: {
                kbn_int : localStorage.getItem('avi_casting_kanban_int').substring(123,127),
                line : localStorage.getItem('avi_line_number'),
                code : [
                    localStorage.getItem('avi_casting_code1'),
                    localStorage.getItem('avi_casting_code2'),
                    localStorage.getItem('avi_casting_code3')
                ]
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == "success") {
                    notifMessege("success", "Data Saved");
                    $('#counter').text(data.counter);
                    clearLocalStorage();
                } else if (data.status == "error") {
                    notifMessege("error", data.messege);
                } else if (data.status == "false") {
                    notifMessege("error", "Scan kanban lain");
                }
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    notifMessege("error", '@lang("avicenna/pis.connection_error")');
                    return;
                }
                notifMessege("error", '@lang("avicenna/pis.fatal_error")');
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
</script>

@endsection
