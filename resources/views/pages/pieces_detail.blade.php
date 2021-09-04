{{-- Extends layout --}}

@extends('layout.front_pieces')


{{-- Content --}}
@section('content')

<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <div class="container mt-4">
      <!--begin::Notice-->
      <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
        <div class="alert-text">
           <span class="basic-color-text font-weight-bolder font-size-h1 d-md-inline mr-3">{{$data->name}}</span>
           <span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">from {{$data->user->name}}</span>
           <span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">
              <p>
               {{$data->description}}
              </p>
           </span>
        </div>
     </div>
      <!--end::Notice-->
      <!--begin::Row-->
      <div class="row">
         <div class="col-xl-12">
            <!--begin::Mixed Widget 14-->
            <div class="card card-custom card-stretch gutter-b">
               <div class="card-body p-15 pb-20">
                  <div class="font-size-h2 mb-7 text-dark-50">
                     <a href="{{route('rooms_pieces_lists',$data->slug)}}" class="btn btn-primary font-weight-bolder font-size-sm">
                     <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                        <title>Stockholm-icons / Media / Backward</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="Stockholm-icons-/-Media-/-Backward" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                           <path d="M11.0879549,18.2771971 L17.8286578,12.3976203 C18.0367595,12.2161036 18.0583109,11.9002555 17.8767943,11.6921539 C17.8622027,11.6754252 17.8465132,11.6596867 17.8298301,11.6450431 L11.0891271,5.72838979 C10.8815919,5.54622572 10.5656782,5.56679309 10.3835141,5.7743283 C10.3034433,5.86555116 10.2592899,5.98278612 10.2592899,6.10416552 L10.2592899,17.9003957 C10.2592899,18.1765381 10.4831475,18.4003957 10.7592899,18.4003957 C10.8801329,18.4003957 10.9968872,18.3566309 11.0879549,18.2771971 Z" id="Path-10" fill="#FFFFFF" opacity="0.3" transform="translate(14.129645, 12.002277) scale(-1, 1) translate(-14.129645, -12.002277) "></path>
                           <path d="M5.08795487,18.2771971 L11.8286578,12.3976203 C12.0367595,12.2161036 12.0583109,11.9002555 11.8767943,11.6921539 C11.8622027,11.6754252 11.8465132,11.6596867 11.8298301,11.6450431 L5.08912711,5.72838979 C4.8815919,5.54622572 4.56567821,5.56679309 4.38351414,5.7743283 C4.30344325,5.86555116 4.25928988,5.98278612 4.25928988,6.10416552 L4.25928988,17.9003957 C4.25928988,18.1765381 4.48314751,18.4003957 4.75928988,18.4003957 C4.88013293,18.4003957 4.99688719,18.3566309 5.08795487,18.2771971 Z" id="Path-10-Copy" fill="#FFFFFF" transform="translate(8.129645, 12.002277) scale(-1, 1) translate(-8.129645, -12.002277) "></path>
                        </g>
                     </svg>
                     Back to all artwork </a>
                  </div>
                  <div class="row mb-17">
                     <div class="col-sm-5 mb-11 mb-xxl-0">
                        <!--begin::Image-->
                        <div class="card card-custom card-stretch p-2">
                           <div class=" test_image d-flex align-items-center justify-content-center overlay-wrapper parent-container">
                                @php
                                $thumimage=url("/media/users/blank.png");
                                if(isset($pieces->pieces_images[0]->url)){
                                    $thumimage=asset_image_display($pieces->pieces_images[0]->url,"images/pieces/");
                                }
                                @endphp
                                <a href="{{$thumimage}}">
                                    <img src="{{$thumimage}}">
                                </a>
                          </div>
                          @if($data->show_public_show_additional_images == 1 && count($pieces->pieces_images) > 1)
                          <div id="gal">
                              <div class="row">
                                 @php
                                    $thumimage=url("/media/users/blank.png");
                                 @endphp

                                 @foreach ($pieces->pieces_images as $key => $image)
                                 @if($key!=0)
                                    @php
                                             $thumimage=asset_image_display($image->url,"images/pieces/");
                                    @endphp
                                    <div class="col-lg-4 col-md-12 col-sm-4 col-4 test overlay-wrapper parent-container">
                                        <a href="{{$thumimage}}">
                                            <img src="{{$thumimage}}">
                                        </a>
                                     </div>
                                     @endif
                                 @endforeach
                              </div>
                          </div>
                          @endif
                        </div>
                        <!--end::Image-->
                     </div>
                     <div class="col-sm-7 pl-xxl-11">
                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{$pieces->title ?? ""}}</h2>
                        <div class="line-height-xl">{{$pieces->description ?? ""}}</div>

                        <div class="font-size-h2 mb-7 text-dark-50 mt-5">
                        @if($data->show_public_show_inquire == 1)
                        <a data-toggle="modal" data-target="#sendinquiry" class="btn btn-light-primary font-weight-bolder px-8 font-size-sm mr-6">Inquiry</a>
                        @endif
                        @if($data->show_public_show_purchase == 1)
                            <a href="#" class="btn btn-light-primary font-weight-bolder px-8 font-size-sm mr-6">Purchase</a>
                        @endif
                    </div>
                     </div>
                  </div>
                  <div class="row mb-6">
                     <!--begin::Info-->


                     @if(isset($pieces->medium))
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Medium</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{$pieces->medium}}</strong></span>
                        </div>
                     </div>
                     @endif

                     @if(isset($pieces->dimension))
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Dimension (.in)</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{float_number_format($pieces->dimension->length)."X".float_number_format($pieces->dimension->width)."X".float_number_format($pieces->dimension->depth)." in" }}</strong></span>
                        </div>
                     </div>
                      @endif

                      @if(isset($pieces->dimension) && $data->show_public_show_both_sizes == 1)
                      <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Dimension (.cm)</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{float_number_format(($pieces->dimension->length * 2.54))."X".float_number_format(($pieces->dimension->width * 2.54))."X".float_number_format(($pieces->dimension->depth * 2.54))." .cm" }}</strong></span>
                        </div>
                     </div>
                      @endif

                     @if(isset($pieces->price) && $pieces->status_id != 6)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Price</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{$pieces->price}}</strong></span>
                        </div>
                     </div>

                     @if($data->show_public_show_wholesale_prices == 1)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Wholesale Price</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{$pieces->wholesale_price}}</strong></span>
                        </div>
                     </div>
                     @endif

                     @endif
                     @if($data->show_public_show_sales == 1 && $pieces->status_id == 6)

                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Status</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><span class="label label-danger font-size-h5 label-inline mb-1 text-white"><strong>Sold</strong></span></span>
                        </div>
                     </div>
                     @endif

                     @if($data->show_public_show_subject_matter == 1)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Subject Matter</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{$pieces->subject_matter ?? ""}}</strong></span>
                        </div>
                     </div>
                     @endif

                     @if($data->show_public_show_creation_date == 1)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Created Date</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{ date("F d,Y", strtotime($pieces->creation_date))}}</strong></span>
                        </div>
                     </div>
                     @endif

                     @if($data->show_public_show_inventory_numbers == 1)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Inventory Number</span>
                           <span class="text-muted font-weight-bolder font-size-lg"><strong>{{$pieces->inventory_number ?? 0}}</strong></span>
                        </div>
                     </div>
                     @endif
                     @if($data->show_public_show_collections == 1)
                     <div class="col-6 col-md-4">
                        <div class="mb-8 d-flex flex-column">
                           <span class="text-dark font-weight-bold mb-4">Collections</span>
                           <span class="text-muted font-weight-bolder font-size-lg">
                            @if(count($collections) > 0)
                            @foreach($collections as $key => $collection)
                                {{$collection->collection_name}}
                                @if(count($collections) > $key+1) , @endif
                            @endforeach
                            @endif
                           </span>
                        </div>
                     </div>
                     @endif



                     <!--end::Info-->
                  </div>
                  <!--begin::Buttons-->
                  <!--end::Buttons-->
               </div>
            </div>
            <!--end::Mixed Widget 14-->
         </div>

      </div>
      <!--end::Row-->
   </div>
   <!--end::Container-->
