<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <!-- Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="bi bi-person-plus-fill fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Tambah Warga Baru</h4>
                            <p class="mb-0 opacity-75">Masukkan data warga baru ke dalam sistem</p>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <div class="card-body border-bottom">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="/dashboard" class="text-decoration-none">
                                    <i class="bi bi-house-door me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/warga" class="text-decoration-none">Kelola Warga</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Warga Baru</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Main Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <!-- Alert Messages -->
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

                    <!-- Validation Errors -->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Terjadi kesalahan dalam pengisian form:
                            </h6>
                            <ul class="mb-0">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><strong><?= ucfirst(str_replace('_', ' ', $field)) ?>:</strong> <?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/dashboard/warga/store" method="post" novalidate>
                        <?= csrf_field() ?>

                        <!-- Informasi Pribadi -->
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-person-fill me-2"></i>
                                            Informasi Pribadi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- NIK -->
                                            <div class="col-md-6">
                                                <label for="nik" class="form-label fw-semibold">
                                                    <i class="bi bi-credit-card-2-front me-1"></i>
                                                    NIK <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="nik" name="nik"
                                                       value="<?= old('nik') ?>"
                                                       placeholder="16 digit Nomor Induk Kependudukan"
                                                       maxlength="16" required>
                                                <div class="form-text">
                                                    Masukkan 16 digit NIK sesuai KTP
                                                </div>
                                                <div class="invalid-feedback">
                                                    NIK harus 16 digit angka.
                                                </div>
                                            </div>

                                            <!-- Nama Lengkap -->
                                            <div class="col-md-6">
                                                <label for="nama_lengkap" class="form-label fw-semibold">
                                                    <i class="bi bi-person me-1"></i>
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="nama_lengkap" name="nama_lengkap"
                                                       value="<?= old('nama_lengkap') ?>"
                                                       placeholder="Nama lengkap sesuai KTP"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Nama lengkap wajib diisi.
                                                </div>
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    <i class="bi bi-gender-ambiguous me-1"></i>
                                                    Jenis Kelamin <span class="text-danger">*</span>
                                                </label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                   id="jenis_kelamin_l" name="jenis_kelamin"
                                                                   value="L" <?= old('jenis_kelamin') == 'L' ? 'checked' : '' ?> required>
                                                            <label class="form-check-label" for="jenis_kelamin_l">
                                                                <i class="bi bi-gender-male text-primary me-1"></i>Laki-laki
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                   id="jenis_kelamin_p" name="jenis_kelamin"
                                                                   value="P" <?= old('jenis_kelamin') == 'P' ? 'checked' : '' ?> required>
                                                            <label class="form-check-label" for="jenis_kelamin_p">
                                                                <i class="bi bi-gender-female text-danger me-1"></i>Perempuan
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback d-block">
                                                    Pilih jenis kelamin.
                                                </div>
                                            </div>

                                            <!-- Tempat Lahir -->
                                            <div class="col-md-3">
                                                <label for="tempat_lahir" class="form-label fw-semibold">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    Tempat Lahir <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="tempat_lahir" name="tempat_lahir"
                                                       value="<?= old('tempat_lahir') ?>"
                                                       placeholder="Kota/Kabupaten"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Tempat lahir wajib diisi.
                                                </div>
                                            </div>

                                            <!-- Tanggal Lahir -->
                                            <div class="col-md-3">
                                                <label for="tanggal_lahir" class="form-label fw-semibold">
                                                    <i class="bi bi-calendar-date me-1"></i>
                                                    Tanggal Lahir <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control"
                                                       id="tanggal_lahir" name="tanggal_lahir"
                                                       value="<?= old('tanggal_lahir') ?>"
                                                       max="<?= date('Y-m-d') ?>"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Tanggal lahir wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-house-fill me-2"></i>
                                            Alamat Lengkap
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Alamat -->
                                            <div class="col-12">
                                                <label for="alamat" class="form-label fw-semibold">
                                                    <i class="bi bi-signpost-split me-1"></i>
                                                    Alamat Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="alamat" name="alamat"
                                                          rows="3" placeholder="Jl. Contoh No. 123, RT/RW 01/02"
                                                          required><?= old('alamat') ?></textarea>
                                                <div class="form-text">
                                                    Tuliskan alamat lengkap sesuai KTP
                                                </div>
                                                <div class="invalid-feedback">
                                                    Alamat lengkap wajib diisi.
                                                </div>
                                            </div>

                                            <!-- RT/RW -->
                                            <div class="col-md-3">
                                                <label for="rt_rw" class="form-label fw-semibold">
                                                    <i class="bi bi-diagram-3 me-1"></i>
                                                    RT/RW <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="rt_rw" name="rt_rw"
                                                       value="<?= old('rt_rw') ?>"
                                                       placeholder="01/02"
                                                       pattern="\d{1,2}\/\d{1,2}"
                                                       required>
                                                <div class="form-text">
                                                    Format: RT/RW (contoh: 01/02)
                                                </div>
                                                <div class="invalid-feedback">
                                                    Format RT/RW tidak valid.
                                                </div>
                                            </div>

                                            <!-- Kecamatan -->
                                            <div class="col-md-3">
                                                <label for="kecamatan" class="form-label fw-semibold">
                                                    <i class="bi bi-building me-1"></i>
                                                    Kecamatan <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="kecamatan" name="kecamatan"
                                                       value="<?= old('kecamatan') ?>"
                                                       placeholder="Kembangan"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Kecamatan wajib diisi.
                                                </div>
                                            </div>

                                            <!-- Kabupaten/Kota -->
                                            <div class="col-md-3">
                                                <label for="kab_kota" class="form-label fw-semibold">
                                                    <i class="bi bi-city me-1"></i>
                                                    Kabupaten/Kota <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="kab_kota" name="kab_kota"
                                                       value="<?= old('kab_kota') ?>"
                                                       placeholder="Jakarta Barat"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Kabupaten/Kota wajib diisi.
                                                </div>
                                            </div>

                                            <!-- Provinsi -->
                                            <div class="col-md-3">
                                                <label for="provinsi" class="form-label fw-semibold">
                                                    <i class="bi bi-globe-americas me-1"></i>
                                                    Provinsi <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="provinsi" name="provinsi"
                                                       value="<?= old('provinsi') ?>"
                                                       placeholder="DKI Jakarta"
                                                       required>
                                                <div class="invalid-feedback">
                                                    Provinsi wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold text-primary">
                                            <i class="bi bi-telephone-fill me-2"></i>
                                            Informasi Kontak
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- No. HP -->
                                            <div class="col-md-6">
                                                <label for="no_hp" class="form-label fw-semibold">
                                                    <i class="bi bi-phone me-1"></i>
                                                    Nomor HP <span class="text-danger">*</span>
                                                </label>
                                                <input type="tel" class="form-control form-control-lg"
                                                       id="no_hp" name="no_hp"
                                                       value="<?= old('no_hp') ?>"
                                                       placeholder="08xxxxxxxxxx"
                                                       required>
                                                <div class="form-text">
                                                    Nomor HP aktif untuk komunikasi
                                                </div>
                                                <div class="invalid-feedback">
                                                    Nomor HP wajib diisi dengan format yang benar.
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <label for="email" class="form-label fw-semibold">
                                                    <i class="bi bi-envelope me-1"></i>
                                                    Email <span class="text-muted">(Opsional)</span>
                                                </label>
                                                <input type="email" class="form-control form-control-lg"
                                                       id="email" name="email"
                                                       value="<?= old('email') ?>"
                                                       placeholder="nama@email.com">
                                                <div class="form-text">
                                                    Email untuk notifikasi dan informasi penting
                                                </div>
                                                <div class="invalid-feedback">
                                                    Format email tidak valid.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="/dashboard/warga" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        Kembali ke Daftar Warga
                                    </a>

                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-outline-warning btn-lg">
                                            <i class="bi bi-arrow-clockwise me-2"></i>
                                            Reset Form
                                        </button>

                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="bi bi-check-circle me-2"></i>
                                            Simpan Data Warga
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    border: none;
    border-radius: 12px 12px 0 0 !important;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    transform: translateY(-1px);
}

