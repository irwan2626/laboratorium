@extends('layouts.admin')

@section('title', 'Kelola Data User')
@section('page_title', 'Kelola Data User')
@section('page_subtitle', 'Daftar akun dan role pengguna sistem')

@section('content')
    <section class="panel">
        <div class="action-row">
            <button id="toggle-user-form" type="button" class="btn btn-gold">
                Tambah User
            </button>
        </div>

        @if(session('status'))
            <div class="alert success-alert">
                {{ session('status') }}
            </div>
        @endif

        <div id="user-create-form" class="user-create-form {{ $errors->any() ? 'active' : '' }}">
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
                </div>

                <div class="field-card">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@domain.com" required>
                </div>

                <div class="field-card">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                </div>

                <div class="field-card">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        <option value="asisten" @selected(old('role') === 'asisten')>Asisten Laboratorium</option>
                        <option value="kepala_lab" @selected(old('role') === 'kepala_lab')>Kepala Laboratorium</option>
                    </select>
                </div>

                <div id="lokasi-lab-wrapper" class="field-card field-span-2">
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
                </div>

                <div class="action-row user-form-actions field-span-2">
                    <button class="btn btn-gold" type="submit">
                        Simpan User
                    </button>

                    <button id="cancel-user-form" class="btn btn-outline" type="button">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Lokasi Lab</th>
                    <th>Aksi</th>
                </tr>

                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="status-pill">{{ $user->role }}</span></td>
                        <td>{{ $user->lokasi_lab ?? '-' }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline">
                                    Edit
                                </a>

                                <form class="inline-form" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="danger-button" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data user.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .user-create-form {
            display: none;
            margin-bottom: 20px;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            padding: 18px;
            background: var(--surface-container-lowest);
        }

        .user-create-form.active {
            display: block;
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

        .error-alert ul {
            margin: 8px 0 0;
            padding-left: 18px;
        }

        @media (max-width: 820px) {
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
        const userForm = document.getElementById('user-create-form');
        const toggleUserForm = document.getElementById('toggle-user-form');
        const cancelUserForm = document.getElementById('cancel-user-form');
        const roleSelect = document.getElementById('role');
        const lokasiWrapper = document.getElementById('lokasi-lab-wrapper');
        const lokasiSelect = document.getElementById('lokasi_lab');

        function toggleLokasiLab() {
            const isAsisten = roleSelect.value === 'asisten';
            lokasiWrapper.style.display = isAsisten ? 'grid' : 'none';
            lokasiSelect.required = isAsisten;

            if (! isAsisten && lokasiSelect.value) {
                lokasiSelect.value = '';
            }
        }

        toggleUserForm.addEventListener('click', function () {
            userForm.classList.add('active');
        });

        cancelUserForm.addEventListener('click', function () {
            userForm.classList.remove('active');
        });

        roleSelect.addEventListener('change', toggleLokasiLab);
        toggleLokasiLab();
    </script>
@endpush
