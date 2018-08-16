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
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
        
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">@lang('avicenna/opname.master_pis')</h3>

                <div class="box-tools pull-right">
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
                </div> 
              </div>
              @if(count($avi_part) > 0)
              @foreach($avi_part as $avp)
              <form role="form" action = "{{ url('/updatepart') }}" method = "post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="img_path" value="{{ $avp->img_path }}">
                <input type="hidden" name="id" value="{{ $avp->id }}">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Part Number</label>
                    <input type="text" class="form-control" id="part_number" name = "part_number" placeholder="Part Number" value = "{{ $avp->part_number }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Part Name</label>
                    <input type="text" class="form-control" id="part_name" name = "part_name" placeholder="Part Name" value = "{{$avp->part_name }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Part Number Nostrip</label>
                    <input type="text" class="form-control" id="part_number_nostrip" name = "part_number_nostrip" placeholder="Back No" value = "{{$avp->part_number_nostrip }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Part Number AG</label>
                    <input type="text" class="form-control" id="part_number_ag" name = "part_number_ag" placeholder="Qty" value = "{{$avp->part_number_ag }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Product Group</label>
                    <input type="text" class="form-control" id="product_group" name = "product_group" placeholder="Type" value = "{{$avp->product_group }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Product Line</label>
                    <input type="text" class="form-control" id="product_line" name = "product_line" placeholder="Destination" value = "{{$avp->product_line }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Min Stock</label>
                    <input type="text" class="form-control" id="min_stock" name = "min_stock" placeholder="Destination" value = "{{$avp->min_stock }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInput1">Max Stock</label>
                    <input type="text" class="form-control" id="max_stock" name = "max_stock" placeholder="Destination" value = "{{$avp->max_stock }}">
                  </div>
                  
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name = "submit">Update</button>
                </div>
              </form>
              @endforeach
              @endif
            </div>
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
