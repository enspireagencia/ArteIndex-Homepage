{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

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
            @if(isset($pieces))
            @lang('buttons.backend.general.crud.edit')
            @else
            @lang('label.backend.pieces.new_piece') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('pieces.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreatePieces">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($pieces))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.pieces.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="savePiecesForm">
         <div class="card-body">
            <div class="form-group row">
               <div class="col-lg-12">
                  <label> @lang('label.backend.create.pieces.title')</label>
                  <input type="text" name="title" id="title" class="form-control form-control-solid" placeholder="@lang('label.backend.create.pieces.enter_title')" value="{{isset($pieces->title)?$pieces->title:''}}" />
                  <input type="hidden" name="pieces_id" id="pieces_id" value="{{isset($pieces->id)?$pieces->id:''}}" />
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <label class=""> @lang('label.backend.create.pieces.piece_images')</label>
                  <div class="dropzone dropzone-default dropzone-primary dz-clickable" id="kt_dropzone_2">
                     <div class="dropzone-msg dz-message needsclick">
                        <h3 class="dropzone-msg-title">@lang('string.backend.create.pieces.click_to_upload')</h3>
                        <span class="dropzone-msg-desc">@lang('string.backend.create.pieces.upload_10_files')</span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <label class=""> @lang('label.backend.create.pieces.notes')</label><br />
                  <span>@lang('string.backend.create.pieces.all_image_file_types')</span> <br />
                  <span>@lang('string.backend.create.pieces.limit_10_images_for_piece')</span> <br />
                  <span>@lang('string.backend.create.pieces.files_unde_30MB_size')</span> <br />
                  <span>@lang('string.backend.create.pieces.click_image_to_Primary_image_piece')</span> <br />
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6">
                  <label> @lang('label.backend.create.pieces.type_of_art')</label>
                  <div class="input-group">
                     <select class="form-control form-control-solid" id="exampleSelect1" name="artType_id">
                        <option value=""> @lang('label.backend.create.pieces.select_type_of_art')</option>
                        @if(isset($art_types))
                           @foreach($art_types as $art_type)
                           <option value="{{$art_type->id}}" @if(isset($pieces->artType_id) && $pieces->artType_id == $art_type->id ) selected @endif >
                              {{ $art_type->name}}
                           </option>
                           @endforeach
                        @endif
                     </select>
                  </div>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <div class="row">
                     <div class="col-xl-6">
                        <label class="">@lang('label.backend.create.pieces.price')</label>
                        <input class="form-control form-control-lg form-control-solid" name="price" id="price" type="text" placeholder="@lang('label.backend.create.pieces.enter_price')" value="{{isset($pieces->price)?$pieces->price:''}}">
                     </div>
                     <div class="col-xl-6">
                        <label class="">@lang('label.backend.create.pieces.wholesale_price')</label>
                        <input class="form-control form-control-lg form-control-solid" name="wholesale_price" id="wholesale_price" value="{{isset($pieces->wholesale_price)?$pieces->wholesale_price:''}}" type="text" placeholder="@lang('label.backend.create.pieces.enter_wholesale_price')">
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6">
                  <div class="row">
                     <div class="col-xl-6">
                        <label class="">@lang('label.backend.create.pieces.medium')</label>
                        <input class="form-control form-control-lg form-control-solid" name="medium" id="medium" value="{{isset($pieces->medium)?$pieces->medium:''}}" type="text" placeholder="@lang('label.backend.create.pieces.enter_medium')">
                     </div>
                     <div class="col-xl-6">
                        <label class="">@lang('label.backend.create.pieces.subject_matter')</label>
                        <input class="form-control form-control-lg form-control-solid" name="subject_matter" id="subject_matter" value="{{isset($pieces->subject_matter)?$pieces->subject_matter:''}}" type="text" placeholder="@lang('label.backend.create.pieces.landscape_portrait_etc')">
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <label>@lang('label.backend.create.pieces.tags_comma_separated')</label>
                  <div class="input-group">
                     <input id="kt_tagify_5" class="form-control form-control-lg tagify form-control-solid" id="tag_list" name="tag_list" placeholder="@lang('label.backend.create.pieces.medium')" value="{{isset($pieces->tag_list)?$pieces->tag_list:''}}">
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.creation_date')</legend>
                     <div class="row">
                        <div class="col-xl-4">
                           <select class="form-control form-control-solid" id="creation_date_year" name="creation_date[year]">
                              <option value="">@lang('label.backend.create.pieces.select_year')</option>
                              @php
                                 $start = date('Y');
                                 for($i=$start;$i>=1880;$i--){
                                    @endphp
                                    <option value="{{$i}}" @if(isset($pieces->year) && $pieces->year == $i ) selected @endif >{{$i}}</option>
                                    @php
                                 }
                              @endphp
                           </select>
                        </div>
                        <div class="col-xl-4 pl-0">
                           <select class="form-control form-control-solid" id="creation_date_month" name="creation_date[month]">
                              <option value="">@lang('label.backend.create.pieces.select_month')</option>
                              <option value="1" @if(isset($pieces->month) && $pieces->month == '01' ) selected @endif>January</option>
                              <option value="2" @if(isset($pieces->month) && $pieces->month == '02' ) selected @endif>February</option>
                              <option value="3" @if(isset($pieces->month) && $pieces->month == '03' ) selected @endif>March</option>
                              <option value="4" @if(isset($pieces->month) && $pieces->month == '04' ) selected @endif>April</option>
                              <option value="5" @if(isset($pieces->month) && $pieces->month == '05' ) selected @endif>May</option>
                              <option value="6" @if(isset($pieces->month) && $pieces->month == '06' ) selected @endif>June</option>
                              <option value="7" @if(isset($pieces->month) && $pieces->month == '07' ) selected @endif>July</option>
                              <option value="8" @if(isset($pieces->month) && $pieces->month == '08' ) selected @endif>August</option>
                              <option value="9" @if(isset($pieces->month) && $pieces->month == '09' ) selected @endif>September</option>
                              <option value="10" @if(isset($pieces->month) && $pieces->month == '10' ) selected @endif>October</option>
                              <option value="11" @if(isset($pieces->month) && $pieces->month == '11' ) selected @endif>November</option>
                              <option value="12" @if(isset($pieces->month) && $pieces->month == '12' ) selected @endif>December</option>
                           </select>
                        </div>
                        <div class="col-xl-4 pl-0">
                           <select class="form-control form-control-solid" id="creation_date_date" name="creation_date[date]">
                              <option value="">@lang('label.backend.create.pieces.select_date')</option>
                              @php
                                 for($i=1;$i<=31;$i++){
                                    @endphp
                                    <option value="{{$i}}" @if(isset($pieces->date) && $pieces->date == $i ) selected @endif >{{$i}}</option>
                                    @php
                                 }
                              @endphp
                           </select>
                        </div>
                     </div>
                        <div class="mt-3">
                           <label class="checkbox">
                           @php
                           if(isset($pieces->piece_creation_date_is_circa) && $pieces->piece_creation_date_is_circa==1){
                              $checked_piece_creation_date_is_circa = 'checked';
                           }else{
                               $checked_piece_creation_date_is_circa = '';
                           }
                           @endphp
                           <input type="checkbox" value="1" name="piece_creation_date_is_circa" {{$checked_piece_creation_date_is_circa}} id="piece_creation_date_is_circa">
                           <span></span> &nbsp;@lang('string.backend.create.pieces.show_creation_date_as_circa')</label>
                        </div>
                  </fieldset>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.select_status')</legend>
                     <div class="row">
                        <div class="col-xl-12">
                           <select class="form-control form-control-solid" id="select_status" name="status_id">
                              <option value="">@lang('label.backend.create.pieces.medium')</option>
                              @if(isset($status))
                                 @foreach($status as $statu)
                                 <option value="{{$statu->id}}" @if(isset($pieces->status_id) && $pieces->status_id == $statu->id ) selected @endif >
                                    {{ $statu->status}}
                                 </option>
                                 @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                  </fieldset>
               </div>

            </div>
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.specifications')</legend>
                     <label class="">@lang('string.backend.create.pieces.dimension_work_unframed_inches')</label> <br />
                     <label class="">@lang('string.backend.create.pieces.use_decimals_when_needed')</label> <br />
                     <div class="row">
                        <div class="col-xl-4">
                           <div class="input-group input-group-solid">
                              <div class="input-group-prepend">
                                 <span class="input-group-text">
                                    <label class="text-muted la la-exclamation-triangle icon-lg">H</label>
                                 </span>
                              </div>
                              <input type="text" class="form-control" name="dimension[height]" value="{{isset($pieces->pieces_dimension_height)?$pieces->pieces_dimension_height:''}}">
                           </div>
                        </div>
                        <div class="col-xl-4">
                           <div class="input-group input-group-solid">
                              <div class="input-group-prepend">
                                 <span class="input-group-text">
                                    <label class="text-muted la la-exclamation-triangle icon-lg">W</label>
                                 </span>
                              </div>
                              <input type="text" class="form-control" name="dimension[width]" value="{{isset($pieces->pieces_dimension_width)?$pieces->pieces_dimension_width:''}}">
                           </div>
                        </div>
                        <div class="col-xl-4">
                           <div class="input-group input-group-solid">
                              <div class="input-group-prepend">
                                 <span class="input-group-text">
                                    <label class="text-muted la la-exclamation-triangle icon-lg">D</label>
                                 </span>
                              </div>
                              <input type="text" class="form-control" name="dimension[depth]" value="{{isset($pieces->pieces_dimension_depth)?$pieces->pieces_dimension_depth:''}}">
                           </div>
                        </div>
                     </div>
                     <div class="mt-5">
                        <a class="frame-div-link" href="javascript:void(0);">@lang('label.backend.create.pieces.add_framed_size')</a> <br />
                        <div class="frame-div" style="display:none">
                           <div class="mt-5">
                              <label class="checkbox">
                              @php
                              if(isset($pieces->piece_framed) && $pieces->piece_framed==1){
                                 $piece_framed = 'checked';
                              }else{
                                 $piece_framed = '';
                              }
                              @endphp
                              <input type="checkbox" name="piece_framed" {{$piece_framed}} id="piece_framed" value="1">
                              <span></span> &nbsp;  @lang('label.backend.create.pieces.framed')</label>
                           </div>

                           <label class="mt-5">@lang('label.backend.create.pieces.framed_dimensions_inches')</label>
                           <div class="row">
                              <div class="col-xl-4">

                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">H</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="framed[height]" value="{{isset($pieces->pieces_frame_height)?$pieces->pieces_frame_height:''}}">
                                 </div>
                              </div>
                              <div class="col-xl-4">
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">W</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="framed[width]" value="{{isset($pieces->pieces_frame_width)?$pieces->pieces_frame_width:''}}">
                                 </div>
                              </div>
                              <div class="col-xl-4">
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">D</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="framed[depth]" value="{{isset($pieces->pieces_frame_depth)?$pieces->pieces_frame_depth:''}}">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <a class="paper-size-link" href="javascript:void(0);">@lang('label.backend.create.pieces.medium')</a> <br />
                        <div class="paper-size-div" style="display:none">
                           <div class="row mt-5">
                              <div class="col-xl-6">
                                 <label class="">@lang('label.backend.create.pieces.paper_size')</label>
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">H</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="paper[height]" value="{{isset($pieces->pieces_papersize_height)?$pieces->pieces_papersize_height:''}}">
                                 </div>
                              </div>
                              <div class="col-xl-6">
                                 <label class="">&nbsp;</label>
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">W</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="paper[width]" value="{{isset($pieces->pieces_papersize_width)?$pieces->pieces_papersize_width:''}}">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <a class="duration-link" href="javascript:void(0);">@lang('string.backend.create.pieces.add_duration')</a> <br />
                        <div class="duration-div" style="display:none">
                           <div class="row mt-5">
                              <div class="col-xl-4">
                                 <label class="">@lang('label.backend.create.pieces.duration')</label>
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">Hrs</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="duration[hours]" value="{{isset($pieces->pieces_duration_hours)?$pieces->pieces_duration_hours:''}}">
                                 </div>
                              </div>
                              <div class="col-xl-4">
                                 <label class="">&nbsp;</label>
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="text-muted la la-exclamation-triangle icon-lg">Min</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="duration[minutes]" value="{{isset($pieces->pieces_duration_minutes)?$pieces->pieces_duration_minutes:''}}">
                                 </div>
                              </div>
                              <div class="col-xl-4">
                                 <label class="">&nbsp;</label>
                                 <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text">
                                          <label class="la icon-lg">Sec</label>
                                       </span>
                                    </div>
                                    <input type="text" class="form-control" name="duration[seconds]" value="{{isset($pieces->pieces_duration_second)?$pieces->pieces_duration_second:''}}">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <a class="weight-link" href="javascript:void(0);">@lang('label.backend.create.pieces.add_Weight')</a> <br />
                        <div class="weight-div" style="display:none">
                           <div class="row mt-5">
                              <div class="col-xl-4">
                                 <label class="">@lang('label.backend.create.pieces.weight')</label>
                                 <div class="input-group input-group-solid">
                                    <input type="text" name="weight[weight]" class="form-control" value="{{isset($pieces->pieces_weight_weight)?$pieces->pieces_weight_weight:''}}" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                       <span class="input-group-text">
                                          <i class="la icon-lg">lb</i>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.signature')</legend>
                     <div class="mt-2 mb-5 ">
                           <label class="checkbox">
                           @php
                              if(isset($pieces->piece_signed) && $pieces->piece_signed==1){
                                 $piece_signed = 'checked';
                              }else{
                                 $piece_signed = '';
                              }
                              @endphp
                           <input type="checkbox" name="piece_signed" {{$piece_signed}} value="1">
                           <span></span> &nbsp; @lang('label.backend.create.pieces.signed')</label>
                        </div>
                     <div class="row">
                        <div class="col-xl-12">
                           <textarea class="form-control form-control-solid" name="signatures" id="signatures" cols="30" rows="6">{{isset($pieces->signatures)?$pieces->signatures:''}}</textarea>
                        </div>
                     </div>
                  </fieldset>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6">
                  <label> @lang('label.backend.create.pieces.inventory_number')  @lang('label.backend.create.pieces.must_be_unique')</label>
                  <div class="input-group">
                     <input class="form-control form-control-lg form-control-solid" name="inventory_number" id="inventory_number" value="{{isset($pieces->inventory_number)?$pieces->inventory_number:''}}" type="text" >
                  </div>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.location')</legend>
                     <div id="existing-location-main">
                        <label for="">@lang('label.backend.create.pieces.add_to_existing_location')</label>
                        <div class="row">
                           <div class="col-xl-12">
                              <select class="form-control form-control-solid" id="location_id" name="location_id">
                                 <option value="">@lang('label.backend.create.pieces.select_location')</option>
                                 @if(isset($locations))
                                    @foreach($locations as $location)
                                    <option value="{{$location->id}}" @if(isset($pieces->location_id) && $pieces->location_id == $location->id ) selected @endif >
                                       {{ $location->name}}
                                    </option>
                                    @endforeach
                                 @endif
                              </select>
                           </div>
                        </div>
                        <a href="javascript:void(0)" id="btn-create-location">@lang('label.backend.create.pieces.create_new_location') </a>
                        </div>

                        <div id="create-location" style="display:none">
                           <label for="">@lang('label.backend.create.pieces.new_location_name')</label>
                           <div class="row">
                              <div class="col-xl-12">
                                 <input type="text" name="location_name" class="form-control form-control-solid" id="enter-location-name"/>
                              </div>
                           </div>
                           <div>
                              <a href="javascript:void(0)" id="btn-existing-location">@lang('label.backend.create.pieces.select_existing_location')</a>
                           </div>
                        </div>
                  </fieldset>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.public_info')</legend>
                     <label for="">@lang('string.backend.create.pieces.public_pieces_viewable_on_public_profile')</label>
                     <div class="mt-3 mb-3">
                        <label class="checkbox">
                        @php
                        if(isset($pieces->piece_public) && $pieces->piece_public==1){
                           $piece_public = 'checked';
                        }else{
                              $piece_public = '';
                        }
                        @endphp
                        <input type="checkbox" name="piece_public" {{$piece_public}} value="1">
                        <span></span> &nbsp; @lang('string.backend.create.pieces.make_piece_public')</label>
                     </div>
                     <div class="row">
                        <div class="col-xl-12">
                           <input type="text" class="form-control form-control-solid" name="linkToPurchasePiece" value="{{isset($pieces->linkToPurchasePiece)?$pieces->linkToPurchasePiece:''}}" />
                        </div>
                     </div>

                  </fieldset>
               </div>
               <div class="col-lg-6 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">@lang('label.backend.create.pieces.collections')</legend>
                     <div id="existing-collection-main">
                        <label for="">@lang('label.backend.create.pieces.add_to_existing_collections')</label>
                        <div class="row">
                           <div class="col-xl-12">
                              <select class="form-control select2 form-control-solid" multiple id="collections_id" name="collections_id[]">
                                 @if(isset($collections))
                                    @foreach($collections as $collection)
                                    <option value="{{$collection->id}}">
                                       {{ $collection->collection_name}}
                                    </option>
                                    @endforeach
                                 @endif
                              </select>
                           </div>
                        </div>
                        <a href="javascript:void(0)" id="btn-create-collection">@lang('label.backend.create.pieces.create_new_location')</a>
                     </div>
                     <div id="create-collection" style="display:none">
                        <label for="">@lang('label.backend.create.pieces.new_collection_name')</label>
                        <div class="row">
                           <div class="col-xl-12">
                              <input type="text" class="form-control form-control-solid" name="collection_name" id="enter-collection-name"/>
                           </div>
                        </div>
                        <div>
                           <a href="javascript:void(0)" id="btn-existing-collection">@lang('label.backend.create.pieces.select_existing_location')</a>
                        </div>
                     </div>
                  </fieldset>
               </div>
            </div>
            <hr />
            <div class="form-group row">
               <div class="col-lg-6">
                  <label>@lang('label.backend.create.pieces.description') <br />@lang('string.backend.create.pieces.if_piece_public_description_shown_public_profile_page')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="description" id="description" cols="30" rows="10">{{isset($pieces->description)?$pieces->description:''}}</textarea>
                  </div>
               </div>
               <div class="col-lg-6">
                  <label>@lang('label.backend.create.pieces.notes') <br />@lang('label.backend.create.pieces.always_private')</label>
                  <div class="input-group">
                     <textarea class="form-control form-control-solid" name="notes" id="notes" cols="30" rows="10">{{isset($pieces->notes)?$pieces->notes:''}}</textarea>
                  </div>
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
   var uploadedDocumentMap = {}
   var filename="";
      var KTDropzoneDemo = {
      init: function() {
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         $("#kt_dropzone_2").dropzone({
            url: "/pieces/images",
            headers: {
               'x-csrf-token': CSRF_TOKEN,
            },
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10,
            addRemoveLinks: !0,
            accept: function(e, o) {
               Swal.fire("{{__('string.backend.common.please_wait')}}");
               Swal.showLoading();
               "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
            },
            success: function (file, response) {
               Swal.fire("{{__('string.backend.create.pieces.uploaded')}}", "{{__('string.backend.create.pieces.image_upload_successfully')}}", 'success');
               $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
               uploadedDocumentMap[file.url] = response.name;
               filename=response.name;
            },
            removedfile: function (file) {
               file.previewElement.remove()
               var name = ''
               var id = ''
               if (typeof file.name !== 'undefined') {
                  if(filename!==""){
                        name = filename
                    }else{
                        name = file.name
                    }
                  id = file.id
                  console.log(name+"nem");
               } else {
                  name = uploadedDocumentMap[file.url]
                  id = uploadedDocumentMap[file.id]
                  console.log(name+"nem");
               }
               console.log("name",name);
               $.ajax({
                  url: "{{ route('pieces.remove_images') }}",
                  method: 'POST',
                  data: {"name":name,'id':id},
                  success: function(data)
                  {
                     if(data.status == 'success'){
                        toastr.options.positionClass = "toast-bottom-left";
                        toastr.success(data.message)
                     }
                  },
            });
               $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function () {
                thisDropzone = this;
               @if(isset($pieces) && $pieces->pieces_images)
               var files =
                  {!! json_encode($pieces->pieces_images) !!}
                  $.each(files, function(key,value){
                  var mockFile = { name: value.url,id: value.id };
                  thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                  thisDropzone.options.thumbnail.call(thisDropzone, mockFile, '{{asset_image_path()}}'+"/images/pieces/"+value.url);

               });

               @endif
            }
         });
      }
   };

   KTUtil.ready((function() {
      KTDropzoneDemo.init()
   }));
   //Tab
   var input = document.querySelector('input[name=tag_list]');
   new Tagify(input)

   $(document).ready(function() {
      $(".frame-div-link").on("click", function(event){
         event.preventDefault();
         $('.frame-div').toggle();
      });
      $(".paper-size-link").on("click", function(event){
         event.preventDefault();
         $('.paper-size-div').toggle();
      });
      $(".duration-link").on("click", function(event){
         event.preventDefault();
         $('.duration-div').toggle();
      });
      $(".weight-link").on("click", function(event){
         event.preventDefault();
         $('.weight-div').toggle();
      });
      $("#btn-create-collection").on("click", function(event){
         event.preventDefault();
         $('#create-collection').show();
         $('#existing-collection-main').hide();
      });
      $("#btn-existing-collection").on("click", function(event){
         event.preventDefault();
         $('#existing-collection-main').show();
         $('#create-collection').hide();
      });
      $("#btn-create-location").on("click", function(event){
         event.preventDefault();
         $('#create-location').show();
         $('#existing-location-main').hide();
      });
      $("#btn-existing-location").on("click", function(event){
         event.preventDefault();
         $('#existing-location-main').show();
         $('#create-location').hide();
      });
      $(".select2").select2({
         multiple: true,
      });
      var selectedValue = "{{isset($pieces->collections_id) ? $pieces->collections_id:''}}";
      if(selectedValue){
         var str = selectedValue.split(',');
         $('.select2').val(str).trigger('change');
      }else{
         $('.select2').val();
      }
      //Create Pieces
      $("#btncreatePieces").on("click", function(event){
         $('#savePiecesForm').trigger('submit');
      });
      $("#savePiecesForm").on("submit", function(event){
         event.preventDefault();

         $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('pieces.store') }}",
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
							window.location.href = "{{route('pieces.index')}}";
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
