<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Saya - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .notifications-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .notifications-hero h1 {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .notifications-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .notifications-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -50px auto 0;
            max-width: 1000px;
            position: relative;
        }

        .notifications-content {
            padding: 3rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e9ecef;
        }

        .page-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .page-title i {
            color: #667eea;
            font-size: 1.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 0;
        }

        .notification-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1.5rem;
            overflow: hidden;
            position: relative;
        }

        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .notification-card.unread {
            border-left: 4px solid #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        }

        .notification-content {
            padding: 2rem;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .notification-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .notification-type {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .notification-time {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .notification-time i {
            font-size: 0.8rem;
        }

        .notification-message {
            color: #495057;
            line-height: 1.6;
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }

        .notification-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .notification-link:hover {
            color: #5a67d8;
            text-decoration: none;
            transform: translateX(3px);
        }

        .notification-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-mark-read {
            background: #28a745;
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-mark-read:hover {
            background: #218838;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }

        .unread-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 12px;
            height: 12px;
            background: #dc3545;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            padding: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #adb5bd;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
        }

        .back-button {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .back-button:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .notifications-hero h1 {
                font-size: 2rem;
            }

            .notifications-container {
                margin: -30px 1rem 0;
                border-radius: 15px;
            }

            .notifications-content {
                padding: 2rem 1.5rem;
            }

            .notification-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Notifications Hero -->
    <section class="notifications-hero">
        <div class="container">
            <h1><i class="bi bi-bell me-3"></i>Notifikasi Saya</h1>
            <p>Pantau semua notifikasi dan informasi penting dari sistem</p>
        </div>
    </section>

    <!-- Notifications Container -->
    <div class="container notifications-container">

        <!-- Notifications Content -->
        <div class="notifications-content">

            <!-- Back Button -->
            <a href="/" class="back-button">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Beranda
            </a>

            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <i class="bi bi-bell"></i>
                    Notifikasi Terbaru
                </h2>
                <p class="page-subtitle">Informasi penting dan pembaruan dari sistem pelayanan masyarakat</p>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Stats Section -->
            <div class="stats-section">
                <h4 style="color: #495057; margin-bottom: 1rem;">Ringkasan Notifikasi</h4>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?= count($notifikasi) ?></div>
                        <div class="stat-label">Total Notifikasi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $unread = 0;
                            foreach ($notifikasi as $item) {
                                if ($item['is_read'] == 0) $unread++;
                            }
                            echo $unread;
                            ?>
                        </div>
                        <div class="stat-label">Belum Dibaca</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $today = 0;
                            $todayDate = date('Y-m-d');
                            foreach ($notifikasi as $item) {
                                if (date('Y-m-d', strtotime($item['created_at'])) === $todayDate) $today++;
                            }
                            echo $today;
                            ?>
                        </div>
                        <div class="stat-label">Hari Ini</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $thisWeek = 0;
                            $weekAgo = strtotime('-7 days');
                            foreach ($notifikasi as $item) {
                                if (strtotime($item['created_at']) > $weekAgo) $thisWeek++;
                            }
                            echo $thisWeek;
                            ?>
                        </div>
                        <div class="stat-label">Minggu Ini</div>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <?php if (!empty($notifikasi)): ?>
                <?php foreach ($notifikasi as $item): ?>
                    <div class="notification-card <?= $item['is_read'] == 0 ? 'unread' : '' ?>" data-id="<?= $item['id_notif'] ?>">
                        <?php if ($item['is_read'] == 0): ?>
                            <div class="unread-indicator" title="Belum dibaca"></div>
                        <?php endif; ?>

                        <div class="notification-content">
                            <div class="notification-header">
                                <div class="notification-meta">
                                    <span class="notification-type">
                                        <i class="bi bi-info-circle me-1"></i>
                                        <?php
                                        if ($item['warga_id'] && $item['user_id']) {
                                            echo 'Personal';
                                        } elseif ($item['warga_id']) {
                                            echo 'Untuk Warga';
                                        } elseif ($item['user_id']) {
                                            echo 'Untuk Petugas';
                                        } else {
                                            echo 'Broadcast';
                                        }
                                        ?>
                                    </span>
                                    <span class="notification-time">
                                        <i class="bi bi-clock"></i>
                                        <?= date('d F Y, H:i', strtotime($item['created_at'])) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="notification-message">
                                <?= nl2br(esc($item['pesan'])) ?>
                            </div>

                            <?php if ($item['link']): ?>
                                <a href="<?= esc($item['link']) ?>" class="notification-link">
                                    <i class="bi bi-arrow-right-circle"></i>
                                    Lihat Detail
                                </a>
                            <?php endif; ?>

                            <div class="notification-actions">
                                <?php if ($item['is_read'] == 0): ?>
                                    <button type="button" class="btn-mark-read" onclick="markAsRead(<?= $item['id_notif'] ?>)">
                                        <i class="bi bi-check-circle"></i>
                                        Tandai Sudah Dibaca
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.85rem;">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                                        Sudah dibaca
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-bell-slash"></i>
                    </div>
                    <h3>Belum ada notifikasi</h3>
                    <p>Anda belum memiliki notifikasi apapun. Notifikasi akan muncul di sini ketika ada informasi penting dari sistem.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mark notification as read
            window.markAsRead = function(id) {
                $.ajax({
                    url: '/notifikasi/mark-read',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update UI
                            const card = $(`.notification-card[data-id="${id}"]`);
                            card.removeClass('unread');
                            card.find('.unread-indicator').remove();
                            card.find('.notification-actions').html(`
                                <span class="text-muted" style="font-size: 0.85rem;">
                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                    Sudah dibaca
                                </span>
                            `);

                            // Update stats
                            const unreadStat = $('.stat-number').eq(1);
                            const currentUnread = parseInt(unreadStat.text());
                            if (currentUnread > 0) {
                                unreadStat.text(currentUnread - 1);
                            }

                            // Show success message
                            showAlert('success', response.message);
                        } else {
                            showAlert('error', response.message);
                        }
                    },
                    error: function() {
                        showAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
                    }
                });
            };

            // Show alert message
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top of content
                $('.notifications-content').prepend(alertHtml);

                // Auto hide after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }

            // Add animation to notification cards
            $('.notification-card').each(function(index) {
                $(this).css('opacity', '0').delay(index * 100).animate({
                    opacity: 1
                }, 500);
            });
        });
    </script>

</body>
</html>
