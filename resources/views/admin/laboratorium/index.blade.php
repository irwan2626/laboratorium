@extends('layouts.admin')

@section('title', 'Kelola Data Laboratorium')
@section('page_title', 'Kelola Data Laboratorium')
@section('page_subtitle', 'Data laboratorium yang terdaftar di sistem')

@section('content')

    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Laboratorium</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>
                @forelse($laboratorium as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>
                          <a href="{{ route('laboratorium.kerusakan', $data->id) }}" class="btn btn-outline">Kerusakan</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data laboratorium.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>

@endsection
