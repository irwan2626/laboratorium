@extends('layouts.asisten')

@section('title', 'Edit Kerusakan')

@section('content')
    <div class="topbar">
        <div>
            <span class="eyebrow">Data Kerusakan</span>
            <h2>Edit Kerusakan</h2>
            <p>Perbarui detail laporan kerusakan peralatan laboratorium.</p>
        </div>
        <a href="/data-kerusakan" class="btn btn-outline">Kembali</a>
    </div>

    <div class="panel">
        <form
            action="/kerusakan/{{ $kerusakan->id }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Kode Barang</label>
                <input
                    type="text"
                    name="kode_barang"
                    value="{{ old('kode_barang', $kerusakan->peralatan->kode_barang) }}"
                    required>
                @error('kode_barang')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    value="{{ old('nama_barang', $kerusakan->peralatan->nama_barang) }}"
                    required>
                @error('nama_barang')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Jenis Kerusakan</label>
                <select name="jenis_kerusakan" required>
                    <option value="">Pilih jenis kerusakan</option>
                    <option value="Ringan" @selected(old('jenis_kerusakan', $kerusakan->jenis_kerusakan) === 'Ringan')>Kerusakan Ringan</option>
                    <option value="Sedang" @selected(old('jenis_kerusakan', $kerusakan->jenis_kerusakan) === 'Sedang')>Kerusakan Sedang</option>
                    <option value="Berat" @selected(old('jenis_kerusakan', $kerusakan->jenis_kerusakan) === 'Berat')>Kerusakan Berat</option>
                    <option value="Tidak Bisa Digunakan" @selected(old('jenis_kerusakan', $kerusakan->jenis_kerusakan) === 'Tidak Bisa Digunakan')>Tidak Bisa Digunakan</option>
                </select>
                @error('jenis_kerusakan')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Status</label>
                <input
                    type="text"
                    name="status"
                    value="{{ old('status', $kerusakan->status) }}"
                    required>
                @error('status')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', $kerusakan->tanggal ? \Carbon\Carbon::parse($kerusakan->tanggal)->format('Y-m-d') : '') }}"
                    required>
                @error('tanggal')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi">{{ old('deskripsi', $kerusakan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Foto Kerusakan</label>
                @if($kerusakan->foto)
                    <div class="mb-3">
                        <img
                            class="preview"
                            src="{{ route('kerusakan.foto', ['path' => $kerusakan->foto]) }}"
                            alt="Foto kerusakan saat ini">
                    </div>
                @endif
                <input type="file" name="foto">
                @error('foto')
                    <div class="muted">{{ $message }}</div>
                @enderror
            </div>

            <div class="action-row">
                <button class="btn" type="submit">Simpan Perubahan</button>
                <a href="/data-kerusakan" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection
