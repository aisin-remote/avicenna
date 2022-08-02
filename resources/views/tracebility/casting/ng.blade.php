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

     <div style="background-color: black; border: 1px solid white; margin-top: 1rem " class="container gfont">
        <div class="bg-merahs ng-header">
            <h1 class="font-weight-bold text-white text-center" style="font-size: 50pt">
                INPUT PART NG - LINE <span id="line-display"></span>
            </h1>
        </div>
        <div style="background-color: black;">

            <div class="row" style="margin-top: 1rem">
                <div class="col-md-12 text-center" style="">
                        <input id="code" style="font-size: 25pt !important; width: 100% ; padding: 1rem;" type="text" name="" placeholder="SCAN KODE PART">
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 text-center border" style="height: 400px;  margin-top: 2rem; ">
                    <table style="width: 100%; height: 100%">
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3 text-center border" style="height: 400px; margin-top: 2rem; color: white; overflow-y: auto;">
                    <table id="ngdetail" style="width: 100%; height: 100%; border: white; color: white">
                        <thead>
                            <td style="height: 15px" class="text-center" colspan="2">NAMA NG</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-top: .5rem">
                <div class="col-md-12 text-center" >
                        <input id="ng" style="font-size: 25pt !important; width: 100% ; padding: 1rem;" type="text" name="" placeholder="SCAN KODE NG">
                </div>
            </div>
            <div class="row" style="margin-top: 3rem; margin-bottom: 4rem">
                <div class="col-md-12 text-center">
                    <button style="width: 100%;font-size: 40pt; color: white; background-color: #32a852" onclick="done()"> KONFIRMASI </button>
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
    <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('/js/jquery-cookie.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function() {
        let line_number = localStorage.getItem('avi_line_number');
        let part = "";
        $('#line-display').text(line_number);

        $('#code').focus();
        $('#code').keypress( function(e) {
            // e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            if(code==13) {
                part = $('#code').val();
                if (part.length == 15) {
                    cekPart(part);
                } else {
                    notif("error", "TOLONG SCAN PART KEMBALI");
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#code').val("");
                        $('#code').focus();
                    }, 2000);
                }
            }
        });

        $('#ng').keypress( function(e) {
            // e.preventDefault();
            let code = (e.keyCode ? e.keyCode : e.which);
            let ng = "";
            if(code==13) {
                ng = $('#ng').val();
                if (ng.length < 3) {
                    // console.log(ng);
                    inputNg(part, ng);
                } else {
                    notif("error", "TOLONG SCAN PART KEMBALI");
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#code').val("");
                        $('#code').focus();
                    }, 2000);
                }
            }
        });


    });

    function cekPart(part) {
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/getPartNg') }}"+'/'+part,
            dataType: 'json',
            success: function (data) {

                notif("success", "PART BERHASIL DISCAN, SILAHKAN SCAN QR CODE NG");
                let interval = setInterval( function(){
                    $('#notifModal').modal('hide');
                    clearInterval(interval);
                    $('#ng').focus();
                }, 2000);
            }

        });
    }

    function inputNg(part, idNg) {
        let line = localStorage.getItem('avi_line_number');
        $.ajax({
            type: 'get',
            url: "{{ url('/trace/scan/casting/inputPartNg') }}"+'/'+part+'/'+idNg+'/'+line,
            dataType: 'json',
            success: function (data) {
                if (data.status == "error") {
                    notif("error", data.messege);
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#ng').val("");
                        $('#ng').focus();
                    }, 2000);
                } else {
                    $("#ngdetail > tbody").empty();
                    data.forEach((item, index) => {
                        console.log(item.ngdetail.name);
                        $("#ngdetail").find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                        .text(item.ngdetail.name)
                                )
                            );
                    });
                    notif("success", "PART BERHASIL DISCAN, SILAHKAN SCAN QR CODE NG");
                    let interval = setInterval( function(){
                        $('#notifModal').modal('hide');
                        clearInterval(interval);
                        $('#ng').val("");
                        $('#ng').focus();
                    }, 2000);

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
        $("#ngdetail > tbody").empty();
        $('#code').val("");
        $('#code').focus();
    }

    </script>
</body>
</html>



