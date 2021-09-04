{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">View Contact
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('contact.index') }}" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                @lang('buttons.backend.general.back')
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder">Contact Images</h3>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="card card-custom overlay">
                            <div class="card-body p-0">
                                <div class="overlay-wrapper parent-container">
                                    <img class="contact_img w-100" style="background-image:url('{{asset_image_display($data->default_image,"images/contact/")}}')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-custom gutter-b">
                    <div class="row">
                        <div class="col-lg-6 col-md-4 col-sm-12">
                            <div class="contact_item mt-10">
                                <ul>
                                    @if($data->job_title) <li> Job Title : <span> {{$data->job_title}} </span> </li> @endif
                                    @if($data->company_name) <li> Company : <span> {{$data->company_name}} </span> </li> @endif
                                    @if($data->phone) <li> Phone : <span> {{$data->phone}} </span> </li> @endif
                                    @if($data->work_phone) <li> Work Phone : <span> {{$data->work_phone}} </span> </li> @endif
                                    @if($data->mobile_phone) <li> Mobile Phone : <span> {{$data->mobile_phone}} </span> </li> @endif
                                    @if($data->email) <li> Email : <span> {{$data->email}} </span> </li> @endif
                                    @if($data->secondary_email) <li> Secondary : <span> {{$data->secondary_email}} </span> </li> @endif
                                    @if($data->website) <li> Website : <span> {{$data->website}} </span> </li> @endif
                                </ul>
                            </div>
                            <div class="add_info ml-13 mt-15">
                                @if($data->spouse_first_name) <p> Spouse First Name : <span>{{$data->spouse_first_name }}</span></p> @endif
                                @if($data->spouse_last_name) <p> Spouse Last Name : <span>{{$data->spouse_last_name }}</span></p> @endif
                                @if($data->creation_date) <p> Birth Date : <span>{{$data->creation_date }}</span></p> @endif
                                @if($data->dath_date) <p> Dath Date : <span>{{$data->dath_date }}</span></p> @endif
                                @if($data->nationality) <p> Nationality : <span>{{$data->nationality }}</span></p> @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-12">
                            <div class="contact_item mt-10">
                                <ul>
                                    @if($data->address1) <li> Address 1 : <span> {{$data->address1}} </span> </li> @endif
                                    @if($data->address2) <li> Address 2 : <span> {{$data->address2}} </span> </li> @endif
                                    @if($data->city) <li> City : <span> {{$data->city}} </span> </li> @endif
                                    @if($data->state) <li> State : <span> {{$data->state}} </span> </li> @endif
                                    @if($data->country) <li> Country : <span> {{$data->country}} </span> </li> @endif
                                    @if($data->zip) <li> Zip : <span> {{$data->zip}} </span> </li> @endif
                                </ul>
                            </div>
                            <div class="contact_item mt-20">
                                <ul>
                                    @if($data->secondary_address1) <li> Address 1 : <span> {{$data->secondary_address1}}</span> </li> @endif
                                    @if($data->secondary_address2) <li> Address 2 : <span> {{$data->secondary_address2}}</span> </li> @endif
                                    @if($data->secondary_city) <li> City : <span> {{$data->secondary_city}}</span> </li> @endif
                                    @if($data->secondary_state) <li> State : <span> {{$data->secondary_state}}</span> </li> @endif
                                    @if($data->secondary_country) <li> Country : <span> {{$data->secondary_country}}</span> </li> @endif
                                    @if($data->secondary_zip) <li> Zip : <span> {{$data->secondary_zip}}</span> </li> @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                            <div class="location mt-2 ml-5">
                                    @if($data->location_id)<h6> Location Relation : {{$data->location->name}} </h6>@endif
                            </div>
                            <div class="Groups mt-1 ml-5">
                                    @if($groups !="")<h6> Groups: {!!$groups!!} </h6>@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="discription ml-13" style="margin-top:30px">
                @if ($data->bio)
                    <div class="bio">
                        <h6> Bio </h6> <p> {{$data->bio}} </p>
                    </div>
                @endif
                @if ($data->notes)
                <div class="notes">
                    <h6> Notes </h6><p> {{$data->notes}} </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


<style>
.contact_img{
    background-repeat: no-repeat;
    background-position: center;
    height: 230px;
}
.contact_item li{
    list-style: none;
    font-size:15px;
    font-weight: 500;
    margin-bottom:10px;
}
.contact_item li span{
    font-weight: 400;
}
.add_info p{
    font-size:14px;
    font-weight: 500;
}
.add_info span{
    font-weight: 400;
}
</style>
