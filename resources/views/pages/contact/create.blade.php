{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                @if(isset($contact))
                @lang('buttons.backend.general.crud.edit') @lang('datatables.backend.contact.title')
                @else
                @lang('label.backend.contact.new_contact') <i class="mr-2"></i>
                @endif
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('contact.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                @lang('buttons.backend.general.back')
            </a>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary font-weight-bolder" id="btncreateCollection">
                    <i class="ki ki-check icon-sm"></i>
                    @if(isset($contact))
                    @lang('buttons.backend.general.crud.update')
                    @else
                    @lang('buttons.backend.general.crud.create') @lang('datatables.backend.contact.title')
                </button>
                @endif

            </div>
        </div>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form class="form" enctype="multipart/form-data" method="post" id="saveCollectionForm">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="col-lg-12 col-md-9 col-sm-12">
                            <fieldset>
                                <legend class="">@lang('label.backend.create.contact.contact_image')</legend>
                                <div class="defult_image my-4">
                                    <input class="form-control form-control-solid" name="default_image" id="default_image" type="file">
                                <input type="hidden" name="old_image" id="old_image" value="{{isset($contact->default_image)?$contact->default_image:''}}">
                                </div>
                                <div class="form-group">
                                    @if(isset($contact->default_image))
                                    <div id="image_preview" style="width:100%;">
                                        <div class="img-div" id="img-div0"><img
                                                src="{{asset_image_display($contact->default_image,"images/contact/")}}"
                                                class="img-responsive image img-thumbnail width-100" title="2(1).jpg">
                                            <div class="middle"><button id="action-icon" value="img-div0" class="btn btn-danger"
                                                    role="2(1).jpg"><i class="fa fa-trash"></i></button></div>
                                        </div>
                                    </div>
                                    @else
                                    <div id="image_preview" style="width:100%;">
                                    </div>
                                    @endif
                                </div>
                            </fieldset>
                        </div>
                        <div class="contact_info mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.contact_info')</legend>
                                    <div class="contact-form my-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">@lang('label.backend.create.contact.first_name')</label>
                                                <input type="text" class="form-control" id="first_name"
                                                    name="first_name" value="{{isset($contact->first_name)?$contact->first_name:''}}">
                                                    <input type="hidden" name="contact_id" id="contact_id" value="{{isset($contact->id)?$contact->id:''}}" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">@lang('label.backend.create.contact.last_name')</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{isset($contact->last_name)?$contact->last_name:''}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">@lang('label.backend.create.contact.title')</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{isset($contact->title)?$contact->title:''}}">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="phone">@lang('label.backend.create.contact.phone')</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{isset($contact->phone)?$contact->phone:''}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="work_phone">@lang('label.backend.create.contact.work_phone')</label>
                                                <input type="text" class="form-control" id="work_phone" name="work_phone" value="{{isset($contact->work_phone)?$contact->work_phone:''}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mobile_phone">@lang('label.backend.create.contact.mobile_phone')</label>
                                                <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" value="{{isset($contact->mobile_phone)?$contact->mobile_phone:''}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">@lang('label.backend.create.contact.email')</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{isset($contact->mobile_phone)?$contact->mobile_phone:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="secondary_email">@lang('label.backend.create.contact.secondary_email')</label>
                                            <input type="email" class="form-control" id="secondary_email" name="secondary_email" value="{{isset($contact->secondary_email)?$contact->secondary_email:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="website">@lang('label.backend.create.contact.website')</label>
                                            <input type="text" class="form-control" id="website" name="website" value="{{isset($contact->website)?$contact->website:''}}">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="company_name">@lang('label.backend.create.contact.company_organization')</label>
                                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{isset($contact->company_name)?$contact->company_name:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="job_title">@lang('label.backend.create.contact.job_title')</label>
                                                <input type="text" class="form-control" id="job_title" name="job_title" value="{{isset($contact->job_title)?$contact->job_title:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="primary_add mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.primary_address')</legend>
                                    <div class="primary_address my-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="address1">@lang('label.backend.create.contact.address_line_1')</label>
                                                <input type="text" class="form-control" id="address1" name="address1" value="{{isset($contact->address1)?$contact->address1:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address1">@lang('label.backend.create.contact.address_line_2')</label>
                                                <input type="text" class="form-control" id="address2" name="address2" value="{{isset($contact->address2)?$contact->address2:''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="city">@lang('label.backend.create.contact.city')</label>
                                                <input type="text" class="form-control" id="city" name="city" value="{{isset($contact->city)?$contact->city:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="state">@lang('label.backend.create.contact.state')</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{isset($contact->state)?$contact->state:''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="zip">@lang('label.backend.create.contact.zip')</label>
                                                <input type="text" class="form-control" id="zip" name="zip" value="{{isset($contact->zip)?$contact->zip:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="country">@lang('label.backend.create.contact.country')</label>
                                                <input type="text" class="form-control" id="country" name="country" value="{{isset($contact->country)?$contact->country:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="Secondary_add mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.secondary_address')</legend>
                                    <div class="Secondary_address my-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="secondary_address1">@lang('label.backend.create.contact.address_line_1')</label>
                                                <input type="text" class="form-control" id="secondary_address1"  name="secondary_address1"  value="{{isset($contact->secondary_address1)?$contact->secondary_address1:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="secondary_address2">@lang('label.backend.create.contact.address_line_2')</label>
                                                <input type="text" class="form-control" id="secondary_address2" name="secondary_address2"  value="{{isset($contact->secondary_address2)?$contact->secondary_address2:''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="secondary_city">@lang('label.backend.create.contact.city')</label>
                                                <input type="text" class="form-control" id="secondary_city" name="secondary_city"  value="{{isset($contact->secondary_city)?$contact->secondary_city:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="stasecondary_statete">@lang('label.backend.create.contact.state')</label>
                                                <input type="text" class="form-control" id="secondary_state" name="secondary_state"  value="{{isset($contact->secondary_state)?$contact->secondary_state:''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="secondary_zip">@lang('label.backend.create.contact.zip')</label>
                                                <input type="text" class="form-control" id="secondary_zip" name="secondary_zip"  value="{{isset($contact->secondary_zip)?$contact->secondary_zip:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="secondary_country">@lang('label.backend.create.contact.country')</label>
                                                <input type="text" class="form-control" id="secondary_country" name="secondary_country"  value="{{isset($contact->secondary_country)?$contact->secondary_country:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="associalte mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.associations')</legend>
                                    <div class="ass_cialr my-4">
                                        <label for="secondary_zip">@lang('label.backend.create.contact.groups')</label>
                                        <div class="groups">
                                        <select class="form-control select2 form-control-solid" multiple id="group_id" name="group_id[]">
                                          @if (isset($group))
                                          @foreach($group as $groups)
                                                <option value="{{$groups->id}}">
                                                    {{ $groups->group_name }}
                                                </option>
                                                @endforeach
                                          @endif

                                       </select>
                                        </div>
                                        <div class="location mt-4">
                                            <label for="secondary_zip ">@lang('label.backend.create.contact.location_relation')</label>
                                            <select class="form-control form-control-solid" id="location_id" name="location_id">
                                                <option value="">@lang('label.backend.create.pieces.select_location')</option>
                                                @if(isset($locations))
                                                    @foreach($locations as $location)
                                                    <option value="{{$location->id}}" @if(isset($contact->location_id) && $contact->location_id == $location->id ) selected @endif >
                                                    {{ $location->name}}
                                                    </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="bio mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.bio')</legend>
                                    <div class="bio my-4">
                                        <label for="secondary_zip ">Bio</label>
                                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="bio"
                                            id="bio">{{isset($contact->bio)?$contact->bio:''}}</textarea>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="bio mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.notes')</legend>
                                    <div class="bio my-4">
                                        <label for="secondary_zip ">Notes</label>
                                        <textarea cols="10" rows="5" class="form-control  form-control-solid" name="notes" id="notes">{{isset($contact->notes)?$contact->notes:''}}</textarea>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="info mt-5">
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <fieldset>
                                    <legend class="">@lang('label.backend.create.contact.additional_info')</legend>
                                    <div class="addi_info my-4">
                                        <div class="birth_date">
                                            <label for="secondary_zip ">@lang('label.backend.create.contact.birth_date')</label>
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <select class="form-control form-control-solid"
                                                        id="creation_date_year" name="creation_date[year]">
                                                        <option value="">
                                                            @lang('label.backend.create.pieces.select_year')
                                                        </option>
                                                        @php
                                                        $start = date('Y');
                                                        for($i=$start;$i>=1880;$i--){
                                                        @endphp
                                                        <option value="{{$i}}" @if(isset($contact->year) && $contact->year ==$i ) selected @endif >{{$i}}</option>
                                                        @php
                                                        }
                                                        @endphp
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 pl-0">
                                                    <select class="form-control form-control-solid"
                                                        id="creation_date_month" name="creation_date[month]">
                                                        <option value="">
                                                            @lang('label.backend.create.pieces.select_month')
                                                        </option>
                                                        <option value="1" @if(isset($contact->month) && $contact->month =='01' ) selected @endif>January</option>
                                                        <option value="2" @if(isset($contact->month) && $contact->month =='02' ) selected @endif>February</option>
                                                        <option value="3" @if(isset($contact->month) && $contact->month =='03' ) selected @endif>March</option>
                                                        <option value="4" @if(isset($contact->month) && $contact->month =='04' ) selected @endif>April</option>
                                                        <option value="5" @if(isset($contact->month) && $contact->month =='05' ) selected @endif>May</option>
                                                        <option value="6" @if(isset($contact->month) && $contact->month =='06' ) selected @endif>June</option>
                                                        <option value="7" @if(isset($contact->month) && $contact->month =='07' ) selected @endif>July</option>
                                                        <option value="8" @if(isset($contact->month) && $contact->month =='08' ) selected @endif>August</option>
                                                        <option value="9" @if(isset($contact->month) && $contact->month =='09' ) selected @endif>September</option>
                                                        <option value="10" @if(isset($contact->month) && $contact->month =='10' ) selected @endif>October</option>
                                                        <option value="11" @if(isset($contact->month) && $contact->month =='11' ) selected @endif>November</option>
                                                        <option value="12" @if(isset($contact->month) && $contact->month=='12' ) selected @endif>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 pl-0">
                                                    <select class="form-control form-control-solid"
                                                        id="creation_date_date" name="creation_date[date]">
                                                        <option value="">
                                                            Select Date
                                                        </option>
                                                        @php
                                                        for($i=1;$i<=31;$i++){ @endphp <option value="{{$i}}"
                                                            @if(isset($contact->date) && $contact->date == $i ) selected @endif >{{$i}}</option>
                                                            @php
                                                            }
                                                            @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="Death_Date mt-4">
                                            <label for="secondary_zip ">@lang('label.backend.create.contact.death_date')</label>
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <select class="form-control form-control-solid" id="dath_date_year"
                                                        name="dath_date[year]">
                                                        <option value="">
                                                            @lang('label.backend.create.pieces.select_year')
                                                        </option>
                                                        @php
                                                        $start = date('Y');
                                                        for($i=$start;$i>=1880;$i--){
                                                        @endphp
                                                        <option value="{{$i}}" @if(isset($contact->year) && $contact->year == $i ) selected @endif >{{$i}}</option>
                                                        @php
                                                        }
                                                        @endphp
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 pl-0">
                                                    <select class="form-control form-control-solid" id="dath_date_month"
                                                        name="dath_date[month]">
                                                        <option value="">
                                                            @lang('label.backend.create.pieces.select_month')
                                                        </option>
                                                        <option value="1" @if(isset($contact->month) && $contact->month =='01' ) selected @endif>January</option>
                                                        <option value="2" @if(isset($contact->month) && $contact->month =='02' ) selected @endif>February</option>
                                                        <option value="3" @if(isset($contact->month) && $contact->month =='03' ) selected @endif>March</option>
                                                        <option value="4" @if(isset($contact->month) && $contact->month == '04' ) selected @endif>April</option>
                                                        <option value="5" @if(isset($contact->month) && $contact->month =='05' ) selected @endif>May</option>
                                                        <option value="6" @if(isset($contact->month) && $contact->month =='06' ) selected @endif>June</option>
                                                        <option value="7" @if(isset($contact->month) && $contact->month =='07' ) selected @endif>July</option>
                                                        <option value="8" @if(isset($contact->month) && $contact->month =='08' ) selected @endif>August</option>
                                                        <option value="9" @if(isset($contact->month) && $contact->month =='09' ) selected @endif>September</option>
                                                        <option value="10" @if(isset($contact->month) && $contact->month=='10' ) selected @endif>October</option>
                                                        <option value="11" @if(isset($contact->month) && $contact->month=='11' ) selected @endif>November</option>
                                                        <option value="12" @if(isset($contact->month) && $contact->month=='12' ) selected @endif>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 pl-0">
                                                    <select class="form-control form-control-solid" id="dath_date_date"
                                                        name="dath_date[date]">
                                                        <option value="">Select Date
                                                        </option>
                                                        @php
                                                        for($i=1;$i<=31;$i++){ @endphp <option value="{{$i}}"
                                                            @if(isset($contact->date) && $contact->date == $i ) selected @endif >{{$i}}</option>
                                                            @php
                                                            }
                                                            @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-5">
                                            <label for="nationality">@lang('label.backend.create.contact.nationality')</label>
                                            <input type="text" class="form-control" id="nationality" name="nationality" value="{{isset($contact->nationality)?$contact->nationality:''}}">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="spouse_first_name">@lang('label.backend.create.contact.spouses_first_name')</label>
                                                <input type="text" class="form-control" id="spouse_first_name" name="spouse_first_name" value="{{isset($contact->spouse_first_name)?$contact->spouse_first_name:''}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="spouse_first_name">@lang('label.backend.create.contact.spouses_last_name')</label>
                                                <input type="text" class="form-control" id="spouse_last_name" name="spouse_last_name" value="{{isset($contact->spouse_last_name)?$contact->spouse_last_name:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
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
      var selectedValue = "{{isset($contact->group_id ) ? $contact->group_id :''}}";
      if(selectedValue){
         var str = selectedValue.split(',');
         $('.select2').val(str).trigger('change');
      }else{
         $('.select2').val();
      }


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
            url: "{{ route('contact.store') }}",
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
                        window.location.href = "{{route('contact.index')}}";
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

    $(document).ready(function () {
        var fileArr = [];
        $("#default_image").change(function () {
            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("default_image").files;
            if (!total_file.length) return;
            for (var i = 0; i < total_file.length; i++) {
                if (total_file[i].size > 1048576) {
                    return false;
                } else {
                    fileArr.push(total_file[i]);
                    $('#image_preview').append("<div class='img-div' id='img-div" + i + "'><img src='" +
                        URL.createObjectURL(event.target.files[i]) +
                        "' class='img-responsive image img-thumbnail' title='" + total_file[i]
                        .name + "'><div class='middle'><button id='action-icon' value='img-div" +
                        i + "' class='btn btn-danger' role='" + total_file[i].name +
                        "'><i class='fa fa-trash'></i></button></div></div>");
                }
            }
        });

        $('body').on('click', '#action-icon', function (evt) {
            var divName = this.value;
            var fileName = $(this).attr('role');
            $(`#${divName}`).remove();

            for (var i = 0; i < fileArr.length; i++) {
                if (fileArr[i].name === fileName) {
                    fileArr.splice(i, 1);
                }
            }
            document.getElementById('default_image').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file) {
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }
    });
</script>
@endsection
