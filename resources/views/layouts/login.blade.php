<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Earthqualizer')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/earthqualizer_logo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="hold-transition login-page text-gray-900 antialiased" style="background-image: url({{ asset('image/background4.jpg') }}); background-size: cover; background-color: rgba(27, 27, 27, .8); font-family: 'Nunito Sans', sans-serif;">    
    <div class="login-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('image/logounggul.png')}}" alt="EQ Logo" width="300px" class="mt-3 mx-auto d-block mb-4">
        </a>
    </div>
    <!-- /.login-logo -->
    @yield('content')
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
