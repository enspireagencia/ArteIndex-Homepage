
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
                <div class="card card-custom gutter-b">   
                    <div class="card-body">
                        <!--begin::Search Form-->
                        <div class="mt-2">
                            <div class="row align-items-center">
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_status">
                                            <option value="">@lang('label.backend.admin.public_pieces.status')</option>
                                            @if(isset($status))
                                                @foreach($status as $statu)
                                                <option value="{{$statu->id}}">
                                                    {{ $statu->status}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_collection">
                                            <option value="">@lang('label.backend.admin.public_pieces.collection')</option>
                                            @if(isset($collections))
                                                @foreach($collections as $collection)
                                                <option value="{{$collection->id}}">
                                                    {{ $collection->collection_name}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_type">
                                            <option value="">@lang('label.backend.admin.public_pieces.type')</option>
                                            @if(isset($types))
                                                @foreach($types as $type)
                                                <option value="{{$type->id}}">
                                                    {{ $type->name}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_subject_matter">
                                            <option value="">@lang('label.backend.admin.public_pieces.subject_matter')</option>
                                            @if(isset($subject_matters))
                                                @foreach($subject_matters as $subject_matter)
                                                <option value="{{$subject_matter->subject_matter}}">
                                                    {{ $subject_matter->subject_matter}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 mt-lg-5 mb-lg-10">
                            <div class="row align-items-center">
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_medium">
                                            <option value="">@lang('label.backend.admin.public_pieces.mediuam')</option>
                                            @if(isset($mediums))
                                                @foreach($mediums as $medium)
                                                <option value="{{$medium->medium}}">
                                                    {{ $medium->medium}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_location">
                                            <option value="">@lang('label.backend.admin.public_pieces.location')</option>
                                            @if(isset($locations))
                                                @foreach($locations as $location)
                                                <option value="{{$location->id}}">
                                                    {{ $location->name}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_edition">
                                            <option value="">@lang('label.backend.admin.public_pieces.editions')</option>
                                            <option value="1">@lang('label.backend.admin.public_pieces.all_editions')</option>
                                            <option value="0">@lang('label.backend.admin.public_pieces.hide_editions')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_datatable_search_public_status">
                                            <option value="">@lang('label.backend.admin.public_pieces.public_status') </option>
                                            <option value="1">@lang('label.backend.admin.public_pieces.public') </option>
                                            <option value="0">@lang('label.backend.admin.public_pieces.private') </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Search Form-->

                        <table class="table table-bordered table-hover" id="public_pieces">
                            <thead>
                            <tr>
                                <th></th>
                                <th style="width:15%">@lang('label.backend.admin.public_pieces.image') </th>
                                <th>@lang('label.backend.admin.public_pieces.title') </th>
                                <th>@lang('label.backend.admin.public_pieces.price') </th>
                                <th>@lang('label.backend.admin.public_pieces.status') </th>
                                <th>@lang('label.backend.admin.public_pieces.action') </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#public_pieces').DataTable({
            processing: true,
            "fnDrawCallback": function (row) {
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
                
                
                //change status
                $(".change_pieces_status").on("change", function(event){
                    var status = $(this).val();
                    var pieces_id = $(this).next().val();
                    $.ajax({
                        url: "{{ route('admin.change_pieces_status') }}",
                        method: 'POST',
                        data: {"status":status,'pieces_id':pieces_id},
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                toastr.options.positionClass = "toast-bottom-left";
                                toastr.success(data.message)
                            }
                        },
                    });
                });
                $(".change_pieces_public").on("click", function(event){
                    var pieces_id = $(this).attr("data-id");
                    var pieces_public_val = $(this).attr("data-value");
                    $.ajax({
                        url: "{{ route('admin.change_pieces_public') }}",
                        method: 'POST',
                        data: {"pieces_id":pieces_id,'pieces_public_val':pieces_public_val},
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                $('.change_pieces_public_'+pieces_id).text(function(i, v){
                                    return v === 'Public' ? 'Not Public' : 'Public'
                                });
                                if($('.change_pieces_public_'+pieces_id).hasClass("btn-success"))
                                {
                                    $('.change_pieces_public_'+pieces_id).addClass("btn-danger");
                                    $('.change_pieces_public_'+pieces_id).removeClass("btn-success");
                                }else{
                                    $('.change_pieces_public_'+pieces_id).addClass("btn-success");
                                    $('.change_pieces_public_'+pieces_id).removeClass("btn-danger");
                                }
                                toastr.options.positionClass = "toast-bottom-left";
                                toastr.success(data.message)
                            }
                            if(data.status == 'error'){
                                toastr.error(data.message)
                            }
                        },
                    });
                });
            },
            responsive:true,
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
            ],
            order: [[1, 'asc']],
            initComplete: function() {
                var $buttons = $('.dt-buttons').hide();
                $('.exportExcel').on('click', function() {
                    var btnClass = $('.excelData').find(".navi-text")[0].id 
                    ? '.buttons-' + $('.excelData').find(".navi-text")[0].id 
                    : null;
                    console.log($('.excelData').find(".navi-text")[0].id);
                    if (btnClass) $buttons.find(btnClass).click(); 
                })
            }, 
            ajax: {
                url: "{{ route('user.public_pieces',$user->user_unique_id) }}",
                data: function (d) {
                    d.select_status = $('select[id=kt_datatable_search_status]').val();
                    d.select_collection = $('select[id=kt_datatable_search_collection]').val();
                    d.select_type = $('select[id=kt_datatable_search_type]').val();
                    d.select_subject_matter = $('select[id=kt_datatable_search_subject_matter]').val();
                    d.select_medium = $('select[id=kt_datatable_search_medium]').val();
                    d.select_location = $('select[id=kt_datatable_search_location]').val();
                    d.select_edition = $('select[id=kt_datatable_search_edition]').val();
                    d.select_public_status = $('select[id=kt_datatable_search_public_status]').val();
                }
            },
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'pieces_images', name: 'pieces_images'},
                {data: 'title', name: 'title'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ]
        });
        $("#kt_datatable_search_status").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_collection").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_type").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_subject_matter").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_medium").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_location").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_edition").on("change", function(event){
            table.draw();
        });
        $("#kt_datatable_search_public_status").on("change", function(event){
            table.draw();
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