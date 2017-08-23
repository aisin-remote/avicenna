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
					<h3 class="box-title">Ini Opname 1. Di dalam Vendor</h3>
				</div>
				<form role="form">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Part Numeber</label>
							<select id="part_no" class="form-control" style="width:100%;">
								<option value="1">Satu</option>
								<option value="2">Dua</option>
								<option value="3">Tiga</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Stock Opname</label>
							<input type="number" class="form-control" id="opname" placeholder="Stock Opname">
						</div>
						
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