{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            @if(isset($inbox->type) && $inbox->type==1)
                <h3 class="card-label">Piece Inquiry from {{$inbox->name}}</h3>
            @else
                <h3 class="card-label">Message from {{$inbox->name}}</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            @if(isset($inbox->pieces_detail->pieces_images) && count($inbox->pieces_detail->pieces_images)>0)
            <div class="col-lg-4">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-body d-flex flex-column">
                        <div class="card card-custom overlay">
                            <div class="card-body p-0">
                                <div class="overlay-wrapper parent-container">
                                    @foreach($inbox->pieces_detail->pieces_images as $key => $image)
                                    @if($key==0)
                                            <img style="background-image:url('{{asset_image_display($image->url,"images/pieces/")}}')" alt="" class="w-100 piece_images"/>
                                    @endif
                                    @endforeach
                                </div>
                                @if(isset($inbox->pieces_detail))
                                <div class="p-5 ">
                                    <hr />
                                    <h5 class="card-title font-weight-bolder">Pieces Info</h5>
                                    <div class="timeline timeline-2">
                                        <div class="timeline-bar"></div>
                                        @if(isset($inbox->pieces_detail) && isset($inbox->pieces_detail->title))
                                            <div class="timeline-item">
                                            <div class="timeline-badge"></div>
                                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                                <span class="mr-3">
                                                <a href="#">Piece Name</a>
                                                </span>
                                                <span class="font-weight-bolder text-right">{{$inbox->pieces_detail->title}}</span>
                                            </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="timeline timeline-2">
                                        <div class="timeline-bar"></div>
                                        @if(isset($inbox->pieces_detail) && isset($inbox->pieces_detail->creation_date))
                                            <div class="timeline-item">
                                                <div class="timeline-badge"></div>
                                                <div class="timeline-content d-flex align-items-center justify-content-between">
                                                    <span class="mr-3">
                                                    <a href="#">Creation Date</a>
                                                    </span>
                                                    <span class="font-weight-bolder text-right">{{$inbox->pieces_detail->creation_date}}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="timeline timeline-2">
                                        <div class="timeline-bar"></div>
                                        @if(isset($inbox->pieces_detail) && isset($inbox->pieces_detail->dimension))
                                            <div class="timeline-item">
                                                <div class="timeline-badge"></div>
                                                <div class="timeline-content d-flex align-items-center justify-content-between">
                                                    <span class="mr-3">
                                                    <a href="#">dimension</a>
                                                    </span>
                                                    <span class="font-weight-bolder text-right">{{$inbox->pieces_detail->dimension->length}} x
                                                    {{$inbox->pieces_detail->dimension->width}} x {{$inbox->pieces_detail->dimension->depth}} in </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="timeline timeline-2">
                                        <div class="timeline-bar"></div>
                                            @if(isset($inbox->pieces_detail) && isset($inbox->pieces_detail->medium))
                                                <div class="timeline-item">
                                                <div class="timeline-badge"></div>
                                                    <div class="timeline-content d-flex align-items-center justify-content-between">
                                                        <span class="mr-3">
                                                        <a href="#">Medium</a>
                                                        </span>
                                                        <span class="font-weight-bolder text-right">{{$inbox->pieces_detail->medium}} </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    <div class="timeline timeline-2">
                                        <div class="timeline-bar"></div>
                                        @if(isset($inbox->pieces_detail) && isset($inbox->pieces_detail->price))
                                            <div class="timeline-item">
                                                <div class="timeline-badge"></div>
                                                <div class="timeline-content d-flex align-items-center justify-content-between">
                                                    <span class="mr-3">
                                                    <a href="#">Price</a>
                                                    </span>
                                                    <span class="font-weight-bolder text-right">{{$inbox->pieces_detail->price}} </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if(isset($collections))
                                        <hr />
                                        <h5 class="card-title font-weight-bolder">Collections</h5>
                                        <ul>
                                            @foreach($collections as $key => $collection)
                                            <li><span class="mr-3">
                                                <span class="font-weight-bolder text-right">{{$collection->collection_name}}</span>
                                            </span></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-8">
            <div class="card card-custom gutter-b">
               <div class="card-header border-0 pt-5">
                  <div class="card-title align-items-start flex-column">
                        <div class="card-toolbar">
                        <h3 class="card-title font-weight-bolder">From : </h3>
                        </div>
                            <div class="timeline timeline-2">
                                <div class="timeline-bar"></div>
                                @if(isset($inbox) && isset($inbox->name))
                                    <div class="timeline-item">
                                        <div class="timeline-badge"></div>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <span class="mr-3 font-weight-bolder">
                                             Name :
                                            </span>
                                            <span class=" text-right">{{$inbox->name}} </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="timeline timeline-2">
                                <div class="timeline-bar"></div>
                                @if(isset($inbox) && isset($inbox->email))
                                    <div class="timeline-item">
                                        <div class="timeline-badge"></div>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <span class="mr-3 font-weight-bolder">
                                            Email :
                                            </span>
                                            <span class="text-right">{{$inbox->email}} </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="timeline timeline-2">
                                <div class="timeline-bar"></div>
                                @if(isset($inbox) && isset($inbox->phone))
                                    <div class="timeline-item">
                                        <div class="timeline-badge"></div>
                                        <div class="timeline-content d-flex align-items-center justify-content-between">
                                            <span class="mr-3 font-weight-bolder">
                                            Phone :
                                            </span>
                                            <span class=" text-right">{{$inbox->phone}} </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(isset($inbox->message))
                                <hr class= "w-100" />
                                <h5 class="card-title font-weight-bolder">Description</h5>
                                <span class="text-left">{{isset($inbox->message)?$inbox->message:''}}</span>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
