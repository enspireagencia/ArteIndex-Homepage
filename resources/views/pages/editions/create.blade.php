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
            @if(isset($editions))
            Edit Edition
            @else
            New Edition <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('editions.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateRuns">
            <i class="ki ki-check icon-sm"></i>
            @if(isset($editions))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') Edition
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveRunsForm">
         <div class="card-body">
         @if(!isset($editions))
            <div class="form-group row">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <fieldset>
                     <legend class="">Pick Your Piece </br>  </legend>
                     <div class="row">
                        <div class="col-xl-12">
                           <select class="form-control form-control-solid" id="piece_id" name="piece_id">
                              <option value="">Select Your Piece</option>
                              @if(isset($pieces))
                                 @foreach($pieces as $piece)
                                 <option value="{{$piece->id}}" @if(isset($editions->piece_id) && $editions->piece_id == $piece->id ) selected @endif >
                                    {{ $piece->title}}
                                 </option>
                                 @endforeach
                              @endif
                        </select>
                        <div class="invalid-feedback"></div>
                        </div>
                     </div>
                  </fieldset>
               </div>
            </div>
            @endif
            <label for=""><h5><b>Edition Info</b></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Name of Edition</label>
                        <input class="form-control  form-control-solid" name="name" id="name" value="{{isset($editions->name)?$editions->name:''}}" type="text">
                        <input type="hidden" name="editions_id" id="editions_id" value="{{isset($editions->id)?$editions->id:''}}" />
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                 <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Edition Default Image</label>
                        <input class="form-control  form-control-solid" name="default_image" id="default_image" type="file">
                        @if(isset($editions))
                           @if(isset($editions->default_image))
                           <div class="card card-custom overlay w-50">
                              <div class="card-body p-0">
                                 <div class="overlay-wrapper">
                                    <img src="{{asset_image_display($editions->default_image,"images/editions/")}}" alt="" class="w-100 rounded"/>
                                 </div>
                                 <div class="overlay-layer">
                                       <a href="javascript:void(0);" class="btn font-weight-bold btn-danger btn-shadow" onclick="deleteDefaultImage({{$editions->id}})">Remove</a>
                                 </div>
                              </div>
                           </div>
                           @else
                           <div class="card card-custom overlay w-50">
                              <div class="card-body p-0">
                                 <div class="overlay-wrapper">
                                    <img src="{{url('/images/default_image_1.jpg')}}" alt="" class="w-100 rounded"/>
                                 </div>
                              </div>
                           </div>
                           @endif
                        @endif
                     </div>
                     <div class="col-lg-6">

                        <div class="col-xxl-12 order-2 order-xxl-1">
                           <!--begin::Advance Table Widget 2-->
                           <div class="card card-custom card-stretch gutter-b">
                              <!--begin::Header-->
                              <div class="card-header border-0 pt-5">
                                 <div class="card-toolbar">
                                    <div class="form-group m-0">
                                       <ul class="row nav">
                                          <li class="col-lg-6 nav-pills nav-pills-sm nav-dark-75" id="open_edition">
                                             <a class="option nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_11_1">
                                                <span class="option-control">
                                                   <span class="radio">
                                                      <input type="radio" name="open_edition" value="">
                                                      <span></span>
                                                   </span>
                                                </span>
                                                <span class="option-label">
                                                   <span class="option-head">
                                                      <span class="option-title">Open Edition</span>
                                                   </span>
                                                </span>
                                             </a>
                                          </li>
                                          <li class="col-lg-6 nav-pills nav-pills-sm nav-dark-75" id="limited_seats">
                                             <a class="option nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_11_2">
                                                <span class="option-control">
                                                   <span class="radio">
                                                      <input type="radio" name="limited_seats" value="">
                                                      <span></span>
                                                   </span>
                                                </span>
                                                <span class="option-label">
                                                   <span class="option-head">
                                                      <span class="option-title">Limited Edition</span>
                                                   </span>
                                                </span>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>

                              <div class="card-body pt-2 pb-0 mt-n3">
                                 <div class="tab-content mt-5" id="myTabTables11">
                                    <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">

                                    </div>
                                    <div class="tab-pane fade" id="kt_tab_pane_11_2" role="tabpanel" aria-labelledby="kt_tab_pane_11_2">
                                       <div class="form-group row">
                                          <div class="col-lg-12">
                                             <label> Number in Limited Edition</label>
                                             <input type="text" value="{{isset($editions->limitied_edition_number)?$editions->limitied_edition_number:''}}" name="limitied_edition_number" id="limitied_edition_number" class="form-control form-control-solid" placeholder="1 - 1000"/>
                                          </div>
                                       </div>
                                    </div>
                                    @if(!isset($editions))
                                    <div class="form-group row">
                                       <div class="col-lg-12">
                                          <label>Initial pieces to create</label>
                                          <input type="text" name="initial_pieces" value="{{isset($editions->initial_pieces)?$editions->initial_pieces:''}}" id="initial_pieces" class="form-control form-control-solid" placeholder="1 - 1000"/>
                                          <div class="invalid-feedback"></div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-12">
                                          <label> Initial proofs to create</label>
                                          <input type="text" name="initial_proofs" value="{{isset($editions->initial_proofs)?$editions->initial_proofs:''}}" id="initial_proofs" class="form-control form-control-solid" placeholder="1 - 10"/>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Edition Description</label>
                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="description" id="description">{{isset($editions->description)?$editions->description:''}}</textarea>
                     </div>
                     <div class="col-lg-6">
                        <label class="">Edition Notes</label>
                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="notes" id="notes">{{isset($editions->notes)?$editions->notes:''}}</textarea>
                     </div>
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
   $(document).ready(function() {

      $(".select2").select2({
         multiple: true,
      });

      //Create Runs
      $("#btncreateRuns").on("click", function(event){
         $('#saveRunsForm').trigger('submit');
      });
      $("#saveRunsForm").on("submit", function(event){
         event.preventDefault();

         $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('editions.store') }}",
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
							window.location.href = "{{route('editions.index')}}";
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

      $('#limited_seats').find('.radio').find('input').attr("checked", false);
      $('#limited_seats').find('.radio').find('input').val(false);
      $('#open_edition').find('.radio').find('input').attr("checked", true);
      $('#open_edition').find('.radio').find('input').val(true);
      $('#kt_tab_pane_11_2').hide();
      $('#open_edition').click(function() {
         $('#kt_tab_pane_11_1').show();
         $('#kt_tab_pane_11_2').hide();
         $('#limited_seats').find('.radio').find('input').attr("checked", false);
         $('#limited_seats').find('.radio').find('input').val(false);
         $(this).find('.radio').find('input').attr("checked", true);
         $(this).find('.radio').find('input').val(true);
      });
      $('#limited_seats').click(function() {
         $('#kt_tab_pane_11_2').show();
         $('#kt_tab_pane_11_1').hide();
         $('#open_edition').find('.radio').find('input').attr("checked", false);
         $('#open_edition').find('.radio').find('input').val(false);
         $(this).find('.radio').find('input').attr("checked", true);
         $(this).find('.radio').find('input').val(true);
      });

   });


   function deleteDefaultImage(id) {
      Swal.fire({
            title: "Do you want to delete the this default image?",
            showCancelButton: true,
            cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
            confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
      }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
               $.ajax({
                  url: "{{ route('admin.remove_editions_image') }}"+'/'+id,
                  method: 'GET',
                  success: function(data)
                  {
                        if(data.status == 'success'){
                           Swal.fire('Deleted!', data.message, 'success');
                           location.reload();
                        }
                  },
               });
            } else if (result.isDenied) {
               Swal.fire('Changes are not saved', '', 'info')
            }
      })
   }
</script>
@endsection
