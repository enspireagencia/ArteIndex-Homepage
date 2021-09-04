{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<style>
   fieldset
	{
		border: 1px solid #ddd !important;
		margin: 0;
		padding: 10px;
		position: relative;
		border-radius:4px;
		padding-left:10px!important;
	}
	legend
   {
      font-size:14px;
      margin-bottom: 0px;
      width: 35%;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px 5px 5px 10px;
      background-color: #ffffff;
   }
   .dz-image img{
      width:100%
   }
   .dz-progress, .dz-filename, .dz-size{
      display:none;
   }
</style>
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($privateroom))
            @lang('buttons.backend.general.crud.edit') @lang('datatables.backend.private_rooms.title')
            @else
            @lang('label.backend.private_rooms.new_private_rooms') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('private_rooms.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreatePrivateroom">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($privateroom))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.private_rooms.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="savePrivateRoomForm">
         <div class="card-body">

            <fieldset>
                <legend><h5><strong>@lang('label.backend.create.private_rooms.room_details')</strong></h5></legend>

            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">

                  <div class="form-group row">
                     <div class="col-lg-12">
                        <label class="">@lang('label.backend.create.private_rooms.name')</label>
                        <input class="form-control  form-control-solid" name="name" id="name" value="{{isset($privateroom->name)?$privateroom->name:''}}" type="text">
                        <input type="hidden" name="privateroom_id" id="privateroom_id" value="{{isset($privateroom->id)?$privateroom->id:''}}" />
                        <div class="invalid-feedback"></div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="">@lang('label.backend.create.private_rooms.description')</label>
                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="description" id="description">{{isset($privateroom->description)?$privateroom->description:''}}</textarea>
                    </div>
                 </div>

               </div>
            </div>
            </fieldset>


           <fieldset class="mt-5">
            <legend><h5><strong>@lang('label.backend.create.private_rooms.public_room_options')</strong></h5></legend>
            <label for=""><h5><u>@lang('label.backend.create.private_rooms.data_settings')</u></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_prices" @if(isset($privateroom->show_public_show_prices) && $privateroom->show_public_show_prices==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_prices">
                          <span></span> &nbsp;Show price</label>
                       </div>
                 </div>
                 <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_location" @if(isset($privateroom->show_public_show_location) && $privateroom->show_public_show_location==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_location">
                          <span></span> &nbsp;Show the piece's current location</label>
                       </div>
                 </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_wholesale_prices" @if(isset($privateroom->show_public_show_wholesale_prices) && $privateroom->show_public_show_wholesale_prices==1) checked @endif id="show_public_show_wholesale_prices">
                          <span></span> &nbsp;Show wholesale price</label>
                       </div>
                 </div>
                 <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_inventory_numbers" @if(isset($privateroom->show_public_show_inventory_numbers) && $privateroom->show_public_show_inventory_numbers==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_inventory_numbers">
                          <span></span> &nbsp;Show inventory numbers</label>
                       </div>
                 </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_creation_date" @if(isset($privateroom->show_public_show_creation_date) && $privateroom->show_public_show_creation_date==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_creation_date">
                          <span></span> &nbsp;Show creation date</label>
                       </div>
                 </div>
                 <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_both_sizes" @if(isset($privateroom->show_public_show_both_sizes) && $privateroom->show_public_show_both_sizes==1) checked @endif id="show_public_show_both_sizes">
                          <span></span> &nbsp;Show size in both centimeters and inches</label>
                       </div>
                 </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_additional_images" @if(isset($privateroom->show_public_show_additional_images) && $privateroom->show_public_show_additional_images==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_additional_images">
                          <span></span> &nbsp;Show additional images for all public pieces</label>
                       </div>
                 </div>
                 <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_subject_matter" @if(isset($privateroom->show_public_show_subject_matter) && $privateroom->show_public_show_subject_matter==1) checked @endif id="show_public_show_subject_matter">
                          <span></span> &nbsp;Show subject matter</label>
                       </div>
                 </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_collections" @if(isset($privateroom->show_public_show_collections) && $privateroom->show_public_show_collections==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_collections">
                          <span></span> &nbsp;Show collections</label>
                       </div>
                 </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_sales" @if(isset($privateroom->show_public_show_sales) && $privateroom->show_public_show_sales==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_sales">
                          <span></span> &nbsp;Show sold label</label>
                       </div>
                 </div>

               </div>

            </div>
            <label for=""><h5><u>@lang('label.backend.create.private_rooms.display_settings')</u></h5></label>
            <div class="form-group">
                <div class="col-lg-12 col-md-9 col-sm-12 row">
                <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_shadows" @if(isset($privateroom->show_public_show_shadows) && $privateroom->show_public_show_shadows==1) checked @endif id="show_public_show_shadows">
                          <span></span> &nbsp;Show info below piece image on gallery view instead of on hover</label>
                       </div>
                 </div>
                 <div class="form-group col-lg-6">
                    <div class="">
                          <label class="checkbox">
                          <input type="checkbox" value="1" name="show_public_show_inquire" @if(isset($privateroom->show_public_show_inquire) && $privateroom->show_public_show_inquire==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_inquire">
                          <span></span> &nbsp;Show inquire button on pieces</label>
                       </div>
                 </div>
                </div>
                <div class="col-lg-12 col-md-9 col-sm-12 row">

                     <div class="form-group col-lg-6">
                        <div class="">
                              <label class="checkbox">
                              <input type="checkbox" value="1" name="show_public_show_purchase" @if(isset($privateroom->show_public_show_purchase) && $privateroom->show_public_show_purchase==1) checked @endif @if(!isset($privateroom)) checked @endif id="show_public_show_purchase">
                              <span></span> &nbsp;Show purchase button on pieces</label>
                           </div>
                     </div>
                    </div>
            </div>
        </fieldset>

        <fieldset class="mt-5">
            <legend><h5><strong>@lang('label.backend.create.private_rooms.default_piece_order_for_room')</strong></h5></legend>

            <div class="form-group">
                <div class="col-lg-12 col-md-9 col-sm-12 row">
                    <div class="form-group">

                        <select class="form-control form-control-solid select_change_user_profile_setting" name="show_public_show_piece_order" id="show_public_show_piece_order">
                            <option value="name_desc"  @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='name_desc' ) selected @endif>Title (z-a)</option>
                            <option value="price_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='price_asc' ) selected @endif>Price (low)</option>
                            <option value="price_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='price_desc' ) selected @endif>Price (high)</option>
                            <option value="inventory_number_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='inventory_number_asc' ) selected @endif>Inventory Number (low)</option>
                            <option value="inventory_number_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='inventory_number_desc' ) selected @endif>Inventory Number (high)</option>
                            <option value="size_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='size_asc' ) selected @endif>Size (smallest)</option>
                            <option value="size_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='size_desc' ) selected @endif>Size (largest)</option>
                            <option value="creation_date_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='creation_date_desc' ) selected @endif>Creation Date (recent)</option>
                            <option value="creation_date_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='creation_date_asc' ) selected @endif>Creation Date (old)</option>
                            <option value="date_added_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='date_added_desc' ) selected @endif>Date Added (recent)</option>
                            <option value="date_added_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='date_added_asc' ) selected @endif>Date Added (old)</option>
                            <option value="type_asc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='type_asc' ) selected @endif>Type (a-z)</option>
                            <option value="type_desc" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='type_desc' ) selected @endif>Type (z-a)</option>
                            <option value="public_piece_daily_random" @if(isset($privateroom->show_public_show_piece_order) && $privateroom->show_public_show_piece_order =='public_piece_daily_random' ) selected @endif>Randomize Daily</option>
                        </select>
                    </div>
                </div>

            </div>
        </fieldset>

        <fieldset class="mt-5">
            <legend><h5><strong>@lang('label.backend.create.private_rooms.published_status')</strong></h5></legend>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                    <div class="form-group col-lg-6">
                        <div class="">
                            <label>@lang('label.backend.create.private_rooms.published_status_tagline')</label>
                              <label class="checkbox">
                              <input type="checkbox" value="1" name="show_public_show_status" @if(isset($privateroom->show_public_show_status) && $privateroom->show_public_show_status==1) checked @endif id="signed">
                              <span></span> &nbsp;Published</label>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
        </fieldset>
            <fieldset class="mt-5">
                <legend><h5><strong>@lang('label.backend.create.private_rooms.privacy_settings')</strong></h5></legend>

            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                <label>@lang('label.backend.create.private_rooms.passphrase_tagline')</label>
                  <div class="form-group row">
                     <div class="col-lg-12">
                        <label class="">@lang('label.backend.create.private_rooms.passphrase')</label>
                        <input class="form-control  form-control-solid" name="show_public_password" id="show_public_password" value="{{isset($privateroom->show_public_password)?$privateroom->show_public_password:''}}" type="text">
                     </div>
                  </div>
               </div>
            </div>
            </fieldset>
            <fieldset class="mt-5">
            <legend><h5><strong>@lang('label.backend.create.private_rooms.select_your_pieces')</strong></h5></legend>
            <div class="form-group row">
                <div class="col-lg-12">
                   <label>@lang('label.backend.create.collections.select_pieces')</label>
                   <div class="input-group">
                   <select class="form-control select2 form-control-solid" multiple id="pieces_id" name="pieces_id[]">
                      @if(isset($pieces))
                        @php
                        if(isset($privateroom->private_rooom_pieces)){
                        foreach($privateroom->private_rooom_pieces as $rooom_pieces){
                                $rooom_pieces_array[] = $rooom_pieces->piece_id;
                        }
                      }
                       @endphp
                         @foreach($pieces as $piece)
                         <option value="{{$piece->id}}">
                            {{ $piece->title}}
                         </option>
                         @endforeach
                      @endif
                   </select>
                   </div>
                </div>
             </div>
            </fieldset>

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
      var selectedValue = "{{isset($rooom_pieces_array) ? json_encode($rooom_pieces_array):''}}";
        if(selectedValue){
            var str = JSON.parse(selectedValue.replace(/&quot;/g,'"'));
            $('.select2').val(str).trigger('change');
        }else{
            $('.select2').val();
        }
      //Create Runs
      $("#btncreatePrivateroom").on("click", function(event){
         $('#savePrivateRoomForm').trigger('submit');
      });
      $("#savePrivateRoomForm").on("submit", function(event){
         event.preventDefault();

         $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('private_rooms.store') }}",
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
							window.location.href = "{{route('private_rooms.index')}}";
						}, 1500);
					}
					if(data.status == 'error'){
						Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
					}
				},
				error :function( data ) {
					if( data.status === 422 ) {
						Swal.fire("{{__('string.backend.create.pieces.error')}}", data.responseJSON.message, 'error');
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
