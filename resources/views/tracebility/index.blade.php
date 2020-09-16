@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  Jejak para produk
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    <div id="searchform">
                    <label>Input Id Produk:</label>
                    <div>
                        <input type="text" class="form-control pull-right" id="id_product" placeholder="Id produk harus 15 karakter" >
                    </div>
                    <br><br>
                    <button type="button" class="btn btn-success" id="buttonsearch"> Search </button>
                    </div>
                </div>
            </div>

            <div class="box-header">
              <h3 class="box-title">Summary</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_part" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Scanned By</th>
                    <th>Time</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    <div class="box box-primary" id="dowa-table" hidden>
        <div class="box-header">
          <h3 class="box-title">Dowa Proses</h3>
        </div>
        <div class="box-body">
          <table  class="table table-bordered table-striped" style="width: 100%">
            <thead>
              <tr>
                <th>Location</th>
                <th>No Kanban</th>
                <th>Scanned By</th>
                <th>Date</th>
                <th>Time</th>
                <th>Note</th>
              </tr>
            </thead>
            <tr>
              <td>Delivery to Dowa</td>
              <td id="kbn_sup">-</td>
              <td id="npk_delivery_dowa">--</td>
              <td id="date_delivery_dowa">--</td>
              <td id="time_delivery_dowa">--</td>
              <td id="note_delivery_dowa">--</td>
            </tr>
            <tr>
              <td>Dowa Receive</td>
              <td>--</td>
              <td id="npk_receive_dowa">--</td>
              <td id="date_receive_dowa">--</td>
              <td id="time_receive_dowa">--</td>
              <td id="note_receive_dowa">--</td>
            </tr>
            <tr>
              <td>Dowa Send</td>
              <td>--</td>
              <td id="npk_send_dowa">--</td>
              <td id="date_send_dowa">--</td>
              <td id="time_send_dowa">--</td>
              <td id="note_send_dowa">--</td>
            </tr>
            <tr>
              <td>AIIA Torimetron</td>
              <td id="kbn_fg">--</td>
              <td id="npk_torimetron_dowa">--</td>
              <td id="date_torimetron_dowa">--</td>
              <td id="time_torimetron_dowa">--</td>
              <td id="note_torimetron_dowa">--</td>
            </tr>
          </table>
        </div>
    </div>
    </div>
    <div class="col-xs-4">
      <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Produk </h3>
          </div>
          <div class="box-body" id="imageDiv">
          </div>
          <div class="box-body">
            <table id="table" class="table table-bordered table-striped" style="width: 100%">
              <thead>
                <tr>
                  <td style="width: 50% ">Model</td><td id="product"></td>
                </tr>
                <tr>
                  <td>Dies</td><td id="dies"></td>
                </tr>
                <tr>
                  <td>Shot</td><td id="shot"></td>
                </tr>
                <tr>
                  <td>Tonase Mesin</td><td id="tonase_mesin"></td>
                </tr>
                <tr>
                  <td>No Mesin</td><td id="mesin"></td>
                </tr>
                <tr>
                  <td>Shift</td><td id="shift"></td>
                </tr>
                <tr>
                  <td>Cycle</td><td id="cycle"></td>
                </tr>
                <tr>
                  <td>Customer</td><td id="customer"></td>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.box-body -->
      </div>
      <div class="box box-primary" id="torimetron-table" hidden >
          <div class="box-header">
            <h3 class="box-title"> Torimetron detail</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table" class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <td >AVGT01</td>
                    <td id="avgt01"></td>
                    <td >AVGT10</td>
                    <td id="avgt10"></td>
                  </tr>
                  <tr>
                    <td>AVGT02</td><td id="avgt02"></td><td>AVGT11</td><td id="avgt11"></td>
                  </tr>
                  <tr>
                    <td>AVGT03</td><td id="avgt03"></td><td>AVGT12</td><td id="avgt12"></td>
                  </tr>
                  <tr>
                    <td>AVGT04</td><td id="avgt04"></td><td>AVGT13</td><td id="avgt13"></td>
                  </tr>
                  <tr>
                    <td>AVGT05</td><td id="avgt05"></td><td>AVGT14</td><td id="avgt14"></td>
                  </tr>
                  <tr>
                    <td>AVGT06</td><td id="avgt06"></td><td>AVGT15</td><td id="avgt15"></td>
                  </tr>
                  <tr>
                    <td>AVGT07</td><td id="avgt07"></td><td>AVGT16</td><td id="avgt16"></td>
                  </tr>
                  <tr>
                    <td>AVGT08</td><td id="avgt08"></td><td>AVGT17</td><td id="avgt17"></td>
                  </tr>
                  <tr>
                    <td>AVGT09</td><td id="avgt09"></td><td>AVGT18</td><td id="avgt18"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
        <!-- /.box -->
    </div>
</div>
<div class="row">
</div>

@endsection

@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"></script>


