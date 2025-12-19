<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?= esc($berita['judul']) ?>">
    <meta property="og:description" content="<?= esc($berita['excerpt'] ?: substr(strip_tags($berita['isi']), 0, 150)) ?>">
    <?php if ($berita['gambar']): ?>
    <meta property="og:image" content="<?= base_url('uploads/berita/' . $berita['gambar']) ?>">
    <?php endif; ?>
    <title><?= esc($berita['judul']) ?> - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .article-hero {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .article-hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
        }

        .article-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.7), rgba(118, 75, 162, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .article-title {
            color: white;
            font-size: 3rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .article-excerpt {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.3rem;
            font-weight: 300;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
            max-width: 800px;
            margin: 0 auto;
        }

        .article-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -100px auto 0;
            max-width: 1000px;
            position: relative;
        }

        .article-content {
            padding: 4rem 3rem;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e9ecef;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .meta-item i {
            color: #667eea;
            font-size: 1rem;
        }

        .article-category {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
            margin-bottom: 3rem;
        }

        .article-body h2,
        .article-body h3,
        .article-body h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-body h2 {
            font-size: 1.8rem;
            border-left: 4px solid #667eea;
            padding-left: 1rem;
        }

        .article-body h3 {
            font-size: 1.5rem;
            color: #667eea;
        }

        .article-body h4 {
            font-size: 1.3rem;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 2rem 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .article-body blockquote {
            border-left: 4px solid #667eea;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #6c757d;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0 10px 10px 0;
        }

        .article-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }

        .share-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .share-label {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .share-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-share {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-facebook {
            background: #1877f2;
        }

        .btn-facebook:hover {
            background: #166fe5;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .btn-twitter {
            background: #1da1f2;
        }

        .btn-twitter:hover {
            background: #1a91da;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(29, 161, 242, 0.3);
        }

        .btn-whatsapp {
            background: #25d366;
        }

        .btn-whatsapp:hover {
            background: #22c55e;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .navigation-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .btn-nav {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-nav:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .related-articles {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 3rem;
        }

        .related-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .related-title i {
            color: #667eea;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .related-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            text-decoration: none;
            color: inherit;
        }

        .related-image {
            height: 150px;
            object-fit: cover;
            width: 100%;
        }

        .related-content {
            padding: 1rem;
        }

        .related-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-meta {
            font-size: 0.8rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .author-info {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
        }

        .author-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }

        .author-role {
            color: #667eea;
            font-size: 0.9rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .article-hero {
                height: 50vh;
                min-height: 300px;
            }

            .article-title {
                font-size: 2rem;
            }

            .article-excerpt {
                font-size: 1.1rem;
            }

            .article-container {
                margin: -50px 1rem 0;
                border-radius: 15px;
            }

            .article-content {
                padding: 2rem 1.5rem;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .article-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .share-buttons {
                justify-content: center;
            }

            .navigation-section {
                flex-direction: column;
                align-items: stretch;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Article Hero -->
    <section class="article-hero">
        <?php if ($berita['gambar']): ?>
            <img src="/<?= $berita['gambar'] ?>" alt="<?= esc($berita['judul']) ?>" class="article-hero-image">
        <?php endif; ?>
        <div class="article-hero-overlay">
            <div class="container">
                <h1 class="article-title"><?= esc($berita['judul']) ?></h1>
                <p class="article-excerpt">
                    <?= esc($berita['excerpt'] ?: substr(strip_tags($berita['isi']), 0, 150) . '...') ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Article Container -->
    <div class="container article-container">

        <!-- Article Content -->
        <div class="article-content">

            <!-- Article Meta -->
            <div class="article-meta">
                <span class="article-category">
                    <i class="bi bi-tag me-1"></i>Berita
                </span>
                <span class="meta-item">
                    <i class="bi bi-person"></i>
                    <?= esc($berita['penulis_nama']) ?>
                </span>
                <span class="meta-item">
                    <i class="bi bi-calendar"></i>
                    <?= date('d F Y', strtotime($berita['published_at'] ?: $berita['created_at'])) ?>
                </span>
                <span class="meta-item">
                    <i class="bi bi-eye"></i>
                    <?= number_format($berita['views']) ?> kali dilihat
                </span>
                <span class="meta-item">
                    <i class="bi bi-clock"></i>
                    <?= ceil(strlen(strip_tags($berita['isi'])) / 200) ?> menit baca
                </span>
            </div>

            <!-- Article Body -->
            <div class="article-body">
                <?= $berita['isi'] ?>
            </div>

            <!-- Article Actions -->
            <div class="article-actions">
                <div class="share-section">
                    <h5 class="share-label">Bagikan:</h5>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>"
                           target="_blank" class="btn-share btn-facebook" title="Bagikan ke Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($berita['judul']) ?>&url=<?= urlencode(current_url()) ?>"
                           target="_blank" class="btn-share btn-twitter" title="Bagikan ke Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text=<?= urlencode($berita['judul'] . ' - ' . current_url()) ?>"
                           target="_blank" class="btn-share btn-whatsapp" title="Bagikan ke WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="navigation-section">
                    <a href="/berita" class="btn-nav">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Berita
                    </a>
                    <a href="#top" class="btn-nav" onclick="scrollToTop()">
                        <i class="bi bi-arrow-up"></i>
                        Kembali ke Atas
                    </a>
                </div>
            </div>

            <!-- Author Info -->
            <div class="author-info">
                <div class="d-flex align-items-center gap-3">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="author-name">Ditulis oleh: <?= esc($berita['penulis_nama']) ?></h6>
                        <p class="author-role mb-0">Administrator Sistem Pelayanan Masyarakat</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Smooth scroll to top
            window.scrollToTop = function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            };

            // Add reading progress indicator
            let articleHeight = $('.article-body').height();
            let windowHeight = $(window).height();

            $(window).scroll(function() {
                let scrollTop = $(window).scrollTop();
                let articleOffset = $('.article-body').offset().top;
                let scrollPosition = scrollTop - articleOffset;

                if (scrollPosition >= 0 && scrollPosition <= articleHeight) {
                    let progress = (scrollPosition / articleHeight) * 100;
                    // Update progress bar if you add one later
                    // $('.reading-progress').css('width', progress + '%');
                }
            });

            // Lazy load images in article content
            $('.article-body img').each(function() {
                const img = $(this);
                const src = img.attr('src');

                if (src) {
                    const newImg = new Image();
                    newImg.onload = function() {
                        img.css('opacity', '0').attr('src', src).animate({opacity: 1}, 500);
                    };
                    newImg.src = src;
                }
            });

            // Add smooth scroll to anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });

            // Track reading time
            let startTime = Date.now();
            let readingTime = 0;

            $(window).on('beforeunload', function() {
                readingTime = Math.floor((Date.now() - startTime) / 1000);
                // Could send reading time to analytics here
                console.log('Reading time: ' + readingTime + ' seconds');
            });
        });
    </script>

</body>
</html>
