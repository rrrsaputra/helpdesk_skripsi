<section>
    <header>
        <h2 class="h6 mb-6">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">{{ __('Kata Sandi Saat Ini') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control mt-1 block w-full" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <span class="text-danger mt-2">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label">{{ __('Kata Sandi Baru') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control mt-1 block w-full"
                autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <span class="text-danger mt-2">{{ $errors->updatePassword->first('password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation"
                class="form-label">{{ __('Konfirmasi Kata Sandi') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control mt-1 block w-full" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <span class="text-danger mt-2">{{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="form-group flex items-center gap-4">
            <button type="submit" class="btn btn-primary"
                style="background-color: #F38F2F; border-color: #F38F2F;">{{ __('Simpan') }}</button>
        </div>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
        @endif
        </div>
    </form>
</section>
