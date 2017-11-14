  @extends('adminlte::layouts.app')

  @section('htmlheader_title')
  {{ trans('adminlte_lang::message.home') }}
  @endsection



  @section('contentheader_title')
    @lang('avicenna/opname.master_pis')
  @endsection

  @section('contentheader_description')
    @lang('avicenna/opname.pis_master')
  @endsection

  @section('main-content')
        <!-- /.box -->

            <!-- <div class="box box-primary"> -->
              <!-- <div class="box-header with-border">
                <h3 class="box-title">@lang('avicenna/opname.pis_master')</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div> 
              </div> -->
              <!-- <form role="form" method="post" action="{{url('/pis/search')}}">
                <input type="hidden" value="{{csrf_token()}}" name="_token">
              <div class="box-body">
                
                <div class="row">
                  <div class="col-xs-4">
                    <label for="exampleInputEmail1">Type</label>
                    <br>
                      <label>
                        <input type="checkbox" class="minimal" name = "oem" value = "OEM" id="">
                        OEM
                      </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="checkbox" class="minimal" name = "gnp" value = "GNP" id="">
                        GNP
                      </label>
                  </div>
                  <div class="col-xs-4">
                    <label for="exampleInputPassword1">Destination</label>
                    <br>
                    <label>
                        <input type="checkbox" class="minimal" name = "dock_4N" value = "4N" id="">
                        Dock 4N
                      </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="checkbox" class="minimal" name = "dock_4L" value = "4L" id="">
                        Dock 4L
                      </label>
                  </div>
                  
                  
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name ="search">
                      <span class="glyphicon glyphicon-search"></span> Search</button>
                </div>
              </div>
              </form> -->
              <!-- /.box-body
            </div> -->

        <div class="box box-primary">
        
              <div class="box-header">
                <h3 class="box-title">Data Master PIS</h3> <br><br>
                <a class = "btn btn-success" href="" data-toggle="modal" data-target="#myModal"><span class=""></span> Add New PIS</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              @if(Session::has('flash_message'))
                      <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
              @endif

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Part No</th>
                    <th>Back No</th>
                    <th>Qty</th>
                    <th>Type</th>
                    <th>Destination</th>
                    <th>Picture</th>
                    <th>Status Picture</th>
                    <th>Edit</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @if(count($avi_part_piss) > 0)
                  @foreach($avi_part_piss as $avp)
                  <tr>
                    <td>{{$avp->part_number_customer}}</td>
                    <td>{{$avp->back_number}}</td>
                    <td>{{$avp->qty_kanban}}</td>
                    <td>{{$avp->part_kind}}</td>
                    <td>{{$avp->part_dock}}</td>
                   
                   
                    <td>
                       
                      <a href="{{ url('pis/preview/'.$avp->img_path) }}" target="_blank" onclick="window.open('{{ url('pis/preview/'.$avp->img_path) }}', 'popup', 'height=540, width=650, top = 120, left= 350 '); return false;">{{$avp->img_path}}</a>
                    </td>
                    <td bgcolor="{{ $avp->validasi == 'Ada' ? 'green' : 'red' }}" align = 'center'><strong><font color="white"> {{$avp->validasi}}</font></strong></td>
                    <td>
                      <a class = "btn btn-primary" href="{{url('/pis/edit/'.$avp->id)}}"><span class="glyphicon glyphicon-edit"></span> </a>
                     <!--  <a class = "btn btn-danger" href="{{url('/pis/delete/'.$avp->id)}}" ><span class="glyphicon glyphicon-trash"></span> </a> -->
                    </td>
                  </tr>

                  @endforeach
                  @endif
                </table>
              </div>
              <!-- /.box-body -->
          </div>
             <!-- /.box -->


      <!-- /.box-body-add-part -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><font face='calibri'><b>CREATE PART</b></font></h4>
                </div>
                      <div class="modal-body">
                      <form role="form" action = "{{ url('pis/add/') }}" method = "post" enctype="multipart/form-data">
                        <!-- <form role="form" action = "{{ url('pis/validasi/') }}" method = "post" enctype="multipart/form-data"> -->
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="img_path" value="{{ $avp->img_path }}">
                          <input type="hidden" name="id" value="{{ $avp->id }}">
                          <div class="box-body">
                            <div class="form-group" id="part_number_show">
                              <label for="exampleInputEmail1">Part Number AIIA</label>
                                <select id="part_number" class="form-control select2" style="width: 100%;" name="part_number" >
                                <option value="" selected="" disabled="" required >Choose Part Number</option>
                                </select>
                            </div>
                            <div class="form-group">
                              <label class="checkbox-inline" for="manual">
                              <input type="checkbox" id="manual" name="manual" value="option1"> Manual Input
                              </label>
                            </div>
                            <div class="form-group" id="hidden_part_no_aiia" for="hidden_part_no_aiia" style="display: none;">
                              <label for="hidden_part_no_aiia">Part Number AIIA</label>
                              <input type="text" class="form-control" id="hidden_part_no_aiia" name = "hidden_part_no_aiia" placeholder="Part Number AIIA" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="form-group" id="hidden_part_name" for="hidden_part_name" style="display: none;">
                              <label for="hidden_part_name">Part Name</label>
                              <input type="text" class="form-control" id="hidden_part_name" name = "hidden_part_name" placeholder="Part Name" onkeyup="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Part Number Customer</label>
                              <input type="text" class="form-control" id="part_number_customer" name = "part_number_customer" placeholder="Part Number Customer" onkeyup="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInput1">Back No</label>
                              <input type="text" class="form-control" id="back_number" name = "back_number" placeholder="Back No" onkeyup="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="form-group" id="hidden_min" for="hidden_min" style="display: none;">
                              <label for="exampleInput1">Min Stock</label>
                              <input type="Number" class="form-control" id="min_stock" name = "min_stock" placeholder="Min Stock" required>
                            </div>
                            <div class="form-group" id="hidden_max" for="hidden_max" style="display: none;">
                              <label for="exampleInput1" id="hidden_max" for="hidden_max">Max Stock</label>
                              <input type="Number" class="form-control" id="max_stock" name = "max_stock" placeholder="Max Stock" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInput1">Qty</label>
                              <input type="Number" class="form-control" id="qty_kanban" name = "qty_kanban" placeholder="Qty" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInput1">Type</label>
                              <select type="text" class="form-control" id="part_kind" name = "part_kind" required>
                                <option value="OEM">OEM</option>
                                <option value="GNP">GNP</option>
                          
                              </select>
                            </div>
                            <div class="form-group" id="part_dock_show">
                              <label for="exampleInput1">Destination</label>
                              <select type="text" class="form-control" id="part_dock" name = "part_dock" placeholder="Destination" required>
                                <option value="43">43</option>
                                <option value="53">53</option>
                                <option value="1L">1L</option>
                                <option value="1N">1N</option>
                                <option value="1S">1S</option>
                                <option value="6I">6I</option>
                                <option value="TAMTAM">TAMTAM</option>
                                <option value="TAMADM">TAMADM</option>
                                <option value="TAMHINO">TAMHINO</option>
                                <option value="OTHER">OTHER</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputFile">Picture (.JPG)</label>
                              <input type="file" id="pis_picture" name = "pis_picture" required>
                            </div> 
                            <div class="col-md-8">
                            <button type="submit" class="btn btn-sm btn-primary" onclick="cekData()" >
                              <span class='glyphicon glyphicon-floppy-saved'></span>&nbsp;
                              <font face='calibri'><b>SAVE</b></font>
                            </button>&nbsp;&nbsp;
                            <button type="reset" class="btn btn-sm btn-danger">
                              <span class='glyphicon glyphicon-repeat'></span>&nbsp;
                              <font face='calibri'><b>RESET</b></font>
                            </button>
                            </div>
                          </div> 
                      </form>
                      </div>
                </div>
          </div>
    </div>
    <!-- /.end-box-body-add-part -->  
  @endsection

  @section('scripts')
  @parent
  <link rel="stylesheet" type="text/css" href="{{url('/css/select2.min.css')}}">
  <script type="text/javascript" src="{{url('/plugins/select2.js')}}"></script>
  <script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/js/dataTables.bootstrap.js')}}"></script>

  <script>
    $(document).ready(function(){
        $('input[type="search"]').removeClass('form-control').removeClass('input-sm');
        $('.dataTables_filter').addClass('pull-right');
        $('.pagination').addClass('pull-right');
    });

    $('table').dataTable({
        "searching": true,
        //hotfix-2.0.4, by Yudo Maryanto, Mengubah paging menjadi 100
        "iDisplayLength": 100
    });
  </script>

  <script type="text/javascript">
  	var pa="";
  	$(document).ready(function() {
  		$("#part_number").select2({
  			ajax:{
          data    : function(params){
  				url			: "{{url('/getajaxpartPis')}}",
  				dataType	: 'json',
  				delay		: 250,
  					return {
  						q		: params.term,
  						page	: params.page
  					};
  				},
  				processResults: function (data) {
  					return {
  						results: $.map(data, function (item) {
  							return {
  								text: item.part_number,
  								id: item.part_number
  							}
  						})
  					};
  				}
  			},
  			minimumresultsForSearch:10,
  			cache	: true,
  			minimumInputLength	: 2,
  		})
  })
  	
  			// alert('test');
  		</script>
      <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script type="text/javascript">
  var pa="";
  $(document).ready(function() {
    $("#part_number").select2({
      ajax:{
        url     : "{{url('/getajaxpartPis')}}",
        dataType  : 'json',
        delay   : 250,
        data    : function(params){
          return {
            q     : params.term,
            page  : params.page
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.part_number,
                id: item.part_number
              }
            })
          };
        }
      },
      minimumresultsForSearch:10,
      cache : true,
      minimumInputLength  : 2,
    })
})
  
      // alert('test');
    </script>
