{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('datatables.backend.schedule.title')
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="mr-5">
                    <div class="d-flex align-items-center">
                        <select class="form-control" id="kt_datatable_search_filter">
                            <option value="">@lang('label.backend.admin.schedule.all')</option>
                            <option value="1">@lang('label.backend.admin.schedule.past_52_week')</option>
                            <option value="2">@lang('label.backend.admin.schedule.this_week')</option>
                            <option value="3">@lang('label.backend.admin.schedule.next_week')</option>
                            <option value="4">@lang('label.backend.admin.schedule.next_30_week')</option>
                            <option value="5">@lang('label.backend.admin.schedule.next_12_months')</option>
                        </select>
                    </div>
                </div>
                <!--begin::Button-->
                <a href="{{route('schedule.create')}}" class="btn btn-primary font-weight-bolder">
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
                </span>@lang('buttons.backend.general.crud.create') @lang('datatables.backend.schedule.title')</a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th></th>
                    <th>@lang('datatables.backend.list.schedule.date')</th>
                    <th>@lang('datatables.backend.list.schedule.message')</th>
                    <th>@lang('datatables.backend.list.schedule.action')</th>
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
            ajax: {
                url: "{{ route('schedule.index') }}",
                data: function (d) {
                    d.select_filter = $('select[id=kt_datatable_search_filter]').val();
                }
            },
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'remainder_date', name: 'remainder_date'},
                {data: 'message', name: 'message'},
                {data: 'action', name: 'action'},
            ]
        });
        $("#kt_datatable_search_filter").on("change", function(event){
            table.draw();
        });
        function scheduleDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.schedule.do_you_want_delete_schedule')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('schedule.store') }}"+'/'+id,
                        method: 'DELETE',
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                Swal.fire("{{__('string.backend.create.pieces.deleted')}}", data.message, 'success');
                                table.ajax.reload();

                            }
                        },
                    });
                } else if (result.isDenied) {
                    Swal.fire("{{__('string.backend.create.locations.changes_are_not_saved')}}", '', 'info')
                }
            })
           
            
        }
        function statusSchedule(id){
            var status = 1;
            var schedule_id = id;
            $.ajax({
                    url: "{{ route('admin.change_schedule_status') }}",
                    method: 'POST',
                    data: {"status":status,'schedule_id':schedule_id},
                    success: function(data)
                    {
                        if(data.status == 'success'){
                            toastr.options.positionClass = "toast-bottom-left";
                            toastr.success(data.message)
                            table.ajax.reload();
                        }
                    },
                });
        }
    </script>
@endsection
