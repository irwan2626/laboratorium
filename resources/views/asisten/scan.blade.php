@extends('layouts.asisten')

@section('title', 'Scan QR Kerusakan')
@section('page_title', 'Scan QR Peralatan')
@section('page_subtitle', 'Arahkan kamera ke QR yang berisi kode barang')

@section('content')
    <div class="panel">
        <div id="reader" class="qr-reader"></div>
        <p id="scan-status" class="muted scan-status">Arahkan kamera ke QR peralatan.</p>
    </div>

    <div id="qr-detail-modal" class="qr-modal" hidden>
        <div class="qr-modal-backdrop" data-close-modal></div>
        <div class="qr-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="qr-detail-title">
            <div class="qr-modal-header">
                <div>
                    <span class="eyebrow">Detail QR Terdata</span>
                    <h3 id="qr-detail-title">Detail Kerusakan</h3>
                </div>
                <button class="qr-modal-close" type="button" data-close-modal aria-label="Tutup">x</button>
            </div>

            <div class="qr-detail-grid">
                <div class="qr-detail-photo">
                    <img id="detail-foto" src="/uploads/kerusakan/tidak-ada-foto" alt="Foto alat">
                </div>

                <div class="qr-detail-list">
                    <div>
                        <span>Kode Barang</span>
                        <strong id="detail-kode">-</strong>
                    </div>
                    <div>
                        <span>Nama Barang</span>
                        <strong id="detail-nama">-</strong>
                    </div>
                    <div>
                        <span>Kondisi Alat</span>
                        <strong id="detail-kondisi">-</strong>
                    </div>
                    <div>
                        <span>Status Kerusakan</span>
                        <strong id="detail-jenis">-</strong>
                    </div>
                    <div>
                        <span>Status</span>
                        <strong id="detail-status">-</strong>
                    </div>
                    <div>
                        <span>Tanggal</span>
                        <strong id="detail-tanggal">-</strong>
                    </div>
                </div>
            </div>

            <div class="qr-detail-description">
                <span>Deskripsi</span>
                <p id="detail-deskripsi">-</p>
            </div>

            <div class="action-row form-actions">
                <button class="btn btn-outline" type="button" data-close-modal>Tutup</button>
            </div>
        </div>
    </div>

    <style>
        .scan-status {
            margin: 14px auto 0;
            max-width: 620px;
        }

        .qr-modal[hidden] {
            display: none;
        }

        .qr-modal {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: grid;
            place-items: center;
            padding: 18px;
        }

        .qr-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(17, 28, 45, 0.48);
        }

        .qr-modal-dialog {
            position: relative;
            width: min(720px, 100%);
            max-height: calc(100vh - 36px);
            overflow-y: auto;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-lowest);
            box-shadow: 0 24px 60px rgba(17, 28, 45, 0.22);
            padding: 22px;
        }

        .qr-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .qr-modal-close {
            width: 36px;
            height: 36px;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-lowest);
            color: var(--secondary);
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
        }

        .qr-detail-grid {
            display: grid;
            grid-template-columns: 220px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .qr-detail-photo img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container);
        }

        .qr-detail-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .qr-detail-list div,
        .qr-detail-description {
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-low);
            padding: 12px;
        }

        .qr-detail-list span,
        .qr-detail-description span {
            display: block;
            margin-bottom: 4px;
            color: var(--secondary);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            text-transform: uppercase;
        }

        .qr-detail-list strong,
        .qr-detail-description p {
            margin: 0;
            color: var(--on-surface);
            font-size: 14px;
            line-height: 20px;
            overflow-wrap: anywhere;
        }

        .qr-detail-description {
            margin-top: 14px;
            margin-bottom: 16px;
        }

        @media (max-width: 720px) {
            .qr-detail-grid,
            .qr-detail-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        const scanStatus = document.getElementById('scan-status');
        const detailModal = document.getElementById('qr-detail-modal');
        const detailFoto = document.getElementById('detail-foto');
        let isProcessingScan = false;

        const setText = (id, value) => {
            document.getElementById(id).textContent = value || '-';
        };

        const openDetailModal = (payload) => {
            const data = payload.data;

            setText('detail-kode', data.kode_barang);
            setText('detail-nama', data.nama_barang);
            setText('detail-kondisi', data.kondisi);
            setText('detail-jenis', data.jenis_kerusakan);
            setText('detail-status', data.status);
            setText('detail-tanggal', data.tanggal);
            setText('detail-deskripsi', data.deskripsi);

            detailFoto.src = data.foto_url || '/uploads/kerusakan/tidak-ada-foto';
            detailModal.hidden = false;
        };

        const closeDetailModal = () => {
            detailModal.hidden = true;
            isProcessingScan = false;
            scanStatus.textContent = 'Arahkan kamera ke QR peralatan.';
        };

        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', closeDetailModal);
        });

        async function onScanSuccess(decodedText)
        {
            if (isProcessingScan) {
                return;
            }

            isProcessingScan = true;
            scanStatus.textContent = 'Memeriksa kode QR...';

            try {
                const response = await fetch('/kerusakan/check/' + encodeURIComponent(decodedText), {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Kode QR gagal diperiksa.');
                }

                const payload = await response.json();

                if (payload.exists) {
                    scanStatus.textContent = 'Kode QR sudah terdata.';
                    openDetailModal(payload);
                    return;
                }

                window.location.href = payload.create_url;
            } catch (error) {
                scanStatus.textContent = 'Gagal memeriksa QR. Coba scan ulang.';
                isProcessingScan = false;
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
