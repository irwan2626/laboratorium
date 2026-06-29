@extends('layouts.asisten')

@section('title', 'Scan QR Kerusakan')
@section('page_title', 'Scan QR Peralatan')
@section('page_subtitle', 'Arahkan kamera ke QR yang berisi kode barang')

@section('content')
    <div class="panel">
        <div id="reader" class="qr-reader"></div>
    </div>

    <div class="scan-modal" id="kerusakan-modal" hidden>
        <div class="scan-modal-backdrop" data-close-modal></div>
        <div class="scan-modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="scan-modal-head">
                <div>
                    <span class="eyebrow">QR sudah terdata</span>
                    <h2 id="modal-title">Data Kerusakan Ditemukan</h2>
                </div>
                <button class="modal-close" type="button" data-close-modal aria-label="Tutup">x</button>
            </div>

            <div class="modal-photo" id="modal-photo-wrap" hidden>
                <img id="modal-photo" src="" alt="Foto kerusakan">
            </div>

            <dl class="detail-grid">
                <div>
                    <dt>Nama Peralatan</dt>
                    <dd id="modal-nama">-</dd>
                </div>
                <div>
                    <dt>Kode QR / Kode Peralatan</dt>
                    <dd id="modal-kode">-</dd>
                </div>
                <div>
                    <dt>Laboratorium</dt>
                    <dd id="modal-laboratorium">-</dd>
                </div>
                <div>
                    <dt>Tanggal Kerusakan</dt>
                    <dd id="modal-tanggal">-</dd>
                </div>
                <div>
                    <dt>Kategori Kerusakan</dt>
                    <dd id="modal-kategori">-</dd>
                </div>
                <div>
                    <dt>Status Kerusakan</dt>
                    <dd id="modal-status">-</dd>
                </div>
                <div class="detail-full">
                    <dt>Deskripsi Kerusakan</dt>
                    <dd id="modal-deskripsi">-</dd>
                </div>
            </dl>

            <div class="action-row form-actions">
                <a class="btn btn-gold" id="modal-detail" href="#">Lihat Detail</a>
                <a class="btn btn-outline" id="modal-create" href="#">Input Kerusakan Baru</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        const modal = document.getElementById('kerusakan-modal');
        const modalPhotoWrap = document.getElementById('modal-photo-wrap');
        const modalPhoto = document.getElementById('modal-photo');
        let scanLocked = false;

        function setText(id, value) {
            document.getElementById(id).textContent = value || '-';
        }

        function openKerusakanModal(payload) {
            const data = payload.kerusakan;

            setText('modal-nama', data.nama_peralatan);
            setText('modal-kode', data.kode_peralatan);
            setText('modal-laboratorium', data.laboratorium);
            setText('modal-tanggal', data.tanggal);
            setText('modal-kategori', data.kategori);
            setText('modal-status', data.status);
            setText('modal-deskripsi', data.deskripsi);

            document.getElementById('modal-detail').href = payload.detail_url;
            document.getElementById('modal-create').href = payload.create_url;

            if (data.foto_url) {
                modalPhoto.src = data.foto_url;
                modalPhotoWrap.hidden = false;
            } else {
                modalPhoto.removeAttribute('src');
                modalPhotoWrap.hidden = true;
            }

            modal.hidden = false;
        }

        function closeKerusakanModal() {
            modal.hidden = true;
            scanLocked = false;
        }

        document.querySelectorAll('[data-close-modal]').forEach((element) => {
            element.addEventListener('click', closeKerusakanModal);
        });

        async function onScanSuccess(decodedText)
        {
            if (scanLocked) {
                return;
            }

            scanLocked = true;
            const kode = encodeURIComponent(decodedText);

            try {
                const response = await fetch('/kerusakan/check/' + kode, {
                    headers: {
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    cache: 'no-store'
                });
                const payload = await response.json();

                if (payload.exists) {
                    openKerusakanModal(payload);
                    return;
                }

                window.location.href = payload.create_url;
            } catch (error) {
                window.location.href = '/kerusakan/create/' + kode;
            }
        }

        let html5QrcodeScanner =
            new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10,
                    qrbox: 250
                }
            );

        html5QrcodeScanner.render(onScanSuccess);
    </script>
@endpush
