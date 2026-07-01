@extends('layouts.asisten')

@section('content')

    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Kerusakan</p>
            <strong>{{ $total }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Semua laporan</span>
        </div>

        <div class="stat-card">
            <p>Total Alat Digunakan</p>
            <strong>{{ $totalAlatDigunakan }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Kondisi aktif</span>
        </div>

        <div class="stat-card status-light">
            <p>Kerusakan Ringan</p>
            <strong>{{ $totalPerJenis['Ringan'] }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Perlu pemeliharaan</span>
        </div>

        <div class="stat-card status-medium">
            <p>Kerusakan Sedang</p>
            <strong>{{ $totalPerJenis['Sedang'] }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Butuh penanganan</span>
        </div>

        <div class="stat-card status-heavy">
            <p>Kerusakan Berat</p>
            <strong>{{ $totalPerJenis['Berat'] }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Prioritas tinggi</span>
        </div>

        <div class="stat-card status-critical">
            <p>Tidak Bisa Digunakan</p>
            <strong>{{ $totalPerJenis['Tidak Bisa Digunakan'] }}</strong>
            <span class="stat-meta"><span class="stat-dot"></span> Peralatan kritis</span>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <span class="eyebrow">Laporan Terakhir</span>
                <h3>Kerusakan Terbaru</h3>
            </div>
            <a href="/data-kerusakan" class="btn">Lihat Data</a>
        </div>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>

                @forelse($kerusakanTerbaru as $data)
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
                        <td>{{ $data->peralatan->kode_barang }}</td>
                        <td>{{ $data->peralatan->nama_barang }}</td>
                        <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                        <td><span class="status-pill">{{ $data->status }}</span></td>
                        <td>{{ $data->tanggal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">Belum ada data kerusakan.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
