<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Andon Charts</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap-5.css') }}">
 </head>
<body class="bg-light">
  {{-- <style>
    .apexcharts-tooltip {
      opacity: 1 !important;
    }
  </style> --}}
  <div class="container-fluid bg-success shadow">
    <nav class="navbar bg-success h-100 shadow-sm">
      <div class="container-fluid">
        <a class="navbar-brand p-1 px-3 bg-white rounded fs-4 fw-bold text-success fs-3" href="#">AWAS</a>
        <span class="text-white fw-semibold fs-3"><i class="fa-brands fa-whatsapp"></i> ANDON WHATSAPP ALERT SYSTEM</span>
      </div>
    </nav>
  </div>
  
  <div class="container-fluid bg-white mt-3 rounded px-3 py-2 shadow">
    {{-- <div class="row m-2 w-50">
      <div class="col-3 p-0 me-1">
        <form method="POST" action="{{ route('direct.filter') }}">
          {{ csrf_field() }}
          <label for="start" class="form-label fw-semibold">Start Date</label>
          <input type="date" id="from" name="from" class="form-control">
        </div>
        <div class="col-3 p-0 me-1">
          <label for="end" class="form-label fw-semibold">End Date</label>
          <input type="date" id="to" name="to" class="form-control">
        </div>
        <div class="col-1 p-0 align-self-end">
          <button type="submit" name="search" class="btn btn-success "><i class="fa-solid fa-filter"></i></button>
        </form>
      </div>
    </div> --}}
    <h3 class="h3 text-center bg-white rounded p-1 m-2">Showing Data from {{ $start }} to {{ $end }}</h3>
    <div class="row">
      <div class="col-md-4 text-center">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12 text-center">
                <div class="mt-3" id="solvedThisTime"></div>
              </div>
            </div>
            <table class="mt-5 table border">
              <tr>
                <td class="fw-semibold table-success align-middle">Solved</td>
                <td class="fs-4 fw-semibold">{{ $solved }} ({{ $percentageSolved }}%)</td>
              </tr>
              <tr>
                <td class="fw-semibold table-danger align-middle">Unsolved</td>
                <td class="fs-4 fw-semibold">{{ $unsolved }} ({{ $percentageUnsolved }}%)</td>
              </tr>
            </table>
            <h5 class="card-title">Solved & Unsolved Rate</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="card">
          <div class="mt-4" id="problemCount"></div>
          <div class="card-body">
            <table class="mt-3 table border">
              {{-- <thead>
                <th class="table-secondary"></th>
                <th class="table-danger">Problem Machine</th>
                <th class="table-warning">Problem Quality</th>
                <th class="table-success">Problem Supply Part</th>
              </thead> --}}
              <tbody>
                <tr>
                  <td class="fw-semibold">Total</td>
                  <td class="table-danger fs-5 fw-semibold">{{ $type2 }}</td>
                  <td class="table-warning fs-5 fw-semibold">{{ $type3 }}</td>
                  <td class="table-success fs-5 fw-semibold">{{ $type4 }}</td>
                </tr> 
                <tr>
                  <td class="fw-semibold">Avg Time</td>
                  <td class="table-danger fs-5 fw-semibold">{{ $avgMin2 }}</td>
                  <td class="table-warning fs-5 fw-semibold">{{ $avgMin3 }}</td>
                  <td class="table-success fs-5 fw-semibold">{{ $avgMin4 }}</td> 
                </tr>
              </tbody>
            </table>
            <h5 class="card-title">Total Problem PerType</h5> 
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="card">
          <div class="card-body">
            <h4 class="text-center">Torimetron</h4>
            <div class="row text-center">
              <div id="ngToday"></div>
              <h5 class="card-title">Today NG Count</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <script src="{{ asset('js/apexcharts.js') }}"></script>
  <script src="{{ asset('js/jquery.js') }}" ></script>
  <script type="text/javascript">
    var solveRate = {
      series: [{{ $solved }}, {{ $unsolved }}],
      chart: {
        width: 404,
        type: 'donut',
      },
      colors: ['#198754', '#dc3545'],
      labels: ['Solved', 'Unsolved'],
      plotOptions: {
        pie: {
          expandOnClick: true,
          donut: {
            size: '55%',
            labels: {
              show: true,
              total: {
                show: true,
                showAlways: true,
                label: 'Total Problem',
              },
              value: {
                show: true,
                fontWeight: 'bold', 
              }
            }
          }
        }
      },
      responsive: [{
        breakpoint: 1192,
        options: {
          chart: {
            width: 400,
          },
          legend: {
            position: 'bottom'
          }
        }
      }],
      dataLabels: {
        enabled: true,
        style: {
          fontSize: '18px',
          fontWeight: 'bold',
        }
      }
    };
    
    var lastMonth = {
      series: [{{ $prevSolved }}, {{ $prevUnsolved }}],
      chart: {
        width: 250, //320
        type: 'pie',
      },
      colors: ['#198754', '#dc3545'],
      labels: ['Solved', 'Unsolved'],
      responsive: [{
        breakpoint: 1366,
        options: {
          chart: {
            width: 150
          },
          legend: {
            show: false
          }
        }
      }],
      dataLabels: {
        enabled: true
      }
    };
    
    var averageAndon = {
      series: [
      {
        name: 'Total Problem',
        data: [
        {
          x: 'Problem Machine',
          y: {{ $type2 }},
          fillColor: '#dc3545',
          goals: [
          {
            name: 'Avg Time: ',
            value: {{ $avgType2 }},
            strokeHeight: 5,
            strokeColor: '#6610f2'
          }
          ]
        },
        {
          x: 'Problem Quality',
          y: {{ $type3 }},
          fillColor: '#ffc107',
          goals: [
          {
            name: 'Avg Time: ',
            value: {{ $avgType3 }},
            strokeHeight: 5,
            strokeColor: '#6610f2'
          }
          ]
        },
        {
          x: 'Problem Supply Part',
          y: {{ $type4 }},
          fillColor: '#198754',
          goals: [
          {
            name: 'Avg Time: ',
            value: {{ $avgType4 }},
            strokeHeight: 5,
            strokeColor: '#6610f2'
          }
          ]
        }
        ]
      }
      ],
      chart: {
        height: 300,
        type: 'bar'
      },
      plotOptions: {
        bar: {
          columnWidth: '60%'
        }
      },
      colors: ['#00E396'],
      dataLabels: {
        enabled: false
      },
      legend: {
        show: true,
        showForSingleSeries: true,
        customLegendItems: ['Average Time to Solve (in seconds)'],
        markers: {
          fillColors: [ '#6610f2']
        }
      }
    };
    
    var ngToday = {
      series: [{{ $notNgToday }}, {{ $ngToday }}],
      chart: {
        width: 317,
        type: 'donut',
      },
      colors: ['#198754', '#dc3545'],
      labels: ['Good', 'NG'],
      plotOptions: {
        pie: {
          expandOnClick: true,
          donut: {
            size: '55%',
            labels: {
              show: true,
              total: {
                show: true,
                showAlways: true,
                label: 'Total Product',
                fontSize: '12px'
              },
              value: {
                show: true,
                fontSize: '14px',
                fontWeight: 'bold'
              }
            }
          }
        }
      },
      responsive: [{
        breakpoint: 1192,
        options: {
          chart: {
            width: 400,
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };
    
    
    var chart1 = new ApexCharts(document.querySelector("#problemCount"), averageAndon);
    chart1.render();
    
    var chart2 = new ApexCharts(document.querySelector("#solvedThisTime"), solveRate);
    chart2.render();
    
    var chart4 = new ApexCharts(document.querySelector("#ngToday"), ngToday);
    chart4.render();
    
    function date_time(id) {
      date = new Date;
      year = date.getFullYear();
      month = date.getMonth();
      months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');
      d = date.getDate();
      day = date.getDay();
      days = new Array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');
      h = date.getHours();
      if(h<10)
      {
        h = "0"+h;
      }
      m = date.getMinutes();
      if(m<10)
      {
        m = "0"+m;
      }
      s = date.getSeconds();
      if(s<10)
      {
        s = "0"+s;
      }
      result = ''+days[day]+', '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
      
      var elems = document.getElementsByClassName(id);
      for(var i = 0; i < elems.length; i++) {
        elems[i].innerHTML = result;
      }
      setTimeout('date_time("'+id+'");','1000');
      
      return true;
    }
    $(document).ready(function(){
      date_time('jam');
      // Start an interval to go to the "next" page every 10 seconds
      setInterval(function(){
        location.reload();
      }, 10000); // 10 seconds
      
    });
    
  </script>
</body>
</html>