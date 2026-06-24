@extends('layouts.admin')

@section('title', 'Kelola Kategori Kerusakan')
@section('page_title', 'Kelola Kategori Kerusakan')
@section('page_subtitle', 'Kategori kerusakan yang digunakan dalam pelaporan')

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>ID Kategori</th>
                    <th>Dibuat</th>
                </tr>

                @forelse($kategoriKerusakan as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data kategori kerusakan.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>
@endsection
