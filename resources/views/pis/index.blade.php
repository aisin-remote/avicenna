@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Loading List</div>
                    <div class="panel-body">       
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-8 control-label">Detail No</label>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input id="detail_no" class="form-control" name="detail_no" required autofocus>
                                </div>
                                <div class="col-md-3">
                                    <button id="btnReset" class="btn btn-primary">
                                     Reset
                                    </button>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">Part</div>
                <div class="panel-body">       
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

         
            <!-- x_panel -->
        </div>
        
        <div id="imageDiv" class="col-md-8">

            
                <!-- x_content -->
            </div>

        </div>  

    </div>
</div>
<!-- <script src="{{asset('/js/jquery.js')}}"></script> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/dataTables.bootstrap.js')}}"></script>

    <script type="text/javascript">
      var barcode="";
      var rep2 = "";
      var jsonData ="";
      $(document).keypress(function(e) {

            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13)// Enter key hit
            {
                console.log(barcode)
               
                $.ajax({
                    type: 'get',           // POST Request
                    url: "{{ url('getAjaxImage') }}"+'/'+barcode,            // Url of the Route (in this case user/save not only save)
                    _token: "{{ csrf_token() }}",
                    dataType: 'json',       // Data Type of the Transmit
                    success: function (data) {
                        // Successfuly called the Controler
                        // alert(data.part_number)
                        $.each(data, function(k, v){
                                rep2 = v.part_number
                        });

                        if(rep2 == ''){
                            $('#imageDiv').show(); //show div 
                            $("#imageDiv").html('@lang("avicenna/pis.part_not_found")');    
                        }
                        else
                        {

                            $('#table_hide').show(); //show div 
                            $('#imageDiv').show(); //show div 
                            $("#imageDiv").html("<img src='{{url('/uploads/PIS')}}/"+rep2+".jpg' width='1000px'/>");
                            document.getElementById("detail_no").readOnly = false;
                            $('detail_no').val(rep2);
                            document.getElementById("detail_no").readOnly = true;
                            barcode = "";
                            rep2    = "";
                            jsonData= "";

                            var table = $('#data_table').DataTable( {
                            "searching" : false, 
                            "paging"    : false,
                            "info"      : false,
                            "ajax"      : "{{ url('pis/pis_transaction') }}",
                            "columns"   : [
                                            { "data": "no" },
                                            { "data": "part_number" },
                                          ],

                            } );

                        }

                        //get data table
                        
                    },
                    error: function (data) {
                        // Error while calling the controller (HTTP Response Code different as 200 OK
                        console.log('Error:', data);
                    }
                });

            }
            else
            {
                barcode=barcode+String.fromCharCode(e.which);
            }
            
        });


$("#btnReset").click(function(){
       $('#table_hide').hide();
       $('#imageDiv').hide();
       $('#detail_no').val('');
    });

$(document).ready(function() {
    $('#table_hide').hide();
    $('#imageDiv').hide();
} );

</script>


@endsection
