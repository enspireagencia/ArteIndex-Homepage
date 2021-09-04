{{-- Extends layout --}}

@extends('layout.front_profile')


{{-- Content --}}
@section('content')

<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <div class="container mt-4">
      <!--begin::Row-->
      <div class="row">
         <div class="col-xl-12">
            <!--begin::Mixed Widget 14-->
            <div class="card card-custom card-stretch gutter-b">
               <div class="card-body p-15 pb-20">
                  <div class="font-size-h2 mb-7 text-dark-50">
                     <a href="{{route('profile',$data->user_unique_id)}}" class="btn btn-primary font-weight-bolder font-size-sm">
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
                     <div class="col-sm-12 mb-11 mb-xxl-0">
                     <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{$post->title ?? ""}}</h2>
                     <div class=" font-size-h5 text-dark mb-7">
                        <span>{{date('F Y',strtotime($post->created_at)) ?? ""}} &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                           <span class="mt-9 mb-6 fb-share-button">
                              <span class="fb-share-button" data-href="{{route('profile.post_detail',[$data->user_unique_id,$post->slug])}}" data-layout="button" data-size="large">
                                 <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('profile.post_detail',[$data->user_unique_id,$post->slug])}}" class="fb-xfbml-parse-ignore btn btn-md btn-icon btn-light-facebook btn-pill mx-2">
                                    <i class="socicon-facebook"></i>
                                 </a>
                              </span>
                              <a target="_blank" class="btn btn-md btn-icon btn-light-twitter btn-pill mx-2 twitter-share-button" href="https://twitter.com/intent/tweet?url={{route('profile.post_detail',[$data->user_unique_id,$post->slug])}}" data-size="large">
                                 <i class="socicon-twitter"></i>
                              </a>
                              <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{route('profile.post_detail',[$data->user_unique_id,$post->slug])}}" class="btn btn-md btn-icon btn-light-linkedin btn-pill mx-2">
                                 <i class="socicon-linkedin"></i>
                              </a>
                           </span>
                        </span>
                     </div>

                        <!--begin::Image-->
                        <div class="card card-custom card-stretch">
                           <div class=" text-center align-items-center overlay-wrapper parent-container">
                                @php
                                $thumimage=url("/media/users/blank.png");
                                if(isset($post->image)){
                                    $thumimage=asset_image_display($post->image,"images/profile/mypost/");
                                }
                                @endphp
                                <a href="{{$thumimage}}">
                                    <img style="background-image:url('{{$thumimage}}')" alt="" class="background_img_1">
                                </a>
                          </div>
                        </div>
                        <!--end::Image-->
                     </div>
                     <div class="col-sm-12 mt-5">
                        <div class="line-height-xl">{!! $post->body ?? "" !!}</div>
                     </div>
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
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId=577395446472038&autoLogAppEvents=1" nonce="uKvlY3ry"></script>
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
