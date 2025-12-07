<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan - Sistem Pelayanan Masyarakat</title>
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
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card.success {
            background: linear-gradient(45deg, #28a745, #20c997);
        }
        .stat-card.warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
        }
        .stat-card.info {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .btn-report {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(45deg, #dc3545, #c82333);
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
                        <li class="breadcrumb-item active" aria-current="page">Pengaduan</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-file-alt text-danger me-2"></i>Laporan Pengaduan Masyarakat
                        </h1>
                        <p class="text-muted mb-0">Analisis mendalam tentang pengaduan masyarakat</p>
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
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($pengaduan_stats['total_pengaduan'] ?? 0) ?></h2>
                        <p class="mb-0">Total Pengaduan</p>
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
                        <h2 class="h1 mb-1"><?= number_format($pengaduan_stats['pengaduan_baru'] ?? 0) ?></h2>
                        <p class="mb-0">Pengaduan Baru</p>
                        <small class="opacity-75">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Menunggu tindakan
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card info">
                    <div class="card-body text-center">
                        <i class="fas fa-cogs fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($pengaduan_stats['pengaduan_diproses'] ?? 0) ?></h2>
                        <p class="mb-0">Sedang Diproses</p>
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
                        <h2 class="h1 mb-1"><?= number_format($pengaduan_stats['pengaduan_selesai'] ?? 0) ?></h2>
                        <p class="mb-0">Pengaduan Selesai</p>
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
                            <i class="fas fa-chart-line me-2 text-danger"></i>
                            Tren Pengaduan (30 Hari Terakhir)
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
                            <i class="fas fa-clock me-2 text-warning"></i>
                            Waktu Respons & Proses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-12">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-tachometer-alt fa-2x text-info mb-2"></i>
                                    <h4 class="h3 mb-1 text-info"><?= $pengaduan_stats['rata_respons'] ?? 0 ?> jam</h4>
                                    <small class="text-muted">Rata-rata Waktu Respons</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-percentage fa-2x text-success mb-2"></i>
                                    <h4 class="h3 mb-1 text-success"><?= $pengaduan_stats['kepuasan_pengguna'] ?? 0 ?>%</h4>
                                    <small class="text-muted">Tingkat Kepuasan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Pengaduan -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-tags me-2 text-primary"></i>
                            Kategori Pengaduan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="kategoriChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-ol me-2 text-success"></i>
                            Top 10 Kategori
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($kategori_stats)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = array_sum($kategori_stats);
                                        $no = 1;
                                        foreach ($kategori_stats as $kategori => $jumlah):
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?= htmlspecialchars($kategori) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center fw-bold"><?= $jumlah ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">
                                                        <?= round(($jumlah / $total) * 100, 1) ?>%
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data kategori pengaduan</p>
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
                            <i class="fas fa-table me-2 text-danger"></i>
                            Detail Pengaduan Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">#</th>
                                        <th class="border-0">Judul</th>
                                        <th class="border-0">Kategori</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Tanggal</th>
                                        <th class="border-0">Petugas</th>
                                        <th class="border-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Get recent pengaduan for table display
                                    $recentPengaduan = array_slice($pengaduan_trend ?? [], -10);
                                    $no = 1;
                                    foreach ($recentPengaduan as $item):
                                        // Mock data for demonstration - in real app, get from database
                                        $judul = 'Pengaduan ' . $no;
                                        $kategori = array_rand(array_flip(['Infrastruktur Jalan', 'Kebersihan Lingkungan', 'Fasilitas Listrik', 'Air Bersih', 'Kesehatan']));
                                        $status = ['baru', 'diproses', 'selesai'][array_rand([0,1,2])];
                                        $petugas = ['Petugas A', 'Petugas B', 'Petugas C', null][array_rand([0,1,2,3])];
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($judul) ?></strong>
                                                <br>
                                                <small class="text-muted">ID: PENG-<?= str_pad($no-1, 4, '0', STR_PAD_LEFT) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?= htmlspecialchars($kategori) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = ['baru' => 'warning', 'diproses' => 'info', 'selesai' => 'success'][$status];
                                                $statusText = ['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai'][$status];
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar me-1 text-muted"></i>
                                                <?= date('d/m/Y', strtotime($item['tanggal'] ?? 'now')) ?>
                                            </td>
                                            <td>
                                                <?php if ($petugas): ?>
                                                    <i class="fas fa-user me-1 text-primary"></i>
                                                    <?= htmlspecialchars($petugas) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="/pengaduan/<?= $no-1 ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/pengaduan" class="btn btn-outline-danger">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Semua Pengaduan
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
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const trendData = <?= json_encode($pengaduan_trend ?? []) ?>;

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => {
                        const date = new Date(item.tanggal);
                        return date.toLocaleDateString('id-ID', {day: '2-digit', month: 'short'});
                    }),
                    datasets: [{
                        label: 'Jumlah Pengaduan',
                        data: trendData.map(item => item.jumlah),
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
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

            // Kategori Chart
            const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
            const kategoriData = <?= json_encode($kategori_stats ?? []) ?>;

            new Chart(kategoriCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(kategoriData),
                    datasets: [{
                        data: Object.values(kategoriData),
                        backgroundColor: [
                            '#dc3545', '#28a745', '#ffc107', '#17a2b8',
                            '#6f42c1', '#fd7e14', '#20c997', '#e83e8c'
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
        });

        // Export function
        function exportReport() {
            const url = '/admin/laporan/export/pengaduan/month';
            window.open(url, '_blank');
        }
    </script>
</body>
</html>
