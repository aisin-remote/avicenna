@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <div id="line" class="panel panel-default" >

                <span style="font-size : 50px "> <center> RESET KANBAN PART NG </span>
                <span style="font-size : 30px "> <center> PT AISIN INDONESIA AUTOMOTIVE </center> </span>
            </div>
        </div>		
	</div>

		<div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">SCAN KANBAN</div>
                    <div class="panel-body" style="height:110px;">
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                    <input height=60 id="scan" class="form-control" name="input" required >
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="col-md-8">
            <div id="alert" class="alert alert-{{ session('message')['type'] ? session('message')['type'] : 'success' }}">
                <h4><div id="alert-header"> <i class="icon fa fa-check"></i>SCAN KANBAN</div></h4>
                <div id="alert-body" style="font-size : 51px; text-align: center; ">{{ session('message')['text'] ? session('message')['text'] : ' ' }}</div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">TOTAL SCAN</div>
                <div class="panel-body" style="height:110px;">
                    <div class="form-group">
                        <table id="data_table" class="table table-bordered responsive-utilities jambo_table">
                            <tbody>
                                <tr>
                                    <td align="center" height=60>
                                        <font size=35><div id="counter">0</div></font></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <!-- last scan -->
            <div class="panel panel-default" id="table_hide">
                <div class="panel-heading">LAST SCAN</div>
                <div class="panel-body">
                    <div class="form-group">
                        <table  id="data" class="table table-bordered responsive-utilities jambo_table">
                            <thead>
                                <tr>
                                    <th>CODE</th> <th>PRODUCT</th> <th>MODEL</th> <th>NPK</th>  <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end last scan -->
        </div>
    </div>
</div>
<div id="modalLineScan" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><strong>Scan Barcode Line</strong></h4>
            </div>
        <div class="modal-body">
            <h3 class="text-warning text-center"><b>Scan Barcode Line Untuk Melanjutkan</b></h3>
            <br>
            <input type="text" class="form-control" id="input-line">
            <br>
        </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection