<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }}>
    <head>
        <meta charset="utf-8"/>

        {{-- Title Section --}}
        <title>{{ config('app.name') }} | @yield('title', $seo_data['title'] ?? '')</title>

        {{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', strip_tags($seo_data['description']) ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <meta property="og:title" content="@yield('page_title', $seo_data['title'] ?? '')" />
        <meta property="og:type" content="@yield('page_type', $seo_data['type'] ?? '')" />
        <meta property="og:description" content="@yield('page_description', strip_tags($seo_data['description']) ?? '')" />
        <meta property="og:url" content="@yield('page_url', $seo_data['url'] ?? '')" />
        <meta property="og:image" content="@yield('page_image', $seo_data['image'] ?? '')" />
        <meta property="og:image:width" content="750" />
        <meta property="og:image:height" content="450" />
        <meta property="og:image:alt" content="@yield('page_image_alt', $seo_data['title'] ?? '')" />
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
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @yield('styles')
        <style>
        .justify-content-between{
            background: #eef0f8;
        }
        .flex-row-fluid{
            padding-left: 0;
        }
        @media (max-width: 991.98px){
            .header-mobile-fixed .wrapper {
                padding-top: 70px;
            }
        }
        @media (min-width: 992px){
            .header-fixed.subheader-fixed.subheader-enabled .wrapper {
                padding-top: 70px;
                padding-left: 0;
            }
            .header{
                left:0px!important;
            }
        }
        </style>
    </head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GC2DT3EQ39"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-GC2DT3EQ39');
    </script>
    <body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>
    {{-- Header --}}

    <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    @auth
                    @if(Auth::id() == $data->user_id)
                    <div id="kt_header" class="header {{ Metronic::printClasses('header', false) }}" {{ Metronic::printAttrs('header') }}>
                        <div class="container-fluid d-flex align-items-center justify-content-between">

                            <div class="topbar pb-4 w-100">
                                <div class="topbar-item w-100">
                                    <div class="btn btn-icon d-flex align-items-center btn-lg px-2 row w-100" id="kt_quick_user_toggle">
                                        <div class="col-lg-6 col-12">
                                        <span class="text-muted  font-weight-bold font-size-base d-md-inline mr-1">Logged in as a</span>
                                        <span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">{{Auth::user()->email}}</span>
                                        <span class="text-muted  font-weight-bold font-size-base d-md-inline mr-1">Room is</span>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                        @if($data->show_public_show_status == 1) <span class="label label-lg label-light-success label-inline">Published</span> @else <span class="label label-lg label-light-warning label-inline">Unpublished</span> @endif &nbsp;&nbsp;&nbsp;
                                        <a href="{{route('private_rooms.edit',encrypt($data->id))}}"><span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">Edit</span></a>
                                        <a href="{{route('dashboard')}}"><span class="basic-color-text font-weight-bolder font-size-base d-md-inline mr-3">Dashboard</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endauth
                    <div class="content {{ Metronic::printClasses('content', false) }} d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="d-flex flex-column-fluid">
                            <div class="{{ Metronic::printClasses('content-container', false) }}">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

