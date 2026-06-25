<?php $__env->startSection('content'); ?>

    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Kerusakan</p>
            <strong><?php echo e($total); ?></strong>
            <span class="stat-meta"><span class="stat-dot"></span> Semua laporan</span>
        </div>

        <div class="stat-card status-light">
            <p>Kerusakan Ringan</p>
            <strong><?php echo e($totalPerJenis['Ringan']); ?></strong>
            <span class="stat-meta"><span class="stat-dot"></span> Perlu pemeliharaan</span>
        </div>

        <div class="stat-card status-medium">
            <p>Kerusakan Sedang</p>
            <strong><?php echo e($totalPerJenis['Sedang']); ?></strong>
            <span class="stat-meta"><span class="stat-dot"></span> Butuh penanganan</span>
        </div>

        <div class="stat-card status-heavy">
            <p>Kerusakan Berat</p>
            <strong><?php echo e($totalPerJenis['Berat']); ?></strong>
            <span class="stat-meta"><span class="stat-dot"></span> Prioritas tinggi</span>
        </div>

        <div class="stat-card status-critical">
            <p>Tidak Bisa Digunakan</p>
            <strong><?php echo e($totalPerJenis['Tidak Bisa Digunakan']); ?></strong>
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

                <?php $__empty_1 = true; $__currentLoopData = $kerusakanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusClass = match ($data->jenis_kerusakan) {
                            'Ringan' => 'light',
                            'Sedang' => 'medium',
                            'Berat' => 'heavy',
                            'Tidak Bisa Digunakan' => 'critical',
                            default => '',
                        };
                    ?>
                    <tr>
                        <td><?php echo e($data->peralatan->kode_barang); ?></td>
                        <td><?php echo e($data->peralatan->nama_barang); ?></td>
                        <td><span class="status-pill <?php echo e($statusClass); ?>"><?php echo e($data->jenis_kerusakan); ?></span></td>
                        <td><span class="status-pill"><?php echo e($data->status); ?></span></td>
                        <td><?php echo e($data->tanggal); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="muted">Belum ada data kerusakan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.asisten', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/asisten/dashboard.blade.php ENDPATH**/ ?>