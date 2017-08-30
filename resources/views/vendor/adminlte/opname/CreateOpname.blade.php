@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Create Stock Opname</h3>
				</div>
				<form role="form" method="post" action="{{url('/saveopname')}}">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Part Number</label>
							<select id="part_number" class="form-control" style="width:100%;" name="part_number" required>
								<option value="" selected="" disabled="">--Choose Part Number--</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Stock Opname</label>
							<input type="number" class="form-control" id="opname_quantity" placeholder="Stock Opname" name="opname_quantity" required>
						</div>
						<input type="hidden" value="{{csrf_token()}}" name="_token">
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-save"></span>
								Save
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>	
	</div>

	@endsection
