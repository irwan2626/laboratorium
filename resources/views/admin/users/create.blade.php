@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')
@section('page_subtitle', 'Buat akun baru untuk admin, asisten, atau kepala laboratorium')

@section('content')
    <section class="panel user-form-panel">
        <div class="user-form-header">
            <div>
                <span class="eyebrow">Form Akun Baru</span>
                <h3>Buat user baru dengan akses yang sesuai</h3>
                <p>Isi data akun, tentukan role, lalu simpan untuk menambahkan user ke sistem.</p>
            </div>
            <a class="btn btn-outline" href="{{ route('users.index') }}">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="alert error-alert">
                <strong>Periksa kembali isian berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-grid user-form-grid" action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="field-card">
                <label for="name">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama user" required>
                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field-card">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@domain.com" required>
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field-card">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                @error('password')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field-card">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    <option value="asisten" @selected(old('role') === 'asisten')>Asisten Laboratorium</option>
                    <option value="kepala_lab" @selected(old('role') === 'kepala_lab')>Kepala Laboratorium</option>
                </select>
                @error('role')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div id="lokasi-lab-wrapper" class="field-card field-span-2" style="display: none;">
                <label for="lokasi_lab">Lokasi Laboratorium</label>
                <select id="lokasi_lab" name="lokasi_lab">
                    <option value="">Pilih lokasi laboratorium</option>
                    @foreach($lokasiLab as $lokasi)
                        <option value="{{ $lokasi }}" @selected(old('lokasi_lab') === $lokasi)>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
                <small class="field-hint">Wajib diisi jika role yang dipilih adalah Asisten Laboratorium.</small>
                @error('lokasi_lab')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="action-row user-form-actions field-span-2">
                <button class="btn btn-gold" type="submit">
                    Simpan User
                </button>

                <a class="btn btn-outline" href="{{ route('users.index') }}">
                    Batal
                </a>
            </div>
        </form>
    </section>
@endsection

@push('styles')
    <style>
        .user-form-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .user-form-header h3 {
            margin: 0;
            color: var(--on-surface);
            font-size: 20px;
            line-height: 28px;
        }

        .user-form-header p {
            margin: 6px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .user-form-grid {
            max-width: 920px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field-card {
            display: grid;
            gap: 6px;
        }

        .field-span-2 {
            grid-column: span 2;
        }

        .field-hint {
            color: var(--on-surface-variant);
            font-size: 12px;
            line-height: 16px;
        }

        .field-error {
            color: var(--error);
            font-size: 12px;
            line-height: 16px;
        }

        .error-alert ul {
            margin: 8px 0 0;
            padding-left: 18px;
        }

        .user-form-actions {
            margin-top: 4px;
        }

        @media (max-width: 820px) {
            .user-form-header {
                flex-direction: column;
            }

            .user-form-grid {
                grid-template-columns: 1fr;
            }

            .field-span-2 {
                grid-column: auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        const roleSelect = document.getElementById('role');
        const lokasiWrapper = document.getElementById('lokasi-lab-wrapper');
        const lokasiSelect = document.getElementById('lokasi_lab');

        function toggleLokasiLab() {
            const isAsisten = roleSelect.value === 'asisten';
            lokasiWrapper.style.display = isAsisten ? 'block' : 'none';
            lokasiSelect.required = isAsisten;

            if (! isAsisten && lokasiSelect.value) {
                lokasiSelect.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleLokasiLab);
        toggleLokasiLab();
    </script>
@endpush
