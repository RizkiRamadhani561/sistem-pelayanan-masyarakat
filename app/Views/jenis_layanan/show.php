<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-3">
                        <li class="breadcrumb-item">
                            <a href="/" class="text-white text-decoration-none">
                                <i class="bi bi-house-door me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/layanan" class="text-white text-decoration-none">Layanan</a>
                        </li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">
                            <?= $layanan['nama_pelayanan'] ?>
                        </li>
                    </ol>
                </nav>

                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3 me-3">
                        <i class="bi bi-file-earmark-text fs-2"></i>
                    </div>
                    <div>
                        <h1 class="h2 mb-1 fw-bold"><?= $layanan['nama_pelayanan'] ?></h1>
                        <div class="badge bg-white text-primary fs-6 px-3 py-1">
                            <i class="bi bi-tag-fill me-1"></i>
                            <?= $layanan['kode'] ?>
                        </div>
                    </div>
                </div>

                <p class="lead mb-4">
                    <?= $layanan['deskripsi'] ?? 'Layanan administrasi kependudukan untuk keperluan resmi.' ?>
                </p>

                <div class="d-flex flex-wrap gap-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-fill text-warning me-2 fs-5"></i>
                        <div>
                            <div class="fw-bold">Estimasi Proses</div>
                            <small class="text-white-50"><?= $layanan['estimasi_hari'] ?> hari kerja</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-check-fill text-success me-2 fs-5"></i>
                        <div>
                            <div class="fw-bold">Status</div>
                            <small class="text-white-50">
                                <?= $layanan['aktif'] ? 'Aktif' : 'Tidak Aktif' ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center">
                <div class="card bg-white shadow-lg border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title text-dark mb-3">Ajukan Permohonan</h5>
                        <?php if (session()->has('warga')): ?>
                            <?php if (!$sudah_mengajukan): ?>
                                <a href="/layanan/<?= $layanan['id_jenis'] ?>/ajukan"
                                   class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Ajukan Sekarang
                                </a>
                            <?php else: ?>
                                <button class="btn btn-success btn-lg w-100 mb-2" disabled>
                                    <i class="bi bi-check-circle me-2"></i>
                                    Sudah Mengajukan
                                </button>
                                <small class="text-muted">Anda memiliki permohonan yang sedang diproses</small>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="/login" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Login untuk Mengajukan
                            </a>
                            <small class="text-muted">Diperlukan akun warga untuk mengajukan layanan</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row g-4">
        <!-- Service Details -->
        <div class="col-lg-8">
            <!-- Requirements Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Persyaratan Dokumen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php
                        $syarat = explode(',', $layanan['syarat']);
                        foreach ($syarat as $index => $item):
                        ?>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 mt-1">
                                        <i class="bi bi-check-circle-fill text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">
                                            <?= trim($item) ?>
                                        </div>
                                        <small class="text-muted">Dokumen wajib disertakan</small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Penting:</strong> Pastikan semua dokumen dalam kondisi baik, terbaca jelas, dan masih berlaku. Dokumen yang tidak lengkap akan mengakibatkan penolakan permohonan.
                    </div>
                </div>
            </div>

            <!-- Process Flow -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark">
                        <i class="bi bi-diagram-3 text-primary me-2"></i>
                        Alur Proses Pengajuan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="process-timeline">
                        <div class="process-step">
                            <div class="step-number bg-primary text-white">1</div>
                            <div class="step-content">
                                <h6 class="text-dark mb-1">Pengajuan Online</h6>
                                <p class="text-muted small mb-0">Lengkapi formulir dan upload dokumen persyaratan</p>
                            </div>
                        </div>

                        <div class="process-step">
                            <div class="step-number bg-warning text-white">2</div>
                            <div class="step-content">
                                <h6 class="text-dark mb-1">Verifikasi Dokumen</h6>
                                <p class="text-muted small mb-0">Petugas memverifikasi kelengkapan dan keabsahan dokumen</p>
                            </div>
                        </div>

                        <div class="process-step">
                            <div class="step-number bg-info text-white">3</div>
                            <div class="step-content">
                                <h6 class="text-dark mb-1">Proses Administrasi</h6>
                                <p class="text-muted small mb-0">Pembuatan dokumen sesuai jenis layanan yang diajukan</p>
                            </div>
                        </div>

                        <div class="process-step">
                            <div class="step-number bg-success text-white">4</div>
                            <div class="step-content">
                                <h6 class="text-dark mb-1">Pengambilan Dokumen</h6>
                                <p class="text-muted small mb-0">Dokumen siap diambil atau dikirim sesuai pilihan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-clock text-primary fs-4 me-3"></i>
                                <div>
                                    <h6 class="text-dark mb-1">Waktu Proses</h6>
                                    <p class="text-muted small mb-0">
                                        Dokumen diproses dalam <?= $layanan['estimasi_hari'] ?> hari kerja setelah semua persyaratan lengkap.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-cash text-success fs-4 me-3"></i>
                                <div>
                                    <h6 class="text-dark mb-1">Biaya</h6>
                                    <p class="text-muted small mb-0">
                                        Biaya administrasi sesuai dengan Peraturan Daerah yang berlaku.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-telephone text-info fs-4 me-3"></i>
                                <div>
                                    <h6 class="text-dark mb-1">Kontak</h6>
                                    <p class="text-muted small mb-0">
                                        Untuk informasi lebih lanjut, hubungi kantor kelurahan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-shield-check text-warning fs-4 me-3"></i>
                                <div>
                                    <h6 class="text-dark mb-1">Keamanan Data</h6>
                                    <p class="text-muted small mb-0">
                                        Semua data pribadi dijamin kerahasiaannya sesuai UU PDP.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('warga')): ?>
                        <?php if (!$sudah_mengajukan): ?>
                            <a href="/layanan/<?= $layanan['id_jenis'] ?>/ajukan"
                               class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-plus-circle me-2"></i>
                                Ajukan Permohonan
                            </a>
                        <?php else: ?>
                            <button class="btn btn-success w-100 mb-2" disabled>
                                <i class="bi bi-check-circle me-2"></i>
                                Permohonan Aktif
                            </button>
                        <?php endif; ?>

                        <a href="/permohonan" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-list-check me-2"></i>
                            Lihat Permohonan Saya
                        </a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login untuk Mengajukan
                        </a>
                        <a href="/register" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus me-2"></i>
                            Daftar Akun Baru
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        Butuh Bantuan?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone-fill text-primary fs-4 me-3"></i>
                        <div>
                            <div class="fw-semibold">Telepon</div>
                            <small class="text-muted">(021) 123-4567</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-envelope-fill text-primary fs-4 me-3"></i>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <small class="text-muted">info@kembanganraya.go.id</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill text-primary fs-4 me-3"></i>
                        <div>
                            <div class="fw-semibold">Alamat</div>
                            <small class="text-muted">Jl. Raya Kembangan No. 123</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Services -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-arrow-right-circle me-2"></i>
                        Layanan Lainnya
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="/layanan" class="list-group-item list-group-item-action px-0">
                            <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                            Semua Layanan
                        </a>
                        <a href="/pengaduan" class="list-group-item list-group-item-action px-0">
                            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                            Pengaduan Masyarakat
                        </a>
                        <a href="/" class="list-group-item list-group-item-action px-0">
                            <i class="bi bi-house-door me-2 text-info"></i>
                            Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.process-timeline {
    position: relative;
    padding-left: 40px;
}

.process-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #007bff, #28a745);
}

.process-step {
    position: relative;
    margin-bottom: 30px;
}

.process-step:last-child {
    margin-bottom: 0;
}

.step-number {
    position: absolute;
    left: -25px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.step-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

@media (max-width: 768px) {
    .process-timeline {
        padding-left: 30px;
    }

    .process-timeline::before {
        left: 15px;
    }

    .step-number {
        left: -20px;
        width: 30px;
        height: 30px;
        font-size: 14px;
    }

    .step-content {
        padding: 15px;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Smooth scroll for anchor links
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

// Add loading animation to buttons
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (this.href && !this.disabled) {
            this.innerHTML = '<i class="bi bi-arrow-clockwise bi-spin me-2"></i>Memuat...';
            this.disabled = true;
        }
    });
});
</script>
<?= $this->endSection() ?>
