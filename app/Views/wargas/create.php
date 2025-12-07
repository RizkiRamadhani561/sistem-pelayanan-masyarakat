<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga Baru - Sistem Pelayanan Masyarakat</title>
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
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        <i class="fas fa-user-plus me-3"></i>Tambah Warga Baru
                    </h1>
                    <p class="lead text-white-50">Masukkan data warga baru ke dalam sistem database</p>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Alert Messages -->
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
                        <form action="/wargas/store" method="post" novalidate>
                            <?= csrf_field() ?>

                            <!-- Informasi Pribadi -->
                            <div class="mb-4">
                                <h4 class="section-title">
                                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nik" class="form-label fw-semibold">NIK *</label>
                                        <input type="text" class="form-control form-control-lg"
                                               id="nik" name="nik" maxlength="16"
                                               value="<?= old('nik') ?>" required>
                                        <div class="form-text">16 digit Nomor Induk Kependudukan</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap *</label>
                                        <input type="text" class="form-control form-control-lg"
                                               id="nama_lengkap" name="nama_lengkap"
                                               value="<?= old('nama_lengkap') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jenis Kelamin *</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                       id="laki" value="L" <?= old('jenis_kelamin') == 'L' ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="laki">
                                                    <i class="fas fa-mars text-primary me-1"></i>Laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                       id="perempuan" value="P" <?= old('jenis_kelamin') == 'P' ? 'checked' : '' ?> required>
                                                <label class="form-check-label" for="perempuan">
                                                    <i class="fas fa-venus text-danger me-1"></i>Perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir *</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                               value="<?= old('tempat_lahir') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir *</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                               value="<?= old('tanggal_lahir') ?>" max="<?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="mb-4">
                                <h4 class="section-title">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                                </h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap *</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="rt_rw" class="form-label fw-semibold">RT/RW *</label>
                                        <input type="text" class="form-control" id="rt_rw" name="rt_rw"
                                               value="<?= old('rt_rw') ?>" placeholder="01/02" required>
                                        <div class="form-text">Format: RT/RW</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kecamatan" class="form-label fw-semibold">Kecamatan *</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                               value="<?= old('kecamatan') ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kab_kota" class="form-label fw-semibold">Kabupaten/Kota *</label>
                                        <input type="text" class="form-control" id="kab_kota" name="kab_kota"
                                               value="<?= old('kab_kota') ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="provinsi" class="form-label fw-semibold">Provinsi *</label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                                               value="<?= old('provinsi') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="mb-4">
                                <h4 class="section-title">
                                    <i class="fas fa-phone me-2"></i>Informasi Kontak
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="no_hp" class="form-label fw-semibold">Nomor HP *</label>
                                        <input type="tel" class="form-control form-control-lg" id="no_hp" name="no_hp"
                                               value="<?= old('no_hp') ?>" required>
                                        <div class="form-text">Nomor HP aktif untuk komunikasi</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                                               value="<?= old('email') ?>">
                                        <div class="form-text">Opsional - untuk notifikasi email</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                <a href="/wargas" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Warga
                                </a>
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-warning btn-lg">
                                        <i class="fas fa-undo me-2"></i>Reset Form
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Simpan Data Warga
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
        // Form validation
        (function() {
            'use strict';
            const forms = document.querySelectorAll('form');
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

        // NIK validation - only numbers
        document.getElementById('nik').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length !== 16) {
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
            this.value = value;
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

        // Loading state for form submission
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            }
        });
    </script>
</body>
</html>
