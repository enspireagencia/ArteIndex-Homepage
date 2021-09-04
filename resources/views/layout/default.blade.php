<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }}>
    <head>
        <meta charset="utf-8"/>

        {{-- Title Section --}}
        <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

        {{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        {{-- Favicon --}}
        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

        {{-- Fonts --}}
        {{ Metronic::getGoogleFontsInclude() }}

        {{-- Global Theme Styles (used by all pages) --}}
        @foreach(config('layout.resources.css') as $style)
            <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        {{-- Layout Themes (used by all pages) --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
        @foreach (Metronic::initThemes() as $theme)
            <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        {{-- Includable CSS --}}
        <link rel="stylesheet" href="{{ asset('css/sweetalert.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
        @yield('styles')
    </head>
    <body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>
    {{-- Header Mobile --}}
        <div id="kt_header_mobile" class="header-mobile {{ Metronic::printClasses('header-mobile', false) }}" {{ Metronic::printAttrs('header-mobile') }}>
            <div class="mobile-logo">
                <a href="{{ url('/') }}">
                    <img alt="{{ config('app.name') }}" src="{{ asset('media/logos/logo-dark.png') }}"/>
                </a>
            </div>
            <div class="d-flex align-items-center">

                @if (config('layout.aside.self.display'))
                    <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle"><span></span></button>
                @endif

                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    {{ Metronic::getSVG('media/svg/icons/General/User.svg', 'svg-icon-xl') }}
                </button>

            </div>
        </div>
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="aside aside-left {{ Metronic::printClasses('aside', false) }} d-flex flex-column flex-row-auto" id="kt_aside">
                    <div class="brand flex-column-auto {{ Metronic::printClasses('brand', false) }}" id="kt_brand">
                        <div class="brand-logo">
                            <a href="{{ url('/dashboard') }}">
                                <span class="art-index-logo"> Arte Index </span>
                            </a>
                        </div>
                    </div>
                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                        <div
                            id="kt_aside_menu"
                            class="aside-menu my-4 {{ Metronic::printClasses('aside_menu', false) }}"
                            data-menu-vertical="1"
                            {{ Metronic::printAttrs('aside_menu') }}>

                            <ul class="menu-nav {{ Metronic::printClasses('aside_menu_nav', false) }}">
                                {{ Menu::renderVerMenu(config('menu_aside.items')) }}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <div id="kt_header" class="header {{ Metronic::printClasses('header', false) }}" {{ Metronic::printAttrs('header') }}>
                        <div class="container-fluid d-flex align-items-center justify-content-between">
                           <div></div>
                            <div class="topbar">
                                <div class="topbar-item">
                                    @if(config('locale.status') && count(config('locale.languages')) > 1)
                                        @foreach(array_keys(config('locale.languages')) as $lang)
                                            <a class="lang-link mr-2 @if(app()->getLocale() == $lang) active @endif" href="{{ url('lang/'.$lang)}}" title="@lang('menus.language-picker.langs.'.$lang)"><img src="{{asset('media/svg/country/'.$lang.'.svg')}}" alt="{{$lang}}" width="auto" height="22"></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="topbar-item">
                                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        <span class="text-muted  font-weight-bold font-size-base d-none d-md-inline mr-1">Hello,</span>
                                        <span class="basic-color-text font-weight-bolder font-size-base d-none d-md-inline mr-3">{{$user->name}}</span>
                                        <span class="symbol symbol-35 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold">{{isset(Auth::user()->name[0])?Auth::user()->name[0]:'A'}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content {{ Metronic::printClasses('content', false) }} d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="d-flex flex-column-fluid">
                            <div class="{{ Metronic::printClasses('content-container', false) }}">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <div class="footer bg-white py-4 d-flex flex-lg-column {{ Metronic::printClasses('footer', false) }}" id="kt_footer">
                        <div class="{{ Metronic::printClasses('footer-container', false) }} d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">{{ date("Y") }} &copy;</span>
                                <a href="https://keenthemes.com/metronic" target="_blank" class="text-dark-75 text-hover-primary">Art Index</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <div class="offcanvas-content pr-5 mr-n5">
                <div class="navi navi-spacer-x-0 p-0">
                    <a class="navi-item" href="/user/{{Auth::user()->user_unique_id}}/profile">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/General/User.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Profile
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="navi-item" href="{{ route('pieces.index') }}">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    {{ Metronic::getSVG("media/svg/icons/Home/Picture.svg", "svg-icon-md svg-icon-primary") }}
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Pieces
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
        <script>var HOST_URL = "{{ route('quick-search') }}";</script>

        {{-- Global Config (global config for global JS scripts) --}}
        <script>
            var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
        </script>

        {{-- Global Theme JS Bundle (used by all pages)  --}}
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
        @foreach(config('layout.resources.js') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="https://releases.transloadit.com/uppy/v1.30.0/uppy.min.js"></script>
        {{-- Includable JS --}} 
        @yield('scripts')

    </body>
</html>

