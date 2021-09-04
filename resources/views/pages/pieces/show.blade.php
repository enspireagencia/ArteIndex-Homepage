{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
<div class="card card-custom">
   <div class="card-header flex-wrap border-0 pt-6 pb-0">
      <div class="card-title">
         <h3 class="card-label">View Pieces
         </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('pieces.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
         <i class="ki ki-long-arrow-back icon-sm"></i>
         @lang('buttons.backend.general.back')
         </a>
      </div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-lg-4">
            <!--begin::Mixed Widget 14-->
            <div class="card card-custom card-stretch gutter-b">
               <!--begin::Header-->
               <div class="card-header border-0 pt-5">
                  <h3 class="card-title font-weight-bolder">Pieces Images</h3>
               </div>
               <!--end::Header-->
               <!--begin::Body-->
               <div class="card-body d-flex flex-column">
                  <div class="card card-custom overlay">
                     <div class="card-body p-0">
                        <div class="overlay-wrapper parent-container">
                           @if(isset($pieces->pieces_images) && count($pieces->pieces_images)>0)
                              @foreach($pieces->pieces_images as $key => $image)
                                    <a href="{{asset_image_display($image->url,"images/pieces/")}}" class="{{ $key==0?'':'hide_image' }}">
                                       <img style="background-image:url('{{asset_image_display($image->url,"images/pieces/")}}')" alt="" class="w-100 piece_images"/>
                                    </a>
                              @endforeach
                           @else
                              <a href="{{url('/images/default_image.jpg')}}">
                                 <img style="background-image:url('{{url('/images/default_image.jpg')}}')" alt="" class="w-100 piece_images"/>
                              </a>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="d-flex align-items-center mt-2 row">
                    @if(isset($pieces->pieces_images) && count($pieces->pieces_images)>0)
                    @php
                        $count_col=50;
                    @endphp
                    @foreach($pieces->pieces_images as $key => $image)
                    <div class="symbol symbol-60 m-2 col-3 {{ $key==0?'hide_image':'' }}">
                        <img style="background-image:url('{{url('/images/default_image.jpg')}}')" alt="Pic" src="{{asset_image_display($image->url,"images/pieces/")}}"/>
                    </div>
                    @endforeach
                    @endif
                </div>
                  <div class="pt-5">
                     <div class="timeline timeline-2">
                        <div class="timeline-bar"></div>
                        @if(isset($pieces->name))
                        <div class="timeline-item">
                           <div class="timeline-badge"></div>
                           <div class="timeline-content d-flex align-items-center justify-content-between">
                              <span class="mr-3">
                              <a href="#">Run Name</a>
                              </span>
                              <span class="font-weight-bolder text-right">{{$pieces->name}}</span>
                           </div>
                        </div>
                        @endif
                        @if(isset($pieces->pieces_detail) && isset($pieces->pieces_detail->title))
                        <div class="timeline-item">
                           <div class="timeline-badge"></div>
                           <div class="timeline-content d-flex align-items-center justify-content-between">
                              <span class="mr-3">
                              <a href="#">Piece Name</a>
                              </span>
                              <span class="font-weight-bolder text-right">{{$pieces->pieces_detail->title}}</span>
                           </div>
                        </div>
                        @endif
                     </div>
                     <hr />
                        <h5 class="card-title font-weight-bolder">Pieces Info</h5>
                     <div class="timeline timeline-2">
                        <div class="timeline-bar"></div>
                        @if(isset($run_details))
                        @foreach($run_details as $key => $run_detail)
                        <div class="timeline-item">
                           <div class="timeline-badge"></div>
                           <div class="timeline-content d-flex align-items-center justify-content-between">
                              <span class="mr-3">
                              <a href="#">{{$run_detail['key']}}</a>
                              </span>
                              <span class="font-weight-bolder text-right">{{$run_detail['value']}}</span>
                           </div>
                        </div>
                        @endforeach
                        @endif
                     </div>
                        @if(isset($collections))
                        <hr />
                        <h5 class="card-title font-weight-bolder">Collections</h5>
                        <ul>
                        @foreach($collections as $key => $collection)
                        <li><span class="mr-3">
                            <a href="{{route('pieces.index')}}">{{$collection->collection_name}}</a>
                        </span></li>
                        @endforeach
                        </ul>
                        @endif
                        @if(isset($pieces->description))
                        <hr />
                        <h5 class="card-title font-weight-bolder">Description</h5>
                        <span class="font-weight-bolder text-right">{{isset($pieces->description)?$pieces->description:''}}</span>
                        @endif
                        @if(isset($pieces->notes))
                        <hr />
                        <h5 class="card-title font-weight-bolder">Notes</h5>
                        <span class="font-weight-bolder text-right">{{isset($pieces->notes)?$pieces->notes:''}}</span>
                        @endif

                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-8">
            <div class="card card-custom gutter-b">
               <div class="card-header border-0 pt-5">
                  <div class="card-title align-items-start flex-column">
                     <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                           <li class="nav-item">
                              <span class="nav-link py-2 px-4">Current Location</span>
                           </li>
                           <li class="nav-item">
                            <a class="btn btn-light-primary font-weight-bolder" data-toggle="tab" href="#kt_tab_pane_11_1">Assign To Location</a>
                         </li>
                        </ul>
                     </div>
                  </div>

               </div>
               <div class="card-body pt-2 pb-0 mt-n3">
                  <div class="tab-content mt-5" id="myTabTables11">
                     <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                        <!--begin::Table-->
                        <div class="table-responsive">
                           <table class="table table-bordered table-hover table-borderless table-vertical-center" id="">
                              <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Location Name</th>
                                 <th>Time Duration</th>
                                 <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                        <!--end::Table-->
                     </div>

                  </div>
               </div>
            </div>
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Location History</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder"  href="{{route('locations.store')}}">New Location Record</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="location_datatable">
                               <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Location</th>
                                  {{-- <th>Date</th>
                                  <th>Current</th>
                                  <th>Action</th> --}}
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
                      </div>

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Exhibition History</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" data-toggle="tab" href="#kt_tab_pane_11_1">New Exhibition</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="">
                               <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Exhibition</th>
                                  <th>Info</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
                      </div>

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Publication History</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" data-toggle="tab" href="#kt_tab_pane_11_1">New Publication Record</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="">
                               <thead>
                               <tr>
                                  <th>#</th>
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

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Original Editions</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" href="{{route('editions.create')}}">New Edition</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="edition_datatable">
                               <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Editions</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
                      </div>

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Runs/Reproductions</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" href="{{route('runs.create')}}"> New Run</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="run_datatable">
                               <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Run</th>
                                  <th>Details</th>

                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
                      </div>

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Additional Files</span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" data-toggle="tab" href="#kt_tab_pane_11_1"> Add File</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="">
                               <thead>
                               <tr>
                                  <th></th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
                      </div>

                   </div>
                </div>
             </div>
             <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5">
                   <div class="card-title align-items-start flex-column">
                      <div class="card-toolbar">
                         <ul class="nav nav-pills nav-pills-sm nav-dark-75">

                            <li class="nav-item">
                               <span class="nav-link py-2 px-4">Expenses </span>
                            </li>
                            <li class="nav-item">
                             <a class="btn btn-light-primary font-weight-bolder" data-toggle="tab" href="#kt_tab_pane_11_1">New Expense</a>
                          </li>
                         </ul>
                      </div>
                   </div>

                </div>
                <div class="card-body pt-2 pb-0 mt-n3">
                   <div class="tab-content mt-5" id="myTabTables11">
                      <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                         <!--begin::Table-->
                         <div class="table-responsive">
                            <table class="table table-bordered table-hover table-borderless table-vertical-center" id="">
                               <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Type</th>
                                  <th>Description</th>
                                  <th>Info</th>
                                  <th>Amount</th>
                                  <th>Actions</th>
                               </tr>
                               </thead>
                               <tbody>
                               </tbody>
                            </table>
                         </div>
                         <!--end::Table-->
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
    var id = "{{$pieces->id}}";
    var table = $('#run_datatable').DataTable({
         processing: true,
         responsive:true,
         ajax: {
               url: "{{ route('admin.getRunWork_By_PiecesId') }}",
               data: {"id":id},
         },
         serverside: true,
         autoWidth: false,
         columns: [
               {data:   "DT_RowIndex",name: 'DT_RowIndex'},
               {data: 'run', name: 'run'},
               {data: 'details', name: 'details'},
         ]
      });

      var table = $('#edition_datatable').DataTable({
         processing: true,
         responsive:true,
         ajax: {
               url: "{{ route('admin.getEdition_By_PiecesId') }}",
               data: {"id":id},
         },
         serverside: true,
         autoWidth: false,
         columns: [
               {data:   "DT_RowIndex",name: 'DT_RowIndex'},
               {data: 'editions', name: 'editions'},
         ]
      });
      var location_id = "{{$pieces->location_id}}";
      var table = $('#location_datatable').DataTable({
         processing: true,
         responsive:true,
         ajax: {
               url: "{{ route('admin.getLocation_By_PiecesId') }}",
               data: {"location_id":location_id},
         },
         serverside: true,
         autoWidth: false,
         columns: [
               {data:   "DT_RowIndex",name: 'DT_RowIndex'},
               {data: 'location', name: 'location'},
         ]
      });




</script>
@endsection
