@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/plugins/daterangepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  LIST PRODUCT
@endsection

@section('main-content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List Product Today</h3>
                <br><br>
                <div>
                  <label>Start Date:</label>
                  <div class="input-group">
                  <div class='input-group-addon'>
                    <select id="myselect" name="myselect" onchange="checkList()">
                      <option value="all" id="all" selected="selected">ALL</option>
                      <option value="casting" id="casting">Casting</option>
                      <option value="machining" id="machining">Machining</option>
                      <option value="pulling" id="pulling">Pulling</option>
                    </select>  
                  </div>
                  </div>
              <div> <br>
              <!-- <button type="button" class="btn btn-success" id="buttonfilter"> Filter </button> -->
          <!-- /.input group -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_part" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Part Code</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Back Number</th>
                    <th>Date Scan</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

</div>

@endsection

@section('scripts')
@parent
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet" id="bootstrap-css">
<script type="text/javascript" src="{{ asset('/js/handlebars.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


<script type="text/javascript">
    // {{-- dev-1.0.0, Handika, 20180703, datatable filter --}}

    // function func1()
    // {
    //   if(document.getElementById('myselect').value == "machining") {
    //     var table = $('#tabel_part').DataTable({
    //       processing: true,
    //       serverSide: true,
    //       searching: false,
    //       paging: false,
    //       ajax: '{{ url ("/trace/view/list/machining") }}',
    //       columns: [
    //         {data: 'no', name: 'no'},
    //         {data: 'code', name: 'code', searchable:false},
    //         {data: 'part_number', name: 'part_number', searchable:false},
    //         {data: 'part_name', name: 'part_name', searchable:false},
    //         {data: 'back_number', name: 'back_number', searchable:false},
    //         {data: 'created_at', name: 'created_at', searchable:false},
    //       ],
    //     });
    //   }else if(document.getElementById('myselect').value == "machining"){
    //     // table.ajax.url("/trace/view/list/machining").load(); 
    //     table.ajax.url("{{ url('/trace/view/list/machining')}}").load(); 
    //   }
    // }
    var table = $('#tabel_part').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        ajax: '{{ url ("/trace/view/list/casting") }}',
        columns: [
          {data: 'no', name: 'no'},
          {data: 'code', name: 'code', searchable:false},
          {data: 'part_number', name: 'part_number', searchable:false},
          {data: 'part_name', name: 'part_name', searchable:false},
          {data: 'back_number', name: 'back_number', searchable:false},
          {data: 'created_at', name: 'created_at', searchable:false},
        ],
      });

    

    function checkList(){
      var dropdown = document.getElementById('myselect').value;
      // console.log(document.getElementById('myselect').value);
      // alert(dropdown);
      table.ajax.url( "{{ url('/trace/view/list/') }}/"+dropdown ).load();

      
    }

    // $(document).ready(function(){
    //   $("myselect").on("change", function(){
    //     if(document.getElementById('myselect').value == "machining") {
    //       table.ajax.url("{{ url('/trace/view/list/machining')}}").load(); 
    //     }
    //   })
    // })

    

    
    
      
    


    // function func1(e){
    //   e.preventDefault();
    //   if(document.getElementById('myselect').value == "machining") {
    //     table.ajax.url("/trace/view/list/machining").load(); 
    //   }
    // }    
    // $('#buttonfilter').on('click', function(e){
    //   e.preventDefault();
    //   var date = $('#date').val();
    //   table.ajax.url("{{ url('/trace/view/delivered/filter').'/'}}"+date).load();      
    // });
    // $('.date').datepicker({
    //   autoclose: true,
    //   format: 'yyyy-mm-dd'
    // });
</script>

@endsection
