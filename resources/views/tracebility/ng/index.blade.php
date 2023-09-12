@extends('adminlte::layouts.app')

@section('htmlheader_title')
NG Data View
@endsection

@section('htmlheader')
@parent
<link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
Tracebility NG Data View
@endsection

@section('contentheader_description')
NG Data Detail
@endsection

@section('main-content')

<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Chart line <span id="lineChart"></span></h3>
        <!-- /.box-header -->
        <div class="box-body">
          
          <canvas id="myChart" style="position: relative; height:30vh; width:80vw"></canvas>
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box-header">
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-lg-3">
              <div class="form-group">
                <label for="exampleInputEmail1">Line</label>
                <select class="form-control" id="line">
                  <option value="null">Pilih Line</option>
                  <option value="DCAA01">DCAA01</option>
                  <option value="DCAA02">DCAA02</option>
                  <option value="DCAA03">DCAA03</option>
                  <option value="DCAA04">DCAA04</option>
                  <option value="DCAA05">DCAA05</option>
                  <option value="DCAA06">DCAA06</option>
                  <option value="DCAA07">DCAA07</option>
                  <option value="DCAA08">DCAA08</option>
                  <option value="MA001">MA001</option>
                  <option value="MA002">MA002</option>
                  <option value="MA003">MA003</option>
                  <option value="MA004">MA004</option>
                  <option value="MA006">MA006</option>
                  <option value="MA007">MA007</option>
                  <option value="MA008">MA008</option>
                  <option value="AS003">AS003</option>
                  <option value="AS004">AS004</option>
                </select>
              </div>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-3">
              <div class="form-group">
                <label for="exampleInputEmail1">Program Number</label>
                <?php
                
                use App\Models\Avicenna\avi_trace_program_number;
                
                $programnumber = avi_trace_program_number::select('code', 'product')->groupBy('code', 'product')->orderBy('code', 'asc')->get(); ?>
                <select class="form-control select2" id="programnumber">
                  <option value="">--pilih--</option>
                  @foreach($programnumber as $val)
                  <option value="{{$val->code}}" id="model">{{$val->product}}</option>
                  @endforeach
                </select>
              </div>
            </div><!-- /.col-lg-6 -->
            {{-- update dies fabian 01162023 --}}
            <div class="col-lg-3">
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
            {{-- update by fabian 12272022 || report excel by month --}}
            <div class="col-lg-3">
              <div class="form-group">
                <div>
                  <label for="keyMonth">
                    <i class='fa fa-calendar'></i>&nbsp;&nbsp;<font face='calibri'><b>Select Month</b></font>
                  </label>
                </div>
                <select class="form-control select2" name="keyMonth" id="keyMonth" style="width: 100%;">
                  @for ($i = 0; $i < 12; $i++)
                  <option value="{{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}">{{ \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->format('Y-m') }}</option>
                  @endfor
                </select>
              </div>
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-4">
              <button type="button" id="btnFilter" class="btn btn-primary" onclick="filterData()">Filter</button>
              <button type="button" id="btnExport" class="btn btn-success" onclick="exportData()"> Export To Excel</button>
              <button type="button" id="btnExport" class="btn btn-success" onclick="exportDataHarpan()"> Export Pak Harpan</button>
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
  //
  let line = $('#line').val() ? $('#line').val() : 'null';
  let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
  let dies = $('#dies').val() ? $('#dies').val() : 'null';

  // data_month
  let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
  
  var table = $('#tabel_all').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ url ("/trace/ng/view/getData") }}/' + line + '/' + programnumber + '/' + dies + '/' + date,
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
      data: 'created_at',
      name: 'created_at'
    },
    {
      data: 'ngdetail.name',
      name: 'ngdetail.name'
    },
    {
      data: 'line',
      name: 'line'
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
    let line = $('#line').val() ? $('#line').val() : 'null';
    let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
    let model = $('#model').text() ? $('#model').text() : 'null';
    let dies = $('#dies').val() ? $('#dies').val() : 'null';

    // data_month
    let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
    myChart.data.labels.splice(0, myChart.data.labels.length);
    myChart.data.datasets[0].data.splice(0, myChart.data.datasets[0].data.length);
    
    table.ajax.url('{{ url ("/trace/ng/view/getData") }}/' + line + '/' + programnumber + '/' + dies + '/' + date).load();
    
    $.ajax({
      type: 'get',
      url: '{{ url ("/trace/ng/view/getDataChart") }}',
      dataType: 'json',
      data: {
        _token: "{{ csrf_token() }}",
        line: line,
        date: date,
        programnumber: programnumber,
        dies: dies,
        // model: model
      },
      success: function(data) {
        console.log(data);
        myChart.data.labels = data.labelChart;
        myChart.data.datasets.forEach(dataset => {
          dataset.data = data.valueChart;
        });
        $('#lineChart').text(data.lineChart + ' Total NG: ' + data.totalLine);
        
        myChart.update();
        
      },
      
    });
    
  }
  
  function exportData() {
    let line = $('#line').val() ? $('#line').val() : 'null';
    let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
    let dies = $('#dies').val() ? $('#dies').val() : 'null';

    // data_month
    let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
    
    location.href = '{{ url ("/trace/ng/view/exportData") }}/' + line + '/' + programnumber + '/' + dies + '/' + date;
  }


  function exportDataHarpan() {
    let line = $('#line').val() ? $('#line').val() : 'null';
    let programnumber = $('#programnumber').val() ? $('#programnumber').val() : 'null';
    let dies = $('#dies').val() ? $('#dies').val() : 'null';

    // data_month
    let date = $('#keyMonth').val() ? $('#keyMonth').val() : 'null';
    
    location.href = '{{ url ("/trace/ng/view/exportDataHarpan") }}/' + line + '/' + programnumber + '/' + dies + '/' + date;
  }
</script>

@endsection