</div>
<!-- Edit Works Modal-->
<div class="modal fade" id="sendinquiry" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="WorkTitle">Contact</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
               </button>
            </div>
            <form class="form" enctype="multipart/form-data" method="post" id="sendinquiryForm">
               <div class="modal-body">
                  <div class="form-group">
                     <div class="col-lg-12 col-md-9 col-sm-12">
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Name</label>
                              <input class="form-control  form-control-solid" name="name" id="name" value="" type="text">
                              <input  name="piece_id" id="piece_id" value="{{$pieces->id}}" type="hidden">
                              <input  name="room_slug" id="room_slug" value="{{$data->slug}}" type="hidden">
                              <input type="hidden" name="private_room_id" value="{{$data->id ?? ''}}">
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Email</label>
                              <input class="form-control  form-control-solid" name="email" id="email" value="" type="text">
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Phone</label>
                              <input class="form-control  form-control-solid" name="phone" id="phone" type="text">
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Message</label>
                              <textarea class="form-control  form-control-solid" name="message" id="message" cols="10" rows="4"> </textarea>
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                  <button type="button" id="inquirypieces" class="btn btn-primary font-weight-bold">Send</button>
               </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css"/>
<script>
 $(document).ready(function() {
      $('.parent-container').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            image: {
               verticalFit: true
            },
            zoom: {
               enabled: true,
               duration: 300 // don't foget to change the duration also in CSS
            },
            gallery: {
               arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow butto
               enabled: true
            },
            // other options
      });
   });

//submit inquiry form
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $("#inquirypieces").on("click", function(event){
         $('#sendinquiryForm').trigger('submit');
      });
      $("#sendinquiryForm").on("submit", function(event){
         event.preventDefault();
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('pieces_inquiry') }}",
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
                     Swal.fire("{{__('string.backend.common.sent')}}", data.message, 'success');
                     setTimeout(function(){
                        location.reload();
						}, 1500);
				}
				if(data.status == 'error'){
						Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
				}

				},
				error :function( data ) {
					if( data.status === 422 ) {
						Swal.fire("Error", "The given data was invalid", 'error');
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
