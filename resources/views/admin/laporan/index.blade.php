@extends('layouts.admin')

@section('title', 'Lihat Laporan')
@section('page_title', 'Lihat Laporan')
@section('page_subtitle', 'Laporan kerusakan yang masuk dari asisten laboratorium')

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>

                @forelse($kerusakan as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($data->foto)
                                <img
                                    class="table-preview"
                                    src="{{ asset('uploads/' . basename($data->foto)) }}"
                                    alt="Foto kerusakan">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td>{{ $data->peralatan->kode_barang }}</td>
                        <td>{{ $data->peralatan->nama_barang }}</td>
                        <td>{{ $data->jenis_kerusakan }}</td>
                        <td>{{ $data->deskripsi }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->tanggal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Belum ada laporan kerusakan.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </section>
@endsection
