@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div id="line" class="panel panel-default" >
                
                <span style="font-size : 50px "> <center> INPUT NG PART DELIVERY </center> </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
            </div>
        </div>

        <div class="col-md-2">
            <!-- counter -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">TOTAL INPUT</div>
                <div class="panel-body" style="height:85px;">       
                    <div class="form-group">
                        <table id="data_table" style="height:100%; width: 100%" border="1">
                            <tbody>
                                <tr>
                                    <td align="center"> 
                                        <font size=6><div id="counter" align="center">0</div></font>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end counter -->
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

    <div class="row">

        
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">ID PART</div>
                    <div class="panel-body">       
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <input height=60 id="detail_no" class="form-control" name="detail_no" required >
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>       

    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">LAST INPUT</div>
                <div class="panel-body">       
                    <div class="form-group">
                        <table id="data" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr> 
                                    <th>CODE</th> <th>NPK</th> <th>DATE</th>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
    // {{-- dev-1.0.0, Handika, 20180703, datatable filter --}}
    var table = $('#data').DataTable({
        "dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        processing: true,
        serverSide: true,
        searching: true,
        paging: false,
        ajax: '{{ url ("trace/delivery/ng/index") }}',
        columns: [
            
            {data: 'code', name: 'code'},
            {data: 'npk_ng', name: 'npk_ng', searchable:false},
            {data: 'date_ng', name: 'date_ng', searchable:false},
        ],

    });

  var barcode   ="";
  var rep2      = "";
  var detail_no = $('#detail_no');
  
  $(document).keypress(function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            barcodecomplete = barcode;
            barcode = "";
            $('#detail_no').val('');
            if (barcodecomplete.length < 15 ){
                alert('Id produk yang anda masukan hanya '+barcodecomplete.length+' karakter, Id produk harus 15 karakter');
                $('#detail_no').val(rep2);
            }else if ( barcodecomplete.length > 15 ) {
                alert('Id produk yang anda masukan sebanyak '+barcodecomplete.length+' karakter, Id produk hanya boleh 15 karakter saja');
                $('#detail_no').val(rep2);
            }else if (barcodecomplete.length == 15) {
                $.ajax({
                        type: 'get',           // {{-- POST Request --}}
                        url: "{{ url('/trace/scan/delivery/getAjaxng') }}"+'/'+barcodecomplete,  
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // {{-- Data Type of the Transmit --}}
                        success: function (data) {
                            code = data.code;                       
                            if(code == "" ){
                                $('#detail_no').prop('readonly', false);
                                $('#detail_no').val(barcode);

                                {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'GAGAL !!');
                                $('#alert-body').text('Data belum pernah discan pulling');

                            }
                            else{
                                $('#alert').removeClass('alert-danger');
                                $('#alert').addClass('alert-success');
                                $('#alert-header').html('<i class="icon fa fa-check"></i>'+'BERHASIL !!');
                                $('#alert-body').text(barcodecomplete+" Selesai terinput");

                                // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                                $('#counter').text(data.counter);

                                $('[id^=last_scan]').html('&nbsp;');
                                table.ajax.url("{{ url ('trace/delivery/ng/update')}}").load();
                            }
                        },
                        error: function (xhr) {

                                // {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                                $('#alert').removeClass('alert-success');
                                $('#alert').addClass('alert-danger');
                                $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'@lang("avicenna/pis.error_scan")'+xhr.status+" - "+xhr.statusText);
                                $('#alert-body').text('@lang("avicenna/pis.part_not_found")');
                        }
                                          
                    });
            }else{
                $('#alert').removeClass('alert-success');
                $('#alert').addClass('alert-danger');
                $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'GAGAL !!');
                $('#alert-body').text('Mohon Scan Ulang');

            }
               
                
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }    
    });

    $(document).ready(function() {
        document.body.style.backgroundColor = '#dddddd';
            // {{-- dev-1.0.0, Handika, 20180703, datatable filter --}}

        
    } );

</script>

@endsection
