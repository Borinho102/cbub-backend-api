<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Cbub') }}</title>

        <!--Google font-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <link href="{{ mix('build/cbub-frontend.css') }}" rel="stylesheet">
        {{-- <link href="{{ mix('build/tailwind.css') }}" rel="stylesheet"> --}}
        <script type="text/javascript" src="{{ mix('build/cbub-frontend.js') }}" defer></script>
    </head>
    <body class="theme-color-1">
        <!-- header start -->
        @include('layouts.frontend.partials.header')
        <!-- header end -->

        <section>
            {{ $slot }}
        </section>

        <!-- footer -->
        @include('layouts.frontend.partials.footer')
        <!-- footer end -->

        <!-- cookie bar start -->
        @include('layouts.frontend.partials.cookie')
        <!-- cookie bar end -->

        <!-- cart start -->
        <div class="addcart_btm_popup" id="fixed_cart_icon">
            <a href="#" class="fixed_cart">
                <i class="ti-shopping-cart"></i>
            </a>
        </div>
        <!-- cart end -->

        <!-- theme setting -->
        @include('layouts.frontend.partials.theme-setting')
        <!-- theme setting -->

        <!-- tap to top -->
        <div class="tap-top top-cls">
            <div>
                <i class="fa fa-angle-double-up"></i>
            </div>
        </div>
        <!-- tap to top end -->

        <script>
            $(window).on('load', function () {
                setTimeout(function () {
                    $('#exampleModal').modal('show');
                }, 2500);
            });

            function openSearch() {
                document.getElementById("search-overlay").style.display = "block";
            }

            function closeSearch() {
                document.getElementById("search-overlay").style.display = "none";
            }
        </script>
    </body>
</html>
