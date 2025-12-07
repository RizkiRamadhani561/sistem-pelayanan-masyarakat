<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Warga - Sistem Pelayanan Masyarakat</title>
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
        .info-card {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 10px;
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
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
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }
        .info-value {
            font-size: 1.1rem;
            color: #212529;
            font-weight: 500;
        }
        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        <i class="fas fa-user-circle me-3"></i>Detail Warga
                    </h1>
                    <p class="lead text-white-50">Informasi lengkap data warga</p>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-header bg-primary text-white py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-1">
                                    <i class="fas fa-id-card me-2"></i>
                                    <?= htmlspecialchars($warga['nama_lengkap']) ?>
                                </h3>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-hashtag me-1"></i>ID: <?= $warga['id_warga'] ?> |
                                    <i class="fas fa-calendar me-1"></i>Didaftarkan: <?= date('d M Y H:i', strtotime($warga['created_at'])) ?>
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/wargas/<?= $warga['id_warga'] ?>/edit" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>

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

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-lg-8">
                                <div class="card info-card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>Informasi Pribadi
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="info-label">NIK</div>
                                                    <div class="info-value">
                                                        <code class="text-primary fs-5"><?= htmlspecialchars($warga['nik']) ?></code>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="info-label">Nama Lengkap</div>
                                                    <div class="info-value fs-5">
                                                        <i class="fas fa-user text-primary me-2"></i>
                                                        <?= htmlspecialchars($warga['nama_lengkap']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div class="info-label">Jenis Kelamin</div>
                                                    <div class="info-value">
                                                        <span class="badge bg-<?= $warga['jenis_kelamin'] == 'L' ? 'primary' : 'danger' ?> fs-6">
                                                            <i class="fas fa-<?= $warga['jenis_kelamin'] == 'L' ? 'mars' : 'venus' ?> me-1"></i>
                                                            <?= $warga['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div class="info-label">Tempat Lahir</div>
                                                    <div class="info-value">
                                                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                                                        <?= htmlspecialchars($warga['tempat_lahir']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div class="info-label">Tanggal Lahir</div>
                                                    <div class="info-value">
                                                        <i class="fas fa-birthday-cake text-warning me-2"></i>
                                                        <?= date('d M Y', strtotime($warga['tanggal_lahir'])) ?>
                                                        <small class="text-muted">
                                                            (<?= date_diff(date_create($warga['tanggal_lahir']), date_create('today'))->y ?> tahun)
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="card info-card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-phone me-2 text-success"></i>Informasi Kontak
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="info-label">Nomor HP</div>
                                                    <div class="info-value fs-5">
                                                        <i class="fas fa-phone text-success me-2"></i>
                                                        <a href="tel:<?= htmlspecialchars($warga['no_hp']) ?>" class="text-decoration-none">
                                                            <?= htmlspecialchars($warga['no_hp']) ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="info-label">Email</div>
                                                    <div class="info-value">
                                                        <?php if ($warga['email']): ?>
                                                            <i class="fas fa-envelope text-primary me-2"></i>
                                                            <a href="mailto:<?= htmlspecialchars($warga['email']) ?>" class="text-decoration-none">
                                                                <?= htmlspecialchars($warga['email']) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">
                                                                <i class="fas fa-envelope-slash me-2"></i>Tidak ada email
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-lg-4">
                                <div class="card info-card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-map-marked-alt me-2 text-info"></i>Alamat Lengkap
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="info-value">
                                                <i class="fas fa-home text-primary me-2"></i>
                                                <?= nl2br(htmlspecialchars($warga['alamat'])) ?>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <div class="info-label">RT/RW</div>
                                                    <div class="info-value">
                                                        <span class="badge bg-info fs-6">
                                                            <i class="fas fa-signpost me-1"></i>
                                                            <?= htmlspecialchars($warga['rt_rw']) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <div class="info-label">Kecamatan</div>
                                                    <div class="info-value">
                                                        <i class="fas fa-map text-success me-2"></i>
                                                        <?= htmlspecialchars($warga['kecamatan']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <div class="info-label">Kabupaten/Kota</div>
                                                    <div class="info-value">
                                                        <i class="fas fa-city text-warning me-2"></i>
                                                        <?= htmlspecialchars($warga['kab_kota']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-0">
                                                    <div class="info-label">Provinsi</div>
                                                    <div class="info-value">
                                                        <i class="fas fa-globe text-danger me-2"></i>
                                                        <?= htmlspecialchars($warga['provinsi']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- System Information -->
                                <div class="card info-card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-cog me-2 text-secondary"></i>Informasi Sistem
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <div class="info-label">ID Warga</div>
                                                    <div class="info-value">
                                                        <code class="text-secondary">#<?= $warga['id_warga'] ?></code>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <div class="info-label">Dibuat Pada</div>
                                                    <div class="info-value small">
                                                        <i class="fas fa-calendar-plus text-primary me-2"></i>
                                                        <?= date('d M Y H:i:s', strtotime($warga['created_at'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-0">
                                                    <div class="info-label">Terakhir Update</div>
                                                    <div class="info-value small">
                                                        <i class="fas fa-calendar-check text-success me-2"></i>
                                                        <?= date('d M Y H:i:s', strtotime($warga['updated_at'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer with Actions -->
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/wargas" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Warga
                            </a>
                    <div class="d-flex gap-2">
                        <a href="/wargas/<?= $warga['id_warga'] ?>/edit" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit Data
                        </a>
                        <form method="POST" action="/wargas/<?= $warga['id_warga'] ?>/delete" style="display: inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data warga "<?= htmlspecialchars($warga['nama_lengkap']) ?>" (NIK: <?= htmlspecialchars($warga['nik']) ?>) ?\n\nData yang sudah dihapus tidak dapat dikembalikan!')">
                                <i class="fas fa-trash me-1"></i>Hapus Warga
                            </button>
                        </form>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Apakah Anda yakin ingin menghapus data warga ini?</p>
                    <div class="alert alert-warning">
                        <strong>Data yang akan dihapus:</strong><br>
                        Nama: <strong><?= htmlspecialchars($warga['nama_lengkap']) ?></strong><br>
                        NIK: <strong><?= htmlspecialchars($warga['nik']) ?></strong>
                    </div>
                    <p class="text-danger mb-0">
                        <i class="fas fa-warning me-1"></i>
                        <strong>Perhatian:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <form method="POST" action="/wargas/<?= $warga['id_warga'] ?>/delete" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Ya, Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>
