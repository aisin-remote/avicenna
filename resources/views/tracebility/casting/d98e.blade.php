@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="line" class="panel panel-default" >

                <span style="font-size : 50px "> <center> LINE CASTING D98E <span id="line-display"></span> </center> </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
            </div>
        </div>


    </div>

    <!-- <div class="row" id="strainer" hidden>
        <div class="col-md-12">
            <div id="strainer-banner" class="panel panel-default" >
                <span style="font-size : 30px; " ><center> <span id="strainer-text"></span> </center>  </span>
            </div>
        </div>
    </div> -->

    <div class="row">


        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">SCAN HERE</div>
                    <div class="panel-body" style="height:110px;">
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                    <input height=60 id="detail_no" class="form-control" name="input" required >
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
                <div class="panel-heading">PART SCANNED</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=90 style="vertical-align: middle">
                                    <font size=5><div id="code1"></div></font>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" height=90  style="vertical-align: middle"><font size=5><div id="code2"></div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">KANBAN SCANNED</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=180 style="vertical-align: middle">
                                    <font size=5><div id="kanban_int"></div></font></td>
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
<script type="text/javascript">

    let line = '';

    function initApp() {
        let line_number = localStorage.getItem('avi_line_number');
        let partCode1 = localStorage.getItem('avi_casting_d98e_code1');
        let partCode2 = localStorage.getItem('avi_casting_d98e_code2');
        $('#code1').text(partCode1);
        $('#code2').text(partCode2);
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
    }

    var barcode   = "";
    var rep2      = "";
    var detail_no = $('#detail_no');

    $(document).ready(function() {
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

        $('#detail_no').prop('readonly', true);

        document.body.style.backgroundColor = '#dddddd';

        $("#detail_no").keypress(function(e) {
            e.preventDefault();
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13)// Enter key hit
            {

                barcodecomplete = barcode;
                barcode = "";

                if (barcodecomplete.length == 15) {
                    // done check
                    checkDataAjax(barcodecomplete);
                    return;
                } else if(barcodecomplete.length == 230) {
                    // done check
                    if (checkDataLocalCode() == true ){
                        sendDataAjax(barcodecomplete);
                        return;
                    }else{
                        notifMessege("error", "Scan Part First");
                    }

                }

                if (barcodecomplete.length == 13)
                {
                    window.location.replace("{{url('/trace/logout')}}");

                }
                if (barcodecomplete == "D98E"){
                    window.location.replace("{{url('/trace/scan/casting')}}");
                    return;
                }
                if (barcodecomplete == "DOWA") {
                    window.location.replace("{{url('/trace/scan/casting/dowa')}}");
                    return;
                }
                if (barcodecomplete == "NGMODE")
                {
                    window.location.replace("{{url('/trace/scan/casting/ng')}}");
                    return;
                }
                if (barcodecomplete == "RELOAD")
                {
                    location.reload();
                }
                else
                {
                    $('#alert').removeClass('alert-success');
                    $('#alert').addClass('alert-danger');
                    $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'GAGAL !!');
                    $('#alert-body').text('Mohon Scan Ulang');
                    $('#detail_no').prop('readonly', true);
                }
            }
            else
            {
                barcode=barcode+String.fromCharCode(e.which);
            }
        });
    } );

    function checkDataAjax(barcodecomplete) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/cek-part-d98e') }}",
            data: {
                code : barcodecomplete,
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == "false") {
                    notifMessege("error", barcodecomplete + " Sudah ada");
                } else {
                    let partCode1 = localStorage.getItem('avi_casting_d98e_code1');
                    if (partCode1 == barcodecomplete) {
                        notifMessege("error", "Part sudah discan sebelumnya");
                    } else {
                        saveDataLocalStorage(data.code);
                    }


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

    function saveDataLocalStorage(code) {
        let partCode1 = localStorage.getItem('avi_casting_d98e_code1');
        let partCode2 = localStorage.getItem('avi_casting_d98e_code2');

        if (partCode1 == null || partCode1 == undefined) {
            localStorage.setItem('avi_casting_d98e_code1', code);
            $('#code1').text(code);
            notifMessege("success", code);
        } else if (partCode2 == null || partCode2 == undefined) {
            localStorage.setItem('avi_casting_d98e_code2', code);
            $('#code2').text(code);
            notifMessege("success", code);
        } else {
            notifMessege("error", "Parts is Complete, Scan Kanban!");
        }

    }

    function clearLocalStorage() {
        localStorage.removeItem('avi_casting_d98e_code1');
        $('#code1').text('');
        localStorage.removeItem('avi_casting_d98e_code2');
        $('#code2').text('');
    }

    function checkDataLocalCode() {
        let partCode1 = localStorage.getItem('avi_casting_d98e_code1');
        let partCode2 = localStorage.getItem('avi_casting_d98e_code2');

        if (partCode1 == null || partCode1 == undefined) {
            return false
        } else if (partCode2 == null || partCode2 == undefined) {
            return false
        } else {
            return true;
        }
    }

    function sendDataAjax(kbn_int) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/ajaxCastingD98e') }}",
            data: {
                kbn_int : kbn_int,
                line : localStorage.getItem('avi_line_number'),
                code1 : localStorage.getItem('avi_casting_d98e_code1'),
                code2 : localStorage.getItem('avi_casting_d98e_code2')
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status == "success") {
                    notifMessege("success", "Data Saved");
                    $('#counter').text(data.counter);
                    clearLocalStorage()
                    return true
                } else if (data.code == "error") {
                    notifMessege("error", data.messege);
                    clearLocalStorage()
                    return false
                } else if (data.code == "Kanbannotreset") {
                    notifMessege("error", "Kanban masih berisi Part");
                    return false
                } else if (data.code == "notregistered") {
                    notifMessege("error", "Kanban Tidak Terdaftar");
                    return false
                } else if (data.code == "partdouble") {
                    notifMessege("error", "Part double, ulangi proses scan part");
                    clearLocalStorage()
                    return false
                } else if (data.code == "partExist") {
                    notifMessege("error", "Part sudah pernah di scan!");
                    clearLocalStorage()
                    return false
                } else if (data.code == "notmatch") {
                    notifMessege("error", "Part dan Kanban Tidak Cocok");
                    clearLocalStorage()
                    return false
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
