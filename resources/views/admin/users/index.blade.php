@extends('layouts.admin')

@section('title', 'Kelola Data User')
@section('page_title', 'Kelola Data User')
@section('page_subtitle', 'Daftar akun dan role pengguna sistem')

@section('content')
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
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->lokasi_lab ?? '-' }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn">
                                Edit
                            </a>

                            <form class="inline-form" action="{{ route('users.password-reset', $user) }}" method="POST">
                                @csrf

                                <button class="btn" type="submit">
                                    Lupa Password
                                </button>
                            </form>

                            <form class="inline-form" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="danger-button" type="submit">
                                    Hapus
                                </button>
                            </form>
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
