<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset ('/css/aisya/pis.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&display=swap" rel="stylesheet">
    <style type="text/css">
        .gfont {
            font-family: 'Chakra Petch', sans-serif !important;
        }

        ::placeholder {
          color: #cfcfcf;
          opacity: 1; /* Firefox */
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
          font-size: 18pt
        }
    </style>
</head>
<body style="background-color: black">

     <div style="background-color: black; border: 1px solid white; margin-top: 1rem ;height : 97% " class="container gfont">
        <div class="bg-merahs ng-header text-center">
            <h1 class="text-center" style="font-size: 20pt; color: white">
                NG MACHINING & ASSY
            </h1>
        </div>
        <div style="background-color: black; border: 1px solid white; padding: 1rem ">
            <div class="row">
                <div class="col-md-12" style="">
                    <h1 style="font-size: 15pt; color: white">
                        Pilih Line :
                    </h1>
                </div>
                <div class="col-md-12 text-center" style="">
                    <select id="line" style="font-size: 10pt !important; width: 100% ; padding: 1rem;" >
                        <option value="MA001">MA001</option>
                        <option value="MA002">MA002</option>
                        <option value="MA003">MA003</option>
                        <option value="MA004">MA004</option>
                        <option value="MA005">MA005</option>
                        <option value="MA006">MA006</option>
                        <option value="AS001">AS001</option>
                        <option value="AS002">AS002</option>
                        <option value="AS003">AS003</option>
                        <option value="AS004">AS004</option>
                    </select>
                </div>
                <div class="col-md-12" style="">
                    <h1 class="" style="font-size: 15pt; color: white">
                        Pilih Jenis NG :
                    </h1>
                </div>
                <div class="col-md-12 text-center" style="">
                    <select id="ng" style="font-size: 10pt !important; width: 100% ; padding: 1rem;" >
                            @foreach ($ngName as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            
                    </select>
                </div>
            </div>
        </div>
        <div style="background-color: black; ">    
            <div class="row" style="margin-top: 2rem; margin-bottom: 2rem">
                <div class="col-md-12" style="">
                    <h1 class="" style="font-size: 15pt; color: white">
                        Scan Part NG :
                    </h1>
                </div>
                <div class="col-md-12 text-center" style="">
                    <input id="code" style="font-size: 10pt !important; width: 100% ; padding: 1rem;" type="text" name="" placeholder="SCAN KODE PART">
                </div>
                <div class="col-md-12 text-center">
                    <button style="margin-top:3rem; width: 100%;font-size: 15pt; color: white; background-color: #32a852" onclick="done()"> SELESAI </button>
                </div>
            </div>
        </div>
        <div class="card-footer p-3  bg-merahs text-center">
            <h5 class="right text-white" style="padding: 0.5rem; height: 4rem; font-size: 2rem">
                Powered by ITD - PT Aisin Indonesia Automotive - 2021
            </h5>

        </div>
    </div>

    <div class="modal fade gfont" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="divNotif" style="border-radius: 0px !important;">
          <div class="modal-body text-center">
            <span style="color: white; font-size: 30pt" id="notif"> Scan Part</span>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('/js/jquery-cookie.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function() {
        $('#code').focus();
        $('#code').keypress( function(e) {
            // e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            if(code==13) {
                line = $('#line').val();
                ng = $('#ng').val();
                part = $('#code').val();

                if (part == "NGMODE") {
                    window.location.replace("{{url('/trace/scan/machining')}}");
                    return;
                }

                if (part.length == 15) {
                    inputNg(part, ng, line);
                    getLineData(line_number);
                } else {
                    notif("error", "TOLONG SCAN PART KEMBALI");
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#code').val("");
                        $('#code').focus();
                    }, 1000);
                }
            }
        });

        let interval = setInterval( function(){
            window.location.replace("{{url('/trace/logout')}}");
        }, 3600000);
    });

    function inputNg(part, idNg, line) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/machining/inputPartNg') }}"+'/'+part+'/'+idNg+'/'+line,
            dataType: 'json',
            success: function (data) {
                if (data.data.status == "error") {
                    notif("error", data.messege);
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#ng').val("");
                        $('#ng').focus();
                    }, 1000);
                } else {
                    // $("#ngdetail > tbody").empty();
                    // data.data.forEach((item, index) => {
                    //     $("#ngdetail").find('tbody') 
                    //         .append($('<tr>')
                    //             .append($('<td>')
                    //                     .text(item.ngdetail.name)
                    //             )
                    //         );
                    // });
                    if(data.type == 'input'){
                        notif("success", part + ` NG BERHASIL DISCAN`);
                    }
                    else{
                        notif("error", "ID NG BERHASIL DIHAPUS");
                    }
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#code').val("");
                        $('#code').focus();
                    }, 1000);

                }
            }

        });
    }

    function notif(color, text) {
        let modal = $('#notifModal');
        let textNotif = $('#notif');
        if (color == "error" ) {
            textNotif.text(text);
            $('#divNotif').css("background-color", "#961a2c");
            $('#notifModal').modal('show');
        } else {
            textNotif.text(text);
            $('#divNotif').css("background-color", "#32a852");
            $('#notifModal').modal('show');

        }
    }

    function done() {
        notif("success", "DATA PART NG SUDAH DISIMPAN, TERIMA KASIH");
        let interval = setInterval( function(){
            $('#notifModal').modal('hide');
            clearInterval(interval);
            $('#code').val("");
            $('#ng').val("");
            $('#code').focus();
            window.location.replace("{{url('/trace/scan/machining')}}");
            return;
        }, 1000);

        $("#ngdetail > tbody").empty();
    }

    </script>
</body>
</html>



