<?php
    $grafikMaksimal = max($grafikKerusakan) > 0 ? max($grafikKerusakan) : 1;
?>

<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page_title', 'Dashboard Utama'); ?>

<?php $__env->startSection('content'); ?>
    <section class="topbar">
        <span class="eyebrow">Dashboard Admin</span>
        <h2>Monitoring Laboratorium</h2>
        <p>Ringkasan data laboratorium, peralatan, dan status kerusakan perangkat.</p>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <p>Total Laboratorium</p>
            <strong><?php echo e($totalLaboratorium); ?></strong>
            <span class="stat-meta">Unit labor terdaftar</span>
        </div>

        <div class="stat-card">
            <p>Total Peralatan</p>
            <strong><?php echo e($totalPeralatan); ?></strong>
            <span class="stat-meta">Inventaris tercatat</span>
        </div>

        <div class="stat-card">
            <p>Total Kerusakan</p>
            <strong><?php echo e($totalKerusakan); ?></strong>
            <span class="stat-meta">Semua laporan</span>
        </div>

        <div class="stat-card status-light">
            <p>Kerusakan Ringan</p>
            <strong><?php echo e($grafikKerusakan['Ringan']); ?></strong>
            <span class="stat-meta">Pemeliharaan ringan</span>
        </div>

        <div class="stat-card status-medium">
            <p>Kerusakan Sedang</p>
            <strong><?php echo e($grafikKerusakan['Sedang']); ?></strong>
            <span class="stat-meta">Butuh penanganan</span>
        </div>

        <div class="stat-card status-heavy">
            <p>Kerusakan Berat</p>
            <strong><?php echo e($grafikKerusakan['Berat']); ?></strong>
            <span class="stat-meta">Prioritas tinggi</span>
        </div>

        <div class="stat-card status-critical">
            <p>Tidak Bisa Digunakan</p>
            <strong><?php echo e($grafikKerusakan['Tidak Bisa Digunakan']); ?></strong>
            <span class="stat-meta">Kondisi kritis</span>
        </div>
    </section>

    <section class="panel">
        <h3>Grafik Kerusakan</h3>

        <?php $__currentLoopData = $grafikKerusakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $jumlah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $statusClass = match ($jenis) {
                    'Ringan' => 'light',
                    'Sedang' => 'medium',
                    'Berat' => 'heavy',
                    'Tidak Bisa Digunakan' => 'critical',
                    default => '',
                };
            ?>
            <div class="chart-row">
                <strong><span class="status-pill <?php echo e($statusClass); ?>"><?php echo e($jenis); ?></span></strong>
                <div class="bar-track">
                    <div class="bar-fill" style="width: <?php echo e(($jumlah / $grafikMaksimal) * 100); ?>%;"></div>
                </div>
                <span><?php echo e($jumlah); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    <section class="panel">
        <h3>Data Dashboard</h3>

        <div class="action-row">
            <button class="tab-button active" type="button" data-target="table-peralatan">
                Data Peralatan
            </button>

            <button class="tab-button" type="button" data-target="table-kerusakan">
                Data Kerusakan
            </button>

            <button class="tab-button" type="button" data-target="table-kategori">
                Kategori Kerusakan
            </button>

            <button class="tab-button" type="button" data-target="table-users">
                Daftar User Dashboard
            </button>
        </div>

        <div id="table-peralatan" class="tab-panel active table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kondisi</th>
                </tr>

                <?php $__empty_1 = true; $__currentLoopData = $peralatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($data->kode_barang); ?></td>
                        <td><?php echo e($data->nama_barang); ?></td>
                        <td><span class="status-pill"><?php echo e($data->kondisi); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4">Belum ada data peralatan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div id="table-kerusakan" class="tab-panel table-wrap">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Kerusakan</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
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
                        <td><span class="status-pill <?php echo e($statusClass); ?>"><?php echo e($data->jenis_kerusakan); ?></span></td>
                        <td><?php echo e($data->deskripsi); ?></td>
                        <td><span class="status-pill"><?php echo e($data->status); ?></span></td>
                        <td><?php echo e($data->tanggal); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7">Belum ada data kerusakan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div id="table-kategori" class="tab-panel table-wrap">
            <div class="action-row">
                <button class="tab-button active" type="button" data-jenis="Ringan">
                    Kerusakan Ringan
                </button>

                <button class="tab-button" type="button" data-jenis="Sedang">
                    Kerusakan Sedang
                </button>

                <button class="tab-button" type="button" data-jenis="Berat">
                    Kerusakan Berat
                </button>

                <button class="tab-button" type="button" data-jenis="Tidak Bisa Digunakan">
                    Tidak Bisa Digunakan
                </button>
            </div>

            <?php $__currentLoopData = $grafikKerusakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $jumlah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="kategori-panel <?php echo e($loop->first ? 'active' : ''); ?>" data-panel-jenis="<?php echo e($jenis); ?>">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Kerusakan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>

                        <?php
                            $kerusakanSesuaiJenis = $kerusakan->where('jenis_kerusakan', $jenis)->values();
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $kerusakanSesuaiJenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                <td><span class="status-pill <?php echo e($statusClass); ?>"><?php echo e($data->jenis_kerusakan); ?></span></td>
                                <td><?php echo e($data->deskripsi); ?></td>
                                <td><span class="status-pill"><?php echo e($data->status); ?></span></td>
                                <td><?php echo e($data->tanggal); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">Belum ada data <?php echo e($jenis); ?>.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div id="table-users" class="tab-panel table-wrap">
            <h3>Akun Komunitas Terdaftar</h3>

            <?php if(session('status')): ?>
                <div class="alert success-alert">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

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
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">Belum ada akun komunitas terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.querySelectorAll('.tab-button').forEach(function (button) {
            button.addEventListener('click', function () {
                if (button.dataset.jenis) {
                    document.querySelectorAll('[data-jenis]').forEach(function (item) {
                        item.classList.remove('active');
                    });

                    document.querySelectorAll('.kategori-panel').forEach(function (panel) {
                        panel.classList.remove('active');
                    });

                    button.classList.add('active');
                    document.querySelector('[data-panel-jenis="' + button.dataset.jenis + '"]').classList.add('active');
                    return;
                }

                document.querySelectorAll('.tab-button').forEach(function (item) {
                    if (! item.dataset.jenis) {
                        item.classList.remove('active');
                    }
                });

                document.querySelectorAll('.tab-panel').forEach(function (panel) {
                    panel.classList.remove('active');
                });

                button.classList.add('active');
                document.getElementById(button.dataset.target).classList.add('active');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pendataan_labor\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>