<script type="text/javascript">
        var table = $('#tabel_part').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        ajax: '{{ url ("trace/view/part/index") }}',
        columns: [

            {data: 'location', name: 'location'},
            {data: 'date', name: 'date', searchable:false},
            {data: 'npk', name: 'npk', searchable:false},
            {data: 'time', name: 'time', searchable:false},
        ],

    });

    //search
    $('#buttonsearch').on('click', function(e){
      e.preventDefault();
        var id_product = $('#id_product').val();

        var a = id_product.length ;
           if (a < 15 ){
            alert('Id produk yang anda masukan hanya '+a+' karakter, Id produk harus 15 karakter');
           }else if ( a > 15 ) {
            alert('Id produk yang anda masukan sebanyak '+a+' karakter, Id produk hanya boleh 15 karakter saja');
           }else if (id_product == '' ) {
            alert('Isi Id produk');
           }else{
              var prog  = id_product.substr(0, 2);
              var dies  = id_product.substr(2, 2);
              var mesin = id_product.substr(5, 1);
              var shift = id_product.substr(11, 1);
              var mesin1= "DCAA0"+id_product.substr(5, 1);
              if (mesin == "A") {
                var mesin1= "DCAA10";
              }


              if (shift == "A") {
                shift = " Shift 1" ;
              }if (shift == "B") {
                shift = " Shift 2" ;
              }if (shift == "C") {
                shift = " Shift 3" ;
              }

              var shot  = id_product.substr(12, 3);
              document.getElementById("dies").innerHTML  = dies;
              document.getElementById("shot").innerHTML  = shot;
              document.getElementById("mesin").innerHTML = mesin1;
              document.getElementById("shift").innerHTML = shift;

              table.ajax.url("{{ url ('trace/view/part').'/'}}"+id_product).load();

              $.ajax({
                url:"{{ url('trace/view/product').'/'}}"+id_product,
                success:function(data){
                    document.getElementById("product").innerHTML  = data.product;
                    document.getElementById("cycle").innerHTML  = data.cycle;
                    document.getElementById("customer").innerHTML  = data.customer;
                    document.getElementById("tonase_mesin").innerHTML  = data.tonase;
                    $("#imageDiv").html("<img src='"+data.img_path+"' style='width: 100%'/>");
                }
              });

              $.ajax({
                url:"{{ url('trace/view/product/dowa').'/'}}"+id_product,
                success:function(data){
                  if (data.status == "success") {
                    $('#kbn_sup').text(data.data.kbn_sup);
                    $('#npk_delivery_dowa').text(data.data.npk_delivery_dowa);
                    $('#date_delivery_dowa').text(data.data.date_delivery_dowa);
                    $('#time_delivery_dowa').text(data.data.time_delivery_dowa);
                    $('#note_delivery_dowa').text(data.data.note_delivery_dowa);
                    $('#npk_receive_dowa').text(data.data.npk_receive_dowa);
                    $('#date_receive_dowa').text(data.data.date_receive_dowa);
                    $('#time_receive_dowa').text(data.data.time_receive_dowa);
                    $('#note_receive_dowa').text(data.data.note_receive_dowa);
                    $('#npk_send_dowa').text(data.data.npk_send_dowa);
                    $('#date_send_dowa').text(data.data.date_send_dowa);
                    $('#time_send_dowa').text(data.data.time_send_dowa);
                    $('#note_send_dowa').text(data.data.note_send_dowa);
                    $('#kbn_fg').text(data.data.kbn_fg);
                    $('#npk_torimetron_dowa').text(data.data.npk_torimetron_dowa);
                    $('#date_torimetron_dowa').text(data.data.date_torimetron_dowa);
                    $('#time_torimetron_dowa').text(data.data.time_torimetron_dowa);
                    $('#note_torimetron_dowa').text(data.data.note_torimetron_dowa);
                    $('#avgt01').text(data.data.avgt01);
                    $('#avgt02').text(data.data.avgt02);
                    $('#avgt03').text(data.data.avgt03);
                    $('#avgt04').text(data.data.avgt04);
                    $('#avgt05').text(data.data.avgt05);
                    $('#avgt06').text(data.data.avgt06);
                    $('#avgt07').text(data.data.avgt07);
                    $('#avgt08').text(data.data.avgt08);
                    $('#avgt09').text(data.data.avgt09);
                    $('#avgt10').text(data.data.avgt10);
                    $('#avgt11').text(data.data.avgt11);
                    $('#avgt12').text(data.data.avgt12);
                    $('#avgt13').text(data.data.avgt13);
                    $('#avgt14').text(data.data.avgt14);
                    $('#avgt15').text(data.data.avgt15);
                    $('#avgt16').text(data.data.avgt16);
                    $('#avgt17').text(data.data.avgt17);
                    $('#avgt18').text(data.data.avgt18);
                    $('#dowa-table').show();
                    $('#torimetron-table').show();
                  } else if (data.status == "notfound") {
                    $('#dowa-table').hide();
                    $('#torimetron-table').hide();
                  }
                }
              });
            }

    });

    $(document).ready(function () {
    });
</script>

@endsection