<script>
$(function(){

var manual = $("#manual");
var hidden = $("#hidden");
var hidden_a = $("#hidden_part_no_aiia");
var hidden_b = $("#hidden_part_name");
var hidden_c = $("#hidden_max");
var hidden_d = $("#hidden_min");
var hidden_e = $("#part_number_show");

hidden.hide();
manual.click(function ()
{
    if ($(this).is(":checked"))
    {
        hidden.show();
        hidden_a.show();
        hidden_b.show();
        hidden_c.show();
        hidden_d.show();
        hidden_e.hide();
    }
    else
    {
        hidden.hide();
        hidden_a.hide();
        hidden_b.hide();
        hidden_c.hide();
        hidden_d.hide();
        hidden_e.show();
        
    }              
});
});
</script>

<script>

  function cekData(){
  var part_number_aiia     = $('#hidden_part_no_aiia').val();
  var part_number          = $('#part_number').val();
  var part_number_customer = $('#part_number_customer').val();
  var part_kind            = $('#part_kind').val();
  var part_dock            = $('#part_dock').val();
  var part_name            = $('#hidden_part_name').val();
  var back_number          = $('#back_number').val();
  var min_stock            = $('#min_stock').val();
  var max_stock            = $('#max_stock').val();
  var qty_kanban           = $('#qty_kanban').val();

    $.ajax({
      url     : "{{url('/pis/validasi')}}",
      type    : "get",
      data    : {
        part_number_aiia     : part_number_aiia,
        part_number          : part_number,
        part_number_customer : part_number_customer,
        part_kind            : part_kind,
        part_dock            : part_dock,
        part_name            : part_name,
        back_number          : back_number,
        min_stock            : min_stock,
        max_stock            : max_stock,
        qty_kanban           : qty_kanban,
      },
      success : function(data){
        if (data == "sukses"){
            alert('Sukses Menyimpan Data');
        }else{
            // $("#partnumbercustomer").val('');
            // $("#partdock").val('');
            // $("#partkind").val('');
            // $("#part_number").val('');
            alert('Data Gagal Ditambahkan');
        }
      }
    });
  }
</script>
@endsection
