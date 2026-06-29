@extends('layouts.asisten')

@section('title', 'Detail Kerusakan')
@section('page_title', 'Detail Kerusakan')
@section('page_subtitle', 'Informasi laporan kerusakan berdasarkan QR')

@section('content')
    <div class="topbar">
        <div>
            <span class="eyebrow">Data Kerusakan</span>
            <h2>Detail Kerusakan</h2>
            <p>Informasi laporan kerusakan berdasarkan QR.</p>
        </div>
        <a href="/data-kerusakan" class="btn btn-outline">Kembali</a>
    </div>

    <section class="panel">
        @if($kerusakan->foto)
            <div class="detail-photo">
                <img src="{{ Storage::disk('public')->url($kerusakan->foto) }}" alt="Foto kerusakan">
            </div>
        @endif

        <dl class="detail-grid">
            <div>
                <dt>Nama Peralatan</dt>
                <dd>{{ $kerusakan->peralatan->nama_barang ?? '-' }}</dd>
            </div>
            <div>
                <dt>Kode QR / Kode Peralatan</dt>
                <dd>{{ $kerusakan->peralatan->kode_barang ?? '-' }}</dd>
            </div>
            <div>
                <dt>Laboratorium</dt>
                <dd>{{ $kerusakan->user->lokasi_lab ?? '-' }}</dd>
            </div>
            <div>
                <dt>Tanggal Kerusakan</dt>
                <dd>{{ $kerusakan->tanggal }}</dd>
            </div>
            <div>
                <dt>Kategori Kerusakan</dt>
                <dd>{{ $kerusakan->jenis_kerusakan }}</dd>
            </div>
            <div>
                <dt>Status Kerusakan</dt>
                <dd>{{ $kerusakan->status }}</dd>
            </div>
            <div class="detail-full">
                <dt>Deskripsi Kerusakan</dt>
                <dd>{{ $kerusakan->deskripsi ?: '-' }}</dd>
            </div>
        </dl>

        <div class="action-row form-actions">
            <a class="btn btn-gold" href="/kerusakan/create/{{ rawurlencode($kerusakan->peralatan->kode_barang ?? '') }}">Input Kerusakan Baru</a>
            <a class="btn btn-outline" href="/kerusakan/{{ $kerusakan->id }}/edit">Edit</a>
        </div>
    </section>
@endsection
