<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <h1 class="h2 mb-4">Data Warga</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($wargas)): ?>
                    <?php foreach ($wargas as $warga): ?>
                        <tr>
                            <td><?= $warga['nik'] ?></td>
                            <td><?= $warga['nama_lengkap'] ?></td>
                            <td><?= $warga['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            <td><?= $warga['alamat'] ?>, <?= $warga['rt_rw'] ?>, <?= $warga['kecamatan'] ?>, <?= $warga['kab_kota'] ?></td>
                            <td><?= $warga['no_hp'] ?? '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data warga.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
