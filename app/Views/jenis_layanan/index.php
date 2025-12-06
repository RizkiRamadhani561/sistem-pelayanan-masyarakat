<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section bg-primary text-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-file-earmark-text-fill me-3"></i>
                    Layanan Administrasi
                </h1>
                <p class="lead mb-4">
                    Permohonan layanan administrasi kependudukan secara online untuk memudahkan masyarakat Kembangan Raya dalam mengurus berbagai dokumen dan surat menyurat.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-fill text-warning me-2 fs-5"></i>
                        <span>Proses Cepat (1-5 hari)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-check-fill text-success me-2 fs-5"></i>
                        <span>Proses Aman & Legal</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-house-door-fill text-info me-2 fs-5"></i>
                        <span>Online dari Rumah</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white rounded-circle p-4 d-inline-block shadow-lg">
                    <i class="bi bi-file-earmark-text text-primary fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" id="searchInput"
                                       placeholder="Cari jenis layanan...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select bg-light border-0" id="sortSelect">
                                <option value="nama">Urutkan: Nama Layanan</option>
                                <option value="estimasi">Urutkan: Waktu Proses</option>
                                <option value="populer">Urutkan: Paling Diminta</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="row g-4" id="servicesContainer">
        <?php if (!empty($jenis_layanan)): ?>
            <?php foreach ($jenis_layanan as $layanan): ?>
                <div class="col-lg-4 col-md-6 service-card" data-service-id="<?= $layanan['id_jenis'] ?>">
                    <div class="card h-100 border-0 shadow-hover card-hover">
                        <div class="card-header bg-gradient-primary text-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold fs-6">
                                    <i class="bi bi-tag-fill me-2"></i>
                                    <?= $layanan['kode'] ?>
                                </div>
                                <div class="badge bg-white text-primary">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= $layanan['estimasi_hari'] ?> hari
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="service-icon mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                    <i class="bi bi-file-earmark-text text-primary fs-2"></i>
                                </div>
                            </div>

                            <h5 class="card-title fw-bold text-dark mb-3">
                                <?= $layanan['nama_pelayanan'] ?>
                            </h5>

                            <p class="card-text text-muted mb-3">
                                <?= $layanan['deskripsi'] ?? 'Layanan administrasi kependudukan untuk keperluan resmi.' ?>
                            </p>

                            <!-- Requirements Preview -->
                            <div class="mb-3">
                                <small class="text-muted fw-semibold">
                                    <i class="bi bi-list-check me-1"></i>Syarat:
                                </small>
                                <div class="small text-muted mt-1">
                                    <?php
                                    $syarat = explode(',', $layanan['syarat']);
                                    echo implode(' • ', array_slice($syarat, 0, 2));
                                    if (count($syarat) > 2) echo ' • ...';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-0 p-3">
                            <div class="d-flex gap-2">
                                <a href="/layanan/<?= $layanan['id_jenis'] ?>"
                                   class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-eye me-1"></i>Lihat Detail
                                </a>
                                <a href="/layanan/<?= $layanan['id_jenis'] ?>/ajukan"
                                   class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-plus-circle me-1"></i>Ajukan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-file-earmark-x text-muted fs-1"></i>
                    </div>
                    <h4 class="text-muted">Belum ada layanan tersedia</h4>
                    <p class="text-muted">Saat ini belum ada jenis layanan yang dapat diajukan secara online.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Information Cards -->
    <div class="row mt-5 g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                        <i class="bi bi-check-circle-fill text-success fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Proses Mudah</h6>
                    <p class="text-muted small mb-0">
                        Pengajuan layanan dapat dilakukan kapan saja tanpa harus datang ke kantor.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                        <i class="bi bi-clock-fill text-info fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Proses Cepat</h6>
                    <p class="text-muted small mb-0">
                        Dokumen diproses dalam waktu 1-5 hari kerja setelah semua persyaratan lengkap.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                        <i class="bi bi-shield-check-fill text-warning fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Aman & Terpercaya</h6>
                    <p class="text-muted small mb-0">
                        Semua data terlindungi dan proses verifikasi dilakukan oleh petugas berwenang.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 text-center">
                        <i class="bi bi-question-circle-fill text-primary me-2"></i>
                        Pertanyaan Umum
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light border-0 fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Bagaimana cara mengajukan permohonan layanan?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Pilih jenis layanan yang diinginkan, klik "Ajukan", lengkapi formulir dan upload dokumen persyaratan, kemudian klik kirim.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light border-0 fw-semibold collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Berapa lama proses pengajuan layanan?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Setiap jenis layanan memiliki estimasi waktu yang berbeda, mulai dari 1-5 hari kerja tergantung kompleksitasnya.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light border-0 fw-semibold collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bagaimana cara melacak status permohonan?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Status permohonan dapat dilihat di menu "Permohonan Saya" setelah login. Anda juga akan menerima notifikasi perubahan status.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.shadow-hover {
    transition: all 0.3s ease;
}

.shadow-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.service-card {
    opacity: 1;
    transition: opacity 0.3s ease;
}

.service-card.hidden {
    opacity: 0;
    pointer-events: none;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    min-height: 50vh;
    display: flex;
    align-items: center;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1000" height="1000" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

@media (max-width: 768px) {
    .hero-section {
        min-height: auto;
        padding: 3rem 0;
        text-align: center;
    }

    .service-card {
        margin-bottom: 2rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const serviceCards = document.querySelectorAll('.service-card');

    serviceCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-text').textContent.toLowerCase();
        const kode = card.querySelector('.badge').textContent.toLowerCase();

        if (title.includes(searchTerm) || description.includes(searchTerm) || kode.includes(searchTerm)) {
            card.style.display = 'block';
            card.classList.remove('hidden');
        } else {
            card.style.display = 'none';
            card.classList.add('hidden');
        }
    });
});

// Sort functionality
document.getElementById('sortSelect').addEventListener('change', function() {
    const sortBy = this.value;
    const container = document.getElementById('servicesContainer');
    const cards = Array.from(container.querySelectorAll('.service-card'));

    cards.sort((a, b) => {
        switch(sortBy) {
            case 'nama':
                return a.querySelector('.card-title').textContent.localeCompare(
                    b.querySelector('.card-title').textContent
                );
            case 'estimasi':
                const estimasiA = parseInt(a.querySelector('.badge').textContent);
                const estimasiB = parseInt(b.querySelector('.badge').textContent);
                return estimasiA - estimasiB;
            case 'populer':
                // For now, sort by name as we don't have popularity data
                return a.querySelector('.card-title').textContent.localeCompare(
                    b.querySelector('.card-title').textContent
                );
            default:
                return 0;
        }
    });

    // Reorder cards in container
    cards.forEach(card => container.appendChild(card));
});

// Lazy loading animation
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    });

    serviceCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
});
</script>
<?= $this->endSection() ?>
