<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-8 mx-auto">
                <div class="fade-in">
                    <h1 class="display-3 fw-bold text-white mb-4 text-balance">
                        Sistem Pelayanan Masyarakat
                        <span class="text-warning">Kembangan Raya</span>
                    </h1>
                    <p class="lead text-white-50 mb-5 fs-5 text-balance">
                        Melayani masyarakat dengan cepat, transparan, dan profesional melalui platform digital modern
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="/pengaduan" class="btn btn-warning btn-lg px-4 py-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Ajukan Pengaduan
                        </a>
                        <a href="/layanan" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="bi bi-file-earmark-text-fill me-2"></i>
                            Layanan Administrasi
                        </a>
                        <a href="/berita" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="bi bi-newspaper me-2"></i>
                            Berita & Informasi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#features" class="text-white-50 text-decoration-none">
                <div class="scroll-indicator">
                    <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Statistics Dashboard -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4" id="features">
            <!-- Pengaduan Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="feature-card bounce-in">
                    <div class="icon bg-warning">
                        <i class="bi bi-exclamation-triangle-fill text-white"></i>
                    </div>
                    <h3 class="h2 mb-2 text-warning fw-bold">
                        <?= $total_pengaduan ?? 0 ?>
                    </h3>
                    <h5 class="mb-1">Total Pengaduan</h5>
                    <p class="text-muted small mb-0">
                        <span class="badge bg-warning-soft text-warning">
                            <?= $pengaduan_baru ?? 0 ?> belum diproses
                        </span>
                    </p>
                </div>
            </div>

            <!-- Permohonan Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="feature-card bounce-in" style="animation-delay: 0.1s">
                    <div class="icon bg-success">
                        <i class="bi bi-file-earmark-text-fill text-white"></i>
                    </div>
                    <h3 class="h2 mb-2 text-success fw-bold">
                        <?= $total_permohonan ?? 0 ?>
                    </h3>
                    <h5 class="mb-1">Total Permohonan</h5>
                    <p class="text-muted small mb-0">
                        <span class="badge bg-success-soft text-success">
                            <?= $permohonan_baru ?? 0 ?> dalam proses
                        </span>
                    </p>
                </div>
            </div>

            <!-- Berita Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="feature-card bounce-in" style="animation-delay: 0.2s">
                    <div class="icon bg-info">
                        <i class="bi bi-newspaper text-white"></i>
                    </div>
                    <h3 class="h2 mb-2 text-info fw-bold">
                        <?= count($berita_terbaru ?? []) ?>
                    </h3>
                    <h5 class="mb-1">Berita Terbaru</h5>
                    <p class="text-muted small mb-0">Informasi terkini</p>
                </div>
            </div>

            <!-- Warga Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="feature-card bounce-in" style="animation-delay: 0.3s">
                    <div class="icon bg-primary">
                        <i class="bi bi-people-fill text-white"></i>
                    </div>
                    <h3 class="h2 mb-2 text-primary fw-bold">24/7</h3>
                    <h5 class="mb-1">Pelayanan Online</h5>
                    <p class="text-muted small mb-0">Selalu siap melayani</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Features Section -->
