<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <h1 class="h2 mb-4">Data Permohonan</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Jenis Layanan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($permohonan)): ?>
                    <?php foreach ($permohonan as $item): ?>
                        <tr>
                            <td><?= $item['nomor_permohonan'] ?? 'PL-' . date('Ymd') . '-' . str_pad($item['id_permohonan'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td>Jenis Layanan ID: <?= $item['jenis_id'] ?></td>
                            <td>
                                <span class="badge bg-<?= $item['status'] == 'diajukan' ? 'primary' : ($item['status'] == 'diproses' ? 'warning' : 'success') ?>">
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($item['tanggal_pengajuan'])) ?></td>
                            <td><?= $item['tanggal_selesai'] ? date('d/m/Y H:i', strtotime($item['tanggal_selesai'])) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data permohonan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
