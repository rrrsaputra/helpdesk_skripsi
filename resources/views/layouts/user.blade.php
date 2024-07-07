<!DOCTYPE html>
<!--
    Name: AmDesk - Help Center HTML template for your digital products
    Version: 1.1.0
    Author: dexad, nK
    Website: https://nkdev.info/
    Purchase: https://1.envato.market/amdesk-html-info
    Support: https://nk.ticksy.com/
    License: You must have a valid license purchased only from ThemeForest (the above link) in order to legally use the theme for your project.
    Copyright 2020.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Earthqualizer Helpdesk</title>
    <meta name="description" content="Amdesk - Help Center HTML template for your digital products">
    <meta name="keywords" content="helpdesk, forum, template, HTML template, responsive, clean">
    <meta name="author" content="nK">
    <link rel="icon" type="image/png" href="{{ asset('image/earthqualizer_logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- START: Styles -->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700%7cMaven+Pro:400,500,700"
        rel="stylesheet"><!-- %7c -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('amdesk/dist/assets/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Fancybox -->
    <link rel="stylesheet" href="{{ asset('amdesk/dist/assets/vendor/fancybox/dist/jquery.fancybox.min.css') }}">
    <!-- Pe icon 7 stroke -->
    <link rel="stylesheet"
        href="{{ asset('amdesk/dist/assets/vendor/pixeden-stroke-7-icon/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css') }}">
    <!-- Swiper -->
    <link rel="stylesheet" type="text/css" href="{{ asset('amdesk/dist/assets/vendor/swiper/swiper-bundle.min.css') }}">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('amdesk/dist/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <!-- Dropzone -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('amdesk/dist/assets/vendor/dropzone/dist/min/dropzone.min.css') }}">
    <!-- Quill -->
    <link rel="stylesheet" type="text/css" href="{{ asset('amdesk/dist/assets/vendor/quill/dist/quill.snow.css') }}">
    <!-- Font Awesome -->
    <script defer src="{{ asset('amdesk/dist/assets/vendor/fontawesome-free/js/all.js') }}"></script>
    <script defer src="{{ asset('amdesk/dist/assets/vendor/fontawesome-free/js/v4-shims.js') }}"></script>
    <!-- Amdesk -->
    <link rel="stylesheet" href="{{ asset('amdesk/dist/assets/css/amdesk.css') }}">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('amdesk/dist/assets/css/custom.css') }}">
    <!-- END: Styles -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('amdesk/dist/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
</head>


<body>


    <!--
    START: Navbar

    Additional Classes:
        .dx-navbar-sticky || .dx-navbar-fixed
        .dx-navbar-autohide
        .dx-navbar-dropdown-triangle
        .dx-navbar-dropdown-dark - only <ul>
        .dx-navbar-expand || .dx-navbar-expand-lg || .dx-navbar-expand-xl
-->
    <x-user.navbar />

    @if (Route::currentRouteName() !== 'user.ticket.show')
        <x-user.header />
    @endif


    @yield('content')
    @if (Route::currentRouteName() !== 'user.ticket.show')
        <x-user.footer />
    @endif


    <!-- START: Scripts -->
    <!-- Object Fit Images -->
    <script src="{{ asset('amdesk/dist/assets/vendor/object-fit-images/dist/ofi.min.js') }}"></script>
    <!-- Popper -->
    <script src="{{ asset('amdesk/dist/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('amdesk/dist/assets/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Fancybox -->
    <script src="{{ asset('amdesk/dist/assets/vendor/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <!-- Cleave -->
    <script src="{{ asset('amdesk/dist/assets/vendor/cleave.js/dist/cleave.min.js') }}"></script>
    <!-- Validator -->
    <script src="{{ asset('amdesk/dist/assets/vendor/validator/validator.min.js') }}"></script>
    <!-- Sticky Kit -->
    <script src="{{ asset('amdesk/dist/assets/vendor/sticky-kit/dist/sticky-kit.min.js') }}"></script>
    <!-- Jarallax -->
    <script src="{{ asset('amdesk/dist/assets/vendor/jarallax/dist/jarallax.min.js') }}"></script>
    <script src="{{ asset('amdesk/dist/assets/vendor/jarallax/dist/jarallax-video.min.js') }}"></script>
    <!-- Isotope -->
    <script src="{{ asset('amdesk/dist/assets/vendor/isotope-layout/dist/isotope.pkgd.min.js') }}"></script>
    <!-- ImagesLoaded -->
    <script src="{{ asset('amdesk/dist/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Swiper -->
    <script src="{{ asset('amdesk/dist/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Gist Embed -->
    <script src="{{ asset('amdesk/dist/assets/vendor/gist-embed/dist/gist-embed.min.js') }}"></script>
    <!-- Bootstrap Select -->
    <script src="{{ asset('amdesk/dist/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <!-- Dropzone -->
    <script src="{{ asset('amdesk/dist/assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
    <!-- Quill -->
    <script src="{{ asset('amdesk/dist/assets/vendor/quill/dist/quill.min.js') }}"></script>
    <!-- The Amdesk -->
    <script src="{{ asset('amdesk/dist/assets/js/amdesk.min.js') }}"></script>
    <script src="{{ asset('amdesk/dist/assets/js/amdesk-init.js') }}"></script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/666821e1981b6c56477be19e/1i03c8mov';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    @stack('js')


    <!--End of Tawk.to Script-->
    <!-- END: Scripts -->
</body>

</html>
