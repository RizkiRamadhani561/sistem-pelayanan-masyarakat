<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Daftar Sebagai Warga
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">Bergabunglah dengan Sistem Pelayanan Masyarakat Kembangan Raya</p>
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

                    <form action="/register" method="post" id="registerForm">
                        <?= csrf_field() ?>

                        <!-- NIK Field -->
                        <div class="mb-3">
                            <label for="nik" class="form-label fw-bold">
                                <i class="bi bi-credit-card-2-front me-1"></i>NIK (Nomor Induk Kependudukan)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg <?= (isset($errors['nik'])) ? 'is-invalid' : '' ?>"
                                   id="nik" name="nik" maxlength="16" pattern="[0-9]{16}"
                                   value="<?= old('nik') ?>" required>
                            <div class="form-text">Masukkan 16 digit NIK sesuai KTP</div>
                            <?php if (isset($errors['nik'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['nik'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Nama Lengkap Field -->
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label fw-bold">
                                <i class="bi bi-person me-1"></i>Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg <?= (isset($errors['nama_lengkap'])) ? 'is-invalid' : '' ?>"
                                   id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                            <div class="form-text">Sesuai dengan nama di KTP</div>
                            <?php if (isset($errors['nama_lengkap'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['nama_lengkap'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Jenis Kelamin & Tanggal Lahir Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-bold">
                                    <i class="bi bi-gender-ambiguous me-1"></i>Jenis Kelamin
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg <?= (isset($errors['jenis_kelamin'])) ? 'is-invalid' : '' ?>"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?= (old('jenis_kelamin') == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= (old('jenis_kelamin') == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <?php if (isset($errors['jenis_kelamin'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['jenis_kelamin'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-bold">
                                    <i class="bi bi-calendar-date me-1"></i>Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-lg <?= (isset($errors['tanggal_lahir'])) ? 'is-invalid' : '' ?>"
                                       id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" required>
                                <?php if (isset($errors['tanggal_lahir'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['tanggal_lahir'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Tempat Lahir & No HP Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tempat_lahir" class="form-label fw-bold">
                                    <i class="bi bi-geo-alt me-1"></i>Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['tempat_lahir'])) ? 'is-invalid' : '' ?>"
                                       id="tempat_lahir" name="tempat_lahir" value="<?= old('tempat_lahir') ?>" required>
                                <?php if (isset($errors['tempat_lahir'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['tempat_lahir'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label fw-bold">
                                    <i class="bi bi-telephone me-1"></i>No. HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control form-control-lg <?= (isset($errors['no_hp'])) ? 'is-invalid' : '' ?>"
                                       id="no_hp" name="no_hp" placeholder="081234567890" value="<?= old('no_hp') ?>" required>
                                <?php if (isset($errors['no_hp'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['no_hp'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i>Email
                                <small class="text-muted">(Opsional)</small>
                            </label>
                            <input type="email" class="form-control form-control-lg <?= (isset($errors['email'])) ? 'is-invalid' : '' ?>"
                                   id="email" name="email" placeholder="nama@email.com" value="<?= old('email') ?>">
                            <div class="form-text">Untuk mendapatkan notifikasi via email</div>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Alamat Field -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-bold">
                                <i class="bi bi-house me-1"></i>Alamat Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control form-control-lg <?= (isset($errors['alamat'])) ? 'is-invalid' : '' ?>"
                                      id="alamat" name="alamat" rows="3" placeholder="Jl. Sudirman No. 123, RT/RW..." required><?= old('alamat') ?></textarea>
                            <div class="form-text">Alamat sesuai KTP</div>
                            <?php if (isset($errors['alamat'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['alamat'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Wilayah Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rt_rw" class="form-label fw-bold">
                                    <i class="bi bi-signpost me-1"></i>RT/RW
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['rt_rw'])) ? 'is-invalid' : '' ?>"
                                       id="rt_rw" name="rt_rw" placeholder="01/02" pattern="\d{1,2}/\d{1,2}" value="<?= old('rt_rw') ?>" required>
                                <?php if (isset($errors['rt_rw'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['rt_rw'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label fw-bold">
                                    <i class="bi bi-geo me-1"></i>Kecamatan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['kecamatan'])) ? 'is-invalid' : '' ?>"
                                       id="kecamatan" name="kecamatan" value="<?= old('kecamatan') ?>" required>
                                <?php if (isset($errors['kecamatan'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['kecamatan'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Kabupaten/Kota & Provinsi Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="kab_kota" class="form-label fw-bold">
                                    <i class="bi bi-building me-1"></i>Kabupaten/Kota
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['kab_kota'])) ? 'is-invalid' : '' ?>"
                                       id="kab_kota" name="kab_kota" value="<?= old('kab_kota') ?>" required>
                                <?php if (isset($errors['kab_kota'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['kab_kota'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="provinsi" class="form-label fw-bold">
                                    <i class="bi bi-globe me-1"></i>Provinsi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['provinsi'])) ? 'is-invalid' : '' ?>"
                                       id="provinsi" name="provinsi" value="<?= old('provinsi') ?>" required>
                                <?php if (isset($errors['provinsi'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['provinsi'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Hidden Password Fields (required for validation but not used) -->
                        <input type="hidden" name="password" value="password123">
                        <input type="hidden" name="confirm_password" value="password123">

                        <!-- Info Alert -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Sistem ini menggunakan NIK sebagai autentikasi utama. Password tidak diperlukan untuk saat ini.
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus me-2"></i>
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p class="mb-0">Sudah punya akun?
                                <a href="/login" class="text-decoration-none fw-bold">Login di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-fill province based on Jakarta area
document.getElementById('kab_kota').addEventListener('input', function() {
    const kabKota = this.value.toLowerCase();
    if (kabKota.includes('jakarta') || kabKota.includes('bekasi') || kabKota.includes('depok') || kabKota.includes('tangerang')) {
        document.getElementById('provinsi').value = 'DKI Jakarta';
    }
});

// Format RT/RW input
document.getElementById('rt_rw').addEventListener('input', function() {
    let value = this.value.replace(/[^\d/]/g, '');
    if (value.length > 3 && !value.includes('/')) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }
    this.value = value;
});

// NIK validation
document.getElementById('nik').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 16);
});

// Form validation feedback
document.getElementById('registerForm').addEventListener('submit', function(e) {
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
</script>
<?= $this->endSection() ?>
