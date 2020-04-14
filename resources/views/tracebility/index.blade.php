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
      <div class="box box-primary" id="torimetron-table" >
          <div class="box-header">
            <h3 class="box-title"> Torimetron detail</h3>
          </div>
          <div class="box-body">
            <table id="table" class="table table-bordered table-striped" style="width: 100%">
              <thead>
                <tr>
                  <td style="width: 20%">AVGT01</td><td style="width: 30%" id="avtg01"></td><td style="width: 20%">AVGT10</td><td style="width: 30%" id="avtg10"></td>
                </tr>
                <tr>
                  <td>AVGT02</td><td id="avtg02"></td><td>AVGT11</td><td id="avtg11"></td>
                </tr>
                <tr>
                  <td>AVGT03</td><td id="avtg03"></td><td>AVGT12</td><td id="avtg12"></td>
                </tr>
                <tr>
                  <td>AVGT04</td><td id="avtg04"></td><td>AVGT13</td><td id="avtg13"></td>
                </tr>
                <tr>
                  <td>AVGT05</td><td id="avtg05"></td><td>AVGT14</td><td id="avtg14"></td>
                </tr>
                <tr>
                  <td>AVGT06</td><td id="avtg06"></td><td>AVGT15</td><td id="avtg15"></td>
                </tr>
                <tr>
                  <td>AVGT07</td><td id="avtg07"></td><td>AVGT16</td><td id="avtg16"></td>
                </tr>
                <tr>
                  <td>AVGT08</td><td id="avtg08"></td><td>AVGT17</td><td id="avtg17"></td>
                </tr>
                <tr>
                  <td>AVGT09</td><td id="avtg09"></td><td>AVGT18</td><td id="avtg18"></td>
                </tr>
              </thead>
            </table>
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
              var mesin1= "DCAA0"+id_product.substr(6, 1);
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
                    $('#dowa-table').show();
                  } else if (data.status == "notfound") {
                    $('#dowa-table').hide();
                  }
                }
              });
            }

    });

    $(document).ready(function () {
    });
</script>

@endsection
