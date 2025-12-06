<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <h1 class="h2 mb-4">Jenis Layanan</h1>

    <div class="row">
        <?php if (!empty($jenis_layanan)): ?>
            <?php foreach ($jenis_layanan as $layanan): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= $layanan['nama_pelayanan'] ?></h5>
                            <p class="card-text"><?= $layanan['deskripsi'] ?? 'Tidak ada deskripsi' ?></p>
                            <p class="text-muted small">Kode: <?= $layanan['kode'] ?> | Estimasi: <?= $layanan['estimasi_hari'] ?> hari</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Belum ada jenis layanan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
