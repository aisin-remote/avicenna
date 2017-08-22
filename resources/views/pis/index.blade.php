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
                                    <input id="detail_no" class="form-control" name="detail_no" required >
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
                                    <th>Part Number</th>
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
      var barcode   ="";
      var rep2      = "";
      var old_html  = $("#imageDiv").html();
      var detail_no = $('#detail_no');
      $(document).keypress(function(e) {

            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13)// Enter key hit
            {
                if(detail_no.val().length === 0 || detail_no.val().length == 0)
                {
                   
                    $("#detail_no").val(barcode);
                    barcode = "";
                    rep2    = "";
                }
                else
                {
                    $.ajax({
                        type: 'get',           // POST Request
                        url: "{{ url('pis/getAjaxImage') }}"+'/'+barcode,            // Url of the Route (in this case user/save not only save)
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // Data Type of the Transmit
                        success: function (data) {
                            // Successfuly called the Controler
                            // alert(data.part_number)
                            $.each(data, function(k, v){
                                    rep2 = v.part_number
                            });
                            
                            if(rep2 == "" ){
                                $("#imageDiv").html('@lang("avicenna/pis.part_not_found")');
                            }
                            else{
                             
                                $('#table_hide').show(); //show div 
                                // $('#imageDiv').show(); //show div 

                                //dev-1.0, 20170816, by yudo, fungsi menampilkan gambar
                                $("#imageDiv").html("<img src='{{url('storage/uploads/PIS')}}/"+rep2+".jpg' width='1000px'/>");
                                //end fungsi menampilkan gambar
                                //dev-1.0, 20170816, by yudo, get from table mutation
                                var table = $('#data_table').DataTable( {
                                "destroy"   : true, //ini refresh table
                                "searching" : false, 
                                "paging"    : false,
                                "info"      : false,
                                "ajax"      : "{{ url('pis/getAjaxMutation') }}",
                                "columns"   : [
                                                { "data": "no" },
                                                { "data": "part_number" },
                                              ],

                                } );
                                //end of get from table mutation
                                //dev-1.0 insert ke table mutation
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ url('/pis/insertMutation/') }}",
                                    data: { 
                                        "_token"        : "{{ csrf_token() }}",
                                        'loading_list'  : $('#detail_no').val(), 
                                        'part_number'   : rep2
                                    },
                                    success: function(msg){
                                        console.log('wow' + msg);
                                    }
                                });
                                //end of insert to table mutation
                            }

                            barcode = "";
                            rep2    = "";
                            
                        },
                        error: function (data) {
                            // Error while calling the controller (HTTP Response Code different as 200 OK
                            console.log('Error:', data);
                        }
                    });
                }
               
            }
            else
            {
                barcode=barcode+String.fromCharCode(e.which);
            }
            
        });


$("#btnReset").click(function(){
       rep2    = "";
       $('#table_hide').hide();
       $('#imageDiv').html(old_html);
       $(this).blur();
       detail_no.val("");
    });

$(document).ready(function() {
    $('#table_hide').hide();
    // $('#imageDiv').hide();
    $('#detail_no').prop('readonly', true);
} );

</script>


@endsection
