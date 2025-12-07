<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Notifikasi - Sistem Pelayanan Masyarakat</title>
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
        .stat-card {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
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
        .btn-notif {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-notif:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .notification-item {
            border-left: 4px solid #6f42c1;
            transition: all 0.3s ease;
        }
        .notification-item:hover {
            background-color: #f8f9fa;
            border-left-color: #e83e8c;
        }
        .notification-item.unread {
            background-color: #e8f4fd;
            border-left-color: #007bff;
        }
        .priority-high {
            border-left-color: #dc3545 !important;
        }
        .priority-medium {
            border-left-color: #ffc107 !important;
        }
        .priority-low {
            border-left-color: #28a745 !important;
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
                        <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-bell text-primary me-2"></i>Manajemen Notifikasi
                        </h1>
                        <p class="text-muted mb-0">Kelola dan pantau semua notifikasi sistem</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="markAllAsRead()" class="btn btn-outline-success">
                            <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                        </button>
                        <a href="/admin/notifikasi/create" class="btn btn-notif">
                            <i class="fas fa-plus me-1"></i>Buat Notifikasi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-bell fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($total_notifikasi ?? 0) ?></h2>
                        <p class="mb-0">Total Notifikasi</p>
                        <small class="opacity-75">
                            <i class="fas fa-calendar me-1"></i>
                            Semua waktu
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card warning">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-2x mb-2"></i>
                        <h2 class="h1 mb-1"><?= number_format($belum_dibaca ?? 0) ?></h2>
                        <p class="mb-0">Belum Dibaca</p>
                        <small class="opacity-75">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Perlu perhatian
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="card stat-card success">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope-open fa-2x mb-2"></i>
                        <h2 class="h1 mb-1">
                            <?php
                            $dibaca = ($total_notifikasi ?? 0) - ($belum_dibaca ?? 0);
                            echo number_format($dibaca);
                            ?>
                        </h2>
                        <p class="mb-0">Sudah Dibaca</p>
                        <small class="opacity-75">
                            <i class="fas fa-check me-1"></i>
                            Telah ditangani
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
                            $total = $total_notifikasi ?? 0;
                            $rate = $total > 0 ? round((($total - ($belum_dibaca ?? 0)) / $total) * 100, 1) : 0;
                            echo $rate;
                            ?>%
                        </h2>
                        <p class="mb-0">Tingkat Pembacaan</p>
                        <small class="opacity-75">
                            <i class="fas fa-chart-line me-1"></i>
                            Efektivitas komunikasi
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>
                            Daftar Notifikasi
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($notifikasi)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-0">#</th>
                                            <th class="border-0">Pesan</th>
                                            <th class="border-0">Penerima</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Tanggal</th>
                                            <th class="border-0 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($notifikasi as $item):
                                        ?>
                                            <tr class="notification-item <?php
                                                echo ($item['is_read'] ?? 0) == 0 ? 'unread' : '';
                                            ?>">
                                                <td>
                                                    <strong><?= $no++ ?></strong>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <strong class="text-dark">
                                                                <?= htmlspecialchars($item['pesan'] ?? 'Notifikasi') ?>
                                                            </strong>
                                                            <br>
                                                            <small class="text-muted">
                                                                ID: <?= 'NTF-' . str_pad($item['id_notif'] ?? $no-1, 4, '0', STR_PAD_LEFT) ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (isset($item['warga_id']) && $item['warga_id']): ?>
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-user me-1"></i>Warga
                                                        </span>
                                                    <?php elseif (isset($item['user_id']) && $item['user_id']): ?>
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-user-tie me-1"></i>Petugas
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-users me-1"></i>Semua
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (($item['is_read'] ?? 0) == 0): ?>
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-envelope me-1"></i>Belum Dibaca
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-envelope-open me-1"></i>Sudah Dibaca
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                                    <small>
                                                        <?= date('d/m/Y H:i', strtotime($item['created_at'] ?? 'now')) ?>
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if (($item['is_read'] ?? 0) == 0): ?>
                                                            <button onclick="markAsRead(<?= $item['id_notif'] ?? 0 ?>)"
                                                                    class="btn btn-outline-success btn-sm"
                                                                    title="Tandai Dibaca">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                        <button onclick="deleteNotification(<?= $item['id_notif'] ?? 0 ?>)"
                                                                class="btn btn-outline-danger btn-sm"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada notifikasi</h5>
                                <p class="text-muted">Notifikasi sistem akan muncul di sini</p>
                                <a href="/admin/notifikasi/create" class="btn btn-notif">
                                    <i class="fas fa-plus me-1"></i>Buat Notifikasi Pertama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($notifikasi)): ?>
                        <div class="card-footer text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan <?= count($notifikasi) ?> notifikasi terbaru
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for notification details (if needed) -->
    <div class="modal fade" id="notificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="notificationDetail"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mark notification as read
        function markAsRead(id) {
            if (confirm('Tandai notifikasi ini sebagai sudah dibaca?')) {
                fetch(`/notifikasi/mark-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menandai notifikasi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses request');
                });
            }
        }

        // Mark all notifications as read
        function markAllAsRead() {
            if (confirm('Tandai semua notifikasi sebagai sudah dibaca?')) {
                // This would require a batch update endpoint
                alert('Fitur ini akan diimplementasikan');
            }
        }

        // Delete notification
        function deleteNotification(id) {
            if (confirm('Hapus notifikasi ini? Tindakan ini tidak dapat dibatalkan.')) {
                fetch(`/admin/notifikasi/${id}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(() => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus notifikasi');
                });
            }
        }

        // Auto-refresh notifications every 30 seconds
        setInterval(() => {
            // Optional: Implement real-time updates
            console.log('Checking for new notifications...');
        }, 30000);
    </script>
</body>
</html>
