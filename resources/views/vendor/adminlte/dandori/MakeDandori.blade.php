@extends('layouts.app')

@section('content')
<div class="container">
    @lang('avicenna/dandori.default_title')

    <div class="row">
        <div class="col-md-9">
            <table class="table">
                <tr>
                    @foreach($models as $model)
                    <td> <button class="btn <?php if($running_model->back_number==$model->back_number) echo 'btn-primary '; else echo 'btn-default '; ?>btn-model" id="{{$model->back_number}}" onclick="SetClass(this.id)">{{$model->back_number}}</button></td>
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading"><b>GAMBAR MODEL</b></div>
              <div class="panel-body">
              </div>
          </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-default">
              <div class="panel-heading"><b>INFORMASI</b></div>
              <div class="panel-body">
               <div class="form-group">
               <center>
                   <label  id="running-model" class="control-label" style="font-size:25pt;">{{$running_model->back_number}}</label>
                   <br/>
                   <label id="running-model-qty" class="control-label" style="font-size:25pt;">{{$running_model->quantity}}</label>
                </center>
               </div>
              </div>
          </div>
      </div>
  </div>

{{-- Modal Loading --}}
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width:350px;">
    <div class="modal-content">
      <div class="modal-body">
      <center>
      <p><b>Pilih Dandori</b></p>
        <button class="btn btn-default" id="btn-dandori-start" onclick="Simpan(this.id)">Dandori Awal Shift</button>
        <button class="btn btn-default" id="btn-dandori-change" onclick="Simpan(this.id)">Dandori di tengah</button>
        <br/><br/>
        <div id="loading" hidden>
            <img src="{{asset('/images/loading.gif')}}"/>
            <br/>Mohon tunggu
        </div>
        </center>
      </div>
    </div>

  </div>
</div>

</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript">
var qty=0;
var is_start=false;
var back_number='';

    $(document).ready(function(){
       setInterval(function(){
        GetQuantity();
       },3000);
    });

    function Simpan(id){
        $('#loading').show();
        $('#btn-dandori-start').attr('disabled','disabled');
        $('#btn-dandori-change').attr('disabled','disabled');

        if(id=='btn-dandori-start'){
            is_start=true;
        }else{
            is_start=false;
        }
        $.ajax({
          url: "{{url('/dandori/make')}}",
          method :'POST',
          data: {
            back_number:back_number,
            _token: "{{csrf_token()}}",
            is_start:is_start,
            line_number:'{{$line_number}}'
          },
          success: function(result){
            $('.btn-model').removeClass('btn-primary');
            $('.btn-model').addClass('btn-default');
            $('#'+back_number).removeClass('btn-default');
            $('#'+back_number).addClass('btn-primary');
            $('#running-model').html(back_number);

            $('#loading').hide();
            $('#btn-dandori-start').removeAttr('disabled');
            $('#btn-dandori-change').removeAttr('disabled');

            closeModal();
          }
        });
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
      // backdrop: 'static',
      // keyboard: true
      });
    }

    function closeModal(){
      $("#myModal").modal('hide');
    }

</script>

@endsection
