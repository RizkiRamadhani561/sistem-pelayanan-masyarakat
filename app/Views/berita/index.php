<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Informasi - Sistem Pelayanan Masyarakat</title>
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

        .news-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .news-hero h1 {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .news-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .news-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -50px auto 0;
            max-width: 1200px;
            position: relative;
        }

        .news-content {
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

        .search-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
            border: 1px solid #e9ecef;
        }

        .search-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-title i {
            color: #667eea;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .btn-search {
            background: #667eea;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background: #5a67d8;
            transform: translateY(-1px);
            color: white;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .news-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        }

        .news-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .news-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-card:hover .news-image {
            transform: scale(1.05);
        }

        .news-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .news-card:hover .news-image-overlay {
            opacity: 1;
        }

        .news-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .news-category {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 1rem;
            align-self: flex-start;
        }

        .news-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .news-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .news-title a:hover {
            color: #667eea;
            text-decoration: none;
        }

        .news-excerpt {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .news-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: #95a5a6;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .news-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .news-meta-item i {
            font-size: 0.8rem;
        }

        .btn-read-more {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            align-self: flex-start;
            margin-top: 1rem;
        }

        .btn-read-more:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .pagination {
            margin-top: 3rem;
            justify-content: center;
        }

        .pagination .page-link {
            color: #667eea;
            border-color: #667eea;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem;
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
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
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

        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
            .news-hero h1 {
                font-size: 2rem;
            }

            .news-container {
                margin: -30px 1rem 0;
                border-radius: 15px;
            }

            .news-content {
                padding: 2rem 1.5rem;
            }

            .news-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .page-header {
                margin-bottom: 2rem;
                padding-bottom: 1rem;
            }

            .search-section {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- News Hero -->
    <section class="news-hero">
        <div class="container">
            <h1><i class="bi bi-newspaper me-3"></i>Berita & Informasi</h1>
            <p>Tetap update dengan berita terbaru dari Sistem Pelayanan Masyarakat Kembangan Raya</p>
        </div>
    </section>

    <!-- News Container -->
    <div class="container news-container">

        <!-- News Content -->
        <div class="news-content">

            <!-- Back Button -->
            <a href="/" class="back-button">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Beranda
            </a>

            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <i class="bi bi-grid"></i>
                    Berita Terbaru
                </h2>
                <p class="page-subtitle">Informasi terkini dan penting untuk masyarakat</p>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <h3 class="search-title">
                    <i class="bi bi-search"></i>
                    Cari Berita
                </h3>
                <form method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul berita, isi, atau penulis..."
                               value="<?= esc($search ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-search w-100">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <h4 style="color: #495057; margin-bottom: 1rem;">Statistik Berita</h4>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?= count($berita) ?></div>
                        <div class="stat-label">Berita Ditampilkan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $totalViews = 0;
                            foreach ($berita as $item) {
                                $totalViews += $item['views'];
                            }
                            echo number_format($totalViews);
                            ?>
                        </div>
                        <div class="stat-label">Total Dilihat</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $uniqueAuthors = array_unique(array_column($berita, 'penulis_nama'));
                            echo count($uniqueAuthors);
                            ?>
                        </div>
                        <div class="stat-label">Penulis</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $thisWeek = 0;
                            $weekAgo = strtotime('-7 days');
                            foreach ($berita as $item) {
                                if (strtotime($item['created_at']) > $weekAgo) {
                                    $thisWeek++;
                                }
                            }
                            echo $thisWeek;
                            ?>
                        </div>
                        <div class="stat-label">Berita Minggu Ini</div>
                    </div>
                </div>
            </div>

            <!-- News Grid -->
            <?php if (!empty($berita)): ?>
                <div class="news-grid">
                    <?php foreach ($berita as $item): ?>
                        <div class="news-card">
                            <div class="news-image-container">
                                <?php if ($item['gambar']): ?>
                                    <img src="/<?= $item['gambar'] ?>" alt="<?= esc($item['judul']) ?>" class="news-image">
                                <?php else: ?>
                                    <div class="news-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-white" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="news-image-overlay"></div>
                            </div>

                            <div class="news-content">
                                <span class="news-category">
                                    <i class="bi bi-tag me-1"></i>Berita
                                </span>

                                <h5 class="news-title">
                                    <a href="/berita/<?= $item['slug'] ?>">
                                        <?= esc($item['judul']) ?>
                                    </a>
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
                                        <?= date('d/m/Y', strtotime($item['published_at'] ?: $item['created_at'])) ?>
                                    </span>
                                    <span class="news-meta-item">
                                        <i class="bi bi-eye"></i>
                                        <?= number_format($item['views']) ?> dilihat
                                    </span>
                                </div>

                                <a href="/berita/<?= $item['slug'] ?>" class="btn-read-more">
                                    <i class="bi bi-arrow-right me-1"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($pager && $pager->getPageCount() > 1): ?>
                    <div class="d-flex justify-content-center">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>Tidak ada berita ditemukan</h3>
                    <p>
                        <?php if ($search): ?>
                            Tidak ada berita yang sesuai dengan kata kunci "<strong><?= esc($search) ?></strong>".
                        <?php else: ?>
                            Belum ada berita yang dipublikasikan saat ini.
                        <?php endif; ?>
                    </p>
                    <?php if ($search): ?>
                        <a href="/berita" class="btn-read-more">
                            <i class="bi bi-arrow-left me-1"></i>Lihat Semua Berita
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add animation classes
            $('.news-card').each(function(index) {
                $(this).css('opacity', '0').delay(index * 100).animate({
                    opacity: 1
                }, 500);
            });

            // Lazy loading images
            $('.news-image').each(function() {
                const img = $(this);
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            // Image is already loaded, just add loaded class
                            img.addClass('loaded');
                            observer.unobserve(img[0]);
                        }
                    });
                });
                observer.observe(img[0]);
            });

            // Search form enhancement
            $('.form-control').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });

            // Smooth scroll for pagination
            $('.pagination .page-link').on('click', function() {
                $('html, body').animate({
                    scrollTop: $('.news-container').offset().top - 20
                }, 500);
            });
        });
    </script>

</body>
</html>
