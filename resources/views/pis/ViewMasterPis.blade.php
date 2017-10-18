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
          <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><font face='calibri'><b>CREATE PIS</b></font></h4>
                </div>
                <div class="modal-body">
          <form role="form" action = "{{ url('pis/add/') }}" method = "post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="img_path" value="{{ $avp->img_path }}">
                <input type="hidden" name="id" value="{{ $avp->id }}">
                <div class="box-body">
                  <div class="form-group">
                    <input type="text" class="form-control" id="part_number" name = "part_number" placeholder="Part Number" value = "{{ $avp->part_number }}">
                    <label for="exampleInputEmail1">Part Number Customer</label>
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Part Name</label>
                    <input type="text" class="form-control" id="part_name" name = "part_name" placeholder="Part Name" value = "{{$avp->part_name }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Back No</label>
                    <input type="text" class="form-control" id="exampleInput1" name = "back_no" placeholder="Back No" value = "{{$avp->back_number }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Qty</label>
                    <input type="text" class="form-control" id="qty" name = "qty" placeholder="Qty" value = "{{$avp->qty_kanban }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Type</label>
                    <input type="text" class="form-control" id="type" name = "type" placeholder="Type" value = "{{$avp->part_kind }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Destination</label>
                    <input type="text" class="form-control" id="part_dock" name = "part_dock" placeholder="Destination" value = "{{$avp->part_dock }}">
                  </div>
                  
                </div>
                <div class="col-md-8">
                <button type="submit" class="btn btn-sm btn-primary">
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
  @endsection

  @section('scripts')
  @parent
  <script type="text/javascript" src="{{url('/plugins/select2.js')}}"></script>
  <script type="text/javascript">
  	var pa="";
  	$(document).ready(function() {
  		$("#part_number").select2({
  			ajax:{
          data    : function(params){
  				url			: "{{url('/getajaxpart')}}",
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
  		@endsection
