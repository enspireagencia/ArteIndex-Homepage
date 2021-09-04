
{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="d-flex flex-column-fluid">
	
	<div class="container">
		<div class="card mb-5">
			<div class="card-header">
				<h2><strong>My Profile</strong></h2>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-8">
						<input type="text" class="form-control  form-control-solid" id="public_url" value="{{url('/profile/'.Auth::user()->user_unique_id)}}" readonly/>
					</div>
					<div class="col-lg-4">
						<a href="javascript:void(0)" class="mr-2" onclick="copyToClipboard('#public_url')"><i class="icon-2x text-success ki ki-copy"></i></a>
					</div>
                </div>
			</div>
		</div>
		<div class="d-flex flex-row">
			
			<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
				
				@include('pages.users.profile_sidebar') 
				
			</div>
			
			
			<div class="flex-row-fluid ml-lg-8">
				
				<div class="card card-custom card-stretch">
					
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark">@lang('label.backend.admin.about.about')</h3>
							<span class="text-muted font-weight-bold font-size-sm mt-1">@lang('string.backend.admin.about.update_your_about_informaiton')</span>
						</div>
						
					</div>
					
					
					<form class="form" method="POST" enctype="multipart/form-data" id="saveAboutForm">
					@csrf
						<div class="card-body">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">About Page Cover Photo</label>
								<div class="col-lg-9 col-xl-6">
									<div class="image-input image-input-outline" id="kt_profile_about" style="background-image: url('{{url('/images/default_image_1.jpg')}}')">
										<div class="image-input-wrapper" style="background-image: url(/images/profile/aboutpagecoverphoto/{{isset($user->profile->about_page_cover_photo)?$user->profile->about_page_cover_photo:''}})"></div>
										<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
											<i class="fa fa-pen icon-sm text-muted"></i>
											<input type="file" name="about_page_cover_photo" accept=".png, .jpg, .jpeg">
											<input type="hidden" name="profile_avatar_remove">
										</label>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.about.public_profile_cover_image')</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.about.short_bio')</label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="short_bio" id="short_bio" type="text" value="{{isset($user->profile->short_bio)?$user->profile->short_bio:''}}" placeholder="@lang('label.backend.admin.about.enter_short_bio')">
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.about.biography')</label>
								<div class="col-lg-9 col-xl-6">
									<textarea class="form-control form-control-lg form-control-solid" name="biography" id="biography" rows="5">{{isset($user->profile->biography)?$user->profile->biography:''}}</textarea>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.about.statement')</label>
								<div class="col-lg-9 col-xl-6">
									<textarea class="form-control form-control-lg form-control-solid" name="statement" id="statement" rows="5">{{isset($user->profile->statement)?$user->profile->statement:''}}</textarea>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<div class="card-toolbar col-xl-12 text-right">
								<button type="submit" class="btn btn-success mr-2">@lang('buttons.backend.general.save_changes')</button>
							</div>
							</div>
							
						</div>
						
					</form>
					
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>
<script src="{{ asset('js/ckeditor.js') }}"></script>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script>
   ClassicEditor
    .create( document.querySelector( '#biography' ), {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    } )
    .catch( error => {
        console.log( error );
    } );
	ClassicEditor
    .create( document.querySelector( '#statement' ), {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    } )
    .catch( error => {
        console.log( error );
    } );

	$(document).ready(function(){
		$("#saveAboutForm").on("submit", function(event){
			event.preventDefault();
			$('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);

			$.ajax({
				url: "{{ route('admin.user_about') }}",
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
						Swal.fire("{{__('string.backend.create.pieces.updated')}}", data.message, 'success');
						setTimeout(function(){
							window.location.reload();
						}, 3000);
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
		});
	});
	var about_img = new KTImageInput('kt_profile_about');
	about_img.on('cancel', function(imageInput) {
	});

	about_img.on('change', function(imageInput) {
	});

	about_img.on('remove', function(imageInput) {
		Swal.fire({
			title: 'Profile Image successfully removed !',
			type: 'error',
			buttonsStyling: false,
			confirmButtonText: 'Got it!',
			confirmButtonClass: 'btn btn-primary font-weight-bold'
		});
	});
	function copyToClipboard(element) {
		console.log(element);
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).val()).select();
		document.execCommand("copy");
		$temp.remove();
		toastr.options.positionClass = "toast-bottom-left";
		toastr.success("{{__('string.backend.common.copied_url')}}")
	}
</script>
@endsection
