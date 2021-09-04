{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">View Exhibition
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('contact.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                @lang('buttons.backend.general.back')
            </a>
            <a href="javascript:void(0)" onClick="copyExhibitionRecord({{$exhibitions->id}})" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="flaticon2-pie-chart"></i>
                @lang('buttons.backend.general.copy')
            </a>
            <!--begin::Button-->
            <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalSizeLg" class="btn btn-light-primary font-weight-bolder mr-2">
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
                </span>@lang('datatables.backend.exhibitions.assign_pieces')
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-lg-12 col-xxl-6">
                <h3 class="font-weight-bold font-size-h4 text-dark-75 mb-3">@lang('label.backend.create.exhibitions.dates')</h3>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.start_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->start_date)):'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.end_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->end_date)):'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.reception_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->reception_date)):'-'}}</span>
                </div>
                <hr />
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.submission_deadline')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->submission_deadline)):'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.notification_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->notification_date)):'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.delivery_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->delivery_date)):'-'}}</span>
                </div>
                <div class="d-flex">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.pickup_date')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->start_date)? date('F j, Y',strtotime($exhibitions->pickup_date)):'-'}}</span>
                </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xxl-6">
                <h3 class="font-weight-bold font-size-h4 text-dark-75 mb-3">@lang('label.backend.create.exhibitions.info')</h3>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.solo_or_group_show')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->solo_group_show)?$exhibitions->solo_group_show:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.location_type')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->location_type)?$exhibitions->location_type:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.location')</span>
                    <span class="text-dark flex-root font-weight-bold"><a href="'.route('locations.show',encrypt($exhibitions->location_id)).'" >{{isset($exhibitions->location->name)?$exhibitions->location->name:'-'}}</a></span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.fee')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->fee) && is_numeric($exhibitions->fee) ? float_number_format($exhibitions->fee):'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.website')</span>
                    <span class="text-dark flex-root font-weight-bold"><a href="{{$exhibitions->website}}" target="_blank">{{isset($exhibitions->website) && $exhibitions->website != 'http://'?'Link':'-'}}</a></span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.email')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->email)?$exhibitions->email:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.phone')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->phone)?$exhibitions->phone:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.address')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->address_line1)?$exhibitions->address_line1:'-'}} {{$exhibitions->address_line2}}<br />{{$exhibitions->city}}<br />{{$exhibitions->state}}<br />{{isset($exhibitions->country_name->name)?$exhibitions->country_name->name:''}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.curator')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->curator)?$exhibitions->curator:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.juror')</span>
                    <span class="text-dark flex-root font-weight-bold">{{isset($exhibitions->juror)?$exhibitions->juror:'-'}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.submitted_works')</span>
                    <span class="text-dark flex-root font-weight-bold">{{$total_submitted_works}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.pending_works')</span>
                    <span class="text-dark flex-root font-weight-bold">{{$total_pending_works}}</span>
                </div>
                <div class="d-flex mb-3">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.accepted_works')</span>
                    <span class="text-dark flex-root font-weight-bold">{{$total_accepted_works}}</span>
                </div>
                <div class="d-flex">
                    <span class="text-dark-50 flex-root font-weight-bold">@lang('label.backend.create.exhibitions.non_accepted_works')</span>
                    <span class="text-dark flex-root font-weight-bold">{{$total_non_accepted_works}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="discription mt-8 col-md-12 col-lg-12 col-xxl-12">
                @if ($exhibitions->description)
                    <div class="bio">
                        <h6> @lang('label.backend.create.exhibitions.description'): </h6> <p> {{$exhibitions->description}} </p>
                    </div>
                @endif
                @if ($exhibitions->notes)
                <div class="notes">
                    <h6> @lang('label.backend.create.exhibitions.notes'): </h6><p> {{$exhibitions->notes}} </p>
                    </div>
                @endif
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xxl-12">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">@lang('datatables.backend.exhibitions.pieces_in_exhibition')
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="kt_datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>@lang('datatables.backend.list.exhibitions.pieces_name')</th>
                                <th>@lang('datatables.backend.list.exhibitions.status')</th>
                                <th>@lang('datatables.backend.list.exhibitions.won_award')</th>
                                <th>@lang('datatables.backend.list.exhibitions.action')</th>
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
<div class="modal fade" id="exampleModalSizeLg" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('label.backend.create.exhibitions.add_work_to') {{$exhibitions->name}} <strong id="lable_room"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form class="form" enctype="multipart/form-data" method="post" id="assignPiecesSubmit">
                        <input  name="exhibition_id" id="exhibition_id" value="{{$exhibitions->id}}" type="hidden">
                        <div class="col-lg-12 col-md-9 col-sm-12">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>@lang('label.backend.create.exhibitions.pieces')</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-solid" id="pieces_id" name="pieces_id">
                                        <option value="">@lang('label.backend.create.exhibitions.select_pieces')</option>
                                            @if(isset($pieces))
                                                @foreach($pieces as $piece)
                                                @php
                                                $pieces_collections = explode(",",$piece->collections_id);
                                                foreach($pieces_collections as $pieces_collection){
                                                    if(isset($collection) && $pieces_collection == $collection->id){
                                                        $collections_array[] = $piece->id;
                                                    }
                                                }
                                                @endphp
                                                <option value="{{$piece->id}}">
                                                {{ $piece->title}}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>@lang('label.backend.create.exhibitions.award_name')</label>
                                    <div class="input-group">
                                        <input type="text" name="award_name" id="award_name" class="form-control form-control-solid">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>@lang('label.backend.create.exhibitions.status')</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                        <input type="radio" checked="checked" name="status" value="1">
                                        <span></span>@lang('label.backend.create.exhibitions.submitted')</label>
                                        <label class="radio">
                                        <input type="radio" name="status" value="2">
                                        <span></span>@lang('label.backend.create.exhibitions.accepted')</label>
                                        <label class="radio">
                                        <input type="radio" name="status" value="3">
                                        <span></span>@lang('label.backend.create.exhibitions.not_accepted')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">@lang('buttons.backend.general.cancel')</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="assignPiecesBtn">@lang('buttons.backend.general.save')</button>
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
        function exhibitionDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.exhibitions.do_you_want_delete_exhibitions')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('exhibitions.store') }}"+'/'+id,
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
        function assignPieces($id){
            $('#exampleModalSizeLg').modal('show');
            $('#lable_room').text($name ? $name : '-');
            $('#privateroom_shere_id').val($id);
        }
        $("#assignPiecesBtn").on("click", function(event){
         $('#assignPiecesSubmit').trigger('submit');
      });
      $("#assignPiecesSubmit").on("submit", function(event){
         event.preventDefault();
		var formData = new FormData($(this)[0]);
         $.ajax({
            url: "{{ route('admin.assign_pieces') }}",
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
            success: function(data){
                if(data.status == 'success'){
                    Swal.fire("{{__('string.backend.common.sent')}}", data.message, 'success');
                    setTimeout(function(){
                            window.location.href = "{{route('exhibitions.show',$exhibitions->id)}}";
                        }, 1500);
                }
                if(data.status == 'error'){
                        Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
                }
            },
            error :function( data ) {
                if( data.status === 422 ) {
                Swal.fire("{{__('string.backend.create.pieces.error')}}", "{{__('string.backend.create.exhibitions.the_given_data_was_invalid')}}", 'error');
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
      var exhibitions_id = "{{$exhibitions->id}}";
      var table = $('#kt_datatable').DataTable({
         processing: true,
         responsive:true,
         ajax: {
               url: "{{ route('admin.get_assign_pieces_by_exhibitions',$exhibitions->id) }}",
         },
         serverside: true,
         autoWidth: false,
         columns: [
               {data:   "DT_RowIndex",name: 'DT_RowIndex'},
               {data: 'pieces_detail', name: 'pieces_detail'},
               {data: 'status', name: 'status'},
               {data: 'award_name', name: 'award_name'},
               {data: 'action', name: 'action'},
         ]
      });
      function changeStatus(id, status) {
        $.ajax({
            url: "{{ route('admin.change_exhibitions_pieces_status') }}",
            method: 'POST',
            data: {"exhibitions_id":id,"status":status},
            success: function(data)
            {
                if(data.status == 'success'){
                    Swal.fire("{{__('string.backend.create.pieces.saved')}}", data.message, 'success');
                    window.location.reload();
                }
            },
        });
      }
      function exhibitionPiecesDelete(id) {
            Swal.fire({
                title: "{{__('string.backend.create.exhibitions.do_you_want_delete_exhibitions_pieces')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.delete')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.remove_exhibitions_pieces') }}",
                        method: 'POST',
                        data: {"exhibitions_id":id},
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                Swal.fire("{{__('string.backend.create.pieces.deleted')}}", data.message, 'success');
                                window.location.reload();
                            }
                        },
                    });
                } 
            })
        }
        function copyExhibitionRecord(id) {
            Swal.fire({
                title: "{{__('string.backend.create.exhibitions.do_you_want_copy_exhibitions')}}",
                showCancelButton: true,
                cancelButtonText: "{{__('buttons.backend.general.crud.cancel')}}",
                confirmButtonText: "{{__('buttons.backend.general.crud.create')}}",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.copy_exhibitions') }}",
                        method: 'POST',
                        data: {"exhibitions_id":id},
                        success: function(data)
                        {
                            if(data.status == 'success'){
                                Swal.fire("{{__('string.backend.create.exhibitions.copied')}}", data.message, 'success');
                                window.location.href = "{{route('exhibitions.index')}}";
                            }
                        },
                    });
                }
            })
        }
    </script>
@endsection
