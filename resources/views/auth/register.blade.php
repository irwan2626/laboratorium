<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" required>
                <option value="">Pilih role</option>
                <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                <option value="asisten" @selected(old('role') === 'asisten')>Asisten Laboratorium</option>
                <option value="kepala_lab" @selected(old('role') === 'kepala_lab')>Kepala Laboratorium</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div id="lokasi-lab-wrapper" style="display: none;">
            <x-input-label for="lokasi_lab" value="Lokasi Laboratorium" />
            <select id="lokasi_lab" name="lokasi_lab">
                <option value="">Pilih lokasi laboratorium</option>
                @foreach($lokasiLab as $lokasi)
                    <option value="{{ $lokasi }}" @selected(old('lokasi_lab') === $lokasi)>
                        {{ $lokasi }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('lokasi_lab')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />

            <x-text-input id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="login-actions">
            <a class="login-link" href="{{ route('login') }}">
                Sudah terdaftar?
            </a>

            <button class="login-button" type="submit">
                Daftar
            </button>
        </div>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const lokasiWrapper = document.getElementById('lokasi-lab-wrapper');
        const lokasiSelect = document.getElementById('lokasi_lab');

        function toggleLokasiLab() {
            const isAsisten = roleSelect.value === 'asisten';

            lokasiWrapper.style.display = isAsisten ? 'grid' : 'none';
            lokasiSelect.required = isAsisten;

            if (! isAsisten) {
                lokasiSelect.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleLokasiLab);
        toggleLokasiLab();
    </script>
</x-guest-layout>
