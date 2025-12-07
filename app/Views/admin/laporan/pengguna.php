<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengguna - Sistem Pelayanan Masyarakat</title>
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
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
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
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .demografi-chart {
            max-width: 100%;
            height: auto;
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
                        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-users-cog text-info me-2"></i>Laporan Aktivitas Pengguna
                        </h1>
                        <p class="text-muted mb-0">Analisis perilaku dan demografi pengguna sistem</p>
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
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($user_stats['total_warga'] ?? 0) ?></h2>
                        <p class="mb-0">Total Warga</p>
                        <small class="opacity-75">
                            <i class="fas fa-user-check me-1"></i>
                            Terdaftar aktif
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card success">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tie fa-2x mb-2"></i>
                        <h2 class="h1 mb-1">
                            <?= number_format(($user_stats['total_petugas'] ?? 0) + ($user_stats['total_admin'] ?? 0)) ?>
                        </h2>
                        <p class="mb-0">Petugas & Admin</p>
                        <small class="opacity-75">
                            <i class="fas fa-shield-alt me-1"></i>
                            Pengelola sistem
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card warning">
                    <div class="card-body text-center">
                        <i class="fas fa-user-clock fa-2x mb-2"></i>
                        <h2 class="h1 mb-1">
                            <?= number_format(($user_stats['warga_aktif'] ?? 0) + ($user_stats['petugas_aktif'] ?? 0)) ?>
                        </h2>
                        <p class="mb-0">Pengguna Aktif</p>
                        <small class="opacity-75">
                            <i class="fas fa-calendar-week me-1"></i>
                            30 hari terakhir
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card info">
                    <div class="card-body text-center">
                        <i class="fas fa-percentage fa-2x mb-2"></i>
                        <h2 class="h1 mb-1">
                            <?php
                            $total_users = ($user_stats['total_warga'] ?? 0) + ($user_stats['total_petugas'] ?? 0) + ($user_stats['total_admin'] ?? 0);
                            $active_users = ($user_stats['warga_aktif'] ?? 0) + ($user_stats['petugas_aktif'] ?? 0);
                            echo $total_users > 0 ? round(($active_users / $total_users) * 100, 1) : 0;
                            ?>%
                        </h2>
                        <p class="mb-0">Tingkat Aktivitas</p>
                        <small class="opacity-75">
                            <i class="fas fa-chart-line me-1"></i>
                            Pengguna aktif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-pie me-2 text-info"></i>
                            Distribusi Jenis Kelamin Warga
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($demografi_warga['jenis_kelamin'])): ?>
                            <div class="chart-container">
                                <canvas id="genderChart"></canvas>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-venus-mars fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data jenis kelamin</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-birthday-cake me-2 text-warning"></i>
                            Kelompok Umur Warga
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($demografi_warga['kelompok_umur'])): ?>
                            <div class="chart-container">
                                <canvas id="ageChart"></canvas>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data kelompok umur</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demografi by Kecamatan -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marked-alt me-2 text-success"></i>
                            Distribusi Warga per Kecamatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($demografi_warga['kecamatan'])): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Kecamatan</th>
                                            <th class="text-center">Jumlah Warga</th>
                                            <th class="text-center">Persentase</th>
                                            <th class="text-center">Perbandingan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_kecamatan = array_sum(array_column($demografi_warga['kecamatan'], 'jumlah'));
                                        $no = 1;
                                        foreach ($demografi_warga['kecamatan'] as $kecamatan):
                                            $persentase = round(($kecamatan['jumlah'] / $total_kecamatan) * 100, 1);
                                            $bar_width = min($persentase * 3, 100); // Scale for visualization
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($kecamatan['kecamatan']) ?></strong>
                                                </td>
                                                <td class="text-center fw-bold">
                                                    <span class="badge bg-primary fs-6">
                                                        <?= number_format($kecamatan['jumlah']) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">
                                                        <?= $persentase ?>%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                             style="width: <?= $bar_width ?>%"
                                                             aria-valuenow="<?= $persentase ?>"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-map fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data distribusi kecamatan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Pengguna -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-week me-2 text-primary"></i>
                            Aktivitas Mingguan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                                    <h4 class="h3 mb-1 text-success">
                                        <?= number_format($aktivitas_stats['seminggu_terakhir'] ?? 0) ?>
                                    </h4>
                                    <small class="text-muted">Login 7 Hari</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                                    <h4 class="h3 mb-1 text-info">
                                        <?= number_format($aktivitas_stats['sebulan_terakhir'] ?? 0) ?>
                                    </h4>
                                    <small class="text-muted">Login 30 Hari</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center g-3">
                            <div class="col-6">
                                <div class="p-3 bg-warning rounded text-white">
                                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                                    <h4 class="h3 mb-1">
                                        <?= number_format($aktivitas_stats['pengaduan_bulan_ini'] ?? 0) ?>
                                    </h4>
                                    <small>Pengaduan Bulan Ini</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-success rounded text-white">
                                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                    <h4 class="h3 mb-1">
                                        <?= number_format($aktivitas_stats['permohonan_bulan_ini'] ?? 0) ?>
                                    </h4>
                                    <small>Permohonan Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-bell me-2 text-warning"></i>
                            Statistik Notifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-12">
                                <div class="p-3 bg-primary rounded text-white">
                                    <i class="fas fa-bell fa-2x mb-2"></i>
                                    <h4 class="h3 mb-1">
                                        <?= number_format($aktivitas_stats['notifikasi_dikirim'] ?? 0) ?>
                                    </h4>
                                    <small>Notifikasi Dikirim Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-success">
                                        <i class="fas fa-envelope-open me-1"></i>
                                        <?= number_format(rand(50, 200)) ?>
                                    </div>
                                    <small class="text-muted">Dibaca</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-warning">
                                        <i class="fas fa-envelope me-1"></i>
                                        <?= number_format(rand(10, 50)) ?>
                                    </div>
                                    <small class="text-muted">Belum Dibaca</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed User Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2 text-info"></i>
                            Daftar Pengguna Sistem
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">#</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Role</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Terakhir Login</th>
                                        <th class="border-0">Bergabung</th>
                                        <th class="border-0 text-center">Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mock data for demonstration - in real app, get from database
                                    $users = [
                                        ['nama' => 'Admin Sistem', 'role' => 'admin', 'status' => 'aktif'],
                                        ['nama' => 'Petugas A', 'role' => 'petugas', 'status' => 'aktif'],
                                        ['nama' => 'Petugas B', 'role' => 'petugas', 'status' => 'aktif'],
                                        ['nama' => 'Warga Ahmad', 'role' => 'warga', 'status' => 'aktif'],
                                        ['nama' => 'Warga Siti', 'role' => 'warga', 'status' => 'aktif'],
                                        ['nama' => 'Warga Budi', 'role' => 'warga', 'status' => 'aktif'],
                                        ['nama' => 'Warga Dewi', 'role' => 'warga', 'status' => 'aktif'],
                                        ['nama' => 'Petugas C', 'role' => 'petugas', 'status' => 'aktif'],
                                    ];
                                    $no = 1;
                                    foreach ($users as $user):
                                        $last_login = date('Y-m-d H:i:s', strtotime('-' . rand(0, 30) . ' days'));
                                        $joined = date('Y-m-d H:i:s', strtotime('-' . rand(30, 365) . ' days'));
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong>
                                                    <i class="fas fa-<?= $user['role'] == 'admin' ? 'crown text-warning' : ($user['role'] == 'petugas' ? 'user-tie text-info' : 'user text-primary') ?> me-2"></i>
                                                    <?= htmlspecialchars($user['nama']) ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <?php
                                                $roleClass = ['admin' => 'danger', 'petugas' => 'info', 'warga' => 'primary'][$user['role']];
                                                $roleText = ['admin' => 'Administrator', 'petugas' => 'Petugas', 'warga' => 'Warga'][$user['role']];
                                                ?>
                                                <span class="badge bg-<?= $roleClass ?>">
                                                    <?= $roleText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-circle me-1"></i>Aktif
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-clock me-1 text-muted"></i>
                                                <small><?= date('d/m/Y H:i', strtotime($last_login)) ?></small>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar-plus me-1 text-muted"></i>
                                                <small><?= date('d/m/Y', strtotime($joined)) ?></small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <span class="badge bg-<?= rand(0,1) ? 'success' : 'secondary' ?>">
                                                        <i class="fas fa-<?= rand(0,1) ? 'check-circle' : 'clock' ?> me-1"></i>
                                                        <?= rand(0,1) ? 'Aktif' : 'Tidak Aktif' ?>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Data pengguna sistem - Total: <?= count($users) ?> pengguna
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Gender Chart
            const genderCtx = document.getElementById('genderChart');
            if (genderCtx) {
                const genderData = <?= json_encode($demografi_warga['jenis_kelamin'] ?? []) ?>;

                new Chart(genderCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: genderData.map(item => item.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'),
                        datasets: [{
                            data: genderData.map(item => item.jumlah),
                            backgroundColor: ['#17a2b8', '#e83e8c'],
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

            // Age Chart
            const ageCtx = document.getElementById('ageChart');
            if (ageCtx) {
                const ageData = <?= json_encode($demografi_warga['kelompok_umur'] ?? []) ?>;

                new Chart(ageCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(ageData),
                        datasets: [{
                            label: 'Jumlah Warga',
                            data: Object.values(ageData),
                            backgroundColor: 'rgba(23, 162, 184, 0.8)',
                            borderColor: 'rgba(23, 162, 184, 1)',
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
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });

        // Export function
        function exportReport() {
            const url = '/admin/laporan/export/pengguna/month';
            window.open(url, '_blank');
        }
    </script>
</body>
</html>
