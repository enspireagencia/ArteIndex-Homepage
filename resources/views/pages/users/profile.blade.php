
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

            <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">

                @include('pages.users.profile_sidebar')

            </div>
			

			<div class="flex-row-fluid ml-lg-8">

				<div class="card card-custom card-stretch">

					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
							<h3 class="card-label font-weight-bolder text-dark"> @lang('label.backend.admin.profile_info.personal_information') </h3>
							<span class="text-muted font-weight-bold font-size-sm mt-1"> @lang('string.backend.admin.profile_info.update_personal_informaiton') </span>
						</div>
					</div>


					<form class="form" method="POST" enctype="multipart/form-data" id="saveProfileForm">
					@csrf
						<div class="card-body">
							<div class="row">
                                <label class="col-xl-3 col-lg-3 col-form-label"></label>
								<div class="col-lg-4 col-xl-4">
									<h5 class="font-weight-bold mb-6">@lang('label.backend.admin.profile_info.profile_image') </h5>
								</div>
                            </div>
							<div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label"></label>
								<div class="col-lg-4 col-xl-4">
									<div class="image-input image-input-outline image-input-circle" id="pro-img" style="background-image: url(/media/users/blank.png)">
										@if(isset($user->profile->profile_image))
											<div class="image-input-wrapper" style="background-image: url({{asset_image_display($user->profile->profile_image,"images/profile/profileimage/")}})"></div>
										@else
											<div class="image-input-wrapper" style="background-image: url(/media/users/blank.png)"></div>
										@endif
										<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
											<i class="fa fa-pen icon-sm text-muted"></i>
											<input type="file" name="profile_image" id="" accept=".png, .jpg, .jpeg">

											<input type="hidden" name="profile_image_remove">
										</label>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
									</div>
									<span id="profile_image"></span>
									<div class="invalid-feedback"></div>
								</div>
                            </div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.logo') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="logo" id="logo" type="file">
									<div class="invalid-feedback"></div>
								</div>
								<div class="col-lg-3 col-xl-3">
									<div class="image-input image-input-outline" id="pro-img" style="background-image: url('{{url('/images/default_image_1.jpg')}}')">
										@if(isset($user->profile->logo))
											<div class="image-input-wrapper" style="background-image: url({{asset_image_display($user->profile->logo,"images/profile/logo/")}})"></div>
										@else
											<div class="image-input-wrapper" style="background-image: url('{{url('/images/default_image_1.jpg')}}')"></div>
										@endif
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.report_header') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="report_header" id="report_header" type="file">
									<div class="invalid-feedback"></div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.upload_image_here_archive_reports')</span>
								</div>
								<div class="col-lg-3 col-xl-3">
									<div class="image-input image-input-outline" id="pro-img" style="background-image: url('{{url('/images/default_image_1.jpg')}}')">
										@if(isset($user->profile->report_header))
											<div class="image-input-wrapper" style="background-image: url({{asset_image_display($user->profile->report_header,"images/profile/reportheader/")}})"></div>
										@else
											<div class="image-input-wrapper" style="background-image: url('{{url('/images/default_image_1.jpg')}}')"></div>
										@endif
									</div>
								</div>
							</div>
                            <hr />
                            <div class="row">
								<label class="col-xl-3"></label>
								<div class="col-lg-9 col-xl-6 mb-6">
									<h5 class="font-weight-bold mt-10">@lang('label.backend.admin.profile_info.profile_info') </h5>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.name') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="name" id="name" value="{{isset($user->profile->name)?$user->profile->name:''}}" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_name') ">
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.phone') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="phone" id="phone" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_phone') " value="{{isset($user->profile->phone)?$user->profile->phone:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.website') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="website" id="website" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_website') " value="{{isset($user->profile->website)?$user->profile->website:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.address_1') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="address_line_1" id="address_line_1" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_address_1') " value="{{isset($user->profile->address_line_1)?$user->profile->address_line_1:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.address_2') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="address_line_2" id="address_line_2" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_address_2') " value="{{isset($user->profile->address_line_2)?$user->profile->address_line_2:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.city') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="city" id="city" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_city') " value="{{isset($user->profile->city)?$user->profile->city:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.state') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="state" id="state" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_state') " value="{{isset($user->profile->state)?$user->profile->state:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.zip_codes') </label>
								<div class="col-lg-9 col-xl-6">
									<input class="form-control form-control-lg form-control-solid" name="zip" id="zip" type="text" placeholder="@lang('label.backend.admin.profile_info.enter_zip_codes') " value="{{isset($user->profile->zip)?$user->profile->zip:''}}">
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.report_header') </label>
                                <div class="col-lg-9 col-xl-6">
                                    <select class="form-control form-control-lg form-control-solid" name="country" id="country">
                                        <option value="">@lang('label.backend.admin.profile_info.select_country') </option>
										@if(isset($countries))
											@foreach($countries as $country)
											<option value="{{$country->name}}" {{isset($user->profile) && $user->profile->country == $country->name ? 'selected' : '' }} >
												{{ $country->name}}
											</option>
											@endforeach
										@endif
                                    </select>
									<div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row">
								<label class="col-xl-3"></label>
								<div class="col-lg-9 col-xl-6 mb-6">
									<h5 class="font-weight-bold mt-10">@lang('label.backend.admin.profile_info.report_header') </h5>
                                    <span class="form-text text-muted">@lang('string.backend.admin.profile_info.must_valid_url')</span>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.facebook') </label>
								<div class="col-lg-9 col-xl-6">
									<div class="input-group input-group-lg input-group-solid">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="la la-facebook"></i>
											</span>
										</div>
										<input type="text" name="facebook" id="facebook" class="form-control form-control-lg form-control-solid" placeholder="@lang('label.backend.admin.profile_info.enter_facebook_link') " value="{{isset($user->profile->facebook)?$user->profile->facebook:''}}">
										<div class="invalid-feedback"></div>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.we_never_share_email_anyone')</span>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.twitter') </label>
								<div class="col-lg-9 col-xl-6">
									<div class="input-group input-group-lg input-group-solid">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="la la-twitter"></i>
											</span>
										</div>
										<input type="text" name="twitter" id="twitter" class="form-control form-control-lg form-control-solid" placeholder="@lang('label.backend.admin.profile_info.enter_twitter_link') " value="{{isset($user->profile->twitter)?$user->profile->twitter:''}}">
										<div class="invalid-feedback"></div>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.we_never_share_email_anyone')</span>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.linkedIn') </label>
								<div class="col-lg-9 col-xl-6">
									<div class="input-group input-group-lg input-group-solid">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="la la-linkedin"></i>
											</span>
										</div>
										<input type="text" name="linkedIn" id="linkedIn" class="form-control form-control-lg form-control-solid" placeholder="@lang('label.backend.admin.profile_info.enter_linkedIn_link') " value="{{isset($user->profile->linkedIn)?$user->profile->linkedIn:''}}">
										<div class="invalid-feedback"></div>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.we_never_share_email_anyone')</span>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.pinterest') </label>
								<div class="col-lg-9 col-xl-6">
									<div class="input-group input-group-lg input-group-solid">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="la la-pinterest"></i>
											</span>
										</div>
										<input type="text" name="pinterest" id="pinterest" class="form-control form-control-lg form-control-solid" placeholder="@lang('label.backend.admin.profile_info.enter_pinterest_link') " value="{{isset($user->profile->pinterest)?$user->profile->pinterest:''}}">
										<div class="invalid-feedback"></div>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.we_never_share_email_anyone')</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.profile_info.instagram')</label>
								<div class="col-lg-9 col-xl-6">
									<div class="input-group input-group-lg input-group-solid">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="la la-instagram"></i>
											</span>
										</div>
										<input type="text" name="instagram" id="instagram" class="form-control form-control-lg form-control-solid" placeholder="@lang('label.backend.admin.profile_info.enter_instagram_link')" value="{{isset($user->profile->instagram)?$user->profile->instagram:''}}">
										<div class="invalid-feedback"></div>
									</div>
									<span class="form-text text-muted">@lang('string.backend.admin.profile_info.we_never_share_email_anyone')</span>
								</div>
							</div>
                            <div class="row">
								<label class="col-xl-3"></label>
								<div class="col-lg-12 col-xl-12 mb-6">
									<h5 class="font-weight-bold mt-10">@lang('label.backend.admin.profile_info.profile_footer')</h5>
                                    <span class="form-text text-muted">@lang('string.backend.admin.profile_info.will_shown_bottom_profile_pages')</span>
								</div>
							</div>
                            <div class="form-group row">
								<div class="col-lg-12 col-xl-12">
									<textarea name="profile_footer" id="profile_footer" class="form-control form-control-lg form-control-solid" rows="5">{{isset($user->profile->profile_footer)?$user->profile->profile_footer:''}}</textarea>
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12 text-right">
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
    .create( document.querySelector( '#profile_footer' ), {
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

		$("#saveProfileForm").on("submit", function(event){

			event.preventDefault();
			$('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);

			$.ajax({
				url: "{{ route('admin.user_profile') }}",
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
		});
	});

	var pro_img = new KTImageInput('pro-img');
	pro_img.on('cancel', function(imageInput) {
	});

	pro_img.on('change', function(imageInput) {
	});

	pro_img.on('remove', function(imageInput) {
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
