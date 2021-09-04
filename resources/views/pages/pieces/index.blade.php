{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('datatables.backend.pieces.title')
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{route('pieces.create')}}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <circle fill="#000000" cx="9" cy="15" r="6"/>
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>@lang('buttons.backend.general.crud.create') @lang('datatables.backend.pieces.title')</a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th></th>
                    <th style="width:15%">@lang('datatables.backend.list.pieces.image')</th>
                    <th>@lang('datatables.backend.list.pieces.title')</th>
                    <th>@lang('datatables.backend.list.pieces.price')</th>
                    <th>@lang('datatables.backend.list.pieces.status')</th>
                    <th>@lang('datatables.backend.list.pieces.action')</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

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
                if(row.json){
                    $.each(row.json.data, function( key, value ) {
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
            },
            ajax: {
                url: "{{ route('pieces.index') }}",
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
        function pieceDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.pieces.do_you_want_delete_pieces')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pieces.store') }}"+'/'+id,
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
