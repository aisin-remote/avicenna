@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="line" class="panel panel-default">

                    <span style="font-size : 50px ">
                        <center> LINE ASSEMBLING <span id="line-display"></span> </center>
                    </span>
                    <span style="font-size : 30px ">
                        <center> PT AISIN INDONESIA AUTOMOTIVE </center>
                    </span>
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
                                        <input height=60 id="detail_no" class="form-control" name="input" required>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="alert"
                    class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                    <h4>
                        <div id="alert-header"> <i class="icon fa fa-check"></i>SCAN PART</div>
                    </h4>
                    <div id="alert-body" style="font-size : 51px; text-align: center; ">
                        {{ session('message')['text'] ? session('message')['text'] : ' ' }}</div>
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
                                            <font size=35>
                                                <div id="counter">0</div>
                                            </font>
                                        </td>
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
                                        <td align="center" height=180 style="vertical-align: middle">
                                            <font size=5>
                                                <div id="nopart"></div>
                                            </font>
                                        </td>
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
                                            <font size=5>
                                                <div id="kanban_int"></div>
                                            </font>
                                        </td>
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
        // var tablekbn = $('#kanban_int').DataTable({
        //     "dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        //     processing: true,
        //     serverSide: true,
        //     searching: false,
        //     paging: false,
        //     ajax: '{{ url('/trace/machining/indexfgkbn') }}',
        //     columns: [

        //         {data: 'kbn_int', name: 'kbn_int'},

        //     ],

        // });

        // var tablecode = $('#nopart').DataTable({
        //     "dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        //     processing: true,
        //     serverSide: true,
        //     searching: false,
        //     paging: false,
        //     ajax: '{{ url('/trace/machining/indexfgcode') }}',
        //     columns: [

        //         {data: 'code', name: 'code'},

        //     ],

        // });

        let line = '';

        function initApp() {
            let line_number = localStorage.getItem('avi_line_number');
            // let strainer_id = localStorage.getItem('strainer_id');
            if (line_number == null || line_number == undefined) {
                $('#modalLineScan').on('shown.bs.modal', function() {
                    $('#input-line').focus();
                })
                $('#modalLineScan').modal('show');

            } else {

                $('#line-display').text(line_number);
                line = line_number;
                $('#detail_no').focus();
            }
        }


        function checkDataLocal(barcodecomplete) {
            let partCode = localStorage.getItem('avi_assembling_nopart');

            if (code == "code") {
                if (barcodecomplete == partCode) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        function saveDataLocal(code) {
            let partCode = localStorage.getItem('avi_assembling_nopart');

            if (code == 'code') {
                localStorage.setItem('avi_assembling_nopart', code);
                $('#nopart').text(code);
                notifMessege("success", code);
            } else {
                notifMessege("error", "Parts is Complete, Scan Kanban!");
            }
            if (localStorage.setItem('avi_assembling_nopart') != null) {
                if (sendDataAjax()) {
                    clearLocalStorage();
                } else {
                    clearLocalStorage();

                }
            }
        }

        function clearLocalStorage() {

            localStorage.removeItem('avi_assembling_nopart');
            $('#nopart').text('');

        }

        function notifMessege(type, messege) {
            if (type == "error") {
                $('#alert').removeClass('alert-success');
                $('#alert').addClass('alert-danger');
                $('#alert-header').html('<i class="icon fa fa-warning"></i>' + 'ERROR');
                $('#alert-body').text(messege);
            } else if (type == "success") {
                $('#alert').removeClass('alert-danger');
                $('#alert').addClass('alert-success');
                $('#alert-header').html('<i class="icon fa fa-success"></i>' + 'SUCCESS');
                $('#alert-body').text(messege);
            }
        }
        var barcode = "";
        var rep2 = "";
        var detail_no = $('#detail_no');

        $(document).ready(function() {
            initApp();
            $(document).on('click', function() {
                $('#detail_no').focus();
            });
            $('#input-line').keypress(function(e) {
                let code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    if ($(this).val().length == 5) {
                        localStorage.setItem('avi_line_number', $(this).val());
                        initApp();
                        $('#modalLineScan').modal('hide');
                        $('#detail_no').focus();
                    } else {
                        $('#input-line').val('');
                        $('#modalLineScan').modal('hide');

                        setTimeout(() => {
                            $('#modalLineScan').modal('show');
                        }, 1000);
                    }
                }
            });

            $('#nopart').text(localStorage.getItem('avi_assembling_nopart'));

            $('#detail_no').prop('readonly', true);

            document.body.style.backgroundColor = '#dddddd';

            $("#detail_no").keypress(function(e) {
                e.preventDefault();
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) // Enter key hit
                {

                    barcodecomplete = barcode;
                    barcode = "";
                    console.log(barcodecomplete.length);
                    $('#detail_no').val('');
                    if (barcodecomplete.length == 15) {
                        // let strainer_id = localStorage.getItem('strainer_id');
                        $.ajax({
                            type: 'get', // {{-- POST Request --}}
                            url: "{{ url('/trace/assembling/cek-part') }}",
                            data: {
                                code: barcodecomplete,
                            },
                            _token: "{{ csrf_token() }}",
                            dataType: 'json', // {{-- Data Type of the Transmit --}}
                            success: function(data) {
                                code = data.code;
                                if (code == "") {
                                    $('#detail_no').prop('readonly', false);
                                    $('#detail_no').val(barcode);
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').addClass('alert-danger');
                                    $('#alert-header').html(
                                        '<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                                    $('#alert-body').text('Data sudah ada');
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();

                                } else {

                                    $('#alert').removeClass('alert-danger');
                                    $('#alert').addClass('alert-success');
                                    $('#alert-header').html('<i class="icon fa fa-check"></i>' +
                                        'BERHASIL !!');
                                    $('#alert-body').text(barcodecomplete);
                                    $('#detail_no').val(rep2);
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();
                                    localStorage.setItem('avi_assembling_nopart', data.code);
                                    $('#nopart').text(localStorage.getItem(
                                        'avi_assembling_nopart'));
                                    $('#kanban_int').text("");
                                }

                                // if (data.model_strainer == 0) {
                                //     $('#strainer').attr('hidden', 'true');
                                // } else {
                                //     $('#strainer').removeAttr('hidden');
                                // }
                            },
                            error: function(xhr) {
                                // if (xhr.status) {
                                //     location.reload();
                                // }

                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-header').html('<i class="icon fa fa-warning"></i>' +
                                    '@lang('avicenna/pis.error_scan')' + xhr.status + " - " + xhr
                                    .statusText);

                                if (xhr.status == 0) {
                                    $('#alert-body').text('@lang('avicenna/pis.connection_error')');
                                    return;
                                }

                                $('#alert-body').text('@lang('avicenna/pis.fatal_error')');
                            }
                        });

                    } else if (barcodecomplete.length == 230) {
                        // let strainer_id = localStorage.getItem('strainer_id');
                        $.ajax({
                            type: 'get', // {{-- POST Request --}}
                            url: "{{ url('/trace/scan/assembling/AjaxFG') }}",
                            data: {
                                code: localStorage.getItem('avi_assembling_nopart'),
                                line: localStorage.getItem('avi_line_number'),
                                // strainer : localStorage.getItem('strainer_id'),
                                kbn_int: barcodecomplete,

                            },
                            _token: "{{ csrf_token() }}",
                            dataType: 'json', // {{-- Data Type of the Transmit --}}
                            success: function(data) {
                                code = data.code;
                                if (code == "") {
                                    $('#detail_no').prop('readonly', false);
                                    $('#detail_no').val(barcode);
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').addClass('alert-danger');
                                    $('#alert-header').html(
                                        '<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                                    $('#alert-body').text('Data sudah ada');
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();

                                } else if (code == "notmatch") {

                                    $('#detail_no').prop('readonly', false);
                                    $('#detail_no').val(barcode);
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').addClass('alert-danger');
                                    $('#alert-header').html(
                                        '<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                                    $('#alert-body').text('Part dan Kanban Tidak Cocok');
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();

                                } else if (code == "notregistered") {

                                    $('#detail_no').prop('readonly', false);
                                    $('#detail_no').val(barcode);
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').addClass('alert-danger');
                                    $('#alert-header').html(
                                        '<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                                    $('#alert-body').text('Kanban Tidak Terdaftar');
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();

                                } else if (code == "Kanbannotreset") {

                                    $('#detail_no').prop('readonly', false);
                                    $('#detail_no').val(barcode);
                                    $('#alert').removeClass('alert-success');
                                    $('#alert').addClass('alert-danger');
                                    $('#alert-header').html(
                                        '<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                                    $('#alert-body').text('Kanban masih berisi Part');
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();

                                } else {

                                    $('#alert').removeClass('alert-danger');
                                    $('#alert').addClass('alert-success');
                                    $('#alert-header').html('<i class="icon fa fa-check"></i>' +
                                        'BERHASIL !!');
                                    $('#alert-body').text(data.kbn_int);
                                    $('#detail_no').val(rep2);
                                    $('#detail_no').prop('readonly', true);
                                    $('#detail_no').focus();
                                    localStorage.getItem('avi_assembling_nopart', data.code);
                                    $('#kanban_int').text(data.kbn_int);
                                    $('#counter').text(data.counter);


                                }

                                // if (data.model_strainer == 0) {
                                //     $('#strainer').attr('hidden', 'true');
                                // } else {
                                //     $('#strainer').removeAttr('hidden');
                                // }
                            },
                            error: function(xhr) {
                                // if (xhr.status) {
                                //     location.reload();
                                // }

                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-header').html('<i class="icon fa fa-warning"></i>' +
                                    '@lang('avicenna/pis.error_scan')' + xhr.status + " - " + xhr
                                    .statusText);

                                if (xhr.status == 0) {
                                    $('#alert-body').text('@lang('avicenna/pis.connection_error')');
                                    return;
                                }

                                $('#alert-body').text('@lang('avicenna/pis.fatal_error')');
                            }
                        });

                    } else if (barcodecomplete.length == 13) {
                        window.location.replace("{{ url('/trace/logout') }}");

                    } else if (barcodecomplete == "DOUBLE") {
                        window.location.replace("{{ url('/trace/scan/assembling/fg-double') }}");

                    } else if (barcodecomplete.length <= 2) {
                        window.location.replace("{{ url('/trace/scan/assembling/fg-assembling-ng2/') }}" +
                            "/" + barcodecomplete);
                    } else if (barcodecomplete == "NGMODE") {
                        window.location.replace("{{ url('/trace/scan/assembling/fg-assembling-ng') }}");

                    } else if (barcodecomplete == "TMMIN") {
                        window.location.replace("{{ url('/trace/scan/assembling/fg-assembling-tmmin') }}");

                    } else if (barcodecomplete == "ADM") {
                        console.log('tetap');

                    } else if (barcodecomplete == "RELOAD") {
                        location.reload();

                    } else if (barcodecomplete == "RESET") {
                        localStorage.clear();
                        location.reload();
                    } else {
                        $('#alert').removeClass('alert-success');
                        $('#alert').addClass('alert-danger');
                        $('#alert-header').html('<i class="icon fa fa-warning"></i>' + 'GAGAL !!');
                        $('#alert-body').text('Mohon Scan Ulang');
                        $('#detail_no').prop('readonly', true);
                    }


                } else {
                    barcode = barcode + String.fromCharCode(e.which);
                }
            });



        });
    </script>
@endsection
