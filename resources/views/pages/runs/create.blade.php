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
            @if(isset($runs))
            @lang('buttons.backend.general.crud.edit') @lang('datatables.backend.runs.title')
            @else
            @lang('label.backend.runs.new_run') <i class="mr-2"></i>
            @endif
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('runs.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
         <div class="btn-group">
            <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateRuns"> 
            <i class="ki ki-check icon-sm"></i>
            @if(isset($runs))
            @lang('buttons.backend.general.crud.update')
            @else
            @lang('buttons.backend.general.crud.create') @lang('datatables.backend.runs.title')
            </button>
            @endif
         </div>
      </div>
   </div>
   <div class="card-body">
      <!--begin::Form-->
      <form class="form" enctype="multipart/form-data" method="post" id="saveRunsForm">
         <div class="card-body">
         @if(!isset($runs))
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
                                 <option value="{{$piece->id}}" @if(isset($runs->piece_id) && $runs->piece_id == $piece->id ) selected @endif >
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
            <label for=""><h5><b>Run Info</b></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Name of Run</label>
                        <input class="form-control  form-control-solid" name="name" id="name" value="{{isset($runs->name)?$runs->name:''}}" type="text">
                        <input type="hidden" name="runs_id" id="runs_id" value="{{isset($runs->id)?$runs->id:''}}" />
                        <div class="invalid-feedback"></div>
                     </div>
                     <div class="col-lg-6">
                        <label class="">Creation Date</label>
                        <input class="form-control  form-control-solid" name="creation_date" id="creation_date" value="{{isset($runs->creation_date)?$runs->creation_date:''}}" type="date">
                     </div>
                  </div>
                  <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Medium</label>
                        <input class="form-control  form-control-solid" name="medium" id="medium" value="{{isset($runs->medium)?$runs->medium:''}}" type="text">
                     </div>
                     <div class="col-lg-6">
                        <label class="">Cost of Run</label>
                        <input class="form-control  form-control-solid" name="cost" id="cost" value="{{isset($runs->cost)?$runs->cost:''}}" type="text">
                     </div>
                     
                  </div>
                  @if(!isset($runs))
                  <div class="form-group row">
                     <div class="col-lg-6">
                        <label class="">Number of Prints</label>
                        <input class="form-control  form-control-solid" name="prints_count" id="prints_count" type="number" placeholder="Between 1 and 1000">
                        <div class="invalid-feedback"></div>
                     </div>
                     <div class="col-lg-6">
                        <label class="">Sale Price (per print)</label>
                        <input class="form-control  form-control-solid" name="sales_price" id="sales_price" type="text">
                     </div>
                  </div>
                  @endif
               </div>
            </div>
            @if(!isset($runs))
            <label for=""><h5><b>Proofs</b></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                     <div class="col-lg-12">
                        <label class="">Number of Proofs</label>
                        <input class="form-control  form-control-solid" name="proofs_count" id="proofs_count" type="number" placeholder="Between 1 and 10">
                     </div>
                  </div>
               </div>
            </div>
            @endif
            <label for=""><h5><b>Size</b></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                  <div class="form-group col-xl-4">
                     <div class="input-group input-group-solid">
                        <input type="number" class="form-control" name="size_height" id="size_height" value="{{isset($runs->size_height)?$runs->size_height:''}}" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <span class="input-group-text">
                              <label class="">H</label>
                           </span>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="form-group col-xl-4">
                     <div class="input-group input-group-solid">
                        <input type="number" class="form-control" name="size_width" id="size_width" value="{{isset($runs->size_width)?$runs->size_width:''}}" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <span class="input-group-text">
                              <label class="">W</label>
                           </span>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="form-group col-xl-4">
                     <div class="input-group input-group-solid">
                        <input type="number" class="form-control" name="size_depth" id="size_depth" value="{{isset($runs->size_depth)?$runs->size_depth:''}}" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <span class="input-group-text">
                              <label class="">D</label>
                           </span>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12 col-md-9 col-sm-12 row">
                  <div class="form-group col-xl-4">
                     <div class="">
                           <label class="checkbox">
                           @php
                           if(isset($runs->signed) && $runs->signed==1){
                              $signed = 'checked';
                           }else{
                               $signed = '';
                           }
                           @endphp
                           <input type="checkbox" value="1" name="signed" {{$signed}} id="signed">
                           <span></span> &nbsp;Are these signed prints</label>
                        </div>
                  </div>
               </div>
            </div>
            <label for=""><h5><b>Additional Info</b></h5></label>
            <div class="form-group">
               <div class="col-lg-12 col-md-9 col-sm-12">
                  <div class="form-group row">
                     <div class="col-lg-12">
                        <label class="">Notes</label>
                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="notes" id="notes">{{isset($runs->notes)?$runs->notes:''}}</textarea>
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
				url: "{{ route('runs.store') }}",
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
							window.location.href = "{{route('runs.index')}}";
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
