{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('datatables.backend.documents.title')
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('documents.index')}}" class="btn btn-primary font-weight-bolder mr-5 d-none" id="document_back_button">
                <span class="svg-icon svg-icon-md">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                        <title>Stockholm-icons / Media / Backward</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="Stockholm-icons-/-Media-/-Backward" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                            <path d="M11.0879549,18.2771971 L17.8286578,12.3976203 C18.0367595,12.2161036 18.0583109,11.9002555 17.8767943,11.6921539 C17.8622027,11.6754252 17.8465132,11.6596867 17.8298301,11.6450431 L11.0891271,5.72838979 C10.8815919,5.54622572 10.5656782,5.56679309 10.3835141,5.7743283 C10.3034433,5.86555116 10.2592899,5.98278612 10.2592899,6.10416552 L10.2592899,17.9003957 C10.2592899,18.1765381 10.4831475,18.4003957 10.7592899,18.4003957 C10.8801329,18.4003957 10.9968872,18.3566309 11.0879549,18.2771971 Z" id="Path-10" fill="#FFFFFF" opacity="0.3" transform="translate(14.129645, 12.002277) scale(-1, 1) translate(-14.129645, -12.002277) "></path>
                            <path d="M5.08795487,18.2771971 L11.8286578,12.3976203 C12.0367595,12.2161036 12.0583109,11.9002555 11.8767943,11.6921539 C11.8622027,11.6754252 11.8465132,11.6596867 11.8298301,11.6450431 L5.08912711,5.72838979 C4.8815919,5.54622572 4.56567821,5.56679309 4.38351414,5.7743283 C4.30344325,5.86555116 4.25928988,5.98278612 4.25928988,6.10416552 L4.25928988,17.9003957 C4.25928988,18.1765381 4.48314751,18.4003957 4.75928988,18.4003957 C4.88013293,18.4003957 4.99688719,18.3566309 5.08795487,18.2771971 Z" id="Path-10-Copy" fill="#FFFFFF" transform="translate(8.129645, 12.002277) scale(-1, 1) translate(-8.129645, -12.002277) "></path>
                        </g>
                    </svg>
                </span>
                @lang('buttons.backend.general.back')</a>
                <!--begin::Button-->
                <a href="{{route('documents.create')}}" class="btn btn-primary font-weight-bolder">
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
                </span>@lang('buttons.backend.general.crud.create') @lang('datatables.backend.documents.title')</a>
                <!--end::Button-->
            </div>
        </div>
    <div class="card-body p-0 position-relative overflow-hidden">
        <div class="card-spacer" id="total_count">
            <div class="row m-0">
                <div class="col text-center bg-light-warning px-4 py-6 rounded-xl mr-7 mb-7">
                    <span class="text-warning d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_resume']}}
                    </span>
                    <a href="?type=resume" class="text-warning font-weight-bold font-size-h6">@lang('label.backend.documents.resume_cv')</a>
                </div>
                <div class="col text-center bg-light-primary px-4 py-6 rounded-xl mr-7 mb-7">
                    <span class="text-primary d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_bio']}}
                    </span>
                    <a href="?type=bio" class="text-primary font-weight-bold font-size-h6 mt-2">@lang('label.backend.documents.bio')</a>
                </div>
                <div class="col text-center bg-light-danger px-4 py-6 rounded-xl mr-7 mb-7">
                    <span class="text-danger d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_statement']}}
                    </span>
                    <a href="?type=statement" class="text-danger font-weight-bold font-size-h6 mt-2">@lang('label.backend.documents.statement')</a>
                </div>
                <div class="col text-center bg-light-danger px-4 py-6 rounded-xl mr-7 mb-7">
                    <span class="text-danger d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_proposal']}}
                    </span>
                    <a href="?type=proposal" class="text-danger font-weight-bold font-size-h6">@lang('label.backend.documents.proposal')</a>
                </div>
                <div class="col text-center bg-light-success px-4 py-6 rounded-xl mb-7">
                    <span class="text-success d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_press']}}
                    </span>
                    <a href="?type=press" class="text-success font-weight-bold font-size-h6 mt-2">@lang('label.backend.documents.press')</a>
                </div>
                <div class="col text-center bg-light-warning px-4 py-6 rounded-xl ml-7 mb-7">
                    <span class="text-warning d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_other']}}
                    </span>
                    <a href="?type=other" class="text-warning font-weight-bold font-size-h6 mt-2">@lang('label.backend.documents.other')</a>
                </div>
            </div>
        </div>
        <div class="resize-triggers"><div class="expand-trigger"><div style="width: 414px; height: 462px;"></div></div><div class="contract-trigger"></div></div></div>
            <div class="card-body">

            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th></th>
                    <th>@lang('datatables.backend.list.documents.type')</th>
                    <th>@lang('datatables.backend.list.documents.name')</th>
                    <th>@lang('datatables.backend.list.documents.description')</th>
                    <th>@lang('datatables.backend.list.documents.date')</th>
                    <th>@lang('datatables.backend.list.documents.action')</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exampleModalSizeLg" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('label.backend.documents.sharing_document'): <strong id="lable_room"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form class="form" enctype="multipart/form-data" method="post" id="sendurlshare">
                       <div class="col-lg-12 col-md-9 col-sm-12">

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>@lang('label.backend.create.private_rooms.contacts')</label>
                                <div class="input-group">
                                    <style>
                                    .select2{
                                        width: 100% !important;
                                    }</style>
                                    <select class="form-control select2 form-control-solid" multiple id="contact_email" name="contact_email[]">

                                        @if (isset($contacts))
                                            @foreach ($contacts as $contact)
                                               @if(isset($contact->email)) <option value="{{$contact->email}}">{{$contact->first_name}} - {{$contact->email}}</option>  @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                             </div>
                         </div>
                          <div class="form-group row">
                             <div class="col-lg-12">
                                <label class="">@lang('label.backend.create.private_rooms.emails')</label>
                                <input id="email_list" class="form-control form-control-lg tagify form-control-solid" name="email_list" value="" placeholder="@lang('label.backend.create.private_rooms.comma_separated')" type="text">
                                <input type="hidden" name="document_shere_id" id="document_shere_id" value="" />
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-lg-12">
                                <label class="">@lang('label.backend.create.private_rooms.message')</label>
                                <textarea cols="10" rows="5" class="form-control  form-control-solid" name="message" id="message"></textarea>
                            </div>
                         </div>

                         <div class="form-group row">
                            <div class="col-lg-12">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" name="self_copy_email" id="self_copy_email">
                                    <span></span>&nbsp;@lang('label.backend.create.private_rooms.self_copy_email')</label>
                            </div>
                         </div>

                       </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="shereUrlDocument">Send</button>
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
            ajax: {
                url: "{{ route('documents.index') }}",
                data: function (d) {
                    d.type = getUrlParameter('type');
                }
            },
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'type', name: 'type'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action'},
            ]
        });
        function documentDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.documents.do_you_want_delete_documents')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('documents.store') }}"+'/'+id,
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
        function shereUrl($id,$name){
            $('#exampleModalSizeLg').modal('show');
            $('#lable_room').text($name ? $name : '-');
            $('#document_shere_id').val($id);
        }
        var input = document.querySelector('input[name=email_list]');
        new Tagify(input)
        //submit share form
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".select2").select2({
            multiple: true,
        });
    $("#shereUrlDocument").on("click", function(event){
            $('#sendurlshare').trigger('submit');
        });
        $("#sendurlshare").on("submit", function(event){
            event.preventDefault();
                var formData = new FormData($(this)[0]);
            $.ajax({
                    url: "{{ route('admin.shareDocumentUrl') }}",
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
                        Swal.fire("{{__('string.backend.common.sent')}}", data.message, 'success');
                        setTimeout(function(){
                                window.location.href = "{{route('documents.index')}}";
                            }, 1500);
                    }
                    if(data.status == 'error'){
                            Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
                    }

                    }
                });
        })
        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return '';
        };
        if(getUrlParameter('type')){
            $('#document_back_button').removeClass('d-none');
        }
    </script>
@endsection