<section class="py-5 bg-gray-50">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold mb-3 text-balance">Layanan Unggulan Kami</h2>
                <p class="lead text-muted mb-0 text-balance">
                    Platform digital terintegrasi untuk memudahkan pelayanan masyarakat Kembangan Raya
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Pengaduan Masyarakat -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mb-4">
                            <div class="icon-circle bg-warning">
                                <i class="bi bi-exclamation-triangle-fill display-4 text-white"></i>
                            </div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Pengaduan Masyarakat</h4>
                        <p class="card-text text-muted mb-4 text-balance">
                            Sampaikan keluhan, aspirasi, dan saran Anda secara online dengan mudah.
                            Tracking status real-time dan notifikasi otomatis.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="/pengaduan" class="btn btn-warning">
                                <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan
                            </a>
                            <a href="/pengaduan" class="btn btn-outline-warning">
                                <i class="bi bi-list me-1"></i>Lihat Status
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layanan Administrasi -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mb-4">
                            <div class="icon-circle bg-success">
                                <i class="bi bi-file-earmark-text-fill display-4 text-white"></i>
                            </div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Layanan Administrasi</h4>
                        <p class="card-text text-muted mb-4 text-balance">
                            Ajukan berbagai permohonan layanan administrasi seperti surat keterangan,
                            rekomendasi, dan dokumen resmi lainnya.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="/layanan" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Ajukan Permohonan
                            </a>
                            <a href="/layanan" class="btn btn-outline-success">
                                <i class="bi bi-info-circle me-1"></i>Jenis Layanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berita & Informasi -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mb-4">
                            <div class="icon-circle bg-info">
                                <i class="bi bi-newspaper display-4 text-white"></i>
                            </div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Berita & Informasi</h4>
                        <p class="card-text text-muted mb-4 text-balance">
                            Dapatkan informasi terbaru tentang kegiatan pemerintah, pengumuman,
                            dan berita penting dari Kembangan Raya.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="/berita" class="btn btn-info">
                                <i class="bi bi-newspaper me-1"></i>Baca Berita
                            </a>
                            <a href="/berita" class="btn btn-outline-info">
                                <i class="bi bi-calendar-event me-1"></i>Agenda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3 text-balance">Berita Terbaru</h2>
                <p class="lead text-muted mb-0 text-balance">
                    Informasi terkini dan pengumuman penting dari Pemerintah Kembangan Raya
                </p>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($berita_terbaru ?? [])): ?>
                <?php foreach (array_slice($berita_terbaru, 0, 3) as $index => $berita): ?>
                    <div class="col-lg-4 col-md-6 slide-in" style="animation-delay: <?= $index * 0.1 ?>s">
                        <div class="card h-100 border-0 shadow-lg hover-lift">
                            <!-- News Image -->
                            <div class="card-img-wrapper">
                                <?php if (!empty($berita['gambar'])): ?>
                                    <img src="<?= $berita['gambar'] ?>"
                                         alt="<?= $berita['judul'] ?>"
                                         class="card-img-top"
                                         style="height: 200px; object-fit: cover;"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="bi bi-newspaper display-4 text-white"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Meta Information -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($berita['published_at'] ?? $berita['created_at'])) ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>
                                        <?= number_format($berita['views'] ?? 0) ?>
                                    </small>
                                </div>

                                <!-- Title -->
                                <h5 class="card-title fw-bold mb-3 line-clamp-2">
                                    <a href="/berita/<?= $berita['slug'] ?? '#' ?>" class="text-decoration-none text-dark hover-primary">
                                        <?= $berita['judul'] ?>
                                    </a>
                                </h5>

                                <!-- Excerpt -->
                                <p class="card-text text-muted flex-grow-1 mb-3 line-clamp-3">
                                    <?= $berita['excerpt'] ?? substr(strip_tags($berita['isi'] ?? ''), 0, 120) . '...' ?>
                                </p>

                                <!-- Read More Button -->
                                <a href="/berita/<?= $berita['slug'] ?? '#' ?>" class="btn btn-outline-primary mt-auto">
                                    <i class="bi bi-arrow-right me-1"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="icon-circle bg-light mx-auto mb-4">
                            <i class="bi bi-newspaper display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Berita</h4>
                        <p class="text-muted">Berita terbaru akan segera dipublikasikan oleh pemerintah.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- View All News Button -->
        <?php if (!empty($berita_terbaru ?? [])): ?>
            <div class="text-center mt-5">
                <a href="/berita" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-grid me-2"></i>Lihat Semua Berita
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3 text-balance">Bergabunglah Bersama Kami</h2>
                <p class="lead mb-4 text-balance">
                    Daftar sebagai warga untuk mengakses semua layanan digital yang tersedia.
                    Mudah, cepat, dan aman untuk semua kebutuhan administrasi Anda.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/register" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Akun
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg px-4 scroll-to-top">
                        <i class="bi bi-info-circle me-2"></i>Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="floating-icon">
                    <i class="bi bi-shield-check display-1 text-white-50"></i>
                </div>
                <p class="small text-white-75 mt-3">Data Anda aman dan terlindungi</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-5 bg-gray-50">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3 text-balance">Mengapa Memilih Sistem Kami?</h2>
                <p class="lead text-muted mb-0 text-balance">
                    Teknologi modern untuk pelayanan publik yang lebih baik
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning display-4"></i>
                    </div>
                    <h5 class="fw-bold">Cepat & Efisien</h5>
                    <p class="text-muted small">Proses pengajuan dalam hitungan menit</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-shield-check-fill text-success display-4"></i>
                    </div>
                    <h5 class="fw-bold">Aman & Terpercaya</h5>
                    <p class="text-muted small">Data terenkripsi dengan standar keamanan tinggi</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-eye-fill text-info display-4"></i>
                    </div>
                    <h5 class="fw-bold">Transparan</h5>
                    <p class="text-muted small">Tracking status real-time untuk semua pengajuan</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-headset-fill text-primary display-4"></i>
                    </div>
                    <h5 class="fw-bold">Dukungan 24/7</h5>
                    <p class="text-muted small">Bantuan teknis kapan saja dibutuhkan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Custom Modern UI Styles */
