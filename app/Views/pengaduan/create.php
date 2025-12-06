<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Buat Pengaduan Baru
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">Sampaikan keluhan atau aspirasi Anda kepada pemerintah</p>
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

                    <form action="/pengaduan/store" method="post" enctype="multipart/form-data" id="pengaduanForm">
                        <?= csrf_field() ?>

                        <!-- Judul Pengaduan -->
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">
                                <i class="bi bi-tag-fill me-1"></i>Judul Pengaduan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                                   id="judul" name="judul" placeholder="Contoh: Jalan rusak di depan rumah"
                                   value="<?= old('judul') ?>" required>
                            <div class="form-text">Berikan judul yang jelas dan singkat untuk pengaduan Anda</div>
                            <?php if (isset($errors['judul'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['judul'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Isi Pengaduan -->
                        <div class="mb-3">
                            <label for="isi_pengaduan" class="form-label fw-bold">
                                <i class="bi bi-textarea-resize me-1"></i>Isi Pengaduan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control form-control-lg <?= (isset($errors['isi_pengaduan'])) ? 'is-invalid' : '' ?>"
                                      id="isi_pengaduan" name="isi_pengaduan" rows="6"
                                      placeholder="Jelaskan secara detail keluhan atau aspirasi Anda..." required><?= old('isi_pengaduan') ?></textarea>
                            <div class="form-text">Jelaskan masalah yang Anda hadapi dengan detail, termasuk waktu kejadian dan dampaknya</div>
                            <?php if (isset($errors['isi_pengaduan'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['isi_pengaduan'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Lokasi Kejadian -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label fw-bold">
                                <i class="bi bi-geo-alt-fill me-1"></i>Lokasi Kejadian
                            </label>
                            <input type="text" class="form-control form-control-lg <?= (isset($errors['lokasi'])) ? 'is-invalid' : '' ?>"
                                   id="lokasi" name="lokasi" placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02"
                                   value="<?= old('lokasi') ?>">
                            <div class="form-text">Sebutkan alamat lengkap lokasi kejadian atau keluhan</div>
                            <?php if (isset($errors['lokasi'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['lokasi'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Lampiran File -->
                        <div class="mb-4">
                            <label for="lampiran" class="form-label fw-bold">
                                <i class="bi bi-paperclip me-1"></i>Lampiran (Opsional)
                            </label>
                            <input type="file" class="form-control form-control-lg <?= (isset($errors['lampiran'])) ? 'is-invalid' : '' ?>"
                                   id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">
                                Upload foto atau dokumen pendukung (JPG, PNG, PDF - maksimal 2MB)
                            </div>
                            <?php if (isset($errors['lampiran'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['lampiran'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi Penting:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pengaduan akan diproses dalam 3-5 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika status berubah</li>
                                <li>Pastikan data yang Anda berikan akurat dan dapat dipertanggungjawabkan</li>
                                <li>Pengaduan anonim tidak akan diproses</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/pengaduan" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-send-fill me-2"></i>
                                Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Info -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="bi bi-person-circle display-4"></i>
                            </div>
                            <h6 class="mb-1">Pengaduan dari:</h6>
                            <strong class="text-primary"><?= session('warga')['nama_lengkap'] ?></strong>
                            <br>
                            <small class="text-muted">NIK: <?= session('warga')['nik'] ?></small>
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
// Character counter for textarea
document.getElementById('isi_pengaduan').addEventListener('input', function() {
    const maxLength = 1000;
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

// File validation
document.getElementById('lampiran').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        if (file.size > maxSize) {
            alert('File terlalu besar! Maksimal 2MB.');
            this.value = '';
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, PNG, atau PDF.');
            this.value = '';
            return;
        }
    }
});

// Form validation
document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
    const judul = document.getElementById('judul');
    const isi = document.getElementById('isi_pengaduan');

    let isValid = true;

    if (judul.value.trim().length < 5) {
        judul.classList.add('is-invalid');
        if (!judul.nextElementSibling || !judul.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Judul minimal 5 karakter';
            judul.parentNode.insertBefore(feedback, judul.nextSibling);
        }
        isValid = false;
    }

    if (isi.value.trim().length < 10) {
        isi.classList.add('is-invalid');
        if (!isi.nextElementSibling || !isi.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Isi pengaduan minimal 10 karakter';
            isi.parentNode.insertBefore(feedback, isi.nextSibling);
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

// Auto-focus on title
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('judul').focus();
});
</script>
<?= $this->endSection() ?>
