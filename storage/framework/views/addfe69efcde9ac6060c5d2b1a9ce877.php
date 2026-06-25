<?php $__env->startSection('title', 'Kelola Data User'); ?>
<?php $__env->startSection('page_title', 'Kelola Data User'); ?>
<?php $__env->startSection('page_subtitle', 'Daftar akun dan role pengguna sistem'); ?>

<?php $__env->startSection('content'); ?>
    <section class="panel">
        <div class="action-row">
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-gold">
                Tambah User
            </a>
        </div>

        <?php if(session('status')): ?>
            <div class="alert success-alert">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Lokasi Lab</th>
                    <th>Aksi</th>
                </tr>

                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->role); ?></td>
                        <td><?php echo e($user->lokasi_lab ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn">
                                Edit
                            </a>

                            <form class="inline-form" action="<?php echo e(route('users.password-reset', $user)); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <button class="btn" type="submit">
                                    Lupa Password
                                </button>
                            </form>

                            <form class="inline-form" action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button class="danger-button" type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">Belum ada data user.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/admin/users/index.blade.php ENDPATH**/ ?>