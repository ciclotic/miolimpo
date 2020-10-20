<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ setting('appshell.ui.name') }}</title>
    <meta property="og:title" content="@yield('title') - {{ setting('appshell.ui.name') }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="{{ url()->full() }}" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:locale" content="{{ App::getLocale() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ setting('appshell.ui.name') }}" />
    <meta name="twitter:card" content="summary_large_image" />

    @yield('metas')

    @if (setting('ctic.general.defaults.google_analytics'))
    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ setting('ctic.general.defaults.google_analytics') }}', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('layouts._favicons')

    <!-- Scripts -->
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <style>
        .cart-widget {
            position: relative;
            float: left;
            background: white;
            padding: 5px;
            top: 0px;
            left: 0px;
            width: 35%;
            height: 100%;
            display: none;
            border-right: {{ setting('ctic.styles.colors.main') }} solid 2px;
            border-bottom: {{ setting('ctic.styles.colors.main') }} solid 2px;
            border-left: {{ setting('ctic.styles.colors.main') }} solid 2px;
        }
        .link-close {
            font-size: 24px;
            text-align: right;
        }
        @media only screen and (max-width: 600px) {
            .cart-widget {
                position: fixed;
                z-index: 100;
                width: 100%;
                border-right: none;
                border-bottom: none;
                border-left: none;
            }
        }

        main {
            position: relative;
            float: left;
            width: 100%;
        }

        a {
            color: {{ setting('ctic.styles.colors.main') }};
        }

        a:hover {
            color: {{ setting('ctic.styles.colors.main') }};
        }

        .navbar-main  a:hover {
            color: #ffffff;
        }

        .text-primary {
            color: {{ setting('ctic.styles.colors.main') }} !important;
        }

        .btn-primary {
            background-color: {{ setting('ctic.styles.colors.main') }} !important;
            border-color: {{ setting('ctic.styles.colors.main') }} !important;
        }

        .navbar-main {
            background-color: {{ setting('ctic.styles.colors.main') }};
        }

        .background-grey-scale a:hover {
            color: {{ setting('ctic.styles.colors.main') }};
            border-bottom: 2px solid {{ setting('ctic.styles.colors.main') }};
        }

        .navbar-main .background-grey-scale  a:hover {
            color: #ffffff;
        }

        .background-grey-scale-1 {
            background-color: #fcfcfc;
        }

        .background-grey-scale-2 {
            background-color: #f9f9f9;
        }

        .background-grey-scale-3 {
            background-color: #f8f8f8;
        }

        .background-grey-scale-4 {
            background-color: #f8f8f8;
        }

        .background-grey-scale-5 {
            background-color: #f8f8f8;
        }

        .background-white {
            background-color: white;
        }

        @media only screen and (max-width: 600px) {
            .auth-style a {
                color: {{ setting('ctic.styles.colors.main') }} !important;
            }

            .auth-style a:hover {
                color: {{ setting('ctic.styles.colors.main') }} !important;
            }
        }
    </style>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel navbar-main">
            <div class="container">

                @if($agent->isMobile())
                    <div class="row w-100">
                        <div class="col-2">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesMenu" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-md-2 col-8 background-grey-scale background-grey-scale-0 store-title mt-1">
                            <a href="{{ url('/') }}">
                                <img src="{{ setting('ctic.general.defaults.logo_url') }}" title="{{ config('app.name', 'Laravel') }}" />
                                {{ setting('appshell.ui.name') }}
                            </a>
                            <div class="input-group header-search" id="header-search-mobile">
                                <form action="{{ route('product.index') }}">
                                    <input type="text" class="form-control" aria-label="{{ __('ctic_shop.search') }}" id="header-search-mobile-input" name="search-term">
                                </form>
                            </div>
                        </div>
                        <div class="col-2 main-menu nav-item header-icon">
                            <a class="nav-link" href="#" onclick="(document.getElementById('header-search-mobile').style.display === 'block') ? document.getElementById('header-search-mobile').style.display = 'none' : document.getElementById('header-search-mobile').style.display = 'block'; document.getElementById('header-search-mobile-input').focus()">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                </svg>
                            </a>
                            @if(Cart::itemCount() > 0 && Route::currentRouteName() !== 'checkout.show')
                                <a class="nav-link" href="#" onclick="showCart()">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-cart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                    @if (Cart::isNotEmpty())
                                        <span class="badge badge-pill badge-secondary">{{ Cart::itemCount() }}</span>
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                    @include('category._categories', ['taxons' => $taxons, 'taxon' => $taxon])

                @else

                    <div class="row w-100">
                        <div class="col-md-2 col-6 background-grey-scale background-grey-scale-0 store-title">
                            <a href="{{ url('/') }}">
                                <img src="{{ setting('ctic.general.defaults.logo_url') }}" title="{{ config('app.name', 'Laravel') }}" />
                                <br>
                                {{ setting('appshell.ui.name') }}
                            </a>
                        </div>
                        <div class="col-md-10">
                            <div class="row mt-1">

                                <!-- Authentication Links -->
                                <!-- Authentication duplicated in _categories.blade.php category -->
                                <div class="col-md-5 header-phrase">
                                    {{ setting('ctic.general.defaults.main_phrase') }}
                                </div>
                                <div class="col-md-7 background-grey-scale background-grey-scale-0 auth-style">
                                    <div class="row">
                                        @if (setting('ctic.general.defaults.help'))
                                            <a href="{{ setting('ctic.general.defaults.help_url') }}" class="col-3">
                                                {{ setting('ctic.general.defaults.help') }}
                                            </a>
                                        @endif
                                        @if (setting('ctic.general.defaults.reference'))
                                            <a href="{{ setting('ctic.general.defaults.reference_url') }}" class="col-3">
                                                {{ setting('ctic.general.defaults.reference') }}
                                            </a>
                                        @endif
                                        @guest
                                            <a href="{{ route('login') }}" class="col-3">{{ __('ctic_shop.login') }}</a>
                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="col-3">{{ __('ctic_shop.register') }}</a>
                                            @endif
                                        @else
                                            <a href="{{ route('account.home') }}" class="col-3">
                                                {{ Auth::user()->name }}
                                            </a>

                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();"
                                               class="col-3">
                                                {{ __('ctic_shop.logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endguest
                                    </div>
                                </div>
                            </div>


                            <form action="{{ route('product.index') }}">
                                <div class="row">
                                    <div class="col-md-5 input-group header-search">
                                        <input type="text" class="form-control" aria-label="{{ __('ctic_shop.search') }}" name="search-term">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                                  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 header-shipping">
                                        <!--<a href="#">
                                            <div class="row">
                                                <div class="col-3 pt-1">
                                                    <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="ml-2 bi bi-truck" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                    </svg>
                                                </div>
                                                <div class="col-9 pt-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            Envío <strong>GRATIS</strong> en 24/48h
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            Desde 60€
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>-->
                                    </div>
                                    @if(Cart::itemCount() > 0 && Route::currentRouteName() !== 'checkout.show')
                                        <div class="col-md-3 col-2 main-menu nav-item header-icon">
                                            <a class="nav-link" href="#" onclick="showCart()">
                                                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-cart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                </svg>
                                                {{ __('ctic_shop.cart') }}
                                                @if (Cart::isNotEmpty())
                                                    <span class="badge badge-pill badge-secondary">{{ Cart::itemCount() }}</span>
                                                @endif
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </nav>

        @if(Cart::itemCount() > 0 && Route::currentRouteName() !== 'checkout.show')
        <div class="cart-widget">
            <div class="row">
                <div class="col-md-10 col-6">
                    &nbsp;
                </div>
                <div class="col-md-2 col-6 link-close">
                    <a href="#" onclick="hideCart()">X</a>
                </div>
            </div>
            @include('cart.cart')
        </div>
        @endif

        <main>

            @if(! $agent->isMobile())
                <div class="container-menu">
                    <div class="container">
                        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesMenu" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            @include('category._categories', ['taxons' => $taxons, 'taxon' => $taxon])
                        </nav>
                    </div>
                </div>
            @endif

            <div class="container mt-3 mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        @yield('breadcrumbs')
                    </ol>
                </nav>
                @include('flash::message')

                <div class="container container-content">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-12">
                        @if (setting('ctic.footer.link.columna1_1_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna1_1_url') }}">{{ setting('ctic.footer.link.columna1_1_text') }}</a>
                            </div>
                        </div>
                        @endif
                        @if (setting('ctic.footer.link.columna1_2_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna1_2_url') }}">{{ setting('ctic.footer.link.columna1_2_text') }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-12">
                        @if (setting('ctic.footer.link.columna2_1_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna2_1_url') }}">{{ setting('ctic.footer.link.columna2_1_text') }}</a>
                            </div>
                        </div>
                        @endif
                        @if (setting('ctic.footer.link.columna2_2_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna2_2_url') }}">{{ setting('ctic.footer.link.columna2_2_text') }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-12">
                        @if (setting('ctic.footer.link.columna3_1_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna3_1_url') }}">{{ setting('ctic.footer.link.columna3_1_text') }}</a>
                            </div>
                        </div>
                        @endif
                        @if (setting('ctic.footer.link.columna3_2_text'))
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{ setting('ctic.footer.link.columna3_2_url') }}">{{ setting('ctic.footer.link.columna3_2_text') }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="row">
                        @if (setting('ctic.footer.link.facebook_url'))
                            <div class="col-4">
                                <a href="{{ setting('ctic.footer.link.facebook_url') }}" target="_blank"><img width="32" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMC8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvVFIvMjAwMS9SRUMtU1ZHLTIwMDEwOTA0L0RURC9zdmcxMC5kdGQnPjxzdmcgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMzIgMzIiIGhlaWdodD0iMzJweCIgaWQ9IkxheWVyXzEiIHZlcnNpb249IjEuMCIgdmlld0JveD0iMCAwIDMyIDMyIiB3aWR0aD0iMzJweCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PGNpcmNsZSBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGN4PSIxNiIgY3k9IjE2IiBmaWxsPSIjM0I1OTk4IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHI9IjE2Ii8+PHBhdGggZD0iTTIyLDMyVjIwaDRsMS01aC01di0yYzAtMiwxLjAwMi0zLDMtM2gyVjVjLTEsMC0yLjI0LDAtNCwwYy0zLjY3NSwwLTYsMi44ODEtNiw3djNoLTR2NWg0djEySDIyICAgeiIgZmlsbD0iI0ZGRkZGRiIgaWQ9ImZfMl8iLz48L2c+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PC9zdmc+" alt="Facebook {{ setting('appshell.ui.name') }}" /></a>
                            </div>
                        @endif
                        @if (setting('ctic.footer.link.twitter_url'))
                            <div class="col-4">
                                <a href="{{ setting('ctic.footer.link.twitter_url') }}" target="_blank"><img width="32" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDQ4IDQ4IiBpZD0iTGF5ZXJfMSIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNDggNDgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxjaXJjbGUgY3g9IjI0IiBjeT0iMjQiIGZpbGw9IiMxQ0I3RUIiIHI9IjI0Ii8+PGc+PGc+PHBhdGggZD0iTTM2LjgsMTUuNGMtMC45LDAuNS0yLDAuOC0zLDAuOWMxLjEtMC43LDEuOS0xLjgsMi4zLTMuMWMtMSwwLjYtMi4xLDEuMS0zLjQsMS40Yy0xLTEuMS0yLjMtMS44LTMuOC0xLjggICAgYy0yLjksMC01LjMsMi41LTUuMyw1LjdjMCwwLjQsMCwwLjksMC4xLDEuM2MtNC40LTAuMi04LjMtMi41LTEwLjktNS45Yy0wLjUsMC44LTAuNywxLjgtMC43LDIuOWMwLDIsMC45LDMuNywyLjMsNC43ICAgIGMtMC45LDAtMS43LTAuMy0yLjQtMC43YzAsMCwwLDAuMSwwLDAuMWMwLDIuNywxLjgsNSw0LjIsNS42Yy0wLjQsMC4xLTAuOSwwLjItMS40LDAuMmMtMC4zLDAtMC43LDAtMS0wLjEgICAgYzAuNywyLjMsMi42LDMuOSw0LjksMy45Yy0xLjgsMS41LTQuMSwyLjQtNi41LDIuNGMtMC40LDAtMC44LDAtMS4zLTAuMWMyLjMsMS42LDUuMSwyLjYsOC4xLDIuNmM5LjcsMCwxNS04LjYsMTUtMTYuMSAgICBjMC0wLjIsMC0wLjUsMC0wLjdDMzUuMiwxNy42LDM2LjEsMTYuNiwzNi44LDE1LjR6IiBmaWxsPSIjRkZGRkZGIi8+PC9nPjwvZz48L3N2Zz4=" alt="Twitter {{ setting('appshell.ui.name') }}" /></a>
                            </div>
                        @endif
                        @if (setting('ctic.footer.link.instagram_url'))
                            <div class="col-4">
                                <a href="{{ setting('ctic.footer.link.instagram_url') }}" target="_blank"><img width="32" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEwMjQgMTAyNCIgaGVpZ2h0PSIxMDI0cHgiIGlkPSJJbnN0YWdyYW1fMl8iIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgd2lkdGg9IjEwMjRweCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGcgaWQ9IkJhY2tncm91bmQiPjxsaW5lYXJHcmFkaWVudCBncmFkaWVudFRyYW5zZm9ybT0ibWF0cml4KDAuOTM5NyAwLjM0MjEgMC4zNDIxIC0wLjkzOTcgMjc2LjIwNDIgNzY1LjgyODQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgaWQ9ImJnXzFfIiB4MT0iNDYzLjk1MjYiIHgyPSItMTk0LjQ4MjkiIHkxPSItNzMuMTE0MyIgeTI9IjcxMS40NDc5Ij48c3RvcCBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiMyMDI1NEMiLz48c3RvcCBvZmZzZXQ9IjAuMDU3MSIgc3R5bGU9InN0b3AtY29sb3I6IzI5MjU0RCIvPjxzdG9wIG9mZnNldD0iMC4xNTAyIiBzdHlsZT0ic3RvcC1jb2xvcjojNDEyMzRGIi8+PHN0b3Agb2Zmc2V0PSIwLjI2NzkiIHN0eWxlPSJzdG9wLWNvbG9yOiM2OTIxNTIiLz48c3RvcCBvZmZzZXQ9IjAuNDAzOSIgc3R5bGU9InN0b3AtY29sb3I6I0EwMUY1NyIvPjxzdG9wIG9mZnNldD0iMC41MzMzIiBzdHlsZT0ic3RvcC1jb2xvcjojREExQzVDIi8+PHN0b3Agb2Zmc2V0PSIwLjU5MjQiIHN0eWxlPSJzdG9wLWNvbG9yOiNEQzI1NUEiLz48c3RvcCBvZmZzZXQ9IjAuNjg4OSIgc3R5bGU9InN0b3AtY29sb3I6I0UxM0Q1NiIvPjxzdG9wIG9mZnNldD0iMC44MTA2IiBzdHlsZT0ic3RvcC1jb2xvcjojRUE2NTRFIi8+PHN0b3Agb2Zmc2V0PSIwLjk1MTUiIHN0eWxlPSJzdG9wLWNvbG9yOiNGNjlDNDQiLz48c3RvcCBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiNGQkIwNDAiLz48L2xpbmVhckdyYWRpZW50PjxjaXJjbGUgY3g9IjUxMi4wMDEiIGN5PSI1MTIiIGZpbGw9InVybCgjYmdfMV8pIiBpZD0iYmciIHI9IjUxMiIvPjwvZz48ZyBpZD0iSW5zdGFncmFtXzNfIj48Y2lyY2xlIGN4PSI2NTguNzY1IiBjeT0iMzY0LjU2MyIgZmlsbD0iI0ZGRkZGRiIgcj0iMzMuMTM2Ii8+PGNpcmNsZSBjeD0iNTEyLjAwMSIgY3k9IjUxMiIgZmlsbD0ibm9uZSIgcj0iMTIxLjQxMiIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iNDUiLz48cGF0aCBkPSJNMjU1LjM1OCw2MTIuNTA2YzAsOTEuMTI3LDczLjg3NCwxNjUsMTY1LDE2NSAgIGgxODMuMjgzYzkxLjEyNywwLDE2NS03My44NzMsMTY1LTE2NVY0MTEuNDk1YzAtOTEuMTI3LTczLjg3My0xNjUtMTY1LTE2NUg0MjAuMzU4Yy05MS4xMjcsMC0xNjUsNzMuODczLTE2NSwxNjVWNjEyLjUwNnoiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0ZGRkZGRiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2Utd2lkdGg9IjQ1Ii8+PC9nPjwvc3ZnPg==" alt="Instagram {{ setting('appshell.ui.name') }}" /></a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center text-primary">
                        © {{ date('Y') }} {{ setting('appshell.ui.name') }}. {{ __('ctic_shop.all_rights_reserved') }}
                    </div>
                </div>
            </div>
        </footer>
        @include('cookieConsent::index')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="application/javascript">
        function showCart() {
            $('.cart-widget').css('display', 'block')
            if ($('.cart-widget').length) {
                $('main').css('width', '65%')
            }
        }
        function hideCart() {
            $('.cart-widget').css('display', 'none')
            $('main').css('width', '100%')
        }

        @if($showCart)
            showCart();
        @endif
    </script>
    @yield('scripts')
</body>
</html>
