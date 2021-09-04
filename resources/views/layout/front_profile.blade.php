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
            background: #fff;
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
    
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <div class="offcanvas-content pr-5 mr-n5">
                <div class="navi navi-spacer-x-0 p-0">
                    <a class="navi-item" href="{{ url('/dashboard') }}" >
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/General/User.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Dashboard
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="navi-item" href="/user/{{$data->user_unique_id}}/profile">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/Home/Picture.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                   Edit Profile
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="navi-item" href="/profile/{{$data->user_unique_id}}">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/Home/Picture.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                   View Profile
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="navi-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('louout-form').submit();">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/Navigation/Sign-out.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Logout
                                </div>
                            </div>
                        </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="louout-form" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    @auth
                    @if(Auth::id() == $data->id)
                    <div id="kt_header" class="header {{ Metronic::printClasses('header', false) }}" {{ Metronic::printAttrs('header') }}>
                        <div class="container-fluid d-flex align-items-center justify-content-between back-white">
                           <div>
                            <div class="brand-logo">
                                <a href="{{ url('/dashboard') }}">
                                    <span class="art-index-logo"> Arte Index </span>
                                </a>
                            </div>
                           </div>
                            <div class="topbar">
                                <div class="topbar-item">
                                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        <span class="text-muted  font-weight-bold font-size-base d-none d-md-inline mr-1">Hello,</span>
                                        <span class="symbol symbol-35 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold">{{isset(Auth::user()->name[0])?Auth::user()->name[0]:'A'}}</span>
                                        </span>
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

