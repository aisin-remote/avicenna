  @extends('adminlte::layouts.app')

  @section('htmlheader_title')
  {{ trans('adminlte_lang::message.home') }}
  @endsection



  @section('contentheader_title')
    @lang('avicenna/opname.default_title')
  @endsection

  @section('contentheader_description')
    @lang('avicenna/opname.pis_master')
  @endsection

  @section('main-content')
        <!-- /.box -->

            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">@lang('avicenna/opname.pis_master')</h3>

                <div class="box-tools pull-right">
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
                </div> 
              </div>
              <form role="form" method="post" action="{{url('/saveopname')}}">
              <div class="box-body">
                
                <div class="row">
                  <div class="col-xs-4">
                    <label for="exampleInputEmail1">Type</label>
                    <br>
                      <label>
                        <input type="checkbox" class="minimal" name = "" id="">
                        OEM
                      </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="checkbox" class="minimal" name = "" id="">
                        GNP
                      </label>
                  </div>
                  <div class="col-xs-4">
                    <label for="exampleInputPassword1">Destination</label>
                    <br>
                    <label>
                        <input type="checkbox" class="minimal" name = "" id="">
                        Dock 4N
                      </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="checkbox" class="minimal" name = "" id="">
                        Dock 4L
                      </label>
                  </div>
                  <input type="hidden" value="{{csrf_token()}}" name="_token">
                  
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                      <span class="glyphicon glyphicon-search"></span> Search</button>
                </div>
              </div>
              </form>
              <!-- /.box-body -->
            </div>

        <div class="box box-primary">
        
              <div class="box-header">
                <h3 class="box-title">Data Master PIS</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Part No</th>
                    <th>Type</th>
                    <th>Destination</th>
                    <th>Path</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @if(count($avi_part_piss) > 0)
                  @foreach($avi_part_piss as $avp)
                  <tr>
                    <td>{{$avp->part_number}}</td>
                    <td>{{$avp->part_kind}}</td>
                    <td>{{$avp->part_dock}}</td>
                    <td><!-- {{$avp->part_number}} --><a href="/pis/preview/{{$avp->link}}">klik</a></td>
                    
                  </tr>
                  @endforeach
                  @endif
                </table>
              </div>
              <!-- /.box-body -->
          </div>
             <!-- /.box -->
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
