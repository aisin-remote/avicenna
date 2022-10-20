@extends('adminlte::layouts.app')

@section('htmlheader_title')
OK Data View
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility OK Data View
@endsection

@section('contentheader_description')
  OK Data Detail
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Chart line <span id="lineChart"></span></h3>
                <!-- /.box-header -->
                <div class="box-body" >

                  <canvas id="myChart" style="position: relative; height:30vh; width:80vw"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box-header">
                <!-- /.box-header -->
                <div class="box-body" >

                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Area</label>
                        <select class="form-control" id="area">
                          <option value="casting">Casting</option>
                          <option value="machining">Machining</option>
                          <option value="assembling">Assembling</option>
                        </select>
                      </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Start Date</label>
                        <input type="date" class="form-control" id="start_date" placeholder="Start Date">
                      </div>
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="exampleInputEmail1">End Date</label>
                        <input type="date" class="form-control" id="end_date" placeholder="End Date">
                      </div>
                    </div><!-- /.col-lg-6 -->
                  </div><!-- /.row -->
                  <div class="row">
                    <div class="col-lg-4">
                      <button type="button" id="btnFilter" class="btn btn-primary" onclick="filterData()">Filter</button>
                      <button type="button" id="btnExport" class="btn btn-success" onclick="exportData()"> Export To Excel</button>
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
                <h3 class="box-title">List Product Today</h3>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tabel_all" class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Part Code</th>
                        <th>Date</th>
                        <th>NG Name</th>
                        <th>Line</th>
                        <th>PIC</th>
                      </tr>
                    </thead>
                  </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
    // Chart
    const ctx = $('#myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Line',
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
    //
    let line = $('#line').val() ? $('#line').val() : 'null' ;
    let start_date = $('#start_date').val() ? $('#start_date').val() : 'null' ;
    let end_date = $('#end_date').val() ? $('#end_date').val() : 'null' ;

    var table = $('#tabel_all').DataTable({
      processing: true,
      serverSide: true,
      ajax : '{{ url ("/trace/ok/view/getData") }}/'+ line + '/' + start_date + '/' + end_date,
      columns: [
        {data: null, name: 'no', orderable: false, searchable: false, render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
        }},
        {data: 'code', name: 'code'},
        {data: 'created_at', name: 'created_at'},
        {data: 'ngdetail.name', name: 'ngdetail.name'},
        {data: 'line', name: 'line'},
        {data: 'pic', name: 'pic'},
      ],
      language: {
        search: "Search :"
      },
    });

    function filterData() {

      let area = $('#area').val() ? $('#area').val() : 'casting' ;
      let start_date = $('#start_date').val() ? $('#start_date').val() : 'null' ;
      let end_date = $('#end_date').val() ? $('#end_date').val() : 'null' ;

      myChart.data.labels.splice(0, myChart.data.labels.length);
      myChart.data.datasets[0].data.splice(0, myChart.data.datasets[0].data.length);

      table.ajax.url('{{ url ("/trace/ok/view/getData") }}/'+ area + '/' + start_date + '/' + end_date).load();
      console.log(area);
      $.ajax({
            type: 'post',
            url: '{{ url ("/trace/ok/view/getDataChart") }}',
            dataType: 'json',
              data: {
                _token: "{{ csrf_token() }}",
                area : area,
                start_date : start_date,
                end_date : end_date
              } ,
            success: function (data) {
              myChart.data.labels = data.labelChart;
              myChart.data.datasets.forEach(dataset => {
                dataset.data = data.valueChart;
              });
              $('#lineChart').text(data.lineChart);
              myChart.update();

            },

          });

      }

      function exportData() {
        let line = $('#line').val() ? $('#line').val() : 'null' ;
        let start_date = $('#start_date').val() ? $('#start_date').val() : 'null' ;
        let end_date = $('#end_date').val() ? $('#end_date').val() : 'null' ;
        location.href = '{{ url ("/trace/ok/view/exportData") }}/'+ line + '/' + start_date + '/' + end_date;
      }


</script>

@endsection
