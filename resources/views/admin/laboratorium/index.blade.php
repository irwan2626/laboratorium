@extends('layouts.admin')

@section('title', 'Kelola Data Laboratorium')
@section('page_title', 'Kelola Data Laboratorium')
@section('page_subtitle', 'Data kerusakan per masing-masing laboratorium')

@section('content')
    @foreach($lokasiLaboratorium as $laboratorium)
        @php
            $dataKerusakan = $kerusakanPerLaboratorium->get($laboratorium, collect());
        @endphp

        <section class="panel lab-panel">
            <div class="lab-panel-header">
                <div>
                    <span class="eyebrow">Laboratorium</span>
                    <h3>{{ $laboratorium }}</h3>
                </div>
                <span class="status-pill">{{ $dataKerusakan->count() }} Data Kerusakan</span>
            </div>

            <div class="table-wrap lab-table">
                <table>
                    <thead>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataKerusakan as $data)
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
                                <td>{{ $data->peralatan->kode_barang ?? '-' }}</td>
                                <td>{{ $data->peralatan->nama_barang ?? '-' }}</td>
                                <td>{{ $data->peralatan->kondisi ?? '-' }}</td>
                                <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                                <td>{{ $data->deskripsi ?: '-' }}</td>
                                <td>
                                    @if($data->foto)
                                        <img
                                            class="table-preview"
                                            src="{{ Storage::disk('public')->url($data->foto) }}"
                                            alt="Foto kerusakan">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td><span class="status-pill">{{ $data->status }}</span></td>
                                <td>{{ $data->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">Belum ada data kerusakan untuk laboratorium ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach
@endsection