.min-vh-75 {
    min-height: 75vh;
}

.animate-bounce {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.scroll-indicator {
    animation: bounce 2s infinite;
    cursor: pointer;
}

.feature-card {
    background: var(--white);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    text-align: center;
    transition: all var(--transition-normal);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-light);
}

.feature-card .icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content-center: center;
    margin: 0 auto var(--spacing-lg);
    box-shadow: var(--shadow-lg);
    color: var(--white);
    font-size: 2rem;
}

.icon-wrapper {
    position: relative;
}

.icon-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.icon-circle::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    border-radius: 50%;
}

.hover-lift {
    transition: all var(--transition-normal);
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.hover-primary:hover {
    color: var(--primary-color) !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.floating-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.feature-icon {
    transition: transform var(--transition-normal);
}

.feature-icon:hover {
    transform: scale(1.1);
}

/* Background gradients */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
}

.bg-warning-soft {
    background: rgba(245, 158, 11, 0.1);
    color: #92400e;
}

.bg-success-soft {
    background: rgba(5, 150, 105, 0.1);
    color: #065f46;
}

/* Card image wrapper */
.card-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
}

.card-img-wrapper img {
    transition: transform var(--transition-normal);
}

.card-img-wrapper:hover img {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: var(--spacing-2xl) 0;
    }

    .min-vh-75 {
        min-height: 60vh;
    }

    .display-3 {
        font-size: 2.5rem;
    }

    .display-4 {
        font-size: 2rem;
    }

    .btn-lg {
        padding: var(--spacing-md) var(--spacing-xl);
        font-size: 1rem;
    }

    .gap-3 {
        gap: var(--spacing-md) !important;
    }
}

@media (max-width: 480px) {
    .display-3 {
        font-size: 2rem;
    }

    .lead {
        font-size: 1.1rem;
    }

    .btn {
        width: 100%;
        margin-bottom: var(--spacing-sm);
    }

    .d-flex.gap-3 {
        flex-direction: column;
        gap: var(--spacing-sm) !important;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
        }
    });
}, observerOptions);

// Observe elements for animation
document.querySelectorAll('.fade-in, .slide-in, .bounce-in').forEach(el => {
    observer.observe(el);
});

// Auto-show success/error messages
<?php if (session()->has('success')): ?>
document.addEventListener('DOMContentLoaded', function() {
    // Show success toast
    showToast('success', '<?= session('success') ?>');
});
<?php endif; ?>

<?php if (session()->has('error')): ?>
document.addEventListener('DOMContentLoaded', function() {
    // Show error toast
    showToast('error', '<?= session('error') ?>');
});
<?php endif; ?>

function showToast(type, message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.setAttribute('role', 'alert');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}
</script>
<?= $this->endSection() ?>
