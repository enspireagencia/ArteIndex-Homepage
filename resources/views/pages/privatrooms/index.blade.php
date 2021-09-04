{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('datatables.backend.private_rooms.title')
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{route('private_rooms.create')}}" class="btn btn-primary font-weight-bolder">
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
                </span>@lang('buttons.backend.general.crud.create') @lang('datatables.backend.private_rooms.title')</a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th></th>
                    <th style="width:10%">Name</th>
                    <th style="width:30%">URL</th>
                    <th>Total Pieces</th>
                    <th>Status</th>
                    <th>Password</th>
                    <th>Actions</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Sharing Private Room: <strong id="lable_room"></strong></h5>
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
                                        width: 100%!important;
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
                                <input type="hidden" name="privateroom_shere_id" id="privateroom_shere_id" value="" />
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
                    <button type="button" class="btn btn-primary font-weight-bold" id="shereUrlPrivateroom">Send</button>
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

            $(".select2").select2({
            multiple: true,
            });
        });
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
                        url: "{{ route('admin.change_room_status') }}",
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
                url: "{{ route('private_rooms.index') }}",
            },
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'url', name: 'URL'},
                {data: 'piecescount', name: 'Total Pieces'},
                {data: 'status', name: 'Status'},
                {data: 'password', name: 'Password'},
                {data: 'action', name: 'action'},
            ]
        });
        function privateroomDelete(id) {
            Swal.fire({
                title: "Do you want to delete the this Private Room?",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('private_rooms.store') }}"+'/'+id,
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
        function copyToClipboard(element) {
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
                $('#privateroom_shere_id').val($id);
            }



   //add multiple email
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
   $("#shereUrlPrivateroom").on("click", function(event){
         $('#sendurlshare').trigger('submit');
      });
      $("#sendurlshare").on("submit", function(event){
         event.preventDefault();
			var formData = new FormData($(this)[0]);
         $.ajax({
				url: "{{ route('admin.shareUrl') }}",
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
							window.location.href = "{{route('private_rooms.index')}}";
						}, 1500);
				}
				if(data.status == 'error'){
						Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
				}

				}
			});
      })
    </script>
@endsection
