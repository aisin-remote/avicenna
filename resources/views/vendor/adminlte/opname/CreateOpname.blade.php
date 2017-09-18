@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{url('/css/select2.min.css')}}">
@endsection

@section('contentheader_title')
  @lang('avicenna/opname.default_title')
@endsection

@section('contentheader_description')
  @lang('avicenna/opname.sto_entry_desc')
@endsection

@section('main-content')
      <!-- /.box -->

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@lang('avicenna/opname.sto_entry_box')</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
              </div>
            </div>
            <form role="form" method="post" action="{{url('/saveopname')}}">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-4">
                  <label for="exampleInputEmail1">@lang('avicenna/pis.part_numb')</label>
                    <select id="part_number" class="form-control select2" style="width: 100%;" name="part_number" required>
                    <option value="" selected="" disabled="" required>--Choose Part Number--</option>
                    </select>
                </div>
                <div class="col-xs-4">
                  <label for="exampleInputPassword1">@lang('avicenna/opname.stock_opname')</label>
                  <input type="number" class="form-control" id="opname_quantity" placeholder="Stock Opname" name="opname_quantity"required>
                </div>
                <input type="hidden" value="{{csrf_token()}}" name="_token">
                <div class="col-xs-4">
                  <label for="exampleInputEmail1">@lang('avicenna/opname.location')</label>
                    <select id="location" class="form-control select2" style="width: 100%;" name="location" required>
                    <option value="" selected="" disabled="" required>--Choose Location--</option>
                    @if(count($locations)>0)
                    @foreach($locations as $location)
                    <option value="{{$location->code}}">{{$location->code}}</option>
                    @endforeach
                    @endif
                    </select>
                </div>
              </div>
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-save"></span>@lang('avicenna/opname.save')</button>
              </div>
            </div>
            </form>
            <!-- /.box-body -->
          </div>

      <div class="box box-primary">
      
            <div class="box-header">
              <h3 class="box-title">@lang('avicenna/opname.table_opname')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
                </tr>
                   <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.0
                  </td>
                  <td>Win 95+</td>
                  <td>5</td>
                  <td>C</td>
                </tr>

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
		@endsection
