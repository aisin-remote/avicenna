@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="line" class="panel panel-default" >

                <span style="font-size : 50px "> <center> LINE ASSEMBLING <span id="line-display"></span> </center> </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
            </div>
        </div>


    </div>

    <div class="row" id="strainer" hidden>
        <div class="col-md-12">
            <div id="strainer-banner" class="panel panel-default" >
                <span style="font-size : 30px; " ><center> <span id="strainer-text"></span> </center>  </span>
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
                                    <input height=60 id="detail_no" class="form-control" name="detail_no" required >
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="col-md-8">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <h4><div id="alert-header"> <i class="icon fa fa-check"></i>SCAN KANBAN ATAU PART YANG NG</div></h4>
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
        <div class="col-md-12">
            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">LAST SCAN</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table  id="data" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr>
                                    <th>CODE</th> <th>PRODUCT</th> <th>MODEL</th> <th>NPK</th>  <th>DATE</th>
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
    // {{-- dev-1.1.0, Handika, 20180703, datatable filter --}}
    var table = $('#data').DataTable({
        "dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        ajax: '{{ url ("trace/assembling/fg-assembling-update") }}',
        columns: [

            {data: 'code', name: 'code'},
            {data: 'product', name: 'product'},
            {data: 'model', name: 'model'},
            {data: 'npk', name: 'npk', searchable:false},
            {data: 'date', name: 'date', searchable:false},
        ],

    });

    let line = '';

    function initApp() {
        let line_number = localStorage.getItem('avi_line_number');
        let strainer_id = localStorage.getItem('strainer_id');
        let isPart = 1;
        console.log(isPart);
        if (line_number == null || line_number == undefined) {
            $('#modalLineScan').on('shown.bs.modal', function () {
                $('#input-line').focus();
            })
            $('#modalLineScan').modal('show');

        } else {
            $('#line-display').text(line_number);
            line = line_number;
            //cek strainer
            $.ajax({
                type: 'get',           // {{-- POST Request --}}
                url: "{{ url('/trace/scan/assembling/check-fg') }}"+'/'+line,
                _token: "{{ csrf_token() }}",
                dataType: 'json',       // {{-- Data Type of the Transmit --}}
                success: function (data) {
                    console.log(data);
                    if (data.line != null) {
                        isPart = 0;
                    } 
                },
                error: function (xhr) {
                }
            });

            $('#detail_no').focus();
        }
    }


    function ajax(isPart, scan) {
        $.ajax({
            type: 'post',
            url: "{{ route('assembling-fg-ng-Ajax') }}",
            dataType: 'json',
              data: {
                _token: "{{ csrf_token() }}",
                isPart : isPart,
                scan : scan
              } ,
            success: function (data) {
              if (data.error == false ) {
                  $('#alert-header').html(data.messege);
                  table.ajax.url("{{ url ('trace/assembling/fg-assembling-update')}}").load();
                  $('#alert').removeClass('alert-danger');
                  $('#alert').addClass('alert-info');
                  $('#scan').val("");
                  $('#scan').focus();
                } else if (data.error == true) {
                  $('#alert-header').html(data.messege);
                  $('#alert').removeClass('alert-info');
                  $('#alert').addClass('alert-danger');
                  $('#scan').val("");
                  $('#scan').focus();
                }
            },

          });
    }

    var barcode   ="";
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
                $('#detail_no').val('');
                if (barcodecomplete.length == 15) {
                    ajax(1, barcodecomplete);
                    
                }if (barcodecomplete.length == 230) {
                    ajax(0, barcodecomplete);
                    
                }
                else if (barcodecomplete.length == 13)
                {
                        window.location.replace("{{url('/trace/logout')}}");

                }
                else if (barcodecomplete == "FGNG")
                {
                    window.location.replace("{{url('/trace/scan/assembling')}}");

                }
                else if (barcodecomplete == "RELOAD")
                {
                        location.reload();

                }


            }
            else
            {
                barcode=barcode+String.fromCharCode(e.which);
            }
        });



    } );

</script>

@endsection
