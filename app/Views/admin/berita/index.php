<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .admin-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -50px auto 0;
            max-width: 1200px;
            position: relative;
        }

        .admin-nav {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .admin-nav .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .admin-nav .nav-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .admin-nav .nav-link.active {
            color: #667eea;
            background: white;
            font-weight: 600;
            box-shadow: 0 -3px 0 #667eea;
        }

        .admin-content {
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            margin: 0;
            color: #495057;
            font-weight: 600;
        }

        .btn-add-news {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-add-news:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .filters-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .filters-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filters-title i {
            color: #667eea;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .btn-filter {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background: #5a6268;
            transform: translateY(-1px);
            color: white;
        }

        .news-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        }

        .news-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .news-title i {
            color: #667eea;
            margin-top: 0.1rem;
        }

        .news-excerpt {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: #95a5a6;
            margin-bottom: 1rem;
        }

        .news-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .news-meta-item i {
            font-size: 0.8rem;
        }

        .news-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-news-action {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-1px);
            color: #212529;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-view:hover {
            background: #138496;
            transform: translateY(-1px);
            color: white;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-published {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-draft {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .pagination {
            margin-top: 2rem;
        }

        .pagination .page-link {
            color: #667eea;
            border-color: #667eea;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
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

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
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

        @media (max-width: 768px) {
            .admin-header h1 {
                font-size: 2rem;
            }

            .admin-container {
                margin: -30px 1rem 0;
                border-radius: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .news-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .news-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Admin Header -->
    <section class="admin-header">
        <div class="container">
            <h1><i class="bi bi-newspaper me-3"></i>Manajemen Berita</h1>
            <p>Kelola berita dan informasi sistem pelayanan masyarakat</p>
        </div>
    </section>

    <!-- Admin Container -->
    <div class="container admin-container">

        <!-- Admin Navigation -->
        <nav class="admin-nav">
            <div class="container-fluid">
                <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="berita-tab" data-bs-toggle="tab" data-bs-target="#berita" type="button" role="tab">
                            <i class="bi bi-grid me-1"></i>Berita
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pengguna-tab" data-bs-toggle="tab" data-bs-target="#pengguna" type="button" role="tab">
                            <i class="bi bi-people me-1"></i>Pengguna
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan" type="button" role="tab">
                            <i class="bi bi-graph-up me-1"></i>Laporan
                        </button>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="tab-content" id="adminTabContent">

                <!-- Berita Tab -->
                <div class="tab-pane fade show active" id="berita" role="tabpanel">

                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">Daftar Berita</h2>
                        <a href="/admin/berita/create" class="btn-add-news">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Berita
                        </a>
                    </div>

                    <!-- Filters -->
                    <div class="filters-section">
                        <h3 class="filters-title">
                            <i class="bi bi-funnel"></i>Filter & Pencarian
                        </h3>
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <select name="status" class="form-control">
                                    <option value="all" <?= $status === 'all' || !$status ? 'selected' : '' ?>>Semua Status</option>
                                    <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Published</option>
                                    <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Cari judul, isi, atau penulis..."
                                       value="<?= esc($search ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-filter w-100">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                            </div>
                        </form>
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

                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Berita List -->
                    <?php if (!empty($berita)): ?>
                        <div class="row">
                            <?php foreach ($berita as $item): ?>
                                <div class="col-lg-6 col-xl-4 mb-4">
                                    <div class="news-card">
                                        <?php if ($item['gambar']): ?>
                                            <img src="/<?= $item['gambar'] ?>" alt="<?= esc($item['judul']) ?>" class="news-image">
                                        <?php else: ?>
                                            <div class="news-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-image text-white" style="font-size: 3rem; opacity: 0.5;"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="news-content">
                                            <h5 class="news-title">
                                                <i class="bi bi-newspaper"></i>
                                                <?= esc($item['judul']) ?>
                                            </h5>

                                            <p class="news-excerpt">
                                                <?= esc($item['excerpt'] ?: substr(strip_tags($item['isi']), 0, 150) . '...') ?>
                                            </p>

                                            <div class="news-meta">
                                                <span class="news-meta-item">
                                                    <i class="bi bi-person"></i>
                                                    <?= esc($item['penulis_nama']) ?>
                                                </span>
                                                <span class="news-meta-item">
                                                    <i class="bi bi-calendar"></i>
                                                    <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                                                </span>
                                                <span class="news-meta-item">
                                                    <i class="bi bi-eye"></i>
                                                    <?= number_format($item['views']) ?> views
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="status-badge status-<?= $item['status'] ?>">
                                                    <i class="bi bi-circle-fill me-1"></i>
                                                    <?= ucfirst($item['status']) ?>
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        onclick="toggleStatus(<?= $item['id_berita'] ?>)">
                                                    <i class="bi bi-toggle-<?= $item['status'] === 'published' ? 'on' : 'off' ?>"></i>
                                                </button>
                                            </div>

                                            <div class="news-actions">
                                                <a href="/berita/<?= $item['slug'] ?>" class="btn-news-action btn-view" target="_blank">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                                <a href="/admin/berita/<?= $item['id_berita'] ?>/edit" class="btn-news-action btn-edit">
                                                    <i class="bi bi-pencil me-1"></i>Edit
                                                </a>
                                                <button type="button" class="btn-news-action btn-delete"
                                                        onclick="deleteBerita(<?= $item['id_berita'] ?>, '<?= esc($item['judul']) ?>')">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            <?= $pager->links() ?>
                        </div>

                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-newspaper"></i>
                            </div>
                            <h3>Tidak ada berita ditemukan</h3>
                            <p>Belum ada berita yang sesuai dengan kriteria pencarian Anda.</p>
                            <a href="/admin/berita/create" class="btn-add-news">
                                <i class="bi bi-plus-circle me-2"></i>Buat Berita Pertama
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Other tabs can be added here -->
                <div class="tab-pane fade" id="pengguna" role="tabpanel">
                    <div class="text-center py-5">
                        <i class="bi bi-people" style="font-size: 3rem; color: #6c757d;"></i>
                        <h4 class="mt-3">Kelola Pengguna</h4>
                        <p class="text-muted">Fitur kelola pengguna akan segera hadir</p>
                    </div>
                </div>

                <div class="tab-pane fade" id="laporan" role="tabpanel">
                    <div class="text-center py-5">
                        <i class="bi bi-graph-up" style="font-size: 3rem; color: #6c757d;"></i>
                        <h4 class="mt-3">Laporan & Analitik</h4>
                        <p class="text-muted">Fitur laporan akan segera hadir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delete confirmation and AJAX delete
            window.deleteBerita = function(id, title) {
                if (confirm('Apakah Anda yakin ingin menghapus berita "' + title + '"?\n\nTindakan ini tidak dapat dibatalkan.')) {
                    $.ajax({
                        url: '/admin/berita/' + id + '/delete',
                        method: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                showAlert('success', response.message);

                                // Remove the card from DOM
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                showAlert('error', response.message);
                            }
                        },
                        error: function() {
                            showAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
                        }
                    });
                }
            };

            // Toggle status
            window.toggleStatus = function(id) {
                $.ajax({
                    url: '/admin/berita/' + id + '/toggle-status',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            showAlert('success', response.message);

                            // Reload page to update status
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
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
                $('.admin-content').prepend(alertHtml);

                // Auto hide after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }
        });
    </script>

</body>
</html>
