{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<div class="card card-custom">
   <div class="card-header flex-wrap border-0 pt-6 pb-0">
      <div class="card-title">
         <h3 class="card-label">View Edition
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('editions.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
      </div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-custom gutter-b">
               <!-- <div class="card-header border-0 pt-5">
                  <div class="card-title align-items-start flex-column">
                     <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                           <li class="nav-item">
                              <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_11_1">Works</a>
                           </li> 
                           <li class="nav-item">
                              <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_11_2">Week</a>
                           </li> 
                        </ul>
                     </div>
                  </div>
                  
               </div> -->
               <div class="card-body pt-2 pb-0 mt-n3">
                  <div class="tab-content mt-5" id="myTabTables11">
                     <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                        <!--begin::Table-->
                        <div class="table-responsive">
                           <table class="table table-bordered table-hover table-borderless table-vertical-center" id="kt_datatable">
                              <thead>
                              <tr>
                                 <th></th>
                                 <th style="width:15%">Default Image</th>
                                 <th>Details</th>
                                 <th>Location</th>
                                 <th>Actions</th>
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                        <!--end::Table-->
                     </div>
                     <!-- <div class="tab-pane fade active show" id="kt_tab_pane_11_2" role="tabpanel" aria-labelledby="kt_tab_pane_11_2">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-borderless table-vertical-center" id="kst_datatable">
                              <thead>
                              <tr>
                                 <th></th>
                                 <th style="width:15%">Name</th>
                                 <th>Works</th>
                                 <th>Sold</th>
                                 <th>In Location</th>
                                 <th>Actions</th>
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                           
                        </div>
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Edit Works Modal-->
<div class="modal fade" id="editWorks" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="WorkTitle">Works</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
               </button>
            </div>
            <form class="form" enctype="multipart/form-data" method="post" id="updateWorksForm">
               <div class="modal-body">
                  <div class="form-group">
                     <div class="col-lg-12 col-md-9 col-sm-12">
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Inventory Number</label>
                              <input class="form-control  form-control-solid" name="inventory_number" id="inventory_number" value="" type="text">
                              <input type="hidden" name="work_id" id="work_id" value="" />
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Price</label>
                              <input class="form-control  form-control-solid" name="price" id="price" value="" type="text">
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Wholesale price</label>
                              <input class="form-control  form-control-solid" name="wholesale_price" id="wholesale_price" type="text">
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="">Notes</label>
                              <textarea class="form-control  form-control-solid" name="notes" id="notes" cols="10" rows="4"> </textarea>
                              <div class="invalid-feedback"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
               </div>
            </form>
        </div>
    </div>
</div>
<!-- View Works Modal-->
<div class="modal fade" id="viewWorks" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="WorkTitle">Reproduction Info</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
               </button>
            </div>
            <div class="modal-body">
               <div class="card card-custom card-stretch gutter-b">
                  <div class="card-body pt-0">
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Edition</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_runs_name"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Number</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_number"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">From Piece</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_pieces_name"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Price</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_price"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Wholesale Price</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_wholesale_price"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Location</a>
                        </div>
                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder" id="view_location"></span>
                     </div>
                     <div class="d-flex align-items-center flex-wrap mb-8">
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                           <span class="font-weight-bold text-dark-75 font-size-lg mb-1" id="view_notes"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Styles Section --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection
{{-- Scripts Section --}}
@section('scripts')
{{-- vendors --}}
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
{{-- page scripts --}}
<script type="text/javascript" src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
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
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var editions_id = "{{$editions->id}}";
    var table = $('#kt_datatable').DataTable({
         processing: true,
         responsive:true,
         "fnDrawCallback": function (row) {
            //Default Image 
            if(row.json){
               $.each( row.json.data, function( key, value ) {
                  $('.parent-container-'+ value.id).magnificPopup({
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
            }
            

            $(".editPopup").on("click", function(event){
               var work_id = $(this).attr('data-id');
               $.ajax({
                  url: "{{ route('admin.get_edition_works') }}",
                  method: 'POST',
                  data: {"work_id":work_id},
                  success: function(data)
                  {
                     if(data.status == 'success'){
                        $('#editWorks').modal('show');
                        $('#inventory_number').val(data.data.inventory_number);
                        $('#price').val(data.data.price);
                        $('#wholesale_price').val(data.data.wholesale_price);
                        $('#notes').val(data.data.notes);
                        $('#work_id').val(data.data.id);
                     }
                  },
               });
            });
            // View Works
            $(".viewPopup").on("click", function(event){
               var work_id = $(this).attr('data-id');
               $.ajax({
                  url: "{{ route('admin.get_edition_works') }}",
                  method: 'POST',
                  data: {"work_id":work_id},
                  success: function(data)
                  {
                     if(data.status == 'success'){
                        $('#viewWorks').modal('show');
                        $('#view_runs_name').text(data.data.edition_detail.name ? data.data.edition_detail.name : '-');
                        $('#view_number').text(data.data.inventory_number ? data.data.inventory_number : '-');
                        $('#view_pieces_name').text(data.data.pieces_detail.title ? data.data.pieces_detail.title : '-');
                        $('#view_price').text(data.data.price ? data.data.price : '-');
                        $('#view_wholesale_price').text(data.data.wholesale_price ? data.data.wholesale_price : '-');
                        $('#view_location').text(data.data.location_detail.name ? data.data.location_detail.name : '-');
                        $('#view_notes').text(data.data.notes);
                     }
                  },
               });
            });
            // Assign Location
            $(".assign_edition_inventory_location").on("change", function(event){
               var location_id = $(this).val();
               var work_id = $(this).attr('data-id');
               $.ajax({
                  url: "{{ route('admin.assign_edition_inventory_location') }}",
                  method: 'POST',
                  data: {"location_id":location_id,'work_id':work_id},
                  success: function(data)
                  {
                        if(data.status == 'success'){
                           toastr.options.positionClass = "toast-bottom-left";
                           toastr.success(data.message)
                        }
                  },
               });
            });
            
         },
         ajax: {
               url: "{{ route('edition_works.index') }}",
               data: {"editions_id":editions_id},
         },
         serverside: true,
         autoWidth: false,
         columns: [
               {data:   "DT_RowIndex",name: 'DT_RowIndex'},
               {data: 'default_image', name: 'default_image'},
               {data: 'details', name: 'details'},
               {data: 'location', name: 'location'},
               {data: 'action', name: 'action'},
         ]
      });
      $("#updateWorksForm").on("submit", function(event){
         event.preventDefault();
         $('.has-danger').next().children().children().css({"border": ""});
			$('.is-invalid').removeClass("is-invalid");
			$('.invalid-feedback').html("");
			$('.has-danger').removeClass("has-danger");
			var work_id = $('#work_id').val();
         var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('edition_works.store') }}",
				method: 'POST',
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function(){
               Swal.fire("{{__('string.backend.common.please_wait')}}");
               Swal.showLoading();
				},
				success: function(data)
				{
					if(data.status == 'success'){
                  Swal.fire("{{__('string.backend.create.pieces.updated')}}", data.message, 'success');
						setTimeout(function(){
							window.location.href = "{{ route('editions.show',$editions->id) }}";
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
      function worksDelete(id) {
         Swal.fire({
               title: "Do you want to delete the this edition works?",
               showCancelButton: true,
               cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
               confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
         }).then((result) => {
               /* Read more about isConfirmed, isDenied below */
               if (result.isConfirmed) {
                  $.ajax({
                     url: "{{ route('edition_works.store') }}"+'/'+id,
                     method: 'DELETE',
                     success: function(data)
                     {
                           if(data.status == 'success'){
                              Swal.fire('Deleted!', data.message, 'success');
                              table.ajax.reload();

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