<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login Warga
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">Masuk ke Sistem Pelayanan Masyarakat</p>
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

                    <form action="/login" method="post" id="loginForm">
                        <?= csrf_field() ?>

                        <!-- NIK Field -->
                        <div class="mb-4">
                            <label for="nik" class="form-label fw-bold">
                                <i class="bi bi-credit-card-2-front me-1"></i>NIK (Nomor Induk Kependudukan)
                            </label>
                            <input type="text" class="form-control form-control-lg <?= (isset($errors['nik'])) ? 'is-invalid' : '' ?>"
                                   id="nik" name="nik" maxlength="16" placeholder="Masukkan 16 digit NIK"
                                   value="<?= old('nik') ?>" required autofocus>
                            <div class="form-text">Gunakan NIK sesuai KTP untuk login</div>
                            <?php if (isset($errors['nik'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['nik'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi:</strong> Sistem ini menggunakan NIK sebagai autentikasi utama. Pastikan NIK Anda sudah terdaftar.
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Masuk
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="mb-0">Belum punya akun?
                                <a href="/register" class="text-decoration-none fw-bold text-success">Daftar di sini</a>
                            </p>
                        </div>

                        <!-- Admin Login Link (for development) -->
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Untuk admin/petugas, gunakan sistem login terpisah
                            </small>
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
                                <i class="bi bi-newspaper fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Berita</small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-warning mb-1">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Pengaduan</small>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-info mb-1">
                                <i class="bi bi-file-earmark-text fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Layanan</small>
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
// NIK input formatting
document.getElementById('nik').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 16);
});

// Form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const nik = document.getElementById('nik');
    if (nik.value.length !== 16) {
        e.preventDefault();
        nik.classList.add('is-invalid');
        if (!nik.nextElementSibling || !nik.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>NIK harus 16 digit';
            nik.parentNode.insertBefore(feedback, nik.nextSibling);
        }
        nik.focus();
    }
});

// Auto-focus on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nik').focus();
});
</script>
<?= $this->endSection() ?>
