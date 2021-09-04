{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
   <div class="card-header">
      <div class="card-title">
         <h3 class="card-label">
            @if(isset($exhibition))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.exhibitions.new_exhibition') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('exhibitions.index') }}"  class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateexhibition">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($exhibition))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.exhibitions.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveexhibitionForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.exhibitions.name')</label>
                  <input type="text" name="name" id="name" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.name')" value="{{isset($exhibition->name)?$exhibition->name:''}}" />
                  <input type="hidden" name="exhibition_id" id="exhibition_id" value="{{isset($exhibition->id)?$exhibition->id:''}}" />
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.exhibition_info')</legend>
                  <div class="row">
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.show_type')</label>
                        <select class="form-control form-control-solid" id="show_type" name="show_type">
                           <option value="Exhibition" @if(isset($exhibition->show_type) && $exhibition->show_type == 'Exhibition' ) selected @endif>Exhibition</option>
                           <option value="Competition" @if(isset($exhibition->show_type) && $exhibition->show_type == 'Competition' ) selected @endif>Competition</option>
                        </select>
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.solo_or_group_show')</label>
                        <select class="form-control form-control-solid" id="solo_group_show" name="solo_group_show">
                           <option value="">None</option>
                           <option value="Solo Show" @if(isset($exhibition->solo_group_show) && $exhibition->solo_group_show == 'Solo Show' ) selected @endif>Solo Show</option>
                           <option value="Group Show" @if(isset($exhibition->solo_group_show) && $exhibition->solo_group_show == 'Group Show' ) selected @endif>Group Show</option>
                        </select>
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.description')</label>
                        <textarea rows="5" name="description" id="description" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.description')" >{{isset($exhibition->description)?$exhibition->description:''}}</textarea>
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.phone')</label>
                        <input type="text" name="phone" id="phone" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.phone')" value="{{isset($exhibition->phone)?$exhibition->phone:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.email')</label>
                        <input type="text" name="email" id="email" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.email')" value="{{isset($exhibition->email)?$exhibition->email:''}}">
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.website')</label>
                        <input type="text" name="website" id="website" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.website')" value="{{isset($exhibition->website)?$exhibition->website:''}}">
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.fee')</label>
                        <input type="number" name="fee" id="fee" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.fee')" value="{{isset($exhibition->fee)?$exhibition->fee:''}}">
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.curator')</label>
                        <input type="text" name="curator" id="curator" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.curator')" value="{{isset($exhibition->curator)?$exhibition->curator:''}}">
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.juror')</label>
                        <input type="text" name="juror" id="juror" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.juror')" value="{{isset($exhibition->juror)?$exhibition->juror:''}}">
                        </br>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.location_info')</legend>
                  <div class="row">
                     <div class="col-xl-12">
                        <label>@lang('label.backend.create.exhibitions.location_type')</label>
                        <select class="form-control form-control-solid" id="location_type" name="location_type">
                           <option value="On Site" @if(isset($exhibition->location_type) && $exhibition->location_type == 'On Site' ) selected @endif>On Site</option>
                           <option value="Online" @if(isset($exhibition->location_type) && $exhibition->location_type == 'Online' ) selected @endif>Online</option>
                           <option value="Traveling" @if(isset($exhibition->location_type) && $exhibition->location_type == 'Traveling' ) selected @endif>Traveling</option>
                        </select>
                        </br>
                     </div>
                     <div class="col-xl-12">
                        <div id="existing-exhibition-main">
                           <div class="row">
                              <div class="col-xl-12">
                                 <label>@lang('label.backend.create.exhibitions.existing_locations')</label>
                                 <select class="form-control form-control-solid" id="location_id" name="location_id">
                                    <option value="">@lang('label.backend.create.exhibitions.select_location')</option>
                                    @if(isset($locations))
                                       @foreach($locations as $location)
                                       <option value="{{$location->id}}" @if(isset($exhibition->location_id) && $exhibition->location_id == $location->id ) selected @endif >
                                          {{ $location->name}}
                                       </option>
                                       @endforeach
                                    @endif
                                 </select>
                              </div>
                           </div>
                           <a href="javascript:void(0)" id="btn-create-exhibition">@lang('label.backend.create.exhibitions.create_new_location') </a>
                        </div>
                        <div id="create-exhibition" style="display:none">
                           <label for="">@lang('label.backend.create.exhibitions.new_location_name')</label>
                           <div class="row">
                              <div class="col-xl-12">
                                 <input type="text" name="location_name" class="form-control form-control-solid" id="enter-exhibition-name"/>
                              </div>
                           </div>
                           <div>
                              <a href="javascript:void(0)" id="btn-existing-exhibition">@lang('label.backend.create.exhibitions.select_existing_location')</a>
                           </div>
                        </div>
                        </br>
                     </div>
                  </div>
                  <div class="mt-3">
                     <label class="checkbox">
                     @php
                     if(isset($exhibition->is_create_location_records_for_pieces_accepted_to_this_show) && $exhibition->is_create_location_records_for_pieces_accepted_to_this_show==1){
                        $is_create_location_records_for_pieces_accepted_to_this_show = 'checked';
                     }else{
                           $is_create_location_records_for_pieces_accepted_to_this_show = '';
                     }
                     @endphp
                     <input type="checkbox" value="1" name="is_create_location_records_for_pieces_accepted_to_this_show" {{$is_create_location_records_for_pieces_accepted_to_this_show}} id="is_create_location_records_for_pieces_accepted_to_this_show">
                     <span></span> &nbsp;@lang('label.backend.create.exhibitions.create_location_records_for_pieces_accepted_to_this_show')</label>
                     <p>@lang('label.backend.create.exhibitions.using_the_start_and_end_dates_below_well_add_the_exhibition_pieces_to_the_proper_location')</p>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.address')</legend>
                  <div class="row">
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.address_line_1')</label>
                        <input type="text" name="address_line_1" id="address_line_1" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.enter_address_line_1')" value="{{isset($exhibition->address_line1)?$exhibition->address_line1:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.address_line_2')</label>
                        <input type="text" name="address_line_2" id="address_line_2" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.enter_address_line_2')" value="{{isset($exhibition->address_line2)?$exhibition->address_line2:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.city')</label>
                        <input type="text" name="city" id="city" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.enter_city')" value="{{isset($exhibition->city)?$exhibition->city:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.state')</label>
                        <input type="text" name="state" id="state" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.enter_state')" value="{{isset($exhibition->state)?$exhibition->state:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.zip')</label>
                        <input type="text" name="zip" id="zip" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.enter_zip')" value="{{isset($exhibition->zip)?$exhibition->zip:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.country')</label>
                        <select class="form-control form-control-solid" id="country" name="country">
                           <option value="">@lang('label.backend.create.exhibitions.select_country')</option>
                              @foreach($countries as $country)
                                 <option value="{{$country->id}}" @if(isset($exhibition->country) && $exhibition->country == $country->id ) selected @endif >
                                    {{ $country->name}}
                                 </option>
                              @endforeach
                        </select>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.dates')</legend>
                  <div class="row">
                     <div class="col-xl-4">
                        <label>@lang('label.backend.create.exhibitions.exhibition_start')</label>
                        <input type="date" name="exhibition_start" id="exhibition_start" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.exhibition_start')" value="{{isset($exhibition->start_date)?$exhibition->start_date:''}}">
                        </br>
                     </div>
                     <div class="col-xl-4">
                        <label>@lang('label.backend.create.exhibitions.exhibition_end')</label>
                        <input type="date" name="exhibition_end" id="exhibition_end" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.exhibition_end')" value="{{isset($exhibition->end_date)?$exhibition->end_date:''}}">
                        </br>
                     </div>
                     <div class="col-xl-4">
                        <label>@lang('label.backend.create.exhibitions.reception_date')</label>
                        <input type="date" name="reception_date" id="reception_date" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.reception_date')" value="{{isset($exhibition->reception_date)?$exhibition->reception_date:''}}">
                        </br>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.deadlines')</legend>
                  <div class="row">
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.submission_deadline')</label>
                        <input type="date" name="submission_deadline" id="submission_deadline" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.submission_deadline')" value="{{isset($exhibition->submission_deadline)?$exhibition->submission_deadline:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.notification_date')</label>
                        <input type="date" name="notification_date" id="notification_date" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.notification_date')" value="{{isset($exhibition->notification_date)?$exhibition->notification_date:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.delivery_date')</label>
                        <input type="date" name="delivery_date" id="delivery_date" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.delivery_date')" value="{{isset($exhibition->delivery_date)?$exhibition->delivery_date:''}}">
                        </br>
                     </div>
                     <div class="col-xl-6">
                        <label>@lang('label.backend.create.exhibitions.pickup_date')</label>
                        <input type="date" name="pickup_date" id="pickup_date" class="form-control form-control-solid" placeholder="@lang('label.backend.create.exhibitions.pickup_date')" value="{{isset($exhibition->pickup_date)?$exhibition->pickup_date:''}}">
                        </br>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <fieldset>
                  <legend class="">@lang('label.backend.create.exhibitions.other_information')</legend>
                  <label>@lang('label.backend.create.exhibitions.notes_always_private')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="notes" id="notes" cols="30" rows="6">{{isset($exhibition->notes)?$exhibition->notes:''}}</textarea>
                  </div>
               </fieldset>
            </div>
            <div class="form-group row">
               <div class="col-lg-12">
                  <label>@lang('label.backend.create.exhibitions.note_you_can_add_artwork_to_the_exhibition_after_its_created')</label>
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
   var selectedValue = "{{isset($exhibitions_array) ? json_encode($exhibitions_array):''}}";
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
   //Create exhibitions
   $("#btncreateexhibition").on("click", function(event){
      $('#saveexhibitionForm').trigger('submit');
   });
   $("#saveexhibitionForm").on("submit", function(event){
      event.preventDefault();

      $('.has-danger').next().children().children().css({"border": ""});
      $('.is-invalid').removeClass("is-invalid");
      $('.invalid-feedback').html("");
      $('.has-danger').removeClass("has-danger");
      var formData = new FormData($(this)[0]);
      $.ajax({
         url: "{{ route('exhibitions.store') }}",
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
                  window.location.href = "{{route('exhibitions.index')}}";
               }, 1500);
            }
            if(data.status == 'error'){
               Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
            }
         },
         error :function( data ) {
            if( data.status === 422 ) {
               Swal.fire("{{__('string.backend.create.pieces.error')}}", "{{__('string.backend.create.exhibitions.the_given_data_was_invalid')}}", 'error');
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
   $("#btn-create-exhibition").on("click", function(event){
         event.preventDefault();
         $('#create-exhibition').show();
         $('#existing-exhibition-main').hide();
      });
      $("#btn-existing-exhibition").on("click", function(event){
         event.preventDefault();
         $('#existing-exhibition-main').show();
         $('#create-exhibition').hide();
      });
</script>
@endsection
