@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Part Number</div>
                    <div class="panel-body">       
                        <div class="form-group">
                           <!--  <div class="row">
                                <label class="col-md-8 control-label">Detail No</label>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <input id="detail_no" class="form-control" name="detail_no" required >
                                </div>
                               <!--  <div class="col-md-3">
                                    <button id="btnReset" class="btn btn-primary">
                                     Reset
                                    </button>
                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="panel panel-default" id="table_hide">
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
            </div> -->
            
         
            <!-- x_panel -->
        </div>
        
        <div id="imageDiv" class="col-md-8">

            
                <!-- x_content -->
            </div>

        </div>  

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script type="text/javascript">
      var barcode   ="";
      var rep2      = "";
      var old_html  = $("#imageDiv").html();
      var detail_no = $('#detail_no');
      $(document).keypress(function(e) {

            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13)// Enter key hit
            {
                $('#detail_no').val('');
                
                $.ajax({
                        type: 'get',           // POST Request
                        url: "{{ url('pis/getAjaxImage') }}"+'/'+barcode,  
                        _token: "{{ csrf_token() }}",
                        dataType: 'json',       // Data Type of the Transmit
                        success: function (data) {

                            $.each(data, function(k, v){
                                    rep2 = v.part_number_customer
                            });
                            
                            if(rep2 == "" ){
                                $('#detail_no').prop('readonly', false);
                                $('#detail_no').val(barcode);
                                $("#imageDiv").html('@lang("avicenna/pis.part_not_found")');
                                 $('#detail_no').prop('readonly', true);
                                barcode = "";
                                rep2    = "";
                            }
                            else{
                                $('#detail_no').prop('readonly', false);
                                $('#detail_no').val(rep2);
                                $('#imageDiv').show();

                                //dev-1.0, 20170816, by yudo, fungsi menampilkan gambar
                                $("#imageDiv").html("<img src='{{url('storage/uploads/PIS')}}/"+rep2+".jpg' width='1000px'/>");
                                 $('#detail_no').prop('readonly', true);
                                barcode = "";
                                rep2    = "";

                            }
                        }
                                          
                    });
                   
                    
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
    // $('#table_hide').hide();
    // $('#imageDiv').hide();
    $('#detail_no').prop('readonly', true);
} );

</script>


@endsection
