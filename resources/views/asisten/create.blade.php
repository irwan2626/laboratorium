@extends('layouts.asisten')

@section('title', 'Input Kerusakan')
@section('page_title', 'Input Kerusakan')
@section('page_subtitle', 'Lengkapi laporan berdasarkan kode barang dari QR')

@section('content')
    <div class="topbar">
        <div>
            <span class="eyebrow">Data Kerusakan</span>
            <h2>Input Kerusakan</h2>
            <p>Lengkapi laporan berdasarkan kode barang dari QR.</p>
        </div>
        <a href="/scan" class="btn btn-outline">Scan Ulang</a>
    </div>

    <section class="panel">
        <form
            class="form-stack"
            action="/kerusakan/store"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label>Kode Barang</label>

                <input
                    type="text"
                    name="kode_barang"
                    value="{{ $kode }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>

                <input
                    type="text"
                    name="nama_barang"
                    value="{{ old('nama_barang', $peralatan->nama_barang ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Kondisi Barang</label>

                <select name="kondisi" id="kondisi-barang" required>
                    <option value="">Pilih kondisi barang</option>
                    <option value="Digunakan" @selected(old('kondisi', $peralatan->kondisi ?? '') === 'Digunakan')>Digunakan</option>
                    <option value="Rusak" @selected(old('kondisi', $peralatan->kondisi ?? '') === 'Rusak')>Rusak</option>
                    <option value="Tidak Bisa Digunakan" @selected(old('kondisi', $peralatan->kondisi ?? '') === 'Tidak Bisa Digunakan')>Tidak Bisa Digunakan</option>
                </select>
                @error('kondisi')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="jenis-kerusakan-wrap">
                <label>Status Kerusakan</label>

                <select
                    name="jenis_kerusakan"
                    id="jenis-kerusakan"
                    required>
                    <option value="">Pilih jenis kerusakan</option>
                    <option value="Ringan" @selected(old('jenis_kerusakan') === 'Ringan')>Kerusakan Ringan</option>
                    <option value="Sedang" @selected(old('jenis_kerusakan') === 'Sedang')>Kerusakan Sedang</option>
                    <option value="Berat" @selected(old('jenis_kerusakan') === 'Berat')>Kerusakan Berat</option>
                    <option value="Tidak Bisa Digunakan" @selected(old('jenis_kerusakan') === 'Tidak Bisa Digunakan')>Tidak Bisa Digunakan</option>
                </select>
                @error('jenis_kerusakan')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>

                <textarea
                    name="deskripsi">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Foto Kerusakan</label>

                <input
                    type="file"
                    name="foto">
            </div>

            <div class="action-row form-actions">
                <button class="btn btn-gold" type="submit">
                    Simpan
                </button>

                <a class="btn btn-outline" href="/data-kerusakan">
                    Batal
                </a>
            </div>
        </form>
    </section>

    <script>
        (function () {
            const kondisiBaru = document.getElementById('kondisi-barang');
            const jenisWrap = document.getElementById('jenis-kerusakan-wrap');
            const jenisSelect = document.getElementById('jenis-kerusakan');

            if (!kondisiBaru || !jenisWrap || !jenisSelect) {
                return;
            }

            const toggleJenis = () => {
                const needsJenis = ['Rusak', 'Tidak Bisa Digunakan'].includes(kondisiBaru.value);
                jenisWrap.style.display = needsJenis ? '' : 'none';
                jenisSelect.required = needsJenis;
                if (!needsJenis) {
                    jenisSelect.value = '';
                }
            };

            kondisiBaru.addEventListener('change', toggleJenis);
            toggleJenis();
        })();
    </script>
@endsection
