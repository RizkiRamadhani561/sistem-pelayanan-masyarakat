<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Warga - Sistem Pelayanan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        .section-title {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
        }
        .current-data {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .current-data .badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        <i class="fas fa-user-edit me-3"></i>Edit Data Warga
                    </h1>
                    <p class="lead text-white-50">Perbarui informasi warga dalam sistem database</p>
                </div>

                <!-- Current Data Info -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Data Warga Saat Ini
                        </h5>
                    </div>
                    <div class="card-body current-data">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>NIK:</strong>
                                <code class="text-primary ms-2"><?= htmlspecialchars($warga['nik']) ?></code>
                            </div>
                            <div class="col-md-6">
                                <strong>Nama:</strong>
                                <span class="ms-2"><?= htmlspecialchars($warga['nama_lengkap']) ?></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Jenis Kelamin:</strong>
                                <span class="badge bg-<?= $warga['jenis_kelamin'] == 'L' ? 'primary' : 'danger' ?> ms-2">
                                    <?= $warga['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>RT/RW:</strong>
                                <span class="badge bg-info ms-2"><?= htmlspecialchars($warga['rt_rw']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Success/Error Messages -->
                        <?php if (session()->has('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= session('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form action="/wargas/<?= $warga['id_warga'] ?>/update" method="post" id="editForm">
                            <?= csrf_field() ?>

                            <!-- NIK Field (Read-only) -->
                            <div class="mb-3">
                                <label for="nik" class="form-label fw-bold">
                                    <i class="bi bi-credit-card-2-front me-1"></i>NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light"
                                       id="nik" name="nik" maxlength="16"
                                       value="<?= old('nik', $warga['nik']) ?>" readonly>
                                <div class="form-text">NIK tidak dapat diubah untuk menjaga integritas data</div>
                            </div>

                            <!-- Nama Lengkap Field -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label fw-bold">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg <?= (isset($errors['nama_lengkap'])) ? 'is-invalid' : '' ?>"
                                       id="nama_lengkap" name="nama_lengkap"
                                       value="<?= old('nama_lengkap', $warga['nama_lengkap']) ?>" required>
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
                                        <option value="L" <?= (old('jenis_kelamin', $warga['jenis_kelamin']) == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= (old('jenis_kelamin', $warga['jenis_kelamin']) == 'P') ? 'selected' : '' ?>>Perempuan</option>
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
                                           id="tanggal_lahir" name="tanggal_lahir"
                                           value="<?= old('tanggal_lahir', $warga['tanggal_lahir']) ?>" required>
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
                                           id="tempat_lahir" name="tempat_lahir"
                                           value="<?= old('tempat_lahir', $warga['tempat_lahir']) ?>" required>
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
                                           id="no_hp" name="no_hp" placeholder="081234567890"
                                           value="<?= old('no_hp', $warga['no_hp']) ?>" required>
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
                                       id="email" name="email" placeholder="nama@email.com"
                                       value="<?= old('email', $warga['email']) ?>">
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
                                          id="alamat" name="alamat" rows="3" required><?= old('alamat', $warga['alamat']) ?></textarea>
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
                                           id="rt_rw" name="rt_rw" placeholder="01/02"
                                           value="<?= old('rt_rw', $warga['rt_rw']) ?>" required>
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
                                           id="kecamatan" name="kecamatan"
                                           value="<?= old('kecamatan', $warga['kecamatan']) ?>" required>
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
                                           id="kab_kota" name="kab_kota"
                                           value="<?= old('kab_kota', $warga['kab_kota']) ?>" required>
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
                                           id="provinsi" name="provinsi"
                                           value="<?= old('provinsi', $warga['provinsi']) ?>" required>
                                    <?php if (isset($errors['provinsi'])): ?>
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            <?= $errors['provinsi'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                <a href="/wargas" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Warga
                                </a>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-save me-2"></i>Update Data Warga
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        // NIK validation (though readonly)
        document.getElementById('nik').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });

        // Phone number formatting
        document.getElementById('no_hp').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                // Keep leading zero
            } else if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
            this.value = value;
        });

        // Form validation feedback
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const requiredFields = ['nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'rt_rw', 'kecamatan', 'kab_kota', 'provinsi', 'no_hp'];
            let hasErrors = false;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    element.classList.remove('is-invalid');
                }
            });

            if (hasErrors) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        // Loading state for form submission
        document.getElementById('editForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            }
        });
    </script>
</body>
</html>
