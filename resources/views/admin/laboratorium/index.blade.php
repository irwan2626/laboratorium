@extends('layouts.admin')

@section('title', 'Kelola Data Laboratorium')
@section('page_title', 'Kelola Data Laboratorium')
@section('page_subtitle', 'Data laboratorium yang terdaftar di sistem')

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>ID Laboratorium</th>
                    <th>Dibuat</th>
                </tr>

                @forelse($laboratorium as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data laboratorium.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>
@endsection
