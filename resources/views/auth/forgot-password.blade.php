<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Masukkan email akun dan password baru yang ingin digunakan.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password Baru')" />
            <div class="password-field mt-1">
                <x-text-input id="password" class="block w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
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

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <div class="password-field mt-1">
                <x-text-input id="password_confirmation" class="block w-full"
                                type="password"
                                name="password_confirmation"
                                required autocomplete="new-password" />
                <button
                    class="password-toggle"
                    type="button"
                    data-password-toggle="password_confirmation"
                    aria-label="Tampilkan konfirmasi password"
                    aria-pressed="false">
                    <span class="password-eye" aria-hidden="true">👁</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="login-actions">
            <a class="login-link" href="{{ route('login') }}">
                Kembali ke login
            </a>

            <button class="login-button" type="submit">
                Simpan Password Baru
            </button>
        </div>
    </form>
</x-guest-layout>
