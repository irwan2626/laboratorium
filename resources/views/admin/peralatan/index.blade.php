@extends('layouts.admin')

@section('title', 'Kelola Data Peralatan')
@section('page_title', 'Kelola Data Peralatan')
@section('page_subtitle', 'Daftar peralatan dan kondisi barang laboratorium')

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kondisi</th>
                </tr>

                @forelse($peralatan as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->kode_barang }}</td>
                        <td>{{ $data->nama_barang }}</td>
                        <td>{{ $data->kondisi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data peralatan.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>
@endsection
