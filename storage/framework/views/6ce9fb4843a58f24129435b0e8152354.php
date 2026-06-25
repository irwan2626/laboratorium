<?php $__env->startSection('title', 'Kelola Data Laboratorium'); ?>
<?php $__env->startSection('page_title', 'Kelola Data Laboratorium'); ?>
<?php $__env->startSection('page_subtitle', 'Data laboratorium yang terdaftar di sistem'); ?>

<?php $__env->startSection('content'); ?>
    <section class="panel">
        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>ID Laboratorium</th>
                    <th>Dibuat</th>
                </tr>

                <?php $__empty_1 = true; $__currentLoopData = $laboratorium; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($data->id); ?></td>
                        <td><?php echo e($data->created_at); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3">Belum ada data laboratorium.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/admin/laboratorium/index.blade.php ENDPATH**/ ?>