<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Helpdesk BAA')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/ubakrie.png') }}">

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

    <!-- Style tambahan -->
    <style>
        /* 1) Pastikan html, body 100% tinggi & tidak ada margin/padding */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            /* Jika benar-benar tidak ingin scroll, aktifkan baris di bawah */
            overflow: hidden;
            font-family: 'Nunito Sans', sans-serif;
        }

        /* 2) .container-fluid dengan vh-100 sudah bagus,
              tapi kita pastikan tingginya penuh juga */
        .container-fluid {
            height: 100%;
        }

        /* 3) Kolom kiri dibuat relative agar .overlay bisa absolute */
        .left-side {
            position: relative;
            background: url('{{ asset('image/background4.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 100%;
        }

        /* 4) .overlay menempel penuh di parent (left-side) */
        .overlay {
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* 5) Teks di atas overlay. 
              Jika mau di tengah vertical, gunakan align-items-center 
              atau transform: translate(-50%, -50%) dll. */
        .overlay-text {
            /* Contoh menempatkan teks di tengah secara vertikal */
            position: absolute;
            top: 50%;
            left: 10%; /* jarak dari kiri agar tidak menempel */
            transform: translateY(-50%);
            color: #fff;
        }

        .overlay-text h1 {
            font-weight: 700;
            font-size: 2rem;
        }

        .overlay-text h4 {
            font-size: 1.3rem;
        }

        .overlay-text p {
            font-size: 1.1rem;
            margin-top: 1rem;
        }
    </style>
</head>

<body class="text-gray-900 antialiased">
    <div class="container-fluid h-100 p-0 m-0">
        <div class="row g-0 h-100">
            <!-- Bagian kiri: Banner dan teks -->
            <div class="col-md-9 d-none d-md-block left-side">
                <div class="overlay">
                    <div class="overlay-text">
                        <h1>Welcome to Biro Administrasi Akademik Helpdesk</h1>
                        <h4>Competent, Assurance, Responsive, Empathy</h4>
                        <p>Academic Year 2024/2025<br>
                            Have a question or concern? We’re here to help you succeed.</p>
                    </div>
                </div>
            </div>

            <!-- Bagian kanan: Form Login -->
            <div class="col-md-3 d-flex align-items-center justify-content-center bg-white">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
