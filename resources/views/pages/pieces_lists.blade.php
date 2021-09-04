{{-- Extends layout --}}
@auth
@if(Auth::id() == $data->user_id)
@extends('layout.front_pieces')
@endif
@endauth


{{-- Content --}}
@section('content')

<div class="d-flex flex-column-fluid">
   <div class="container">

      <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
         <div class="alert-text">
            <span class="basic-color-text font-weight-bolder font-size-h1 d-md-inline mr-3">{{$data->name}}</span>
            <span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">from {{$data->user->name}}</span>
            <span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">
               <p>
                {{$data->description}}
               </p>
            </span>
         </div>
      </div>
      <div class="row">
          @if(isset($data->private_rooom_pieces))
          @foreach($data->private_rooom_pieces as $pieces)
          @if(isset($pieces->pieces_detail))
         <div class="col-lg-4 mt-5">
            <div class="card card-custom gutter-b">
               <div class="card-body">
                  <div class="d-flex align-items-center">
                     <div class="d-flex flex-column flex-grow-1">
                        <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">{{$pieces->pieces_detail->title}}</a>
                        @if($data->show_public_show_creation_date == 1)
                        <span class="text-muted font-weight-bold">{{ date("F d,Y", strtotime($pieces->pieces_detail->creation_date))}}</span>
                        @endif
                     </div>
                  </div>
                  <div class="pt-4">
                     <div class="card card-custom overlay">
                        <div class="card-body p-0">
                           <div class="overlay-wrapper">
                            @php
                                $thumimage=url("/media/users/blank.png");
                                if(isset($pieces->pieces_detail->pieces_images[0]->url)){
                                    $thumimage=asset_image_display($pieces->pieces_detail->pieces_images[0]->url,"images/pieces/");
                                }
                            @endphp
                            <a href="{{ url('rooms_pieces_detail/' . $data->slug . '/' . encrypt($pieces->piece_id) )}}"><img src="{{$thumimage}}" class="w-100 rounded" height="250px"/></a>
                           </div>
                           @if($data->show_public_show_shadows == 0)
                           <a href="{{ url('rooms_pieces_detail/' . $data->slug . '/' . encrypt($pieces->piece_id) )}}">
                           <div class="overlay-layer m-5 rounded flex-center" style="background: rgba(0,0,0,0.5)">
                              <div class="d-flex flex-column flex-center">
                                  @if(isset($pieces->pieces_detail->medium))
                                 <span class="font-size-h5 label-inline mb-1 text-white"><strong>{{$pieces->pieces_detail->medium}}</strong></span>
                                  @endif
                                  @if(isset($pieces->pieces_detail->dimension))
                                 <span class="font-size-h5 label-inline mb-1 text-white"><strong>{{float_number_format($pieces->pieces_detail->dimension->length)."X".float_number_format($pieces->pieces_detail->dimension->width)."X".float_number_format($pieces->pieces_detail->dimension->depth)." in" }}</strong></span>
                                  @endif
                                  @if(isset($pieces->pieces_detail->dimension) && $data->show_public_show_both_sizes == 1)
                                  <span class="font-size-h5 label-inline mb-1 text-white">{{float_number_format(($pieces->pieces_detail->dimension->length * 2.54))."X".float_number_format(($pieces->pieces_detail->dimension->width * 2.54))."X".float_number_format(($pieces->pieces_detail->dimension->depth * 2.54))." cm" }}</span>
                                   @endif
                                 @if(isset($pieces->pieces_detail->price) && $pieces->pieces_detail->status_id != 6)
                                 <span class="font-size-h5 label-inline mb-1 text-white"><strong>{{$pieces->pieces_detail->price}}</strong></span>
                                 @if($data->show_public_show_wholesale_prices == 1)
                                 <span class="font-size-h5 label-inline mb-1 text-white"><strong>{{$pieces->pieces_detail->wholesale_price}}(wholesale)</strong></span>
                                 @endif
                                 @endif
                                 @if($data->show_public_show_sales == 1 && $pieces->pieces_detail->status_id == 6)
                                 <span class="label label-danger font-size-h5 label-inline mb-1 text-white"><strong>Sold</strong></span>
                                 @endif
                              </div>
                           </div>
                           </a>
                           @endif
                        </div>
                     </div>
                  </div>
                  @if($data->show_public_show_shadows == 1)
                  <div class="overlay-layer m-5 rounded flex-center">
                    <div class="d-flex flex-column flex-center">
                        @if(isset($pieces->pieces_detail->medium))
                       <span class="font-size-h5 label-inline mb-1 text-dark"><strong>{{$pieces->pieces_detail->medium}}</strong></span>
                        @endif
                        @if(isset($pieces->pieces_detail->dimension))
                       <span class="font-size-h5 label-inline mb-1 text-dark"><strong>{{float_number_format($pieces->pieces_detail->dimension->length)."X".float_number_format($pieces->pieces_detail->dimension->width)."X".float_number_format($pieces->pieces_detail->dimension->depth)." in" }}</strong></span>
                        @endif
                        @if(isset($pieces->pieces_detail->dimension) && $data->show_public_show_both_sizes == 1)
                        <span class="font-size-h5 label-inline mb-1 text-dark">{{float_number_format(($pieces->pieces_detail->dimension->length * 2.54))."X".float_number_format(($pieces->pieces_detail->dimension->width * 2.54))."X".float_number_format(($pieces->pieces_detail->dimension->depth * 2.54))." cm" }}</span>
                         @endif
                       @if(isset($pieces->pieces_detail->price) && $pieces->pieces_detail->status_id != 6)
                       <span class="font-size-h5 label-inline mb-1 text-dark"><strong>{{$pieces->pieces_detail->price}}</strong></span>
                       @if($data->show_public_show_wholesale_prices == 1)
                       <span class="font-size-h5 label-inline mb-1 text-dark"><strong>{{$pieces->pieces_detail->wholesale_price}}(wholesale)</strong></span>
                       @endif
                       @endif
                       @if($data->show_public_show_sales == 1 && $pieces->pieces_detail->status_id == 6)
                       <span class="label label-danger font-size-h5 label-inline mb-1 text-white"><strong>Sold</strong></span>
                       @endif
                    </div>
                 </div>
                 @endif
               </div>
            </div>
        </div>
        @endif
        @endforeach
        @else
         <h2>No Pieces</h2>
        @endif

      </div>
   </div>
</div>
@endsection

{{-- Scripts Section --}}
@section('scripts')

@endsection
