@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Rekap NG
@endsection

@section('htmlheader')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
    Rekap NG
@endsection

@section('contentheader_description')
    {{-- NG Data Detail --}}
@endsection

@section('main-content')
    <div class="row">

        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Input Data Rekap NG</h3>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- @if (session('error'))
                                    <div id="alert" class="alert alert-danger mt-2">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif (session('warning'))
                                    <div id="alert" class="alert alert-warning mt-2">
                                        {{ session('warning') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif (session('success'))
                                    <div id="alert" class="alert alert-success mt-2">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif --}}
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" name="code" id="code" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" name="area" id="area">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-success" id="submitRekap">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">List Rekap NG</h3>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Line</label>
                                    <select class="form-control" id="line">
                                        <option value="null">Pilih Line</option>
                                        <option value="16">DCAA06</option>
                                        <option value="17">DCAA07</option>
                                        <option value="18">DCAA08</option>
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Program Number</label>
                                    <select class="form-control select2" id="programnumber">
                                        <option value="">Pilih Program Number</option>
                                        <option value="07">CSH D98E</option>
                                        <option value="08">CSH D05E</option>
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                            {{-- update dies fabian 01162023 --}}
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dies</label>
                                    <select class="form-control" id="dies">
                                        <option value="null">Pilih Dies</option>
                                        <option value="01">Die #1</option>
                                        <option value="02">Die #2</option>
                                        <option value="03">Die #3</option>
                                        <option value="04">Die #4</option>
                                        <option value="05">Die #5</option>
                                        <option value="06">Die #6</option>
                                        <option value="07">Die #7</option>
                                        <option value="08">Die #8</option>
                                        <option value="09">Die #9</option>
                                        <option value="10">Die #10</option>
                                        <option value="11">Die #11</option>
                                        <option value="12">Die #12</option>
                                        <option value="13">Die #13</option>
                                        <option value="14">Die #14</option>
                                        <option value="15">Die #15</option>
                                        <option value="16">Die #16</option>
                                        <option value="17">Die #17</option>
                                        <option value="18">Die #18</option>
                                        <option value="19">Die #19</option>
                                        <option value="20">Die #20</option>
                                        <option value="21">Die #21</option>
                                        <option value="22">Die #22</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="area">Area NG</label>
                                    <select class="form-control" id="area_ng">
                                        <option value="null">Pilih Area NG</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area }}">{{ $area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- update by fabian 12272022 || report excel by month --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div>
                                        <label for="keyMonth">
                                            <i class='fa fa-calendar'></i>&nbsp;&nbsp;<font face='calibri'><b>LOT</b>
                                            </font>
                                        </label>
                                    </div>
                                    <select class="form-control select2" name="keyMonth" id="keyMonth"
                                        style="width: 100%;">
                                        <option value="null">Pilih LOT</option>
                                        @for ($i = 0; $i < 12; $i++)
                                            <option
                                                value="{{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}">
                                                {{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-lg-4">
                                <button type="button" id="btnFilter" class="btn btn-primary"
                                    onclick="filterData()">Filter</button>
                                <button type="button" id="btnExport" class="btn btn-success" onclick="exportData()">
                                    Export
                                    To Excel</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-body table-responsive">
                        <div class="alert-avicenna"></div>
                        <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part Code</th>
                                    <th>Area NG</th>
                                    <th>LOT</th>
                                    <th>Tanggal Rekap</th>
                                    <th>PIC Rekap</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Chart Rekap NG |<span id="lineChart"></span> |<span id="monthChart"></span>
                    </h3>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Line</label>
                                    <select class="form-control" id="line_chart">
                                        <option value="null">Pilih Line</option>
                                        <option value="16">DCAA06</option>
                                        <option value="17">DCAA07</option>
                                        <option value="18">DCAA08</option>
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Program Number</label>
                                    <select class="form-control select2" id="programnumber_chart">
                                        <option value="null">Pilih Program Number</option>
                                        <option value="07">CSH D98E</option>
                                        <option value="08">CSH D05E</option>
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                            {{-- update dies fabian 01162023 --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dies</label>
                                    <select class="form-control" id="dies_chart">
                                        <option value="null">Pilih Dies</option>
                                        <option value="01">Die #1</option>
                                        <option value="02">Die #2</option>
                                        <option value="03">Die #3</option>
                                        <option value="04">Die #4</option>
                                        <option value="05">Die #5</option>
                                        <option value="06">Die #6</option>
                                        <option value="07">Die #7</option>
                                        <option value="08">Die #8</option>
                                        <option value="09">Die #9</option>
                                        <option value="10">Die #10</option>
                                        <option value="11">Die #11</option>
                                        <option value="12">Die #12</option>
                                        <option value="13">Die #13</option>
                                        <option value="14">Die #14</option>
                                        <option value="15">Die #15</option>
                                        <option value="16">Die #16</option>
                                        <option value="17">Die #17</option>
                                        <option value="18">Die #18</option>
                                        <option value="19">Die #19</option>
                                        <option value="20">Die #20</option>
                                        <option value="21">Die #21</option>
                                        <option value="22">Die #22</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="area">Area NG</label>
                                    <select class="form-control" id="area_ng_chart">
                                        <option value="null">Pilih Area NG</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                        <option value="H">H</option>
                                        <option value="M6">M6</option>
                                        <option value="M7">M7</option>
                                        <option value="M8">M8</option>
                                        <option value="M10">M10</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- update by fabian 12272022 || report excel by month --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div>
                                        <label for="keyMonth">
                                            <i class='fa fa-calendar'></i>&nbsp;&nbsp;<font face='calibri'><b>LOT</b>
                                            </font>
                                        </label>
                                    </div>
                                    <select class="form-control select2" name="keyMonth" id="keyMonth_chart"
                                        style="width: 100%;">
                                        <option value="null">Pilih LOT</option>
                                        @for ($i = 0; $i < 12; $i++)
                                            <option
                                                value="{{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}">
                                                {{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-lg-4">
                                <button type="button" id="btnFilter" class="btn btn-primary"
                                    onclick="filterDataChart()">Filter</button>
                                {{-- <button type="button" id="btnExport" class="btn btn-success" onclick="exportData()">
                                    Export
                                    To Excel</button> --}}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-body">
                        <canvas id="myChart" style="position: relative; height:30vh; width:80vw"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editModalLabel">Edit Confirmation</h4>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to edit this item?</h5>
                    <input type="hidden" id="id_edit">
                    <div class="form-group">
                        <label for="code_edit">Code :</label>
                        <input type="text" class="form-control" id="code_edit">
                    </div>
                    <div class="form-group">
                        <label for="area_edit">Area :</label>
                        <input type="text" class="form-control" id="area_edit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-edit">Yes, Edit!</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteModalLabel">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this item?</h5>
                    <input type="hidden" id="id_delete">
                    <div class="form-group">
                        <label for="code_delete">Code :</label>
                        <input type="text" class="form-control" id="code_delete" readonly>
                    </div>
                    <div class="form-group">
                        <label for="area_delete">Area :</label>
                        <input type="text" class="form-control" id="area_delete" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-delete">Yes, Delete!</button>
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
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
        integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}

    {{-- <script>
        Highcharts.chart('chart', {

            chart: {
                type: 'column'
            },

            title: {
                text: '',
                align: 'center'
            },

            xAxis: {
                categories: ['A', 'B', 'C', 'D', 'E', 'F', 'G',
                    'H', 'M6', 'M7',
                ]
            },

            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Total Forms'
                }
            },

            tooltip: {
                format: '<b>{key}</b><br/>{series.name}: {y}<br/>' +
                    'Total: {point.stackTotal}'
            },

            plotOptions: {
                column: {
                    stacking: 'normal',
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },

            series: [{
                name: 'CSH D98E',
                color: '#001d52',
                data: [{{ $csh_d98e_a }}, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            }, {
                name: 'CSH D05E',
                color: '#25b7db',
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            }]
        });
    </script> --}}

    <script>
        function removeAlert() {
            const errorAlert = document.querySelector('.alert-danger');
            const successAlert = document.querySelector('.alert-success');
            if (errorAlert) {
                errorAlert.remove();
            }
            if (successAlert) {
                successAlert.remove();
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const areaNgInput = document.getElementById('area');
            const submitButton = document.getElementById('submitRekap');

            codeInput.addEventListener('input', function() {
                removeAlert(); // Menghapus alert error saat input berubah
            });

            areaNgInput.addEventListener('input', function() {
                removeAlert(); // Menghapus alert error saat input berubah
            });

            // Set autofocus to code input when the page loads
            codeInput.focus();

            // Move to the next input field after scanning the barcode
            codeInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    areaNgInput.focus();
                }
            });

            // Submit the form after scanning the area
            areaNgInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    submitButton.click();
                }
            });

            // Handle the submit button click
            submitButton.addEventListener('click', function() {
                removeAlert();
                // Ambil nilai dari input fields
                const code = codeInput.value;
                const idNg = areaNgInput.value;

                if (!code) {
                    $('.col-lg-12').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">Mohon isi code part<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>`
                    );
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika code kosong
                }

                // Validasi panjang code harus 15 karakter
                if (code.length !== 15) {
                    $('.col-lg-12').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">Code harus terdiri dari 15 digit<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>`
                    );
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika panjang code tidak sama dengan 15
                }

                if (code.substring(0, 2) !== '07' && code.substring(0, 2) !== '08') {
                    $('.col-lg-12').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">Code ${code} tidak valid<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>`
                    );
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika code kosong
                }

                // Ambil digit ke-3 dan ke-4 dari kode
                let digits34 = code.substring(2, 4);

                // Konversi ke integer untuk memeriksa rentang
                let digits34Int = parseInt(digits34, 10);

                // Periksa apakah digit ke-3 dan ke-4 berada dalam rentang 01-22
                if (digits34Int < 1 || digits34Int > 22) {
                    // Tampilkan alert bahwa kode tidak valid
                    $('.col-lg-12').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">Code ${code} tidak valid<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>`
                    );
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika kode tidak valid
                }

                // Ambil digit ke-3 dan ke-4 dari kode
                let digit56 = code.substring(4, 6);

                // Konversi ke integer untuk memeriksa rentang
                let digit56Int = parseInt(digit56, 10);

                // Periksa apakah digit ke-3 dan ke-4 berada dalam rentang 01-22
                if (digit56Int < 11 || digit56Int > 18) {
                    // Tampilkan alert bahwa kode tidak valid
                    $('.col-lg-12').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">Code ${code} tidak valid<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>`
                    );
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika kode tidak valid
                }

                // Lakukan request AJAX untuk menyimpan data
                fetch('/trace/ng/rekap/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content') // Laravel CSRF token
                        },
                        body: JSON.stringify({
                            code: code,
                            area: idNg
                        })
                    })
                    .then(response => {
                        // Pastikan respons adalah JSON yang valid
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Jika berhasil, refresh dataTables
                            $('#tabel_all').DataTable().ajax.reload();
                            $('#lineChart').text(' Total NG: ' + data.totalLine);
                            // Memperbarui grafik
                            myChart.update();
                            // Mengupdate grafik dengan data yang diterima
                            // Bersihkan input fields setelah submit
                            codeInput.value = '';
                            areaNgInput.value = '';
                            // Set autofocus back to the code input
                            codeInput.focus();

                            $('.col-lg-12').prepend(
                                `<div id="alert" class="alert alert-success mt-2">${data.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>`
                            );
                        } else {
                            // Tangani kesalahan jika ada
                            // Tangani kesalahan jika ada
                            codeInput.value = '';
                            areaNgInput.value = '';
                            // Set autofocus back to the code input
                            let alertType = 'danger';
                            if (data.message === 'code sudah ada') {
                                alertType = 'warning';
                            }
                            // Remove any existing alert
                            $('#alert').remove();
                            // Show the alert
                            $('.col-lg-12').prepend(
                                `<div id="alert" class="alert alert-${alertType} mt-2">${data.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>`
                            );
                            // Keep the focus on the code input
                            codeInput.focus();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });


            });
        });
    </script>


    <script type="text/javascript">
        // Chart
        const ctx = $('#myChart');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah NG',
                    data: [],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // End Chart


        let line = $('#line').val() ? $('#line').val() : 'null';
        let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
        let dies = $('#dies').val() ? $('#dies').val() : 'null';
        let area = $('#area_ng').val() ? $('#area_ng').val() : 'null';
        // data_month
        let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
        var table = $('#tabel_all').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('/trace/ng/rekap/getData') }}/' + programnumber + '/' + dies + '/' + line + '/' + area +
                '/' + date,
            columns: [{
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'code',
                    name: 'code'
                },

                {
                    data: 'area',
                    name: 'area'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'pic',
                    name: 'pic'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return `
                        <div class="d-flex justify-content-between text-center">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="${data.id}" data-code="${data.code}" data-area="${data.area}" style="margin-left: 20px;">Edit</button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="${data.id}" data-code="${data.code}" data-area="${data.area}">Delete</button>
                        </div>`;
                    }
                }
            ],
            language: {
                search: "Search :"
            },
        });

        $('#tabel_all tbody').on('click', 'button[data-target="#editModal"]', function() {
            var id = $(this).data('id');
            var code = $(this).data('code');
            var area = $(this).data('area');

            $('#alert').remove();

            $('#editModal #id_edit').val(id);
            $('#editModal #code_edit').val(code);
            $('#editModal #area_edit').val(area);
        });

        $('#btn-edit').on('click', function() {
            var id = $('#id_edit').val();
            var code = $('#code_edit').val();
            var area = $('#area_edit').val();

            $.ajax({
                url: '{{ url('/trace/ng/rekap/update') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    type: 'edit',
                    code: code,
                    area: area
                },
                success: function(response) {
                    // Check if the response is successful
                    if (response.success) {
                        // Display the success message
                        $('.alert-avicenna').prepend(
                            `<div id="alert" class="alert alert-success mt-2">${response.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>`
                        );
                        $('#editModal').modal('hide');
                        table.ajax.reload(); // Refresh the DataTable
                    } else {
                        // Handle the case where success is false
                        $('.alert-avicenna').prepend(
                            `<div id="alert" class="alert alert-danger mt-2">${response.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>`
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // Optionally handle the error
                    $('.alert-avicenna').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">An error occurred while updating the item.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>`
                    );
                }
            });
        });

        $('#tabel_all tbody').on('click', 'button[data-target="#deleteModal"]', function() {
            var id = $(this).data('id');
            var code = $(this).data('code');
            var area = $(this).data('area');

            $('#alert').remove();

            $('#deleteModal #id_delete').val(id);
            $('#deleteModal #code_delete').val(code);
            $('#deleteModal #area_delete').val(area);
        });

        $('#btn-delete').on('click', function() {
            var id = $('#id_delete').val();
            var code = $('#code_delete').val();
            var area = $('#area_delete').val();

            $.ajax({
                url: '{{ url('/trace/ng/rekap/update') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    type: 'delete',
                    code: code,
                    area: area
                },
                success: function(response) {
                    // Check if the response is successful
                    if (response.success) {
                        // Display the success message
                        $('.alert-avicenna').prepend(
                            `<div id="alert" class="alert alert-success mt-2">${response.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>`
                        );
                        $('#deleteModal').modal('hide');
                        table.ajax.reload(); // Refresh the DataTable
                    } else {
                        // Handle the case where success is false
                        $('.alert-avicenna').prepend(
                            `<div id="alert" class="alert alert-danger mt-2">${response.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>`
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // Optionally handle the error
                    $('.alert-avicenna').prepend(
                        `<div id="alert" class="alert alert-danger mt-2">An error occurred while updating the item.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>`
                    );
                }
            });
        });

        function reloadDataTable() {
            let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
            let dies = $('#dies').val() ? $('#dies').val() : 'null';
            let line = $('#line').val() ? $('#line').val() : 'null';
            let area = $('#area_ng').val() ? $('#area_ng').val() : 'null';
            let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';

            table.ajax.url('{{ url('/trace/ng/rekap/getData') }}/' + programnumber + '/' + dies + '/' + line + '/' + area +
                    '/' + date)
                .load();
        }

        // Call reloadDataTable every 5 seconds
        setInterval(reloadDataTable, 5000);

        function filterData() {
            // update
            let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
            let dies = $('#dies').val() ? $('#dies').val() : 'null';
            let line = $('#line').val() ? $('#line').val() : 'null';
            let area = $('#area_ng').val() ? $('#area_ng').val() : 'null';
            let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';

            table.ajax.url('{{ url('/trace/ng/rekap/getData') }}/' + programnumber + '/' + dies + '/' + line + '/' + area +
                    '/' + date)
                .load();
        }

        document.addEventListener('DOMContentLoaded', function() {
            realoadDataChart(); // Load data when the page is first accessed or refreshed
        });

        setInterval(realoadDataChart, 5000);

        function realoadDataChart() {
            // Update
            let programnumber_chart = $('#programnumber_chart').val() ? $('#programnumber_chart').val() : 'null';
            let dies_chart = $('#dies_chart').val() ? $('#dies_chart').val() : 'null';
            let line_chart = $('#line_chart').val() ? $('#line_chart').val() : 'null';
            let area_ng_chart = $('#area_ng_chart').val() ? $('#area_ng_chart').val() : 'null';
            let keyMonth_chart = $('#keyMonth_chart').val() ? $('#keyMonth_chart').val() : 'null';
            myChart.data.datasets[0].data.splice(0, myChart.data.datasets[0].data.length);

            $.ajax({
                type: 'get',
                url: '{{ url('/trace/ng/rekap/getDataChart') }}',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    line: line_chart,
                    date: keyMonth_chart,
                    programnumber: programnumber_chart,
                    dies: dies_chart,
                    area: area_ng_chart,
                },
                success: function(data) {
                    myChart.data.labels = data.labelChart;
                    myChart.data.datasets.forEach(dataset => {
                        dataset.data = data.valueChart;
                    });
                    $('#lineChart').text(' Total NG: ' + data.totalLine);
                    $('#monthChart').text(' Bulan: ' + data.monthName);
                    myChart.update();
                },
            });
        }

        function filterDataChart() {
            // Update
            let programnumber_chart = $('#programnumber_chart').val() ? $('#programnumber_chart').val() : 'null';
            let dies_chart = $('#dies_chart').val() ? $('#dies_chart').val() : 'null';
            let line_chart = $('#line_chart').val() ? $('#line_chart').val() : 'null';
            let area_ng_chart = $('#area_ng_chart').val() ? $('#area_ng_chart').val() : 'null';
            let keyMonth_chart = $('#keyMonth_chart').val() ? $('#keyMonth_chart').val() : 'null';
            myChart.data.datasets[0].data.splice(0, myChart.data.datasets[0].data.length);

            $.ajax({
                type: 'get',
                url: '{{ url('/trace/ng/rekap/getDataChart') }}',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    line: line_chart,
                    date: keyMonth_chart,
                    programnumber: programnumber_chart,
                    dies: dies_chart,
                    area: area_ng_chart,
                },
                success: function(data) {
                    myChart.data.labels = data.labelChart;
                    myChart.data.datasets.forEach(dataset => {
                        dataset.data = data.valueChart;
                    });
                    $('#lineChart').text(' Total NG: ' + data.totalLine);
                    $('#monthChart').text(' Bulan: ' + data.monthName);
                    myChart.update();
                },
            });
        }

        function exportData() {
            let line = $('#line').val() ? $('#line').val() : 'null';
            let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
            let dies = $('#dies').val() ? $('#dies').val() : 'null';
            let area = $('#area_ng').val() ? $('#area_ng').val() : 'null';
            let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
            if (programnumber == "null") {
                alert('Minimal pilih Program Number');
                return;
            }

            location.href = '{{ url('/trace/ng/rekap/exportData') }}/' + programnumber + '/' + dies + '/' + line + '/' +
                area + '/' + date;
        }
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            let programnumber_chart = $('#programnumber_chart').val() ? $('#programnumber_chart').val() : 'null';
            let dies_chart = $('#dies_chart').val() ? $('#dies_chart').val() : 'null';
            let line_chart = $('#line_chart').val() ? $('#line_chart').val() : 'null';
            let area_ng_chart = $('#area_ng_chart').val() ? $('#area_ng_chart').val() : 'null';
            let keyMonth_chart = $('#keyMonth_chart').val() ? $('#keyMonth_chart').val() : 'null';

            function updateChartData() {
                fetch(
                        `/trace/ng/rekap/getDataChart?line=${line_chart}&date=${keyMonth_chart}&programnumber=${programnumber_chart}&dies=${dies_chart}&area=${area_ng_chart}`)
                    .then(response => {
                        // Ensure the response is valid JSON
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update the chart with the received data
                        myChart.data.labels = data.labelChart;
                        myChart.data.datasets.forEach(dataset => {
                            dataset.data = data.valueChart;
                        });
                        $('#lineChart').text(' Total NG: ' + data.totalLine);
                        // Refresh the chart
                        myChart.update();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
            }

            // Execute the updateChartData function when the page is loaded
            updateChartData();

            // Call updateChartData every 5 seconds
            setInterval(updateChartData, 5000);
        });
    </script> --}}
@endsection
