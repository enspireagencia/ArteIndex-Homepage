{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($location))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.locations.new_location') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('locations.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateLocation"> 
            <i class="ki ki-check icon-sm"></i>
            @if(isset($location))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.locations.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveLocationForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.locations.location_info')</legend>
                     <div class="row">
                        <div class="col-xl-12">
                              <input type="text" name="name" id="name" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_name')" value="{{isset($location->name)?$location->name:''}}">
                              <input type="hidden" name="location_id" id="location_id" value="{{isset($location->id)?$location->id:''}}" />
                              <div class="invalid-feedback"></div>
                           <br>
                              <input type="text" name="website" id="website" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_website')" value="{{isset($location->website)?$location->website:''}}">
                           <br>
                              <input type="text" name="email" id="email" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_email')" value="{{isset($location->email)?$location->email:''}}">
                           <br>
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="phone" id="phone" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_phone')" value="{{isset($location->phone)?$location->phone:''}}">
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="fax" id="fax" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_fax')" value="{{isset($location->fax)?$location->fax:''}}">
                        </div>
                        <div class="col-xl-12">
                           <br>
                           <label>@lang('label.backend.create.locations.notes')</label>
                           <textarea class="form-control form-control-solid" name="notes" id="notes" cols="30" rows="6" spellcheck="false">{{isset($location->notes)?$location->notes:''}}</textarea>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.locations.address')</legend>
                     <div class="row">
                        <div class="col-xl-6">
                           <input type="text" name="address_line_1" id="address_line_1" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_address_line_1')" value="{{isset($location->address_line_1)?$location->address_line_1:''}}">
                           </br>
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="address_line_2" id="address_line_2" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_address_line_2')" value="{{isset($location->address_line_2)?$location->address_line_2:''}}">
                           </br>
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="city" id="city" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_city')" value="{{isset($location->city)?$location->city:''}}">
                           </br>
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="state" id="state" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_state')" value="{{isset($location->state)?$location->state:''}}">
                           </br>
                        </div>
                        <div class="col-xl-6">
                           <input type="text" name="zip" id="zip" class="form-control form-control-solid" placeholder="@lang('label.backend.create.locations.enter_zip')" value="{{isset($location->zipcode)?$location->zipcode:''}}">
                           </br>
                        </div>
                        <div class="col-xl-6">
                           <select class="form-control form-control-solid" id="country" name="country">
                              <option value="">@lang('label.backend.create.locations.select_country')</option>
                                 @foreach($countries as $country)
                                    <option value="{{$country->id}}" @if(isset($location->country) && $location->country == $country->id ) selected @endif >
                                       {{ $country->name}}
                                    </option>
                                 @endforeach
                           </select>
                        </div>
                     </div>
                  </fieldset>
               </div>
            </div>
         </div>
      </form>
      <!--end::Form-->
   </div>
</div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
<script>
   //Dropzone
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
   $(document).ready(function() {

      $(".select2").select2({
         multiple: true,
      });

      //Create Location
      $("#btncreateLocation").on("click", function(event){
         $('#saveLocationForm').trigger('submit');
      });
      $("#saveLocationForm").on("submit", function(event){
         event.preventDefault();

         $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('locations.store') }}",
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
							window.location.href = "{{route('locations.index')}}";
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
   });
</script>
@endsection
