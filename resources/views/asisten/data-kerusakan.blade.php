@extends('layouts.asisten')



@section('content')
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="action-row">
            <a href="/scan" class="btn btn-gold">Scan QR Kerusakan</a>
        </div>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kondisi Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>

                @forelse($kerusakan as $data)
                    @php
                        $statusClass = match ($data->jenis_kerusakan) {
                            'Ringan' => 'light',
                            'Sedang' => 'medium',
                            'Berat' => 'heavy',
                            'Tidak Bisa Digunakan' => 'critical',
                            default => '',
                        };
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->peralatan->kode_barang }}</td>
                        <td>{{ $data->peralatan->nama_barang }}</td>
                        <td>{{ $data->peralatan->kondisi }}</td>
                        <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                        <td>{{ $data->deskripsi }}</td>
                        <td>
                            @if($data->foto)
                                <img
                                class="preview"
                                src="{{ asset('uploads/' . $data->foto) }}"
                                alt="Foto kerusakan">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td><span class="status-pill">{{ $data->status }}</span></td>
                        <td>{{ $data->tanggal }}</td>
                        <td>
                            <div class="table-actions">
                                <a class="btn btn-outline" href="/kerusakan/{{ $data->id }}/edit">Edit</a>
                                <form
                                    class="inline-form"
                                    action="/kerusakan/{{ $data->id }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus data kerusakan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">Belum ada data kerusakan.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
