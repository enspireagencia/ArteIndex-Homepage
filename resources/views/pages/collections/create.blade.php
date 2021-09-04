{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($collection))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.collections.new_collection') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('collections.index') }}"  class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateCollection">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($collection))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.collections.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveCollectionForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.collections.title')</label>
                  <input type="text" name="collection_name" id="collection_name" class="form-control form-control-solid" placeholder="@lang('label.backend.create.collections.enter_collection_name')" value="{{isset($collection->collection_name)?$collection->collection_name:''}}" />
                  <input type="hidden" name="collection_id" id="collection_id" value="{{isset($collection->id)?$collection->id:''}}" />
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.collections.description')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="description" id="description" cols="30" rows="6">{{isset($collection->description)?$collection->description:''}}</textarea>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <div class="">
                     <label class="checkbox">
                     @php
                     if(isset($collection->hide_from_public) && $collection->hide_from_public==1){
                        $hide_from_public = 'checked';
                     }else{
                        $hide_from_public = '';
                     }
                     @endphp
                     <input type="checkbox" name="hide_from_public" {{$hide_from_public}} value="1">
                     <span></span> &nbsp; @lang('string.backend.create.collections.hide_collection_name_public_profile')</label>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.collections.select_pieces')</label>
                  <div class="input-group">
                  <select class="form-control select2 form-control-solid" multiple id="pieces_id" name="pieces_id[]">
                     @if(isset($pieces))
                        @foreach($pieces as $piece)
                        @php
                           $pieces_collections = explode(",",$piece->collections_id);
                           foreach($pieces_collections as $pieces_collection){
                              if(isset($collection) && $pieces_collection == $collection->id){
                                 $collections_array[] = $piece->id;
                              }
                           }

                        @endphp
                        <option value="{{$piece->id}}">
                           {{ $piece->title}}
                        </option>
                        @endforeach
                     @endif
                  </select>
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
   
   $(".select2").select2({
      multiple: true,
   });
   var selectedValue = "{{isset($collections_array) ? json_encode($collections_array):''}}";
   if(selectedValue){
      var str = JSON.parse(selectedValue.replace(/&quot;/g,'"'));
      $('.select2').val(str).trigger('change');
   }else{
      $('.select2').val();
   }
   
   // var selectedValue = "";
   // console.log("selectedValue",selectedValue);
   // if(selectedValue){
   //    var str = selectedValue.split(',');
   //    $('.select2').val(str).trigger('change');
   // }else{
   //    $('.select2').val();
   // }
   //Create Collections
   $("#btncreateCollection").on("click", function(event){
      $('#saveCollectionForm').trigger('submit');
   });
   $("#saveCollectionForm").on("submit", function(event){
      event.preventDefault();

      $('.has-danger').next().children().children().css({"border": ""});
      $('.is-invalid').removeClass("is-invalid");
      $('.invalid-feedback').html("");
      $('.has-danger').removeClass("has-danger");
      var formData = new FormData($(this)[0]);
      $.ajax({
         url: "{{ route('collections.store') }}",
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
                  window.location.href = "{{route('collections.index')}}";
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
