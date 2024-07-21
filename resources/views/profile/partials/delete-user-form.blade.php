<section>
    <header>
        <h2 class="h6 mb-6">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
        @csrf
        @method('delete')

        <div class="form-group">
            <label for="password" class="form-label mb-2">{{ __('Password') }}</label>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>
            <input id="password" name="password" type="password" class="form-control mt-1 block w-full"
                placeholder="{{ __('Password') }}">
            @if ($errors->userDeletion->has('password'))
                <span class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</span>
            @endif
        </div>

        <div class="form-group flex items-center gap-4">
            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            {{-- <button type="button" class="btn btn-secondary"
                x-on:click="$dispatch('close')">{{ __('Cancel') }}</button> --}}
        </div>
    </form>
</section>
