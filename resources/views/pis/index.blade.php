@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="imageDiv" class="col-sm-4">
            
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.1.js'></script> -->
<!-- <script src="{{ asset('js/jquery.mmp.barcodereader.js') }}"></script> -->
<!-- <script type="text/javascript" src="./jquery-1.7.1.js"></script> -->
    <script type="text/javascript">
      var barcode="";
      var rep2 = "";
      var jsonData ="";
 $(document).keypress(function(e) {

            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13)// Enter key hit
            {
                console.log(barcode)
                // $.get("{{ url('getAjaxImage/".barcode."') }}", data, function (dataJSON) {

                //     console.log(data.part_number);

                // });
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

                        if(rep2 == '')
                        document.getElementById("imageDiv").innerHTML="Data Part tidak ada, silahkan input ke Sistem";
                        else
                        document.getElementById("imageDiv").innerHTML="<img src='{{url('/uploads/PIS')}}/"+rep2+".jpg' />";
                        barcode = "";
                        rep2    = "";
                        jsonData= "";

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
    </script>


@endsection
