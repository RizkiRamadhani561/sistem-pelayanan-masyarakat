<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Permohonan - Sistem Pelayanan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stat-card {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card.warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
        }
        .stat-card.info {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
        }
        .stat-card.danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .btn-report {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/laporan" class="text-decoration-none"><i class="fas fa-chart-line me-1"></i>Laporan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-clipboard-list text-success me-2"></i>Laporan Permohonan Layanan
                        </h1>
                        <p class="text-muted mb-0">Analisis permohonan layanan administrasi</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/admin/laporan" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button onclick="exportReport()" class="btn btn-report">
                            <i class="fas fa-download me-1"></i>Export Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($permohonan_stats['total_permohonan'] ?? 0) ?></h2>
                        <p class="mb-0">Total Permohonan</p>
                        <small class="opacity-75">
                            <i class="fas fa-plus-circle me-1"></i>
                            Semua waktu
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card warning">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($permohonan_stats['permohonan_diajukan'] ?? 0) ?></h2>
                        <p class="mb-0">Diajukan</p>
                        <small class="opacity-75">
                            <i class="fas fa-file-signature me-1"></i>
                            Menunggu proses
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card info">
                    <div class="card-body text-center">
                        <i class="fas fa-cogs fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($permohonan_stats['permohonan_diproses'] ?? 0) ?></h2>
                        <p class="mb-0">Diproses</p>
                        <small class="opacity-75">
                            <i class="fas fa-spinner me-1"></i>
                            Dalam penanganan
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card success">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($permohonan_stats['permohonan_selesai'] ?? 0) ?></h2>
                        <p class="mb-0">Selesai</p>
                        <small class="opacity-75">
                            <i class="fas fa-check me-1"></i>
                            Telah ditangani
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-success"></i>
                            Tren Permohonan (6 Bulan Terakhir)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-percentage me-2 text-success"></i>
                            Tingkat Kelulusan & Waktu Proses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-12">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-percentage fa-2x text-success mb-2"></i>
                                    <h4 class="h3 mb-1 text-success"><?= $permohonan_stats['tingkat_kelulusan'] ?? 0 ?>%</h4>
                                    <small class="text-muted">Tingkat Kelulusan</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                    <h4 class="h3 mb-1 text-info">
                                        <?= round($waktu_proses['rata_rata_hari'] ?? 0, 1) ?> hari
                                    </h4>
                                    <small class="text-muted">Rata-rata Waktu Proses</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Populer -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2 text-warning"></i>
                            Layanan Paling Diminati
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($layanan_populer)): ?>
                            <div class="chart-container">
                                <canvas id="layananChart"></canvas>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data layanan populer</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-ol me-2 text-success"></i>
                            Top 10 Layanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($layanan_populer)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Layanan</th>
                                            <th class="text-center">Permohonan</th>
                                            <th class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = array_sum(array_column($layanan_populer, 'jumlah'));
                                        $no = 1;
                                        foreach ($layanan_populer as $layanan):
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($layanan['nama_pelayanan']) ?></strong>
                                                </td>
                                                <td class="text-center fw-bold"><?= $layanan['jumlah'] ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">
                                                        <?= round(($layanan['jumlah'] / $total) * 100, 1) ?>%
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-list-ol fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data layanan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Waktu Proses Distribusi -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-hourglass-half me-2 text-info"></i>
                            Distribusi Waktu Proses Permohonan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($waktu_proses['distribusi'])): ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="chart-container">
                                        <canvas id="waktuChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fas fa-info-circle me-2 text-info"></i>Statistik Waktu
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <small class="text-muted">Total Permohonan Selesai</small>
                                                    <div class="h5 text-success"><?= $waktu_proses['total_selesai'] ?? 0 ?></div>
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted">Rata-rata Proses</small>
                                                    <div class="h5 text-info">
                                                        <?= round($waktu_proses['rata_rata_hari'] ?? 0, 1) ?> hari
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted">Proses Tercepat</small>
                                                    <div class="h5 text-warning">1-3 hari</div>
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted">Proses Terlama</small>
                                                    <div class="h5 text-danger">30+ hari</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data waktu proses</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2 text-success"></i>
                            Detail Permohonan Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">#</th>
                                        <th class="border-0">Jenis Layanan</th>
                                        <th class="border-0">Warga</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Tanggal</th>
                                        <th class="border-0">Waktu Proses</th>
                                        <th class="border-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mock data for demonstration - in real app, get from database
                                    $statuses = ['diajukan', 'diproses', 'selesai', 'ditolak'];
                                    $layanans = ['Surat Keterangan Domisili', 'Surat Keterangan Tidak Mampu', 'Surat Pengantar Nikah', 'Surat Keterangan Usaha'];
                                    $no = 1;
                                    for ($i = 0; $i < 10; $i++):
                                        $status = $statuses[array_rand($statuses)];
                                        $layanan = $layanans[array_rand($layanans)];
                                        $waktu_proses = rand(1, 45);
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($layanan) ?></strong>
                                                <br>
                                                <small class="text-muted">ID: PMH-<?= str_pad($no-1, 4, '0', STR_PAD_LEFT) ?></small>
                                            </td>
                                            <td>
                                                <i class="fas fa-user me-1 text-primary"></i>
                                                Warga <?= $no ?>
                                                <br>
                                                <small class="text-muted">NIK: 32xxxxxxxxxxxxxx</small>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = ['diajukan' => 'primary', 'diproses' => 'warning', 'selesai' => 'success', 'ditolak' => 'danger'][$status];
                                                $statusText = ['diajukan' => 'Diajukan', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'][$status];
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar me-1 text-muted"></i>
                                                <?= date('d/m/Y', strtotime('-' . rand(1, 30) . ' days')) ?>
                                            </td>
                                            <td>
                                                <?php if ($status == 'selesai'): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <?= $waktu_proses ?> hari
                                                    </span>
                                                <?php elseif ($status == 'diproses'): ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-spinner me-1"></i>
                                                        Sedang proses
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="/permohonan/<?= $no-1 ?>" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/permohonan" class="btn btn-outline-success">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Semua Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                const trendData = <?= json_encode([]) ?>; // Would be populated from controller

                new Chart(trendCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Permohonan',
                            data: [12, 19, 15, 25, 22, 30],
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Layanan Chart
            const layananCtx = document.getElementById('layananChart');
            if (layananCtx) {
                const layananData = <?= json_encode($layanan_populer ?? []) ?>;

                new Chart(layananCtx.getContext('2d'), {
                    type: 'horizontalBar',
                    data: {
                        labels: layananData.map(item => item.nama_pelayanan.substring(0, 20) + '...'),
                        datasets: [{
                            label: 'Jumlah Permohonan',
                            data: layananData.map(item => item.jumlah),
                            backgroundColor: [
                                '#28a745', '#20c997', '#17a2b8', '#6c757d',
                                '#ffc107', '#fd7e14', '#dc3545', '#6f42c1'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Waktu Proses Chart
            const waktuCtx = document.getElementById('waktuChart');
            if (waktuCtx) {
                const waktuData = <?= json_encode($waktu_proses['distribusi'] ?? []) ?>;

                new Chart(waktuCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(waktuData),
                        datasets: [{
                            data: Object.values(waktuData),
                            backgroundColor: [
                                '#28a745', '#20c997', '#17a2b8', '#6f42c1', '#dc3545'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }
        });

        // Export function
        function exportReport() {
            const url = '/admin/laporan/export/permohonan/month';
            window.open(url, '_blank');
        }
    </script>
</body>
</html>
