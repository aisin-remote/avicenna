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
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="area">Area NG</label>
                                    <select class="form-control" id="area_ng">
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
                            </div>
                            {{-- update by fabian 12272022 || report excel by month --}}
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div>
                                        <label for="keyMonth">
                                            <i class='fa fa-calendar'></i>&nbsp;&nbsp;<font face='calibri'><b>Tanggal
                                                    Produksi</b></font>
                                        </label>
                                    </div>
                                    <select class="form-control select2" name="keyMonth" id="keyMonth"
                                        style="width: 100%;">
                                        <option value="null">Pilih Tanggal</option>
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
                                {{-- <button type="button" id="btnExport" class="btn btn-success" onclick="exportData()">
                                    Export
                                    To Excel</button> --}}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-body">
                        <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part Code</th>
                                    <th>Area NG</th>
                                    <th>Tanggal Produksi</th>
                                    <th>Tanggal Rekap</th>
                                    <th>PIC Rekap</th>
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
                    <h3 class="box-title">Chart Rekap NG |<span id="lineChart"></span></h3>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Line</label>
                                    <select class="form-control" id="line_chart">
                                        <option value="null">Pilih Line</option>
                                        <option value="17">DCAA07</option>
                                        <option value="18">DCAA08</option>
                                    </select>
                                </div>
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Program Number</label>
                                    <select class="form-control select2" id="programnumber_chart">
                                        <option value="">Pilih Program Number</option>
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
                                            <i class='fa fa-calendar'></i>&nbsp;&nbsp;<font face='calibri'><b>Tanggal
                                                    Produksi</b></font>
                                        </label>
                                    </div>
                                    <select class="form-control select2" name="keyMonth" id="keyMonth_chart"
                                        style="width: 100%;">
                                        <option value="null">Pilih Tanggal</option>
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
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const areaNgInput = document.getElementById('area');
            const submitButton = document.getElementById('submitRekap');

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
                // Ambil nilai dari input fields
                const code = codeInput.value;
                const idNg = areaNgInput.value;

                if (!code) {
                    alert('Mohon isi code.');
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika code kosong
                }

                // Validasi panjang code harus 15 karakter
                if (code.length !== 15) {
                    alert('Code harus terdiri dari 15 karakter.');
                    codeInput.value = '';
                    areaNgInput.value = '';
                    // Set autofocus back to the code input
                    codeInput.focus();
                    return; // Keluar dari fungsi jika panjang code tidak sama dengan 15
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
                        } else {
                            // Tangani kesalahan jika ada
                            alert('Error: ' + data.message);
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
            ],
            language: {
                search: "Search :"
            },
        });

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

        function filterDataChart() {
            // update
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
                    myChart.update();
                },
            });
        }

        // const exampleLabels = ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'];
        // const exampleData = [10, 20, 15, 25, 30];

        // // Mengganti isi labels dan data pada grafik
        // myChart.data.labels = exampleLabels;
        // myChart.data.datasets[0].data = exampleData;

        // // Memperbarui grafik
        // myChart.update();

        function exportData() {
            let line = $('#line').val() ? $('#line').val() : 'null';
            let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
            let dies = $('#dies').val() ? $('#dies').val() : 'null';

            // data_month
            let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';

            location.href = '{{ url('/trace/ng/view/exportData') }}/' + line + '/' + programnumber + '/' + dies + '/' +
                date;
        }


        function exportDataHarpan() {
            let line = $('#line').val() ? $('#line').val() : 'null';
            let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
            let dies = $('#dies').val() ? $('#dies').val() : 'null';

            // data_month
            let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';

            location.href = '{{ url('/trace/ng/view/exportDataHarpan') }}/' + line + '/' + programnumber + '/' + dies +
                '/' + date;
        }
    </script>
    <script>
        // Lakukan request AJAX untuk mendapatkan data grafik saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/trace/ng/rekap/getDataChart')
                .then(response => {
                    // Pastikan respons adalah JSON yang valid
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Mengupdate grafik dengan data yang diterima
                    myChart.data.labels = data.labelChart;
                    myChart.data.datasets.forEach(dataset => {
                        dataset.data = data.valueChart;
                    });
                    $('#lineChart').text(' Total NG: ' + data.totalLine);
                    // Memperbarui grafik
                    myChart.update();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                });
        });
    </script>
@endsection
