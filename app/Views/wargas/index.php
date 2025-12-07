<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Warga - Sistem Pelayanan Masyarakat</title>
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
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
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
        .badge {
            font-size: 0.75rem;
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
                        <i class="fas fa-users me-3"></i>Daftar Warga
                    </h1>
                    <p class="lead text-white-50">Data warga yang terdaftar dalam sistem database</p>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-header bg-white py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1 fw-bold text-primary">
                                    <i class="fas fa-database me-2"></i>Data Warga Terdaftar
                                </h4>
                                <p class="mb-0 text-muted">Total: <strong><?= count($wargas ?? []) ?> warga</strong></p>
                            </div>
                            <a href="/wargas/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Warga Baru
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <?php if (!empty($wargas)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>RT/RW</th>
                                            <th>Kecamatan</th>
                                            <th>No. HP</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wargas as $index => $warga): ?>
                                            <tr>
                                                <td class="text-center fw-bold"><?= $index + 1 ?></td>
                                                <td>
                                                    <code class="text-primary"><?= htmlspecialchars($warga['nik']) ?></code>
                                                </td>
                                                <td class="fw-semibold">
                                                    <i class="fas fa-user text-primary me-2"></i>
                                                    <?= htmlspecialchars($warga['nama_lengkap']) ?>
                                                </td>
                                                <td>
                                                    <?php if ($warga['jenis_kelamin'] == 'L'): ?>
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-mars me-1"></i>Laki-laki
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-venus me-1"></i>Perempuan
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars(substr($warga['alamat'], 0, 30)) ?>
                                                        <?= strlen($warga['alamat']) > 30 ? '...' : '' ?>
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">
                                                        <?= htmlspecialchars($warga['rt_rw']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-success me-1"></i>
                                                    <?= htmlspecialchars($warga['kecamatan']) ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-phone text-warning me-1"></i>
                                                    <?= htmlspecialchars($warga['no_hp']) ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="/wargas/<?= $warga['id_warga'] ?>"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="/wargas/<?= $warga['id_warga'] ?>/edit"
                                                           class="btn btn-sm btn-outline-warning"
                                                           title="Edit Data">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="/wargas/<?= $warga['id_warga'] ?>/delete"
                                                           class="btn btn-sm btn-outline-danger"
                                                           title="Hapus Data"
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada data warga</h4>
                                <p class="text-muted mb-4">Belum ada warga yang terdaftar dalam sistem database.</p>
                                <a href="/wargas/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Warga Pertama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Sistem Pelayanan Masyarakat Kembangan Raya - Data Warga Database
                        </small>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="text-center mt-4">
                    <a href="/" class="btn btn-outline-light">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
