<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="bi bi-eye text-primary me-2"></i>
                                Detail Pengaduan
                            </h4>
                            <small class="text-muted">ID: #<?= str_pad($pengaduan['id_pengaduan'], 5, '0', STR_PAD_LEFT) ?></small>
                        </div>
                        <div>
                            <a href="/pengaduan" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        <span class="badge fs-6 px-3 py-2 status-badge status-<?= $pengaduan['status'] ?>">
                            <i class="bi bi-circle-fill me-1"></i>
                            <?= ucfirst($pengaduan['status']) ?>
                        </span>
                    </div>

                    <!-- Pengaduan Details -->
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h5 class="text-primary mb-2">
                                    <i class="bi bi-tag-fill me-2"></i>
                                    <?= $pengaduan['judul'] ?>
                                </h5>
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar me-1"></i>
                                    Dibuat: <?= date('d F Y H:i', strtotime($pengaduan['created_at'])) ?>
                                    <?php if ($pengaduan['updated_at'] != $pengaduan['created_at']): ?>
                                        | Diupdate: <?= date('d F Y H:i', strtotime($pengaduan['updated_at'])) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="content-text">
                                    <?= nl2br($pengaduan['isi_pengaduan']) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <?php if (!empty($pengaduan['lokasi'])): ?>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-info mb-2">
                                        <i class="bi bi-geo-alt-fill me-1"></i>Lokasi Kejadian
                                    </h6>
                                    <p class="mb-0 text-muted">
                                        <?= $pengaduan['lokasi'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Lampiran -->
                        <?php if (!empty($pengaduan['lampiran'])): ?>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-success mb-2">
                                        <i class="bi bi-paperclip me-1"></i>Lampiran
                                    </h6>
                                    <a href="/<?= $pengaduan['lampiran'] ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye me-1"></i>Lihat Lampiran
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Warga Info -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-primary mb-2">
                                    <i class="bi bi-person-fill me-1"></i>Pelapor
                                </h6>
                                <div class="text-muted small">
                                    <strong class="text-dark"><?= $warga['nama_lengkap'] ?></strong><br>
                                    NIK: <?= $warga['nik'] ?><br>
                                    Alamat: <?= $warga['alamat'] ?><br>
                                    Kontak: <?= $warga['no_hp'] ?? 'Tidak tersedia' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Petugas Info -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-warning mb-2">
                                    <i class="bi bi-person-badge-fill me-1"></i>Penanggung Jawab
                                </h6>
                                <?php if ($petugas): ?>
                                    <div class="text-muted small">
                                        <strong class="text-dark"><?= $petugas['nama'] ?></strong><br>
                                        Role: <?= ucfirst($petugas['role']) ?><br>
                                        Kontak: <?= $petugas['phone'] ?? 'Tidak tersedia' ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted">
                                        <em>Belum ditugaskan</em>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Catatan Petugas -->
                        <?php if (!empty($pengaduan['catatan'])): ?>
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-secondary mb-2">
                                        <i class="bi bi-chat-quote-fill me-1"></i>Catatan Petugas
                                    </h6>
                                    <div class="text-muted">
                                        <?= nl2br($pengaduan['catatan']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="/pengaduan" class="btn btn-outline-secondary">
                                    <i class="bi bi-list me-1"></i>Daftar Pengaduan
                                </a>

                                <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
                                    <a href="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>/edit" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil me-1"></i>Update Status
                                    </a>
                                <?php endif; ?>

                                <?php if (session()->has('warga') && session('warga')['id_warga'] == $pengaduan['warga_id']): ?>
                                    <button type="button" class="btn btn-outline-info" onclick="printPengaduan()">
                                        <i class="bi bi-printer me-1"></i>Print
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-timeline me-2"></i>Riwayat Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Dibuat</h6>
                                <p class="timeline-text mb-0">
                                    Pengaduan berhasil diajukan pada <?= date('d F Y H:i', strtotime($pengaduan['created_at'])) ?>
                                </p>
                                <small class="text-muted">Status: Baru</small>
                            </div>
                        </div>

                        <?php if ($pengaduan['status'] != 'baru'): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Status Diubah</h6>
                                    <p class="timeline-text mb-0">
                                        Status pengaduan diubah menjadi "<?= ucfirst($pengaduan['status']) ?>" pada <?= date('d F Y H:i', strtotime($pengaduan['updated_at'])) ?>
                                    </p>
                                    <small class="text-muted">
                                        Oleh: <?= $petugas ? $petugas['nama'] : 'Sistem' ?>
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($pengaduan['status'] == 'selesai'): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Pengaduan Selesai</h6>
                                    <p class="timeline-text mb-0">
                                        Pengaduan telah diselesaikan dan ditutup
                                    </p>
                                    <small class="text-muted">Terima kasih atas partisipasi Anda</small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-text {
    line-height: 1.6;
    white-space: pre-wrap;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.timeline-title {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.timeline-text {
    color: #6c757d;
    font-size: 0.875rem;
}

@media print {
    .btn, .card-header, .timeline::before {
        display: none !important;
    }

    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }

    .timeline-item {
        break-inside: avoid;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function printPengaduan() {
    window.print();
}

// Auto-refresh for real-time updates (optional)
<?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
    setInterval(function() {
        // Could add AJAX call to check for status updates
    }, 30000);
<?php endif; ?>
</script>
<?= $this->endSection() ?>
