@extends('layouts.admin')

@section('title','Data Kerusakan')

@section('content')

<h3>
    Data Kerusakan {{ $laboratorium->nama_laboratorium }}
</h3>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peralatan</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

        @forelse($kerusakan as $item)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->peralatan->nama_peralatan }}</td>
            <td>{{ $item->kategori->nama_kategori }}</td>
            <td>{{ $item->tanggal_kerusakan }}</td>
            <td>{{ $item->status }}</td>
        </tr>

        @empty

        <tr>
            <td colspan="5">
                Belum ada data kerusakan.
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection