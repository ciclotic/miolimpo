<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('layouts._favicons')
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
                        <div class="col-md-2 col-5 background-grey-scale background-grey-scale-0 store-title mt-1">
                            <a href="{{ url('/') }}">
                                <img src="{{ setting('ctic.general.defaults.logo_url') }}" title="{{ config('app.name', 'Laravel') }}" />
                                {{ setting('appshell.ui.name') }}
                            </a>
                            <div class="input-group header-search" id="header-search-mobile">
                                <input type="text" class="form-control" aria-label="{{ __('ctic_shop.search') }}" id="header-search-mobile-input">
                            </div>
                        </div>
                        <div class="col-5 main-menu nav-item header-icon">
                            <a class="nav-link" href="#" onclick="(document.getElementById('header-search-mobile').style.display === 'block') ? document.getElementById('header-search-mobile').style.display = 'none' : document.getElementById('header-search-mobile').style.display = 'block'; document.getElementById('header-search-mobile-input').focus()">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                </svg>
                            </a>
                            @if(Cart::itemCount() > 0)
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
                                            <a href="{{ route('login') }}" class="col-6">{{ __('ctic_shop.login') }}</a>
                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="col-6">{{ __('ctic_shop.register') }}</a>
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
                            <div class="row">
                                <div class="col-md-5 input-group header-search">
                                    <input type="text" class="form-control" aria-label="{{ __('ctic_shop.search') }}">
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
                                    <a href="#">
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
                                    </a>
                                </div>
                                @if(Cart::itemCount() > 0)
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
                        </div>
                    </div>
                @endif
            </div>
        </nav>

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
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="application/javascript">
        function showCart() {
            $('.cart-widget').css('display', 'block')
            $('main').css('width', '65%')
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
