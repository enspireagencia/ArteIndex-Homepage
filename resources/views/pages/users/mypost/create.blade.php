
{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="d-flex flex-column-fluid">
	<div class="container">
		<div class="d-flex flex-row">
			<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
				@include('pages.users.profile_sidebar')
			</div>

			<div class="flex-row-fluid ml-lg-8">
				<div class="card card-custom card-stretch">
					<div class="card-header py-3">
						<div class="card-title align-items-start flex-column">
						@if (isset($myPost))
							<h3 class="card-label font-weight-bolder text-dark">@lang('label.backend.admin.my_post.edit_post')</h3>
						@else
							<h3 class="card-label font-weight-bolder text-dark">@lang('label.backend.admin.my_post.add_post')</h3>
						@endif
						</div>
					</div>

					<form class="form" method="POST" enctype="multipart/form-data" id="savePostForm">
					@csrf
						<div class="card-body">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.my_post.photo')</label>
								<div class="col-lg-9 col-xl-9">
									<div class="image-input image-input-outline" id="kt_profile_about" style="background-image: url('{{url('/images/default_image_1.jpg')}}')">
										<div class="image-input-wrapper" style="background-image: url({{isset($myPost->image)?asset_image_display($myPost->image,'images/profile/mypost/'):''}})"></div>
										<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
											<i class="fa fa-pen icon-sm text-muted"></i>
											<input type="file" name="image" accept=".png, .jpg, .jpeg">
											<input type="hidden" name="post_image_remove">
											<input type="hidden" name="old_image" id="old_image" value="{{isset($myPost->image)?$myPost->image:''}}" />
										</label>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
										<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
											<i class="ki ki-bold-close icon-xs text-muted"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.my_post.title')</label>
								<div class="col-lg-9 col-xl-9">
									<input class="form-control form-control-lg form-control-solid" name="title" id="title" type="text" value="{{isset($myPost->title)?$myPost->title:''}}" placeholder="Enter the title">
									<input type="hidden" name="post_id" id="post_id" value="{{isset($myPost->id)?$myPost->id:''}}" />
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.my_post.subheader')</label>
								<div class="col-lg-9 col-xl-9">
									<input class="form-control form-control-lg form-control-solid" name="subheader" id="subheader" type="text" value="{{isset($myPost->subheader)?$myPost->subheader:''}}" placeholder="Enter the Subheader">
									<div class="invalid-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.my_post.body')</label>
								<div class="col-lg-9 col-xl-9">
									<textarea id="body" name="body" rows="5">{{isset($myPost->body)?$myPost->body:''}}</textarea>
									<div class="invalid-feedback"></div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">@lang('label.backend.admin.my_post.publish_info')</label>
								<div class="col-lg-9 col-xl-9 publish_info">
                                    <div class="">
                                        <label class="checkbox mb-3">
										@php
											if(isset($myPost->status) && $myPost->status==1){
												$status = 'checked';
											}else{
												$status = '';
											}
										@endphp
                                            <input type="checkbox" name="status" {{$status}} value="1">
                                            <span></span> &nbsp; @lang('label.backend.admin.my_post.publish_post')
                                        </label>
								        <label class="col-form-label">@lang('label.backend.admin.my_post.post_date')</label>
                                        <input class="form-control form-control-lg form-control-solid" name="post_date" id="post_date" type="date"  placeholder="Enter the Subheader" value="{{isset($myPost->post_date)?$myPost->post_date:''}}">
                                    </div>
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
	.create( document.querySelector( '#body' ), {
		removePlugins: [ 'MediaEmbed','oembed' ],
		image: {
            styles: [
                'alignLeft', 'alignCenter', 'alignRight'
            ],
            toolbar: [
                'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                '|',
                'resizeImage',
                '|',
                'imageTextAlternative'
            ]
        },
		ckfinder: {
			uploadUrl: "{{route('ckeditor.mypost.upload', ['_token' => csrf_token() ])}}",
		},
	} )
	.catch( error => {
		console.error( error );
	} );
	$(document).ready(function(){
		$("#savePostForm").on("submit", function(event){
			event.preventDefault();
			$('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);

			$.ajax({
				url: "{{ route('posts.store') }}",
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
							window.location.href = "{{route('user.my_posts', [Auth::user()->user_unique_id, 'all'])}}";
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
	var about_img = new KTImageInput('kt_profile_about');
	about_img.on('cancel', function(imageInput) {
	});

	about_img.on('change', function(imageInput) {
	});

	about_img.on('remove', function(imageInput) {
		Swal.fire({
			title: 'Post Image successfully removed !',
			type: 'error',
			buttonsStyling: false,
			confirmButtonText: 'Got it!',
			confirmButtonClass: 'btn btn-primary font-weight-bold'
		});
	});
</script>
@endsection

<style>
.col-lg-9.col-xl-6.publish_info {
    border: 1px solid #00000024;
    padding: 30px;
}
</style>
