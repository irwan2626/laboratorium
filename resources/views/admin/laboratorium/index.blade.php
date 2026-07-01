@extends('layouts.admin')

@section('title', 'Kelola Data Laboratorium')
@section('page_title', 'Kelola Data Laboratorium')
@section('page_subtitle', 'Data kerusakan per masing-masing laboratorium')

@section('content')
    <section class="panel lab-filter-panel">
        <label for="lab-selector">Pilih Laboratorium</label>
        <select id="lab-selector">
            @foreach($lokasiLaboratorium as $laboratorium)
                @php
                    $dataKerusakan = $kerusakanPerLaboratorium->get($laboratorium, collect());
                @endphp
                <option value="lab-panel-{{ $loop->index }}">
                    {{ $laboratorium }} ({{ $dataKerusakan->count() }} data)
                </option>
            @endforeach
        </select>
    </section>

    @foreach($lokasiLaboratorium as $laboratorium)
        @php
            $dataKerusakan = $kerusakanPerLaboratorium->get($laboratorium, collect());
        @endphp

        <section
            class="panel lab-panel {{ $loop->first ? 'active' : '' }}"
            id="lab-panel-{{ $loop->index }}"
            data-lab-panel>
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
                                            class="preview"
                                            src="{{ route('kerusakan.foto', ['path' => $data->foto]) }}"
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

@push('scripts')
    <script>
        const labSelector = document.getElementById('lab-selector');

        if (labSelector) {
            labSelector.addEventListener('change', function () {
                document.querySelectorAll('[data-lab-panel]').forEach(function (panel) {
                    panel.classList.toggle('active', panel.id === labSelector.value);
                });
            });
        }
    </script>
@endpush
