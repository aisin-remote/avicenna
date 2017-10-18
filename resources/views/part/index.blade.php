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
                <h3 class="box-title">Data Master PARTS</h3> <br> <br>
                <a class = "btn btn-success" href="" data-toggle="modal" data-target="#myModal"><span class=""></span> Add New Part</a>
              </div>
               
              <!-- /.box-header -->
              <div class="box-body">

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Part No</th>
                    <th>Part No AG</th>
                    <th>Part Name</th>
                    <th>Product Group</th>
                    <th>Product Line</th>
                    <th>Min Stock</th>
                    <th>Max Stock</th>
                    <th>Edit</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(count($avi_part_piss) > 0)
                  @foreach($avi_part_piss as $avp)
                  <tr>
                    <td>{{$avp->part_number}}</td>
                    <td>{{$avp->part_number_ag}}</td>
                    <td>{{$avp->part_name}}</td>
                    <td>{{$avp->product_group}}</td>
                    <td>{{$avp->product_line}}</td>
                    <td>{{$avp->min_stock}}</td>
                    <td>{{$avp->max_stock}}</td>
                    <td>
                      <a class = "btn btn-primary" href="{{url('/part/edit/'.$avp->id)}}"><span class="glyphicon glyphicon-edit"></span> </a>
                     
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
                    <h4 class="modal-title"><font face='calibri'><b>CREATE PART</b></font></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" enctype='multipart/form-data' method="POST" action="{{ url('/part/master') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
              <div class="col-md-4">
                <font face='calibri'><b>Part Number</b></font><br/>
                <input type="text" class="form-control" name="part_number" id="back_number">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8">
                <font face='calibri'><b>Part Number Nostrip</b></font><br/>
                <input type="text" class="form-control" name="part_number_nostrip" id="part_number_nostrip" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8">
                <font face='calibri'><b>Part Number AG</b></font><br/>
                <input type="text" class="form-control" name="part_number_ag" id="part_number_ag" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8">
                <font face='calibri'><b>Part Name</b></font><br/>
                <input type="text" class="form-control" name="part_name" id="part_name" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8">
                <font face='calibri'><b>Product Group</b></font><br/>
                <input type="text" class="form-control" name="product_group" id="product_group" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-3">
                <font face='calibri'><b>Product Line</b></font><br/>
                  <input type='text' class="form-control" name="product_line" id="product_line" >
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-3">
                <font face='calibri'><b>Min Stock</b></font><br/>
                  <input type='text' class="form-control" name="min_stock" id="min_stock" >
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-3">
                <font face='calibri'><b>Max Stock</b></font><br/>
                  <input type='text' class="form-control" name="max_stock" id="max_stock" >
              </div>
            </div>

            <div class="form-group">
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
  				url			: "{{url('/getajaxpart')}}",
  				dataType	: 'json',
  				delay		: 250,
  				data 	 	: function(params){
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
