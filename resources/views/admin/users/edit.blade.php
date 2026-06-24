@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_subtitle', 'Perbarui data akun pengguna sistem')

@section('content')
    <section class="panel">
        <form class="form-grid" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" value="{{ old('password') }}" autocomplete="new-password">
            </div>

            <div>
                <label>Role</label>
                <select id="role" name="role" required>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    <option value="asisten" @selected(old('role', $user->role) === 'asisten')>Asisten Laboratorium</option>
                    <option value="kepala_lab" @selected(old('role', $user->role) === 'kepala_lab')>Kepala Laboratorium</option>
                </select>
            </div>

            <div id="lokasi-lab-wrapper" style="display: none;">
                <label>Lokasi Laboratorium</label>
                <select id="lokasi_lab" name="lokasi_lab">
                    <option value="">Pilih lokasi laboratorium</option>
                    @foreach($lokasiLab as $lokasi)
                        <option value="{{ $lokasi }}" @selected(old('lokasi_lab', $user->lokasi_lab) === $lokasi)>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="action-row">
                <button class="btn btn-gold" type="submit">
                    Simpan Perubahan
                </button>

                <a class="btn" href="{{ route('users.index') }}">
                    Batal
                </a>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        const roleSelect = document.getElementById('role');
        const lokasiWrapper = document.getElementById('lokasi-lab-wrapper');
        const lokasiSelect = document.getElementById('lokasi_lab');

        function toggleLokasiLab() {
            const isAsisten = roleSelect.value === 'asisten';
            lokasiWrapper.style.display = isAsisten ? 'block' : 'none';
            lokasiSelect.required = isAsisten;

            if (! isAsisten) {
                lokasiSelect.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleLokasiLab);
        toggleLokasiLab();
    </script>
@endpush
