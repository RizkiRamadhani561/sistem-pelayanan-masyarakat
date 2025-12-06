<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Selamat Datang di Sistem Pelayanan Masyarakat</h1>
                <p class="lead mb-4">Kembangan Raya - Melayani masyarakat dengan cepat, transparan, dan profesional</p>
                <div class="d-flex gap-3">
                    <a href="/pengaduan" class="btn btn-light btn-lg">
                        <i class="bi bi-exclamation-triangle me-2"></i>Ajukan Pengaduan
                    </a>
                    <a href="/layanan" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-file-earmark-text me-2"></i>Ajukan Permohonan
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="bi bi-building display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= count($berita_terbaru) ?></h3>
                    <p class="text-muted mb-0">Berita Terbaru</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= $total_pengaduan ?></h3>
                    <p class="text-muted mb-0">Total Pengaduan</p>
                    <small class="text-danger"><?= $pengaduan_baru ?> belum diproses</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= $total_permohonan ?></h3>
                    <p class="text-muted mb-0">Total Permohonan</p>
                    <small class="text-info"><?= $permohonan_baru ?> dalam proses</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h2 mb-1">24/7</h3>
                    <p class="text-muted mb-0">Pelayanan Online</p>
                    <small class="text-success">Selalu Siap</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Berita Terbaru Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h1 text-center mb-4">Berita Terbaru</h2>
                <p class="text-center text-muted lead">Informasi terkini dari Pemerintah Kembangan Raya</p>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($berita_terbaru)): ?>
                <?php foreach ($berita_terbaru as $berita): ?>
                    <div class="col-lg-4 col-md-6 fade-in">
                        <div class="card h-100 border-0 shadow-sm card-hover">
                            <?php if ($berita['gambar']): ?>
                                <img src="/images/placeholder-news.jpg"
                                     data-src="<?= $berita['gambar'] ?>"
                                     alt="<?= $berita['judul'] ?>"
                                     class="card-img-top lazy-img"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-newspaper text-white display-4"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($berita['published_at'])) ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>
                                        <?= number_format($berita['views']) ?>
                                    </small>
                                </div>

                                <h5 class="card-title">
                                    <a href="/berita/<?= $berita['slug'] ?>" class="text-decoration-none text-dark">
                                        <?= substr($berita['judul'], 0, 60) ?>...
                                    </a>
                                </h5>

                                <p class="card-text flex-grow-1">
                                    <?= $berita['excerpt'] ?? substr(strip_tags($berita['isi']), 0, 100) ?>...
                                </p>

                                <a href="/berita/<?= $berita['slug'] ?>" class="btn btn-primary mt-auto">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-newspaper display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada berita</h4>
                        <p class="text-muted">Berita terbaru akan segera dipublikasikan.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="/berita" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-arrow-right me-2"></i>Lihat Semua Berita
            </a>
        </div>
    </div>
</section>

<!-- Quick Actions Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h1 text-center mb-4">Layanan Cepat</h2>
                <p class="text-center text-muted lead">Akses layanan pemerintah dengan mudah dan cepat</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center card-hover">
                    <div class="card-body py-5">
                        <div class="display-1 text-danger mb-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <h4 class="card-title">Pengaduan Online</h4>
                        <p class="card-text text-muted">Sampaikan keluhan dan aspirasi Anda dengan mudah melalui sistem online</p>
                        <a href="/pengaduan" class="btn btn-danger">
                            <i class="bi bi-plus-circle me-2"></i>Ajukan Pengaduan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center card-hover">
                    <div class="card-body py-5">
                        <div class="display-1 text-success mb-3">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <h4 class="card-title">Permohonan Layanan</h4>
                        <p class="card-text text-muted">Ajukan berbagai jenis permohonan layanan administrasi pemerintah</p>
                        <a href="/layanan" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>Ajukan Permohonan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center card-hover">
                    <div class="card-body py-5">
                        <div class="display-1 text-info mb-3">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h4 class="card-title">Informasi Layanan</h4>
                        <p class="card-text text-muted">Dapatkan informasi lengkap tentang berbagai layanan pemerintah</p>
                        <a href="/layanan" class="btn btn-info">
                            <i class="bi bi-info-circle me-2"></i>Lihat Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Populer Sidebar -->
<?php if (!empty($berita_populer)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="h2 text-center mb-4">Berita Terpopuler</h3>
            </div>
        </div>

        <div class="row justify-content-center">
            <?php foreach ($berita_populer as $berita): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <?php if ($berita['gambar']): ?>
                                        <img src="/images/placeholder-news.jpg"
                                             data-src="<?= $berita['gambar'] ?>"
                                             alt="<?= $berita['judul'] ?>"
                                             class="lazy-img rounded"
                                             style="width: 80px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                            <i class="bi bi-newspaper text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1">
                                        <a href="/berita/<?= $berita['slug'] ?>" class="text-decoration-none">
                                            <?= substr($berita['judul'], 0, 50) ?>...
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i><?= number_format($berita['views']) ?> views
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Toast Notifications -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <!-- Success Toast -->
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i>Aksi berhasil dilakukan!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!-- Error Toast -->
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle me-2"></i>Terjadi kesalahan!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-show toasts if there are flash messages
<?php if (session()->has('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.querySelector('#successToast .toast-body').innerHTML =
            '<i class="bi bi-check-circle me-2"></i><?= session('success') ?>';
        toast.show();
    });
<?php endif; ?>

<?php if (session()->has('error')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.querySelector('#errorToast .toast-body').innerHTML =
            '<i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>';
        toast.show();
    });
<?php endif; ?>
</script>
<?= $this->endSection() ?>
