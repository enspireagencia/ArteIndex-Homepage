
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
                    <div class="card-header border-0 pt-5">
                        <a href="{{route('posts.create')}}"> <button type="submit" class="btn btn-primary"> @lang('buttons.backend.general.crud.create') @lang('label.backend.admin.my_post.new_post') </button> </a>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 @if($filter == 'all') active @endif"  href="{{route('user.my_posts',[Auth::user()->user_unique_id,'all'])}}">@lang('label.backend.admin.my_post.all')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 @if($filter == 'published') active @endif"  href="{{route('user.my_posts',[Auth::user()->user_unique_id,'published'])}}">@lang('label.backend.admin.my_post.published')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 @if($filter == 'draft') active @endif"  href="{{route('user.my_posts',[Auth::user()->user_unique_id,'draft'])}}">@lang('label.backend.admin.my_post.draft')</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="kt_datatable">
                            <thead>
                            <tr>
                                <th> No </th>
                                <th style="width:15%">@lang('label.backend.admin.my_post.image')</th>
                                <th>@lang('label.backend.admin.my_post.title')</th>
                                <th>@lang('datatables.backend.list.private_rooms.status')</th>
                                <th>@lang('datatables.backend.list.private_rooms.action')</th>
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
    <script type="text/javascript" src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#kt_datatable').DataTable({
        processing: true,
        responsive:true,
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
        "fnDrawCallback": function (row) {
            //change status
            $(".change_room_status").on("change", function(event){
                var status = $(this).val();
                var room_id = $(this).next().val();
                $.ajax({
                    url: "{{ route('admin.change_published') }}",
                    method: 'POST',
                    data: {"status":status,'room_id':room_id},
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
            url: "{{route('user.my_posts',[Auth::user()->user_unique_id, $filter])}}",
        },
        serverside: true,
        autoWidth: false,
        responsive: true,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'title', name: 'title'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
        ]
    });

    function postDelete(id) {
        Swal.fire({
            title: "Do you want to delete the this Post?",
            showCancelButton: true,
            cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
            confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('posts.store') }}"+'/'+id,
                    method: 'DELETE',
                    beforeSend: function(){
                        Swal.fire("{{__('string.backend.common.please_wait')}}");
                        Swal.showLoading();
                    },
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
