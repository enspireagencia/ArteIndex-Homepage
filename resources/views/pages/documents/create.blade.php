{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($document))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.documents.new_documents') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('documents.index') }}"  class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateDocument">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($document))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.documents.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveDocumentForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.documents.type')</label>
                  <select class="form-control form-control-solid" id="type_id" name="type_id">
                        @foreach($document_type as $type)
                           <option value="{{$type->id}}" @if(isset($document->type_id) && $document->type_id == $type->id ) selected @endif >
                              {{ $type->name}}
                           </option>
                        @endforeach
                  </select>
                  <input type="hidden" name="document_id" id="document_id" value="{{isset($document->id)?$document->id:''}}" />
                  <input type="hidden" name="old_image" id="old_image" value="{{isset($document->file_url)?$document->file_url:''}}" />
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.documents.name')</label>
                  <div class="input-group">
                     <input type="text" class="form-control form-control-solid" name="name" id="name" value="{{isset($document->name)?$document->name:''}}" />
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.documents.description')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="description" id="description" cols="30" rows="6">{{isset($document->description)?$document->description:''}}</textarea>
                  </div>
               </div>
            </div>
            <div class="form-group row">
            <div class="col-lg-6">
                  <label>@lang('label.backend.create.documents.file')</label>
                  <div class="input-group">
                     <input type="file" class="form-control form-control-solid" name="file" id="file" />
                  </div>
               </div>
               <div class="col-lg-6">
                  <label>@lang('label.backend.create.documents.date')</label>
                  <div class="input-group">
                     <input type="date" class="form-control form-control-solid" name="date" id="date" value="{{isset($document->date)?$document->date:''}}" />
                  </div>
               </div>
            </div>
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

   
   // var selectedValue = "";
   // console.log("selectedValue",selectedValue);
   // if(selectedValue){
   //    var str = selectedValue.split(',');
   //    $('.select2').val(str).trigger('change');
   // }else{
   //    $('.select2').val();
   // }
   //Create Documents
   $("#btncreateDocument").on("click", function(event){
      $('#saveDocumentForm').trigger('submit');
   });
   $("#saveDocumentForm").on("submit", function(event){
      event.preventDefault();

      $('.has-danger').next().children().children().css({"border": ""});
      $('.is-invalid').removeClass("is-invalid");
      $('.invalid-feedback').html("");
      $('.has-danger').removeClass("has-danger");
      var formData = new FormData($(this)[0]);
      $.ajax({
         url: "{{ route('documents.store') }}",
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
                  window.location.href = "{{route('documents.index')}}";
               }, 1500);
            }
            if(data.status == 'error'){
               Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
            }
         },
         error :function( data ) {
            if( data.status === 422 ) {
               Swal.fire("{{__('string.backend.create.pieces.error')}}", "{{__('string.backend.create.private_rooms.the_given_data_was_invalid')}}", 'error');
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
