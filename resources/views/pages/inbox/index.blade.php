{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('datatables.backend.inbox.title')</h3>
            </div>
        </div>
        <div class="archive ml-8 row">
            <div class="col-* mt-2">
            <label><i class="fas fa-filter"></i> @lang('datatables.backend.list.inbox.filter'): </label>
            </div>
            <div class="col-2">
            <select class="form-control form-control-solid">
                <option selected value="{{ route('inbox.index')}}">@lang('datatables.backend.list.inbox.active')</option>
                <option value="{{ route('inbox.inboxex')}}">@lang('datatables.backend.list.inbox.archive')</option>
            </select>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th style="width:30%" colspan="2" class="text-center">@lang('datatables.backend.list.inbox.message_info')</th>
                    <th> @lang('datatables.backend.list.inbox.sender_info') </th>
                    <th> @lang('datatables.backend.list.inbox.details') </th>
                    <th> @lang('datatables.backend.list.inbox.action') </th>
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
            ajax: {
                url: "{{ route('inbox.index') }}",
            },
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data:'message_info', name:'message_info'},
                {data:'sender_info', name:'sender_info'},
                {data:'details', name:'details'},
                {data: 'action', name: 'action'},
            ]
        });
        function inboxDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.inbox.do_you_want_delete_inbox')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('inbox.destroy', '')}}"+"/"+id,
                        method: 'DELETE',
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                Swal.fire("{{__('string.backend.create.inbox.deleted')}}", data.message, 'success');
                                table.ajax.reload();
                            }
                        },
                    });
                } else if (result.isDenied) {
                    Swal.fire("{{__('string.backend.create.inbox.something_wrong')}}", '', 'error')
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

        function archive(id)
        {
            var status = 1;
            var archive_id = id;
            $.ajax({
                    url: "{{ route('archive') }}",
                    method: 'POST',
                    data: {"status":status,'archive_id':archive_id},
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

        $('select').on('change', function (e) {
        var link = $("option:selected", this).val();
            if (link) {
                location.href = link;
            }
    });
    </script>
@endsection
<style>
td:nth-child(2){
    width: 80px;
}
</style>
