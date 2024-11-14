@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('avicenna/pis.part_numb')</div>
                    <div class="panel-body">
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <input id="detail_no" class="form-control" name="detail_no" required>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- counter -->
                <div class="panel panel-default" id="table_hide">
                    <div class="panel-heading">@lang('avicenna/pis.counter')</div>
                    <div class="panel-body" style="height:110px;">
                        <div class="form-group">
                            <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                                <tbody>
                                    <tr>
                                        <td align="center" height=100>
                                            <font size=40>
                                                <div id="counter">TRIAL</div>
                                            </font>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-body">@lang('avicenna/pis.date')</div>
                </div>
                <!-- end counter -->

                <!-- last scan -->
                <div class="panel panel-default" id="table_hide">
                    <div class="panel-heading">@lang('avicenna/pis.last_scan_title')</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                                <thead>
                                    <tr>
                                        <th>@lang('avicenna/pis.last_scan_part')</th>
                                    </tr>
                                    <tr>
                                        <td id="last_scan">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td id="last_scan">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td id="last_scan">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td id="last_scan">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td id="last_scan">&nbsp;</td>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- end last scan -->

                <!-- x_panel -->
            </div>

            <div class="col-md-9">
                <div id="alert"
                    class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                    <h4>
                        <div id="alert-header"> <i class="icon fa fa-check"></i>Alert!</div>
                    </h4>
                    <div id="alert-body">{{ session('message')['text'] ? session('message')['text'] : 'Ready to Scan !!' }}
                    </div>
                </div>

                <div id="imageDiv">

                    <!-- x_content -->
                </div>
            </div>

            <div class="col-md-1">
                <div id="delivery" class="form-group">
                    <button id="btnOEM" value="OEM" type="button" class="btn btn-block btn-primary"
                        onclick="func_change_delivery(this);">OEM</button>
                    <button id="btnGNP" value="GNP" type="button" class="btn btn-block btn-default"
                        onclick="func_change_delivery(this);">GNP</button>
                    <input id="delivery_type" value="OEM" type="hidden"></input>
                </div>

                <div id="dock" class="form-group">
                    <label>Dock :</label>
                    <button id="btnOTHER" value="OTHER" type="button" class="btn btn-block btn-primary"
                        onclick="func_change_dock(this);">OTHER</button>
                    <button id="btn43" value="43" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">43</button>
                    <button id="btn53" value="53" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">53</button>
                    <button id="btn1L" value="1L" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">1L</button>
                    <button id="btn1N" value="1N" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">1N</button>
                    <button id="btn1S" value="1S" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">S1</button>
                    <button id="btn6I" value="6I" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">6I</button>
                    <button id="btnTAMTAM" value="TAMTAM" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">TAM-TAM</button>
                    <button id="btnTAMADM" value="TAMADM" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">TAM-ADM</button>
                    <button id="btnTAMHINO" value="TAMHINO" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">TAM-HINO</button>
                    <button id="btnADMAS" value="ADMAS" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">ADM-AS</button>
                    <button id="btnADMKP" value="ADMKP" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">ADM-KP</button>
                    <button id="btnADMKP" value="YHA" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">YHA</button>
                    <button id="btnADMAS" value="ADM" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">ADM</button>
                    <button id="btnADMKP" value="TTI" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">TTI</button>
                    <button id="btnADMKP" value="S1-TAM" type="button" class="btn btn-block btn-default"
                        onclick="func_change_dock(this);">S1-TAM</button>
                    <input id="dock_type" value="OTHER" type="hidden"></input>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        // Fungsi untuk menangani perubahan pada delivery type
        function func_change_delivery(obj) {
            $('#delivery').find('button').removeClass('btn-primary');
            $('#delivery').find('button').addClass('btn-default');
            $(obj).addClass('btn-primary');
            $('#delivery_type').val(obj.value);
        }

        // Fungsi untuk menangani perubahan pada dock type
        function func_change_dock(obj) {
            $('#dock').find('button').removeClass('btn-primary');
            $('#dock').find('button').addClass('btn-default');
            $(obj).addClass('btn-primary');
            $('#dock_type').val(obj.value);
        }

        var barcode = "";
        var token = ""; // Variabel untuk menyimpan token yang diperoleh setelah login
        var stage = 1; // Mulai dari stage 1 (scan loading list)

        $(document).keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) { // Jika tombol Enter ditekan
                // Ambil nilai dari input #detail_no
                var detail_no = $('#detail_no').val(); // Nilai dari input detail_no

                // Cek apakah token sudah ada
                if (!token) {
                    // Login jika token belum ada
                    loginApi(function() {
                        // Setelah login sukses, lanjutkan untuk scan loading list
                        if (stage === 1) {
                            scanLoadingList(barcode, detail_no); // Proses mengambil data loading list
                        }
                    });
                } else {
                    // Jika sudah login dan token tersedia, lanjutkan untuk scan loading list
                    if (stage === 1) {
                        scanLoadingList(barcode, detail_no); // Proses mengambil data loading list
                    }
                }

                barcode = ""; // Reset barcode setelah scan
            } else {
                barcode += String.fromCharCode(e.which); // Kumpulkan karakter barcode
            }
        });

        // Fungsi untuk login ke API dan mendapatkan token
        function loginApi(callback) {
            $.ajax({
                url: 'https://dea-dev.aiia.co.id/api/v1/auth/login',
                type: 'POST',
                data: {
                    npk: "{{ Auth::user()->npk }}", // NPK pengguna yang sudah login
                    password: '123456' // Password yang digunakan (misalnya hardcoded di sini)
                },
                success: function(response) {
                    // Menyimpan token setelah login berhasil
                    token = response.token;
                    console.log('Login berhasil, token: ' + token);

                    // Panggil callback setelah login sukses
                    callback();
                },
                error: function(xhr, status, error) {
                    $('#alert').removeClass('alert-success').addClass('alert-danger');
                    $('#alert-header').html('<i class="icon fa fa-warning"></i> Error Login');
                    $('#alert-body').text('Gagal login: ' + xhr.statusText);
                }
            });
        }

        // Fungsi untuk memindai loading list menggunakan barcode yang diberikan
        function scanLoadingList(barcode, detail_no) {
            $.ajax({
                type: 'GET',
                url: 'https://dea-dev.aiia.co.id/api/v1/loading-lists/' +
                barcode, // Menggunakan barcode yang dipindai
                headers: {
                    "Authorization": "Bearer " + token // Gunakan token untuk otorisasi
                },
                dataType: 'json',
                success: function(data) {
                    // Cek apakah data ditemukan
                    if (data && data.loading_list) {
                        // Tampilkan data loading list
                        console.log('Loading list ditemukan: ', data.loading_list);
                        $('#alert').removeClass('alert-danger alert-warning').addClass('alert-success');
                        $('#alert-header').html('<i class="icon fa fa-check"></i> Loading List Ditemukan');
                        $('#alert-body').text('Loading list: ' + data.loading_list
                        .name); // Menampilkan nama loading list
                        $('#detail_no').val(data.loading_list.name); // Menampilkan nama loading list di input
                    } else {
                        // Menampilkan alert jika data tidak ditemukan
                        $('#alert').removeClass('alert-success').addClass('alert-danger');
                        $('#alert-header').html(
                            '<i class="icon fa fa-warning"></i> Loading List Tidak Ditemukan');
                        $('#alert-body').text('Barcode tidak sesuai dengan loading list.');
                    }
                },
                error: function(xhr, status, error) {
                    $('#alert').removeClass('alert-success').addClass('alert-danger');
                    $('#alert-header').html('<i class="icon fa fa-warning"></i> Error Pemindaian');
                    $('#alert-body').text('Gagal memindai loading list: ' + xhr.statusText);
                }
            });
        }

        $(document).ready(function() {
            $('#detail_no').prop('readonly', true);
        });
    </script>
@endsection
