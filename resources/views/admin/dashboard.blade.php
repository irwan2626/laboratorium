@extends('layouts.admin')

@php
    $grafikMaksimal = max($grafikKerusakan) > 0 ? max($grafikKerusakan) : 1;
@endphp

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Utama')

@section('content')

    <section class="stats-grid">
        <div class="stat-card">
            <p>Total Laboratorium</p>
            <strong>{{ $totalLaboratorium }}</strong>
            <span class="stat-meta">Unit labor terdaftar</span>
        </div>

        <div class="stat-card">
            <p>Total Peralatan</p>
            <strong>{{ $totalPeralatan }}</strong>
            <span class="stat-meta">Inventaris tercatat</span>
        </div>

        <div class="stat-card">
            <p>Total Kerusakan</p>
            <strong>{{ $totalKerusakan }}</strong>
            <span class="stat-meta">Semua laporan</span>
        </div>

        <div class="stat-card status-light">
            <p>Kerusakan Ringan</p>
            <strong>{{ $grafikKerusakan['Ringan'] }}</strong>
            <span class="stat-meta">Pemeliharaan ringan</span>
        </div>

        <div class="stat-card status-medium">
            <p>Kerusakan Sedang</p>
            <strong>{{ $grafikKerusakan['Sedang'] }}</strong>
            <span class="stat-meta">Butuh penanganan</span>
        </div>

        <div class="stat-card status-heavy">
            <p>Kerusakan Berat</p>
            <strong>{{ $grafikKerusakan['Berat'] }}</strong>
            <span class="stat-meta">Prioritas tinggi</span>
        </div>

        <div class="stat-card status-critical">
            <p>Tidak Bisa Digunakan</p>
            <strong>{{ $grafikKerusakan['Tidak Bisa Digunakan'] }}</strong>
            <span class="stat-meta">Kondisi kritis</span>
        </div>
    </section>

    <section class="panel">
        <h3>Grafik Kerusakan</h3>

        @foreach($grafikKerusakan as $jenis => $jumlah)
            @php
                $statusClass = match ($jenis) {
                    'Ringan' => 'light',
                    'Sedang' => 'medium',
                    'Berat' => 'heavy',
                    'Tidak Bisa Digunakan' => 'critical',
                    default => '',
                };
            @endphp
            <div class="chart-row">
                <strong><span class="status-pill {{ $statusClass }}">{{ $jenis }}</span></strong>
                <div class="bar-track">
                    <div class="bar-fill" style="width: {{ ($jumlah / $grafikMaksimal) * 100 }}%;"></div>
                </div>
                <span>{{ $jumlah }}</span>
            </div>
        @endforeach
    </section>

    <section class="panel">
        <h3>Data Dashboard</h3>

        <div class="action-row">
            <button class="tab-button active" type="button" data-target="table-peralatan">
                Data Peralatan
            </button>

            <button class="tab-button" type="button" data-target="table-kerusakan">
                Data Kerusakan
            </button>

            <button class="tab-button" type="button" data-target="table-kategori">
                Kategori Kerusakan
            </button>

            <button class="tab-button" type="button" data-target="table-users">
                Daftar User Dashboard
            </button>
        </div>

        <div id="table-peralatan" class="tab-panel active table-wrap">
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
                        <td><span class="status-pill">{{ $data->kondisi }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data peralatan.</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div id="table-kerusakan" class="tab-panel table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
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
                        <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                        <td>{{ $data->deskripsi }}</td>
                        <td><span class="status-pill">{{ $data->status }}</span></td>
                        <td>{{ $data->tanggal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data kerusakan.</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div id="table-kategori" class="tab-panel table-wrap">
            <div class="action-row">
                <button class="tab-button active" type="button" data-jenis="Ringan">
                    Kerusakan Ringan
                </button>

                <button class="tab-button" type="button" data-jenis="Sedang">
                    Kerusakan Sedang
                </button>

                <button class="tab-button" type="button" data-jenis="Berat">
                    Kerusakan Berat
                </button>

                <button class="tab-button" type="button" data-jenis="Tidak Bisa Digunakan">
                    Tidak Bisa Digunakan
                </button>
            </div>

            @foreach($grafikKerusakan as $jenis => $jumlah)
                <div class="kategori-panel {{ $loop->first ? 'active' : '' }}" data-panel-jenis="{{ $jenis }}">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Kerusakan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>

                        @php
                            $kerusakanSesuaiJenis = $kerusakan->where('jenis_kerusakan', $jenis)->values();
                        @endphp

                        @forelse($kerusakanSesuaiJenis as $data)
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
                                <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                                <td>{{ $data->deskripsi }}</td>
                                <td><span class="status-pill">{{ $data->status }}</span></td>
                                <td>{{ $data->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Belum ada data {{ $jenis }}.</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            @endforeach
        </div>

        <div id="table-users" class="tab-panel table-wrap">
            <h3>Akun Komunitas Terdaftar</h3>

            @if(session('status'))
                <div class="alert success-alert">
                    {{ session('status') }}
                </div>
            @endif

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
                        <td><span class="status-pill">{{ $user->role }}</span></td>
                        <td>{{ $user->lokasi_lab ?? '-' }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline">
                                    Edit
                                </a>

                                <form class="inline-form" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="danger-button" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada akun komunitas terdaftar.</td>
                    </tr>
                @endforelse
            </table>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.tab-button').forEach(function (button) {
            button.addEventListener('click', function () {
                if (button.dataset.jenis) {
                    document.querySelectorAll('[data-jenis]').forEach(function (item) {
                        item.classList.remove('active');
                    });

                    document.querySelectorAll('.kategori-panel').forEach(function (panel) {
                        panel.classList.remove('active');
                    });

                    button.classList.add('active');
                    document.querySelector('[data-panel-jenis="' + button.dataset.jenis + '"]').classList.add('active');
                    return;
                }

                document.querySelectorAll('.tab-button').forEach(function (item) {
                    if (! item.dataset.jenis) {
                        item.classList.remove('active');
                    }
                });

                document.querySelectorAll('.tab-panel').forEach(function (panel) {
                    panel.classList.remove('active');
                });

                button.classList.add('active');
                document.getElementById(button.dataset.target).classList.add('active');
            });
        });
    </script>
@endpush
