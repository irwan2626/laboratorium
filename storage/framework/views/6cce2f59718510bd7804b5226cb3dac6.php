<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="success-message">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="panel">
        <div class="action-row">
            <a href="/scan" class="btn btn-gold">Scan QR Kerusakan</a>
        </div>

        <div class="table-wrap">
            <table>
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
                    <th>Aksi</th>
                </tr>

                <?php $__empty_1 = true; $__currentLoopData = $kerusakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($data->peralatan->kode_barang); ?></td>
                        <td><?php echo e($data->peralatan->nama_barang); ?></td>
                        <td><?php echo e($data->peralatan->kondisi); ?></td>
                        <td><span class="status-pill <?php echo e($statusClass); ?>"><?php echo e($data->jenis_kerusakan); ?></span></td>
                        <td><?php echo e($data->deskripsi); ?></td>
                        <td>
                            <?php if($data->foto): ?>
                                <img
                                class="preview"
                                src="<?php echo e(asset('storage/'.$data->foto)); ?>"
                                alt="Foto kerusakan">
                            <?php else: ?>
                                Tidak ada foto
                            <?php endif; ?>
                        </td>
                        <td><span class="status-pill"><?php echo e($data->status); ?></span></td>
                        <td><?php echo e($data->tanggal); ?></td>
                        <td>
                            <div class="table-actions">
                                <a class="btn btn-outline" href="/kerusakan/<?php echo e($data->id); ?>/edit">Edit</a>
                                <form
                                    class="inline-form"
                                    action="/kerusakan/<?php echo e($data->id); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Hapus data kerusakan ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10">Belum ada data kerusakan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.asisten', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/asisten/data-kerusakan.blade.php ENDPATH**/ ?>