{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                @if(isset($group))
                @lang('buttons.backend.general.crud.edit') @lang('datatables.backend.group.title')
                @else
                @lang('label.backend.group.new_group') <i class="mr-2"></i>
                @endif
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('group.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                @lang('buttons.backend.general.back')
            </a>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateCollection">
                    <i class="ki ki-check icon-sm"></i>
                    @if(isset($group))
                    @lang('buttons.backend.general.crud.update')
                    @else
                    @lang('buttons.backend.general.crud.create') @lang('datatables.backend.group.title')
                </button>
                @endif
                
            </div>
        </div>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form class="form" enctype="multipart/form-data" method="post" id="saveCollectionForm">
            <div class="card-body">
                <div class="form-group">
                    <label> @lang('label.backend.create.group.group_name') </label>
                        <input type="text" class="form-control" name="group_name" value="{{isset($group->group_name)?$group->group_name:''}}">
                        <input type="hidden" name="group_id" id="group_id" value="{{isset($group->id)?$group->id:''}}" />
                        
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/ckeditor.js') }}"></script>

@endsection

{{-- Scripts Section --}}
@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".select2").select2({
        multiple: true,
    });
 
    $("#btncreateCollection").on("click", function (event) {
        $('#saveCollectionForm').trigger('submit');
    });
    $("#saveCollectionForm").on("submit", function (event) {
        event.preventDefault();

        $('.has-danger').next().children().children().css({
            "border": ""
        });
        $('.is-invalid').removeClass("is-invalid");
        $('.invalid-feedback').html("");
        $('.has-danger').removeClass("has-danger");
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "{{ route('group.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {},
            success: function (data) {
                if (data.status == 'success') {
                    if (data.type == '1') {
                        Swal.fire("{{__('string.backend.create.pieces.created')}}", data.message,
                            'success');
                    } else {
                        Swal.fire("{{__('string.backend.create.pieces.updated')}}", data.message,
                            'success');
                    }
                    setTimeout(function () {
                        window.location.href = "{{route('group.index')}}";
                    }, 1500);
                }
                if (data.status == 'error') {
                    Swal.fire("{{__('string.backend.create.pieces.error')}}", data.message, 'error');
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    Swal.fire("{{__('string.backend.create.pieces.error')}}",
                        "{{__('string.backend.create.locations.the_given_data_was_invalid')}}",
                        'error');
                    $('.btn-success').removeAttr('disabled');
                    var errors = [];
                    errors = data.responseJSON.errors
                    $.each(errors, function (key, value) {
                        $('#' + key).parent().addClass('has-danger');
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent('.has-danger').find('.invalid-feedback').html(
                            value);
                        $('#' + key).next().children().children().css({
                            "border": "1px solid #f86c6b"
                        });
                    })
                }
            }
        });
    })

</script>
@endsection
