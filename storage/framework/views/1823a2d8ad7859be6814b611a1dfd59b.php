<?php $__env->startSection('title', 'Scan QR Kerusakan'); ?>
<?php $__env->startSection('page_title', 'Scan QR Peralatan'); ?>
<?php $__env->startSection('page_subtitle', 'Arahkan kamera ke QR yang berisi kode barang'); ?>

<?php $__env->startSection('content'); ?>
    <div class="panel">
        <div id="reader" class="qr-reader"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.asisten', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/asisten/scan.blade.php ENDPATH**/ ?>