<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laporan & Analitik - Sistem Pelayanan Masyarakat</title>
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
            background: linear-gradient(45deg, #667eea, #764ba2);
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
        .stat-card.danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .btn-report {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
                        <li class="breadcrumb-item active" aria-current="page">Laporan & Analitik</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-chart-line text-primary me-2"></i>Dashboard Laporan & Analitik
                        </h1>
                        <p class="text-muted mb-0">Monitoring kinerja sistem pelayanan masyarakat</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="fas fa-print me-1"></i>Cetak
                        </button>
                        <button onclick="exportData()" class="btn btn-report">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($stats['total_warga'] ?? 0) ?></h2>
                        <p class="mb-0">Total Warga</p>
                        <small class="opacity-75">
                            <i class="fas fa-plus-circle me-1"></i>
                            Terdaftar dalam sistem
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card success">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($stats['total_pengaduan'] ?? 0) ?></h2>
                        <p class="mb-0">Total Pengaduan</p>
                        <small class="opacity-75">
                            <i class="fas fa-calendar-check me-1"></i>
                            Bulan ini: <?= number_format($stats['pengaduan_bulan_ini'] ?? 0) ?>
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card warning">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($stats['total_perMohonan'] ?? 0) ?></h2>
                        <p class="mb-0">Total Permohonan</p>
                        <small class="opacity-75">
                            <i class="fas fa-calendar-check me-1"></i>
                            Bulan ini: <?= number_format($stats['permohonan_bulan_ini'] ?? 0) ?>
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card info">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h2 class="h1 mb-1">
                            <?= number_format(($stats['pengaduan_selesai'] ?? 0) + ($stats['permohonan_selesai'] ?? 0)) ?>
                        </h2>
                        <p class="mb-0">Laporan Selesai</p>
                        <small class="opacity-75">
                            <i class="fas fa-percentage me-1"></i>
                            Tingkat Penyelesaian: <?= round((($stats['pengaduan_selesai'] ?? 0) + ($stats['permohonan_selesai'] ?? 0)) / max(1, ($stats['total_pengaduan'] ?? 0) + ($stats['total_perMohonan'] ?? 0)) * 100, 1) ?>%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Tren Pengaduan & Permohonan (6 Bulan Terakhir)
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
                            Rata-rata Waktu Proses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                                    <h4 class="h3 mb-1 text-success"><?= $stats['rata_waktu_pengaduan'] ?? 0 ?> hari</h4>
                                    <small class="text-muted">Pengaduan</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-clipboard-list fa-2x text-info mb-2"></i>
                                    <h4 class="h3 mb-1 text-info"><?= $stats['rata_waktu_perMohonan'] ?? 0 ?> hari</h4>
                                    <small class="text-muted">Permohonan</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Waktu rata-rata dari pengajuan sampai selesai
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Reports -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>Laporan Pengaduan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-4">
                                <div class="p-2 bg-warning rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['total_pengaduan'] - $stats['pengaduan_selesai'] ?? 0 ?></div>
                                    <small class="text-white-50">Aktif</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-info rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['pengaduan_diproses'] ?? 0 ?></div>
                                    <small class="text-white-50">Diproses</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-success rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['pengaduan_selesai'] ?? 0 ?></div>
                                    <small class="text-white-50">Selesai</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a href="/admin/laporan/pengaduan" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-1"></i>Lihat Detail Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>Laporan Permohonan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-4">
                                <div class="p-2 bg-primary rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['permohonan_diajukan'] ?? 0 ?></div>
                                    <small class="text-white-50">Diajukan</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-warning rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['permohonan_diproses'] ?? 0 ?></div>
                                    <small class="text-white-50">Diproses</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-success rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['permohonan_selesai'] ?? 0 ?></div>
                                    <small class="text-white-50">Selesai</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a href="/admin/laporan/permohonan" class="btn btn-success w-100">
                            <i class="fas fa-eye me-1"></i>Lihat Detail Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-users-cog me-2"></i>Laporan Pengguna
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-4">
                                <div class="p-2 bg-primary rounded">
                                    <div class="h5 mb-0 text-white"><?= $stats['total_warga'] ?? 0 ?></div>
                                    <small class="text-white-50">Warga</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-warning rounded">
                                    <div class="h5 mb-0 text-white"><?= ($stats['total_petugas'] ?? 0) + ($stats['total_admin'] ?? 0) ?></div>
                                    <small class="text-white-50">Petugas</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-success rounded">
                                    <div class="h5 mb-0 text-white"><?= ($stats['warga_aktif'] ?? 0) + ($stats['petugas_aktif'] ?? 0) ?></div>
                                    <small class="text-white-50">Aktif</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a href="/admin/laporan/pengguna" class="btn btn-info w-100">
                            <i class="fas fa-eye me-1"></i>Lihat Detail Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <button onclick="exportReport('pengaduan')" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-file-pdf me-2"></i>Export Pengaduan
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button onclick="exportReport('permohonan')" class="btn btn-outline-success w-100">
                                    <i class="fas fa-file-excel me-2"></i>Export Permohonan
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button onclick="exportReport('pengguna')" class="btn btn-outline-info w-100">
                                    <i class="fas fa-file-csv me-2"></i>Export Pengguna
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button onclick="refreshData()" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-sync-alt me-2"></i>Refresh Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trendChart').getContext('2d');
            const chartData = <?= json_encode($charts ?? []) ?>;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels || [],
                    datasets: [{
                        label: 'Pengaduan',
                        data: chartData.pengaduan || [],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Permohonan',
                        data: chartData.permohonan || [],
                        borderColor: '#764ba2',
                        backgroundColor: 'rgba(118, 75, 162, 0.1)',
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
                        },
                        title: {
                            display: true,
                            text: 'Tren Pengaduan & Permohonan'
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
        });

        // Export functions
        function exportReport(type) {
            const url = `/admin/laporan/export/${type}/month`;
            window.open(url, '_blank');
        }

        function exportData() {
            // Export dashboard data
            const data = {
                stats: <?= json_encode($stats ?? []) ?>,
                charts: <?= json_encode($charts ?? []) ?>,
                exported_at: new Date().toISOString()
            };

            const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'dashboard-data-' + new Date().toISOString().split('T')[0] + '.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        function refreshData() {
            // Reload the page to refresh data
            window.location.reload();
        }

        // Auto refresh every 5 minutes
        setTimeout(function() {
            if (confirm('Data akan di-refresh otomatis setiap 5 menit. Refresh sekarang?')) {
                refreshData();
            }
        }, 5 * 60 * 1000);
    </script>
</body>
</html>
