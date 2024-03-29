@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="line" class="panel panel-default" >
                
                <span style="font-size : 50px "> <center> LINE CASTING </center> </span>
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
        <div class="col-md-12">
            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">LAST SCAN</div>
                <div class="panel-body">       
                    <div class="form-group">
                        <table  class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr> 
                                    <th>CODE</th> <th>NPK</th> <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody id="data_table">
                                
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

<script type="text/javascript">
  
  var barcode   ="";
  var rep2      = "";
  var detail_no = $('#detail_no');
  
  $(document).keypress(function(e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)// Enter key hit
        {
            $('#detail_no').val('');
            $.ajax({
                    type: 'get',           // {{-- POST Request --}}
                    url: "{{ url('/trace/scan/casting/getAjax') }}"+'/'+barcode,  
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
                            $('#alert-body').text('Data sudah ada');
                            
                            $('#detail_no').prop('readonly', true);
                            barcode = "";
                            rep2    = "";

                        }
                        else{
                            $('#alert').removeClass('alert-danger');
                            $('#alert').addClass('alert-success');
                            $('#alert-header').html('<i class="icon fa fa-check"></i>'+'BERHASIL !!');
                            $('#alert-body').text(barcode);

                            $('#detail_no').val(rep2);
                            $('#detail_no').prop('readonly', true);

                            // {{-- dev-1.0, 20170913, Ferry, Fungsi informasi display --}}
                            $('#counter').text(data.counter);

                            $('[id^=last_scan]').html('&nbsp;');

                            barcode = "";
                            rep2    = "";



                        }
                    },
                    error: function (xhr) {

                            // {{-- dev-1.0, ferry, 20170913, alert jika error scan --}}
                            $('#alert').removeClass('alert-success');
                            $('#alert').addClass('alert-danger');
                            $('#alert-header').html('<i class="icon fa fa-warning"></i>'+'@lang("avicenna/pis.error_scan")'+xhr.status+" - "+xhr.statusText);
                            $('#alert-body').text('@lang("avicenna/pis.part_not_found")');
                            
                            barcode = "";
                            rep2    = "";
                    }
                                      
                });




             $.ajax({
                    type : "GET",
                    data : "",
                    url : "{{ url('/trace/scan/casting/getAjax2') }}", // Mengakses query pada tabel
                    success : function(result){  // Menyimpan parameter url pada result
                        var hasilDtt = JSON.parse(result);  // Memanggil result dengan json
                        var dataHandler = $("#data_table");  // Pemanggilan id muat-data-disini
                                
                        $.each(hasilDtt, function(key,val){  // Menampung hasilDtt dalam variable val
                            var newRow = $("<tr>");
                                
                                            // Menyimpan elemen data kedalam tabel
                            newRow.html("<td>"+val.code+"</td><td>"+val.npk+"</td><td>"+val.date+"</td>");
                            dataHandler.append(newRow);
                                
                            });
                        }
                    });
               
                
        }
        else
        {
            barcode=barcode+String.fromCharCode(e.which);
        }    
    });

    $(document).ready(function() {
        $('#detail_no').prop('readonly', true);
        document.body.style.backgroundColor = '#dddddd';
    } );

</script>

@endsection
