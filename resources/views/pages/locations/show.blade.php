{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header  border-0 pt-6 ">
            <h2 class="card-label">Location</h2>
            <div class="card-toolbar">
 
            </div>
        </div>
        <div class="location_details">
                @if(isset($data->address_line_1))<p> Address 1 : <span><span>{{$data->address_line_1}}</span> </p> @endif
                @if(isset($data->address_line_2))<p> Address 2 : <span>{{$data->address_line_2}}</span> </p>@endif
                @if(isset($data->city))<p> City : <span>{{$data->city}}</span> </p>@endif
                @if(isset($data->state))<p> State : <span>{{$data->state}}</span> </p>@endif
                @if(isset($data->zip))<p> Zip : <span>{{$data->zip}}</span> </p>@endif
                @if(isset($data->country))<p> Country : <span>{{$data->country}}</span> </p>@endif
                @if(isset($data->phone))<p> Phone : <span>{{$data->phone}}</span> </p>@endif
                @if(isset($data->fax))<p> Fax : <span>{{$data->fax}}</span> </p>@endif
                @if(isset($data->email))<p> Email : <span>{{$data->email}}</span> </p>@endif
                @if(isset($data->website))<p> Website : <span>{{$data->website}}</span> </p>@endif
            </div>
        <div class="contact_de">
            <div class="card-header border-0">
                <h2 class="card-label">Contact</h2>
            </div>
        
            <div class="card-body">
                <table class="table table-bordered table-hover" id="kt_datatable">
                    <thead>
                    <tr>
                        <th> No </th>
                        <th style="width:15%">Images</th>
                        <th>Information</th>
                        <th>Contact</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
    var table = $('#kt_datatable').DataTable({
            processing: true,
            responsive:true,
            serverside: true,
            autoWidth: false,
            responsive: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'information', name: 'information'},
                {data: 'contact', name:'contact'},
                {data: 'address', name: 'address'},
            ]
        });
        
    </script>
@endsection

<style>
    .location_details p {
        margin-bottom:0px;
        padding:10px;
        font-weight: 600; 
        font-size: larger;
    }
    .location_details span{
        font-weight: 500; 
    }
    .location_details{
        display: flex;
        padding: 5px 20px;
        margin-bottom: 20px;
        justify-content: space-between;
        margin-top: 10px;
    }
    .contact_de  > .card-header{
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        flex-wrap: wrap;
        min-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
        background-color: transparent;
    }
    .card.card-custom > .card-header{
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        flex-wrap: wrap;
        min-height: 30px !important;
        padding-top: 0;
        padding-bottom: 0;
        background-color: transparent;
    }
    @media only screen and (max-width: 600px) {
        .location_details{
            display: inline-block;
  }
}


</style>