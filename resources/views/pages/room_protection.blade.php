{{-- Extends layout --}}

@extends('layout.front_pieces')

{{-- Content --}}
@section('content')
<form class="form" enctype="multipart/form-data" method="post" id="password_protection">
<div class="d-flex flex-column-fluid">
   <div class="container">
       <div class="card card-custom">
         <div class="card-body p-0">
            <div class="wizard wizard-6 d-flex flex-column flex-lg-row flex-column-fluid" id="kt_wizard" data-wizard-state="first">
               <div class="wizard-content d-flex flex-column mx-auto py-10 py-lg-20 w-100 w-md-700px">
                  <form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_forgot_form">
									<div class="text-center pb-8">
										<h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">This private room requires a password.</h2>
									</div>
									<div class="form-group fv-plugins-icon-container">
										<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off">
                                        <input type="hidden" placeholder="Password" name="slug" value="{{$data->slug}}">
                                        <div class="invalid-feedback"></div>
                                    <div class="fv-plugins-message-container"></div></div>
									<div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
										<button type="button" id="password_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
									</div>
								<div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</form>
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script>
     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
     $(document).ready(function() {
          //Create Pieces
          $("#password_submit").on("click", function(event){
         $('#password_protection').trigger('submit');
      });
      $("#password_protection").on("submit", function(event){
         event.preventDefault();

           $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('rooms_protection') }}",
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
                     Swal.fire("Successed", data.message, 'success');
						setTimeout(function(){
							window.location.href = "{{route('rooms_pieces_lists',$data->slug)}}";
						}, 1500);
					}
					if(data.status == 'error'){
						Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
					}
				},
				error :function( data ) {
					if( data.status === 422 ) {
						Swal.fire("Error", "Please Enter Password", 'error');
					}
				}
			});
      })
   });
</script>
@endsection
