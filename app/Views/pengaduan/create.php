<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">

            <!-- Card utama -->
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Buat Pengaduan Baru
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">
                        Sampaikan keluhan atau aspirasi Anda kepada pemerintah
                    </p>
                </div>

                <div class="card-body p-4 p-lg-5">

                    <!-- Flash Message -->
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session('success') ?>
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session('error') ?>
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="/pengaduan/store" method="post" enctype="multipart/form-data" id="pengaduanForm">
                        <?= csrf_field() ?>

                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="judul">
                                <i class="bi bi-tag-fill me-1"></i>Judul Pengaduan <span class="text-danger">*</span>
                            </label>

                            <input 
                                type="text"
                                class="form-control form-control-lg <?= isset($errors['judul']) ? 'is-invalid' : '' ?>"
                                id="judul"
                                name="judul"
                                placeholder="Contoh: Jalan rusak di depan rumah"
                                value="<?= old('judul') ?>"
                                required
                            >

                            <div class="form-text">Berikan judul yang jelas dan singkat</div>

                            <?php if (isset($errors['judul'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['judul'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Isi Pengaduan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="isi_pengaduan">
                                <i class="bi bi-textarea-resize me-1"></i>Isi Pengaduan <span class="text-danger">*</span>
                            </label>

                            <textarea
                                class="form-control form-control-lg <?= isset($errors['isi_pengaduan']) ? 'is-invalid' : '' ?>"
                                id="isi_pengaduan"
                                name="isi_pengaduan"
                                rows="6"
                                placeholder="Jelaskan secara detail..."
                                required><?= old('isi_pengaduan') ?></textarea>

                            <div class="form-text">Jelaskan masalah secara detail</div>

                            <?php if (isset($errors['isi_pengaduan'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['isi_pengaduan'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="lokasi">
                                <i class="bi bi-geo-alt-fill me-1"></i>Lokasi Kejadian
                            </label>

                            <input
                                type="text"
                                class="form-control form-control-lg <?= isset($errors['lokasi']) ? 'is-invalid' : '' ?>"
                                id="lokasi"
                                name="lokasi"
                                placeholder="Contoh: Jl. Sudirman No. 123"
                                value="<?= old('lokasi') ?>"
                            >

                            <div class="form-text">Sebutkan alamat lengkap</div>

                            <?php if (isset($errors['lokasi'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['lokasi'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-4">
                            <label class="form-label fw-bold" for="lampiran">
                                <i class="bi bi-paperclip me-1"></i>Lampiran (Opsional)
                            </label>

                            <input
                                type="file"
                                class="form-control form-control-lg <?= isset($errors['lampiran']) ? 'is-invalid' : '' ?>"
                                id="lampiran"
                                name="lampiran"
                                accept=".jpg,.jpeg,.png,.pdf"
                            >

                            <div class="form-text">Maksimal 2MB. Format: JPG, PNG, PDF</div>

                            <?php if (isset($errors['lampiran'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['lampiran'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi Penting:</strong>
                            <ul class="mt-2 mb-0">
                                <li>Diproses dalam 3–5 hari</li>
                                <li>Anda akan mendapat notifikasi status</li>
                                <li>Pastikan data akurat</li>
                                <li>Pengaduan anonim tidak diproses</li>
                            </ul>
                        </div>

                        <!-- Tombol -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/pengaduan" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i>Batal
                            </a>

                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-send-fill me-2"></i>Kirim Pengaduan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- User Info -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm text-center p-3">
                        <div class="text-primary mb-2">
                            <i class="bi bi-person-circle display-4"></i>
                        </div>

                        <h6 class="mb-1">Pengaduan dari:</h6>
                        <strong class="text-primary">
                            <?= session('warga')['nama_lengkap'] ?>
                        </strong>

                        <br>
                        <small class="text-muted">
                            NIK: <?= session('warga')['nik'] ?>
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>


<!-- Scripts -->
<?= $this->section('scripts') ?>
<script>

// Hitung karakter textarea
document.getElementById('isi_pengaduan').addEventListener('input', function() {
    const max = 1000;
    let counter = this.parentNode.querySelector('.char-counter');

    if (!counter) {
        counter = document.createElement('small');
        counter.className = 'char-counter text-muted form-text';
        this.parentNode.appendChild(counter);
    }

    counter.textContent = `${this.value.length}/${max} karakter`;

    counter.classList.toggle('text-warning', this.value.length > max * 0.9);
});

// Validasi file
document.getElementById('lampiran').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const maxSize = 2 * 1024 * 1024;
    const allowed = ['image/jpeg', 'image/png', 'application/pdf'];

    if (file.size > maxSize) {
        alert('Ukuran file maksimal 2MB.');
        this.value = "";
    }

    if (!allowed.includes(file.type)) {
        alert('Format tidak didukung. Gunakan JPG, PNG, atau PDF.');
        this.value = "";
    }
});

// Validasi submit
document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
    let valid = true;

    const title = document.getElementById('judul');
    const isi = document.getElementById('isi_pengaduan');

    if (title.value.trim().length < 5) {
        valid = false;
        title.classList.add('is-invalid');
    }

    if (isi.value.trim().length < 10) {
        valid = false;
        isi.classList.add('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        document.querySelector('.is-invalid').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Auto-focus
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('judul').focus();
});

</script>
<?= $this->endSection() ?>
