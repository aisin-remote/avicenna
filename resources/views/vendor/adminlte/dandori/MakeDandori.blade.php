@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
      <div class="panel-heading"><b>DANDORI MODEL</b>
          <a href="javascript:openModal();"  class="btn btn-default pull-right"><i class="icon fa fa-bars"></i></a>
          <div class="clearfix"></div>
        </div>
        <div class="panel-body">
        <div class="row">
          <div class="col-md-10">
            <span class="border border-default">
              <div class="img-dandori"></div>
              <br/><br/><br/>
            </span>
          </div>
          <div class="col-md-2">
            <br/><br/><br/>
          </div>
        </div>
        </div>
      </div>
    </div>
    <div class="col-md-1">
    </div>
  </div>

  {{-- Modal Loading --}}
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:800px;">
      <div class="modal-content">
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
          <center><h3>MENU DANDORI</h3></center>
          <hr/>
          <center>
            <?php $i=0?>
            @foreach($models as $model)
            <button class="btn btn-default btn-model" id="{{$model->back_number}}" style="margin-right:10px;width:150px;" onclick="ShowButtonControl(this.id)">
              <h2>{{$model->back_number}}</h2>
            </button>
            <?php 
            $i++;
            if($i==4){
              echo"<br/><br/>";
              $i=0;
            }
            ?>
            @endforeach
          </center>
          <hr/>          
          <div class="row">
            <div class="col-md-6">
              <h4><b>Jumlah NG Sebelum Dandori</b></h4>
              <input class="keyboard form-control input-lg" id="input-ng" type="text" placeholder="Jumlah NG Sebelum Dandori">
            </div>
            <div class="col-md-6">
              <h4><b>Jumlah Seteuchi Sebelum Dandori</b></h4>
              <input class="keyboard form-control input-lg" id="input-seteuchi" type="text" placeholder="Jumlah Seteuchi Sebelum Dandori">
            </div>
          </div>
          <hr/>
          <div class="row" id="control-button" hidden>
            <div class="col-md-6">
              <center>
                <button class="btn btn-warning"  style="width:350px;" id="start" onclick="Simpan(this.id)"><h4>Awal Shift</h4></button>
              </center>
            </div>
            <div class="col-md-6">
              <center>
                <button class="btn btn-success" style="width:350px;" id="change" onclick="Simpan(this.id)"><h4>Tengah Shift</h4></button>
              </center>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection

@section('scripts')
@parent
<link href="{{ asset ('/plugins/jqbtk/jqbtk.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset ('css/all.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('/plugins/jqbtk/jqbtk.min.js')}}"></script>
<script type="text/javascript">
  var qty=0;
  var is_start=false;
  var back_number='';
  var qty_ng=0;
  var qty_seteuchi=0;
  var dandori = $('#img-dandori');
  var modal = $('myModal');

    // $(document).ready(function(){
    //    setInterval(function(){
    //     GetQuantity();
    //    },3000);
    // });
$('#input-seteuchi').keyboard({type:'numpad'});;
$('#input-ng').keyboard({type:'numpad'});;
function ShowButtonControl(id){
  $('#control-button').show();
  $('.btn-model').removeClass('btn-primary');
  $('#'+id).addClass('btn-primary');
  back_number=id;
}

function Simpan(id){
  // $('#loading').show();
  // $('#btn-dandori-start').attr('disabled','disabled');
  // $('#btn-dandori-change').attr('disabled','disabled');
  if(id=='start'){
      is_start=true;
  }else{
      is_start=false;
  }
  if($('#input-ng').val().length >0){
    qty_ng=$('#input-ng').val();
  }
  if($('#input-seteuchi').val().length >0){
    qty_seteuchi=$('#input-seteuchi').val();
  }
  $.ajax({
    url: "{{url('/dandori/make')}}",
    method :'POST',
    data: {
      back_number:back_number,
      _token: "{{csrf_token()}}",
      is_start:is_start,
      line_number:'{{$line_number}}',
      qty_seteuchi:qty_seteuchi,
      qty_ng:qty_ng
    },
    success: function(data){
      // if(data.)
      closeModal();
      dandori.html("<img src='"+data.img_path+"' width='990px' height='560px' />");
      // if(data.type=="success"){
      //   // alert(data.message);
        
      //   dandori.html("<img src='"+data.img_path+"' width='990px' height='560px' />");
      //   modal.modal('hide');
      // }else{
      //  // alert(data.message);
      //  modal.modal('hide'); 
      // }
      
      // alert(data.type);
    }
  });

        // if(id=='btn-dandori-start'){
        //     is_start=true;
        // }else{
        //     is_start=false;
        // }
        // $.ajax({
        //   url: "{{url('/dandori/make')}}",
        //   method :'POST',
        //   data: {
        //     back_number:back_number,
        //     _token: "{{csrf_token()}}",
        //     is_start:is_start,
        //     line_number:'{{$line_number}}'
        //   },
        //   success: function(result){
        //     $('.btn-model').removeClass('btn-primary');
        //     $('.btn-model').addClass('btn-default');
        //     $('#'+back_number).removeClass('btn-default');
        //     $('#'+back_number).addClass('btn-primary');
        //     $('#running-model').html(back_number);

        //     $('#loading').hide();
        //     $('#btn-dandori-start').removeAttr('disabled');
        //     $('#btn-dandori-change').removeAttr('disabled');

        //     closeModal();
        //   }
        // });
}

function SetClass (id) {
  back_number=id;
  openModal();
}

function GetQuantity(){
  $.ajax({
    url: "{{url('/dandori/quantity')}}",
    method :'GET',
    data: {
      line_number:'{{$line_number}}',
    },
    success: function(result){
      qty=result;
      $('#running-model-qty').html(result);
    }
  });
}
function openModal(){
 $('#myModal').modal({
      backdrop: 'static',
      // keyboard: true
    });
}

function closeModal(){
  $("#myModal").modal('hide');
}

$('#myModal').on('hidden.bs.modal', function () {
  $('#control-button').hide();
  $('.btn-model').removeClass('btn-primary');
})
</script>
<style>
/*.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:hover, .open>.btn-default.dropdown-toggle.focus, .open>.btn-default.dropdown-toggle:focus, .open>.btn-default.dropdown-toggle:hover {
    color: #fff;
    background-color: #1f648b;
    border-color: #133d55;
  }*/
  .btn-primary{
    color: #fff;
   /* background-color: #f9f9f9;
    border-color: #133d55;*/
  }
  .panel-heading h3 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: normal;
    width: 75%;
    padding-top: 8px;
  }
</style>
@endsection
