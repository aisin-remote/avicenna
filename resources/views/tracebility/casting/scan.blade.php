@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="line" class="panel panel-default">
                    <span style="font-size : 50px ">
                        <center> LINE CASTING <span id="line-display"></span> </center>
                    </span>
                    <span style="font-size : 30px ">
                        <center> PT AISIN INDONESIA AUTOMOTIVE </center>
                    </span>
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
                                        <input height=60 id="detail_no" class="form-control" name="detail_no" required
                                            autofocus>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="alert"
                    class="alert alert-{{ isset(session('message')['type']) ? session('message')['type'] : 'success' }}">
                    <h4>
                        <div id="alert-header"> <i class="icon fa fa-check"></i>SCAN PART</div>
                    </h4>
                    <div id="alert-body" style="font-size : 51px; text-align: center; ">
                        {{ isset(session('message')['text']) ? session('message')['text'] : ' ' }}</div>
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
            <div class="col-md-12">
                <!-- last scan -->
                <div class="panel panel-default" id="table_hide">
                    <div class="panel-heading">LAST SCAN</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <table id="data" class="table table-bordered responsive-utilities jambo_table">
                                <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>PRODUCT</th>
                                        <th>MODEL</th>
                                        <th>NPK</th>
                                        <th>DATE</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end last scan -->
            </div>


        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <button class="text-center" style="width: 100%"
                    onclick="window.location.replace(`{{ url('/trace/scan/casting/ng2') }}`)">MODE NG</button>
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



        let table = $('#data').DataTable({
            "dom": ' <"search"f><"top"l>rt<"bottom"ip><"clear">',
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            ajax: '{{ url('trace/casting/index') }}',
            columns: [{
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'model',
                    name: 'model'
                },
                {
                    data: 'npk',
                    name: 'npk',
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date',
                    searchable: false
                },
            ],

        });
        $(document).ready(function() {
            initApp();

            $(document).on('click', function() {
                $('#detail_no').focus();
            });

            $('#input-line').keypress(function(e) {
                let code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    if ($(this).val().length == 6) {
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
            })

            $('#detail_no').prop('readonly', true);
            document.body.style.backgroundColor = '#dddddd';
            // end of dev-1.1.0 : 20190801 Handika , Optimasi line,
            let barcode = "";
            let rep2 = "";
            let detail_no = $('#detail_no');

            $('#detail_no').keypress(function(e) {
                e.preventDefault();
                let code = (e.keyCode ? e.keyCode : e.which);
                // key enter
                if (code == 13) {
                    barcodecomplete = barcode;
                    barcode = "";
                    // end of isi dengan line

                    $('#detail_no').val('');
                    if (barcodecomplete == "DOWA") {
                        window.location.replace("{{ url('/trace/scan/casting/dowa') }}");
                        return;
                    }
                    if (barcodecomplete == "NGMODE") {
                        window.location.replace("{{ url('/trace/scan/casting/ng') }}");
                        return;
                    }
                    // update part csh d983 by Fabian 
                    if (barcodecomplete == "D98E") {
                        window.location.replace("{{ url('/trace/scan/casting/d98e') }}");
                        return;
                    }
                    if (barcodecomplete.length == 15) {
                        $.ajax({
                            type: 'get', // {{-- POST Request --}}
                            url: "{{ url('/trace/scan/casting/getAjax') }}" + '/' +
                                barcodecomplete + '/' + line,
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

                                } else {
                                    table.ajax.url("{{ url('trace/casting/update') }}")
                                        .load();
                                    $('#alert').removeClass('alert-danger');
                                    $('#alert').addClass('alert-success');
                                    $('#alert-header').html('<i class="icon fa fa-check"></i>' +
                                        'BERHASIL !!');
                                    $('#alert-body').text(barcodecomplete);
                                    $('#detail_no').val(rep2);
                                    $('#detail_no').prop('readonly', true);
                                    // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                                    $('#counter').text(data.counter);
                                }

                                $('#detail_no').focus();
                            },
                            error: function(xhr) {
                                if (xhr.status) {
                                    // location.reload();
                                }

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
