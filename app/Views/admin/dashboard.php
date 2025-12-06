<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-0">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>
                        Dashboard Admin
                    </h1>
                    <p class="text-muted mb-0">Selamat datang, <?= $user['nama'] ?> (<?= ucfirst($user['role']) ?>)</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        <?= date('l, d F Y') ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= number_format($stats['total_warga']) ?></h3>
                    <p class="text-muted mb-0">Total Warga</p>
                    <small class="text-success">
                        <i class="bi bi-person-plus me-1"></i>
                        Terdaftar
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= number_format($stats['total_berita']) ?></h3>
                    <p class="text-muted mb-0">Total Berita</p>
                    <small class="text-info">
                        <i class="bi bi-eye me-1"></i>
                        Diterbitkan
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= number_format($stats['total_pengaduan']) ?></h3>
                    <p class="text-muted mb-0">Total Pengaduan</p>
                    <small class="text-danger">
                        <i class="bi bi-clock me-1"></i>
                        <?= $stats['pengaduan_baru'] ?> baru
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= number_format($stats['total_permohonan']) ?></h3>
                    <p class="text-muted mb-0">Total Permohonan</p>
                    <small class="text-primary">
                        <i class="bi bi-hourglass me-1"></i>
                        <?= $stats['permohonan_baru'] ?> dalam proses
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Menu Pengelolaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="/dashboard/warga" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 card-hover">
                                    <div class="card-body text-center py-4">
                                        <div class="display-4 text-primary mb-2">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <h6 class="card-title">Kelola Warga</h6>
                                        <small class="text-muted">Tambah, edit, hapus data warga</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="/pengaduan" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 card-hover">
                                    <div class="card-body text-center py-4">
                                        <div class="display-4 text-warning mb-2">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                        </div>
                                        <h6 class="card-title">Kelola Pengaduan</h6>
                                        <small class="text-muted">Update status pengaduan</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="/permohonan" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 card-hover">
                                    <div class="card-body text-center py-4">
                                        <div class="display-4 text-success mb-2">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <h6 class="card-title">Kelola Permohonan</h6>
                                        <small class="text-muted">Proses permohonan layanan</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 card-hover">
                                    <div class="card-body text-center py-4">
                                        <div class="display-4 text-info mb-2">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <h6 class="card-title">Kelola Wilayah</h6>
                                        <small class="text-muted">RT/RW & wilayah administrasi</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-3">
        <!-- Recent Pengaduan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Pengaduan Terbaru
                    </h6>
                    <a href="/pengaduan" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_pengaduan)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_pengaduan as $pengaduan): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>" class="text-decoration-none">
                                                    <?= substr($pengaduan['judul'], 0, 40) ?><?= strlen($pengaduan['judul']) > 40 ? '...' : '' ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>
                                                Warga ID: <?= $pengaduan['warga_id'] ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $pengaduan['status'] == 'baru' ? 'warning' : ($pengaduan['status'] == 'diproses' ? 'info' : 'success') ?> ms-2">
                                            <?= ucfirst($pengaduan['status']) ?>
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($pengaduan['created_at'])) ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle display-1 text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pengaduan baru</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Permohonan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Permohonan Terbaru
                    </h6>
                    <a href="/permohonan" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_permohonan)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_permohonan as $permohonan): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="/permohonan/<?= $permohonan['id_permohonan'] ?>" class="text-decoration-none">
                                                    Permohonan #<?= str_pad($permohonan['id_permohonan'], 5, '0', STR_PAD_LEFT) ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>
                                                Warga ID: <?= $permohonan['warga_id'] ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $permohonan['status'] == 'diajukan' ? 'primary' : ($permohonan['status'] == 'diproses' ? 'warning' : 'success') ?> ms-2">
                                            <?= ucfirst($permohonan['status']) ?>
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($permohonan['tanggal_pengajuan'])) ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-file-earmark-text display-1 text-muted mb-3"></i>
                            <p class="text-muted">Belum ada permohonan baru</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="mb-2">Sistem Pelayanan Masyarakat Kembangan Raya</h6>
                    <p class="text-muted mb-0 small">
                        <i class="bi bi-info-circle me-1"></i>
                        Dashboard admin untuk mengelola data warga, berita, pengaduan, dan permohonan masyarakat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-refresh statistics every 30 seconds
setInterval(function() {
    // Could add AJAX call to refresh stats if needed
}, 30000);

// Toast notifications for actions
<?php if (session()->has('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.querySelector('.alert-success'));
        setTimeout(() => toast.show(), 500);
    });
<?php endif; ?>

<?php if (session()->has('error')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.querySelector('.alert-danger'));
        setTimeout(() => toast.show(), 500);
    });
<?php endif; ?>
</script>
<?= $this->endSection() ?>
