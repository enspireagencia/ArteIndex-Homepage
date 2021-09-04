{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}

    <div class="row">
        <div class="col-lg-6 col-xxl-4">
            @include('pages.widgets.total_count', ['class' => 'card-stretch gutter-b', 'total' => $total])
        </div>

        <div class="col-lg-8">
            @include('pages.widgets.inbox', ['class' => 'card-stretch gutter-b', 'inbox_list'=> $inbox_list])
        </div>

        <div class="col-lg-6 col-xxl-4">
            @include('pages.widgets.page_views', ['class' => 'card-stretch gutter-b', 'views' => $views])
        </div>

        <div class="col-lg-8 col-xxl-8 order-1 order-xxl-1">
            @include('pages.widgets.pieces_location', ['class' => 'card-stretch gutter-b', 'location_list' => $location_list])
        </div>
    </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection
