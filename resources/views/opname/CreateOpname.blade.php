@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ __('pesan.tes')}}
@endsection


@section('main-content')
<link rel="stylesheet" type="text/css" href="{{asset('/plugins/select2.css')}}">
<!-- <script type="text/javascript" src="{{asset('/plugins/jquery-2.2.3.min.js')}}"></script> -->
<!-- <script type="text/javascript" src="{{asset('/plugins/select2.js')}}"></script> -->
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Ini Opname 2. Diluar Vendor</h3>
				</div>
				<form role="form">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="exampleInputFile">File input</label>
							<input type="file" id="exampleInputFile">

							<p class="help-block">Example block-level help text here.</p>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox"> Check me out
							</label>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
@endsection