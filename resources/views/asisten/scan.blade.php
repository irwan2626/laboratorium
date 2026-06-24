@extends('layouts.asisten')

@section('title', 'Scan QR Kerusakan')
@section('page_title', 'Scan QR Peralatan')
@section('page_subtitle', 'Arahkan kamera ke QR yang berisi kode barang')

@section('content')
    <div class="panel">
        <div id="reader" class="qr-reader"></div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function onScanSuccess(decodedText)
        {
            window.location.href =
                "/kerusakan/create/" +
                encodeURIComponent(decodedText);
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
