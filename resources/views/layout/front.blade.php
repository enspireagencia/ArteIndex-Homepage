<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }}>
    <head>
        <meta charset="utf-8"/>

        {{-- Title Section --}}
        <title>{{ config('app.name') }}</title>

        {{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        {{-- Favicon --}}
        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

        {{-- Fonts --}}
        {{ Metronic::getGoogleFontsInclude() }}

        {{-- Global Theme Styles (used by all pages) --}}
        @foreach(config('layout.resources.css') as $style)
            <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        {{-- Layout Themes (used by all pages) --}}
        @foreach (Metronic::initThemes() as $theme)
            <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        {{-- Includable CSS --}}
        <link rel="stylesheet" href="{{ asset('css/front/login-2.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/front/plugins.bundle.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/front/prismjs.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('css/front/style.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

        @yield('styles')
    </head>

    <body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>
        <div class="d-flex flex-column flex-root">
            @yield('content')
        </div>
        <script>var HOST_URL = "{{ route('quick-search') }}";</script>
        {{-- Global Config (global config for global JS scripts) --}}
        <script>
            var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
        </script>

        {{-- Global Theme JS Bundle (used by all pages)  --}}

        @foreach(config('layout.resources.js') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
        {{-- <script src="{{ asset('js/front/plugins.bundle.js') }}"></script> --}}
		<script src="{{ asset('js/front/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('js/front/scripts.bundle.js') }}"></script>


		<script src="{{ asset('js/front/login-general.js') }}"></script>
		<script src="{{ asset('js/front/main.js') }}"></script>
        {{-- Includable JS --}}
        @yield('scripts')

    </body>
</html>

