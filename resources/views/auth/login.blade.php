@extends('layouts.login')

@section('title', 'Helpdesk BAA Login')

@section('content')

    <!-- Contoh style inline khusus untuk halaman login ini -->
    <style>
        /* Agar box login turun sedikit dari atas */
        .login-box {
            margin-top: 40px;
        }

        /* Logo */
        .login-logo img {
            width: 220px;
            margin-bottom: 1rem;
        }

        /* Card dan isinya */
        .card {
            border: none;
            /* Hilangkan border bawaan */
            border-radius: 10px;
            /* Sudut membulat */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            /* Bayangan lembut */
        }

        .login-card-body {
            border-radius: 10px;
            /* Samakan radius dengan card */
            padding: 2rem;
            /* Tambah jarak isi card */
        }

        .login-card-body .btn-primary {
            border-radius: 5px;
            /* Tombol lebih membulat */
        }
    </style>

    <div class="login-box mx-auto" style="width: 100%; max-width: 400px;">
        <!-- Logo / Judul Aplikasi -->
        <div class="login-logo text-center mb-4">
            <a href="{{ route('home') }}" class="d-flex justify-content-center">
                <img src="{{ asset('image/logounggul.png') }}" alt="Logo Universitas Bakrie" class="mb-2" style="width: 300px;">
            </a>
        </div>

        <!-- Card untuk form login -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Selamat Datang!</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus placeholder="Email" style="border-color: #85171A;">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #85171A; color: white;">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Password" style="border-color: #85171A;">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #85171A; color: white;">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn" style="background-color: #85171A; color: white;">
                                Sign In
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Link tambahan -->
                @if (Route::has('password.request'))
                    <p class="mt-3">
                        <a href="{{ route('password.request') }}">I forgot my password</a>
                    </p>
                @endif

                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">
                        Register a new account
                    </a>
                </p>
            </div>
        </div>
    </div>

@endsection
