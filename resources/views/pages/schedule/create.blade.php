{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($schedule))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.schedule.new_schedule') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('schedule.index') }}"  class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateschedule">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($schedule))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.schedule.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="savescheduleForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.schedule.date')</label>
                  <input type="date" name="remainder_date" id="remainder_date" class="form-control form-control-solid" placeholder="@lang('label.backend.create.schedule.remainder_date')" value="{{isset($schedule->remainder_date)?$schedule->remainder_date:''}}" />
                  <input type="hidden" name="schedule_id" id="schedule_id" value="{{isset($schedule->id)?$schedule->id:''}}" />
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.schedule.message')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="message" id="message" cols="30" rows="6">{{isset($schedule->message)?$schedule->message:''}}</textarea>
                     <div class="invalid-feedback"></div>
                  </div>
               </div>
            </div>
            @if(isset($schedule->status) && $schedule->status==1)
            <div class="form-group row">
               <div class="col-lg-12">
                  <label class="checkbox">
                  <input type="checkbox" value="1" name="status" @if(isset($schedule->status) && $schedule->status==1) checked @endif>
                  <span></span> &nbsp;@lang('label.backend.create.schedule.complete')</label>
               </div>
            </div>
            @endif
         </div>
      </form>
      <!--end::Form-->
   </div>
</div>
<script src="{{ asset('js/ckeditor.js') }}"></script>

@endsection

{{-- Scripts Section --}}
@section('scripts')
<script>
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   //Create schedules
   $("#btncreateschedule").on("click", function(event){
      $('#savescheduleForm').trigger('submit');
   });
   $("#savescheduleForm").on("submit", function(event){
      event.preventDefault();

      $('.has-danger').next().children().children().css({"border": ""});
      $('.is-invalid').removeClass("is-invalid");
      $('.invalid-feedback').html("");
      $('.has-danger').removeClass("has-danger");
      var formData = new FormData($(this)[0]);
      $.ajax({
         url: "{{ route('schedule.store') }}",
         method: 'POST',
         data: formData,
         contentType: false,
         cache: false,
         processData: false,
         dataType: "json",
         beforeSend: function(){
            Swal.fire("{{__('string.backend.common.please_wait')}}");
            Swal.showLoading();
         },
         success: function(data)
         {
            if(data.status == 'success'){
               if(data.type == '1'){
                  Swal.fire("{{__('string.backend.create.pieces.created')}}", data.message, 'success');
               }else{
                  Swal.fire("{{__('string.backend.create.pieces.updated')}}", data.message, 'success');
               }
               setTimeout(function(){
                  window.location.href = "{{route('schedule.index')}}";
               }, 1500);
            }
            if(data.status == 'error'){
               Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
            }
         },
         error :function( data ) {
            if( data.status === 422 ) {
               Swal.fire("{{__('string.backend.create.pieces.error')}}", "{{__('string.backend.create.locations.the_given_data_was_invalid')}}", 'error');
               $('.btn-success').removeAttr('disabled');
               var errors = [];
               errors = data.responseJSON.errors
               $.each(errors, function (key, value) {
                  $('#'+key).parent().addClass('has-danger');
                  $('#'+key).addClass('is-invalid');
                  $('#'+key).parent('.has-danger').find('.invalid-feedback').html(value);
                  $('#'+key).next().children().children().css({"border": "1px solid #f86c6b"});
               })
            }
         }
      });
   })
</script>
@endsection