.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1.1rem;
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.alert {
    border-radius: 12px;
    border: none;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-label {
    cursor: pointer;
    transition: color 0.2s ease;
}

.form-check-input:checked ~ .form-check-label {
    color: #007bff;
    font-weight: 600;
}

/* Custom scrollbar for form */
.form-control::-webkit-scrollbar {
    width: 6px;
}

.form-control::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.form-control::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.form-control::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .d-flex.gap-2 {
        justify-content: center;
    }
}
</style>

<script>
// Form validation
(function() {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
})();

// NIK validation
document.getElementById('nik').addEventListener('input', function() {
    const nik = this.value.replace(/\D/g, '');
    this.value = nik;

    if (nik.length !== 16) {
        this.setCustomValidity('NIK harus 16 digit');
    } else {
        this.setCustomValidity('');
    }
});

// RT/RW format validation
document.getElementById('rt_rw').addEventListener('input', function() {
    let value = this.value.replace(/[^\d/]/g, '');
    const parts = value.split('/');

    if (parts.length > 2) {
        value = parts[0] + '/' + parts[1];
    }

    if (parts[0] && parts[0].length > 2) {
        parts[0] = parts[0].substring(0, 2);
    }

    if (parts[1] && parts[1].length > 2) {
        parts[1] = parts[1].substring(0, 2);
    }

    this.value = parts.join('/');
});

// Phone number formatting
document.getElementById('no_hp').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');

    if (value.startsWith('0')) {
        // Keep leading zero for Indonesian numbers
    } else if (value.startsWith('62')) {
        value = '0' + value.substring(2);
    }

    this.value = value;
});

// Auto-fill province if Jakarta area
document.getElementById('kab_kota').addEventListener('change', function() {
    const jakartaCities = ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur'];
    const provinsiField = document.getElementById('provinsi');

    if (jakartaCities.some(city => this.value.toLowerCase().includes(city.toLowerCase()))) {
        if (!provinsiField.value) {
            provinsiField.value = 'DKI Jakarta';
        }
    }
});

// Real-time character count for textarea
document.getElementById('alamat').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;

    // Add visual feedback for long text
    if (currentLength > maxLength * 0.8) {
        this.style.borderColor = '#ffc107';
    } else {
        this.style.borderColor = '#e9ecef';
    }
});

// Loading state for form submission
document.querySelector('form').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
    }
});
</script>

<?= $this->endSection() ?>
