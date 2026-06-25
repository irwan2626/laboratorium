@extends('layouts.admin')

@section('title', 'Kelola Data User')
@section('page_title', 'Kelola Data User')
@section('page_subtitle', 'Daftar akun dan role pengguna sistem')

@section('content')
    @php
        $totalUsers = $users->count();
        $totalAdmin = $users->where('role', 'admin')->count();
        $totalAsisten = $users->where('role', 'asisten')->count();
        $totalKepalaLab = $users->where('role', 'kepala_lab')->count();
    @endphp

    <section class="dashboard-hero">
        <div class="hero-card">
            <span class="hero-eyebrow">Kelola Data User</span>
            <h2 class="hero-title">Atur akses akun sistem dengan tampilan yang lebih ringkas</h2>
            <p class="hero-text">
                Pantau jumlah akun, role pengguna, dan kelola data user dari satu halaman yang lebih nyaman di desktop maupun mobile.
            </p>

            <div class="hero-metrics">
                <div class="hero-metric">
                    <span>Total User</span>
                    <strong>{{ $totalUsers }}</strong>
                </div>

                <div class="hero-metric">
                    <span>Admin</span>
                    <strong>{{ $totalAdmin }}</strong>
                </div>

                <div class="hero-metric">
                    <span>Asisten</span>
                    <strong>{{ $totalAsisten }}</strong>
                </div>
            </div>
        </div>

        <div class="hero-side">
            <div class="quick-actions">
                <h3>Aksi Cepat</h3>

                <div class="quick-grid">
                    <a class="quick-card" href="{{ route('users.create') }}">
                        <span class="quick-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 5v14"></path>
                                <path d="M5 12h14"></path>
                            </svg>
                        </span>
                        <strong>Tambah User</strong>
                        <span>Buat akun baru untuk admin atau asisten.</span>
                    </a>

                    <a class="quick-card" href="{{ route('admin.laboratorium.index') }}">
                        <span class="quick-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 7h16"></path>
                                <path d="M6 7v12h12V7"></path>
                                <path d="M9 11h6"></path>
                            </svg>
                        </span>
                        <strong>Data Laboratorium</strong>
                        <span>Lihat dan kelola data laboratorium terkait user.</span>
                    </a>

                    <a class="quick-card" href="{{ route('admin.dashboard') }}">
                        <span class="quick-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 10.5 12 4l8 6.5"></path>
                                <path d="M6.5 9.5V20h11V9.5"></path>
                            </svg>
                        </span>
                        <strong>Kembali ke Dashboard</strong>
                        <span>Pindah cepat ke ringkasan admin utama.</span>
                    </a>
                </div>
            </div>

            <div class="stat-card status-light">
                <p>Kepala Laboratorium</p>
                <strong>{{ $totalKepalaLab }}</strong>
                <span class="stat-meta">Akun pengawas aktif</span>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="action-row">
            <a href="{{ route('users.create') }}" class="btn btn-gold">
                Tambah User
            </a>
        </div>

        @if(session('status'))
            <div class="alert success-alert">
                {{ session('status') }}
            </div>
        @endif

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
                            <div class="action-row">
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
