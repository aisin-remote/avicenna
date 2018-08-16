@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('htmlheader')
@parent
<link rel="stylesheet" type="text/css" href="{{url('/css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/css/aisya/dandori.css')}}">
@endsection

@section('contentheader_title')
@lang('avicenna/dandori.default_title')
@endsection

@section('contentheader_description')
@lang('avicenna/dandori.default_desc')
@endsection

@section('main-content')
@if (Session::has('flash_message'))
<div class="alert {{ Session::get('flash_type') }} alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {{ Session::get('flash_message')}}
</div>
@endif

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">@lang('avicenna/dandori.dandori_entry_box')</h3>
    <div class="box-tools pull-right">
    </div>
  </div>
  {{-- Awal dari FOrm --}}
  <form id="form-dandori" role="form" method="post" action="{{url('/dandori/save')}}" class="form-horizontal">
    {{-- <div class="form-horizontal"> --}}
    <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
    <div class="box-body">
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">@lang('avicenna/dandori.label_1')</label>
        <div class="col-sm-10">
          <select name="old_running_model" id="old_running_model" class="form-control" onchange="PopulateInformation()">
            @if ( count($running_models) > 0)
            <option>-- Choose --</option>
            @foreach($running_models as $running_model)
            <option value="{{$running_model->id}}">{{$running_model->line_name}}</option>
            @endforeach
            @endif
          </select>
        </div>
      </div>
      <hr/>
      <div class="form-group">
        <label  class="col-md-3 control-label pull-left"><b>@lang('avicenna/dandori.label_2')</b></label>
        <div class="col-sm-10">
        </div>
      </div>
      <div class="form-group">
       <label  class="col-sm-2 control-label">@lang('avicenna/dandori.label_line')</label>
       <div class="col-sm-10">
         <input class="form-control" placeholder="Line" readonly="" id="line_name">
       </div>
     </div>
     <div class="form-group">
       <label  class="col-sm-2 control-label">@lang('avicenna/dandori.label_model')</label>
       <div class="col-sm-10">
         <input  class="form-control" placeholder="Model" readonly="" id="back_number">
       </div>
     </div>
     <div class="form-group">
       <label  class="col-sm-2 control-label">@lang('avicenna/dandori.label_qty')</label>
       <div class="col-sm-10">
         <input  class="form-control" placeholder="Quantity" readonly="" id="qty">
       </div>
     </div>
     <br/>
     <hr/>
     <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">@lang('avicenna/dandori.lbl_choose_model')</label>
       <div class="col-sm-10">
         <select name="new_back_number" id="new_back_number" class="form-control" style="width:100%;">
         </select>
       </div>
     </div>
   </div>
   <div class="box-footer">
    <input type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default" value="@lang('avicenna/dandori.save_text')"></button>
  </div>
</form>
{{-- Akhir dari FOrm --}}


<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">@lang('avicenna/dandori.modal_title_txt')</h4>
        </div>
        <div class="modal-body">
          <p>@lang('avicenna/dandori.modal_body_txt')</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('avicenna/dandori.cancel_text')</button>
          <button type="button" class="btn btn-primary" id="modal_save">@lang('avicenna/dandori.save_text')</button>
        </div>
      </div>
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
    $("#new_back_number").select2({
      ajax:{
        url     : "{{url('/dandori/getajaxpart')}}",
        dataType  : 'json',
        delay   : 250,
        data    : function(params){
          return {
            q   : params.term,
            page  : params.page
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.back_number + " (" + item.part_number + ")",
                id: item.back_number
              }
            })
          };
        }
      },
      minimumresultsForSearch:10,
      cache : true,
      minimumInputLength  : 2,
    })
  })

  function PopulateInformation(){
    if($('#old_running_model').val()!=""){
     $.ajax({
       url: "{{url('/dandori/getajaxmodel')}}",
       method :'GET',
       data: {
         id:$('#old_running_model').val()
       },
       success: function(result){
         $('#line_name').val(result.line_name);
         $('#back_number').val(result.back_number);
         $('#qty').val(result.quantity);
       }
     });
   }

 }

 $('#modal_save').click(function(){
  /* when the submit button in the modal is clicked, submit the form */
  if(Validasi()){
    $('#form-dandori').submit();
  }else{
    alert('Please fill all blank data');
  }
});

 function Validasi(){
  var _result=false;
  if($('#old_running_model').val()!="" && $('#line_name').val() != "" && $('#back_number').val()!="" && $('#qty').val() !="" && $('#new_back_number').val()!="" ){
    _result = true;
  }
  return _result;
}
</script>
@endsection