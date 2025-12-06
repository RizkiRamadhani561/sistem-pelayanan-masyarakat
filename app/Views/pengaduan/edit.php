<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Update Status Pengaduan
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">Kelola dan update status pengaduan masyarakat</p>
                </div>

                <div class="card-body p-4 p-lg-5">
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

                    <!-- Pengaduan Info -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi Pengaduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <strong>ID Pengaduan:</strong><br>
                                    <span class="text-primary">#<?= str_pad($pengaduan['id_pengaduan'], 5, '0', STR_PAD_LEFT) ?></span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Status Saat Ini:</strong><br>
                                    <span class="badge status-badge status-<?= $pengaduan['status'] ?>">
                                        <?= ucfirst($pengaduan['status']) ?>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <strong>Judul:</strong><br>
                                    <span class="text-primary fw-bold"><?= $pengaduan['judul'] ?></span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Pelapor:</strong><br>
                                    <span class="text-muted">
                                        <?= $warga ? $warga['nama_lengkap'] : 'Tidak ditemukan' ?>
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Dibuat:</strong><br>
                                    <span class="text-muted">
                                        <?= date('d F Y H:i', strtotime($pengaduan['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>/update" method="post" id="updateForm">
                        <?= csrf_field() ?>

                        <!-- Status Update -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">
                                <i class="bi bi-flag-fill me-1"></i>Update Status
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg <?= (isset($errors['status'])) ? 'is-invalid' : '' ?>"
                                    id="status" name="status" required>
                                <option value="">Pilih Status Baru</option>
                                <option value="baru" <?= ($pengaduan['status'] == 'baru') ? 'selected' : '' ?>>
                                    🔵 Baru - Pengaduan baru diterima
                                </option>
                                <option value="diproses" <?= ($pengaduan['status'] == 'diproses') ? 'selected' : '' ?>>
                                    🟡 Diproses - Sedang dalam penanganan
                                </option>
                                <option value="selesai" <?= ($pengaduan['status'] == 'selesai') ? 'selected' : '' ?>>
                                    🟢 Selesai - Pengaduan telah ditangani
                                </option>
                            </select>
                            <div class="form-text">Pilih status yang sesuai dengan progress penanganan pengaduan</div>
                            <?php if (isset($errors['status'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['status'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Catatan Petugas -->
                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-bold">
                                <i class="bi bi-chat-quote-fill me-1"></i>Catatan Petugas
                            </label>
                            <textarea class="form-control form-control-lg <?= (isset($errors['catatan'])) ? 'is-invalid' : '' ?>"
                                      id="catatan" name="catatan" rows="4"
                                      placeholder="Tambahkan catatan tentang progress penanganan, tindak lanjut, atau informasi penting lainnya..."><?= old('catatan', $pengaduan['catatan']) ?></textarea>
                            <div class="form-text">
                                Catatan ini akan terlihat oleh pelapor dan membantu tracking progress pengaduan
                            </div>
                            <?php if (isset($errors['catatan'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['catatan'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Petugas Assignment (if admin) -->
                        <?php if (session('user')['role'] == 'admin'): ?>
                            <div class="mb-4">
                                <label for="petugas_id" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i>Petugas Penanggung Jawab
                                </label>
                                <select class="form-select form-select-lg" id="petugas_id" name="petugas_id">
                                    <option value="">Pilih Petugas (Opsional)</option>
                                    <?php foreach ($petugas as $p): ?>
                                        <option value="<?= $p['id_user'] ?>" <?= ($pengaduan['petugas_id'] == $p['id_user']) ? 'selected' : '' ?>>
                                            <?= $p['nama'] ?> (<?= ucfirst($p['role']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Assign petugas yang akan menangani pengaduan ini</div>
                            </div>
                        <?php endif; ?>

                        <!-- Status Preview -->
                        <div class="alert alert-info mb-4" id="statusPreview">
                            <i class="bi bi-eye me-2"></i>
                            <strong>Preview Status:</strong>
                            <span id="statusText">Status akan diupdate setelah disimpan</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                            <a href="/pengaduan" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-4 g-3">
                <div class="col-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-primary mb-1">
                                <i class="bi bi-clock fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Dibuat</small>
                            <small class="fw-bold">
                                <?= date('d/m/Y', strtotime($pengaduan['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-warning mb-1">
                                <i class="bi bi-arrow-clockwise fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Terakhir Update</small>
                            <small class="fw-bold">
                                <?= date('d/m/Y', strtotime($pengaduan['updated_at'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-info mb-1">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Dikelola Oleh</small>
                            <small class="fw-bold">
                                <?= session('user')['nama'] ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Status change preview
document.getElementById('status').addEventListener('change', function() {
    const status = this.value;
    const statusText = document.getElementById('statusText');
    const preview = document.getElementById('statusPreview');

    if (status) {
        let statusLabel = '';
        let statusClass = '';

        switch(status) {
            case 'baru':
                statusLabel = '🔵 Baru - Pengaduan baru diterima';
                statusClass = 'alert-primary';
                break;
            case 'diproses':
                statusLabel = '🟡 Diproses - Sedang dalam penanganan';
                statusClass = 'alert-warning';
                break;
            case 'selesai':
                statusLabel = '🟢 Selesai - Pengaduan telah ditangani';
                statusClass = 'alert-success';
                break;
        }

        statusText.textContent = statusLabel;
        preview.className = `alert ${statusClass} mb-4`;
    } else {
        statusText.textContent = 'Status akan diupdate setelah disimpan';
        preview.className = 'alert alert-info mb-4';
    }
});

// Form validation
document.getElementById('updateForm').addEventListener('submit', function(e) {
    const status = document.getElementById('status');
    const catatan = document.getElementById('catatan');

    let isValid = true;

    if (!status.value) {
        status.classList.add('is-invalid');
        if (!status.nextElementSibling || !status.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Status harus dipilih';
            status.parentNode.insertBefore(feedback, status.nextSibling);
        }
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
        // Scroll to first error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

// Character counter for catatan
document.getElementById('catatan').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;

    // Add character counter if it doesn't exist
    let counter = this.parentNode.querySelector('.char-counter');
    if (!counter) {
        counter = document.createElement('small');
        counter.className = 'char-counter text-muted form-text';
        this.parentNode.appendChild(counter);
    }

    counter.textContent = `${currentLength}/${maxLength} karakter`;

    if (currentLength > maxLength * 0.9) {
        counter.classList.add('text-warning');
        counter.classList.remove('text-muted');
    } else {
        counter.classList.remove('text-warning');
        counter.classList.add('text-muted');
    }
});

// Auto-focus on status select
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('status').focus();
});
</script>
<?= $this->endSection() ?>
