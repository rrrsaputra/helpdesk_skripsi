@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create User" />
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert" style="opacity: 1; transition: opacity 0.5s;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('error-alert').style.opacity = '0';
            }, 4500); // Mengurangi 500ms untuk transisi lebih halus
            setTimeout(function() {
                document.getElementById('error-alert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.user_management.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama">
                </div>
                <div class="form-group">
                    <label for="username">NIM</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label for="study_program_id">Study Program</label>
                    <select name="study_program_id" class="form-control" id="study_program_id">
                        <option value="">Choose Study Program</option>
                        @foreach($studyPrograms as $studyProgram)
                            <option value="{{ $studyProgram->id }}">{{ $studyProgram->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" minlength="8">
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <small id="passwordLength" class="form-text text-danger" style="display: none;">Passwords must be at least 8 characters long.</small>
                </div>
                <script>
                    document.getElementById('password').addEventListener('input', function () {
                        const password = this.value;
                        const lengthWarning = document.getElementById('passwordLength');
                        if (password.length < 8) {
                            lengthWarning.style.display = 'block';
                        } else {
                            lengthWarning.style.display = 'none';
                        }
                    });
                </script>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi password">
                    <small id="passwordMismatch" class="form-text text-danger" style="display: none;">The password and confirmation password do not match.</small>
                </div>
                <script>
                    document.getElementById('togglePassword').addEventListener('click', function (e) {
                        const passwordField = document.getElementById('password');
                        const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', passwordFieldType);
                        this.querySelector('i').classList.toggle('fa-eye-slash');
                    });

                    document.getElementById('password_confirmation').addEventListener('input', function () {
                        const password = document.getElementById('password').value;
                        const passwordConfirmation = this.value;
                        const mismatchWarning = document.getElementById('passwordMismatch');
                        if (password !== passwordConfirmation) {
                            mismatchWarning.style.display = 'block';
                        } else {
                            mismatchWarning.style.display = 'none';
                        }
                    });

                    document.querySelector('form').addEventListener('submit', function (e) {
                        const password = document.getElementById('password').value;
                        const passwordConfirmation = document.getElementById('password_confirmation').value;
                        if (password !== passwordConfirmation) {
                            e.preventDefault();
                            document.getElementById('passwordMismatch').style.display = 'block';
                        }
                    });
                </script>
                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.user_management.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
