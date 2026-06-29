<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="password-field mt-2">
                <x-text-input id="password" class="block w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <button
                    class="password-toggle"
                    type="button"
                    data-password-toggle="password"
                    aria-label="Tampilkan password"
                    aria-pressed="false">
                    <span class="password-eye" aria-hidden="true">👁</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="login-actions">
            @if (Route::has('password.request'))
                <a class="login-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button class="login-button" type="submit">
                {{ __('Log in') }}
            </button>
        </div>

        <button id="install-app-button" class="install-button" type="button">
            Install Aplikasi Android
        </button>

        <p id="install-app-hint" class="install-hint">
            Tombol ini muncul di Android jika browser mendukung instal aplikasi.
        </p>
    </form>
</x-guest-layout>
