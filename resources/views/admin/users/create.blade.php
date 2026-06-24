@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')
@section('page_subtitle', 'Buat akun baru untuk admin, asisten, atau kepala laboratorium')

@section('content')
    <section class="panel">
        <form class="form-grid" action="{{ route('users.store') }}" method="POST">
            @csrf

            <div>
                <label>Nama</label>
                <input type="text" name="name" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label>Role</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="asisten">Asisten Laboratorium</option>
                    <option value="kepala_lab">Kepala Laboratorium</option>
                </select>
            </div>

            <div id="lokasi-lab-wrapper" style="display: none;">
                <label>Lokasi Laboratorium</label>
                <select id="lokasi_lab" name="lokasi_lab">
                    <option value="">Pilih lokasi laboratorium</option>
                    @foreach($lokasiLab as $lokasi)
                        <option value="{{ $lokasi }}" @selected(old('lokasi_lab') === $lokasi)>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="action-row">
                <button class="btn btn-gold" type="submit">
                    Simpan
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
