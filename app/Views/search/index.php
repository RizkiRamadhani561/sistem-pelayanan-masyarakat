<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .search-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .search-hero h1 {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .main-search-form {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .main-search-input {
            width: 100%;
            padding: 1rem 2rem 1rem 1rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .main-search-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2), 0 0 0 4px rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .main-search-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
        }

        .main-search-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .main-search-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-50%) scale(1.05);
            color: white;
        }

        .search-results {
            padding: 60px 0;
        }

        .results-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .results-count {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            display: inline-block;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .result-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        }

        .result-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .result-icon {
            font-size: 1.5rem;
            opacity: 0.9;
        }

        .result-category {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .result-body {
            padding: 1.5rem;
        }

        .result-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .result-title i {
            color: #667eea;
        }

        .result-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: #95a5a6;
        }

        .result-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .result-meta-item i {
            font-size: 0.8rem;
        }

        .result-actions {
            padding: 1rem 1.5rem 1.5rem;
            border-top: 1px solid #e9ecef;
            background: rgba(248, 249, 250, 0.5);
        }

        .btn-view-result {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-view-result:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-results-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .no-results h3 {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .no-results p {
            color: #adb5bd;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .search-tips {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .search-tips h4 {
            color: #495057;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-tips h4 i {
            color: #667eea;
        }

        .tips-list {
            list-style: none;
            padding: 0;
        }

        .tips-list li {
            padding: 0.5rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .tips-list li i {
            color: #28a745;
            margin-top: 0.1rem;
        }

        .category-section {
            margin-bottom: 3rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-icon {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .search-hero h1 {
                font-size: 2rem;
            }

            .main-search-input {
                font-size: 1rem;
                padding: 0.8rem 1.8rem 0.8rem 0.8rem;
            }

            .result-card {
                margin-bottom: 1rem;
            }

            .result-title {
                font-size: 1.1rem;
            }

            .result-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            display: none;
        }

        .autocomplete-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .autocomplete-icon {
            color: #667eea;
            font-size: 1.1rem;
            margin-top: 0.1rem;
        }

        .autocomplete-content {
            flex: 1;
        }

        .autocomplete-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
        }

        .autocomplete-description {
            font-size: 0.85rem;
            color: #6c757d;
            line-height: 1.4;
        }

        .autocomplete-category {
            font-size: 0.75rem;
            color: #667eea;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

            <!-- Bagian Hero Pencarian -->
    <section class="search-hero">
        <div class="container">
            <h1><i class="bi bi-search me-3"></i>Pencarian Global</h1>
            <p class="mb-4">Temukan pengaduan, layanan, dan informasi yang Anda butuhkan</p>

            <form class="main-search-form" action="/search" method="GET">
                <input type="text" class="main-search-input" name="q" placeholder="Ketik kata kunci pencarian..."
                       value="<?= esc($query ?? '') ?>" autocomplete="off" id="main-search-input">
                <button type="submit" class="main-search-btn">
                    <i class="bi bi-search me-1"></i>Cari
                </button>

                <!-- Autocomplete Results -->
                <div class="autocomplete-results" id="autocomplete-results"></div>
            </form>
        </div>
    </section>

    <!-- Search Results -->
    <section class="search-results">
        <div class="container">

            <?php if ($query): ?>
                <div class="results-header">
                    <div class="results-count">
                        <i class="bi bi-bar-chart me-2"></i>
                        Ditemukan <?= number_format($total_results) ?> hasil untuk "<strong><?= esc($query) ?></strong>"
                    </div>
                </div>

                <?php if ($total_results > 0): ?>
                    <!-- Pengaduan Results -->
                    <?php if (!empty($results['pengaduan'])): ?>
                        <div class="category-section">
                            <h3 class="category-title">
                                <i class="bi bi-exclamation-triangle category-icon"></i>
                                Pengaduan (<?= count($results['pengaduan']) ?> hasil)
                            </h3>
                            <div class="row">
                                <?php foreach ($results['pengaduan'] as $pengaduan): ?>
                                    <div class="col-lg-6 col-xl-4 mb-4">
                                        <div class="result-card">
                                            <div class="result-header">
                                                <i class="bi bi-exclamation-triangle result-icon"></i>
                                                <span class="result-category">Pengaduan</span>
                                            </div>
                                            <div class="result-body">
                                                <h5 class="result-title">
                                                    <i class="bi bi-flag"></i>
                                                    <?= esc($pengaduan['judul']) ?>
                                                </h5>
                                                <p class="result-description">
                                                    <?= esc(substr($pengaduan['isi_pengaduan'] ?? '', 0, 150)) . (strlen($pengaduan['isi_pengaduan'] ?? '') > 150 ? '...' : '') ?>
                                                </p>
                                                <div class="result-meta">
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <?= esc($pengaduan['lokasi'] ?? 'Tidak diketahui') ?>
                                                    </span>
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-calendar"></i>
                                                        <?= date('d/m/Y', strtotime($pengaduan['created_at'])) ?>
                                                    </span>
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-circle-fill" style="color:
                                                            <?php
                                                            switch($pengaduan['status'] ?? 'baru') {
                                                                case 'selesai': echo '#28a745'; break;
                                                                case 'diproses': echo '#ffc107'; break;
                                                                default: echo '#dc3545';
                                                            }
                                                            ?>;"></i>
                                                        <?= ucfirst($pengaduan['status'] ?? 'baru') ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="result-actions">
                                                <a href="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>" class="btn-view-result">
                                                    <i class="bi bi-eye me-1"></i>Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Layanan Results -->
                    <?php if (!empty($results['layanan'])): ?>
                        <div class="category-section">
                            <h3 class="category-title">
                                <i class="bi bi-file-earmark-text category-icon"></i>
                                Layanan (<?= count($results['layanan']) ?> hasil)
                            </h3>
                            <div class="row">
                                <?php foreach ($results['layanan'] as $layanan): ?>
                                    <div class="col-lg-6 col-xl-4 mb-4">
                                        <div class="result-card">
                                            <div class="result-header">
                                                <i class="bi bi-file-earmark-text result-icon"></i>
                                                <span class="result-category">Layanan</span>
                                            </div>
                                            <div class="result-body">
                                                <h5 class="result-title">
                                                    <i class="bi bi-file-earmark"></i>
                                                    <?= esc($layanan['nama_pelayanan']) ?>
                                                </h5>
                                                <p class="result-description">
                                                    <?= esc(substr($layanan['deskripsi'], 0, 150)) ?>...
                                                </p>
                                                <div class="result-meta">
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-clock"></i>
                                                        Maksimal <?= esc($layanan['waktu_proses'] ?? 'N/A') ?> hari
                                                    </span>
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-cash"></i>
                                                        Biaya: <?= $layanan['biaya'] ? 'Rp ' . number_format($layanan['biaya']) : 'Gratis' ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="result-actions">
                                                <a href="/layanan/<?= $layanan['id_jenis'] ?>" class="btn-view-result">
                                                    <i class="bi bi-eye me-1"></i>Lihat Layanan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Warga Results (Admin Only) -->
                    <?php if (!empty($results['warga'])): ?>
                        <div class="category-section">
                            <h3 class="category-title">
                                <i class="bi bi-people category-icon"></i>
                                Data Warga (<?= count($results['warga']) ?> hasil)
                            </h3>
                            <div class="row">
                                <?php foreach ($results['warga'] as $warga): ?>
                                    <div class="col-lg-6 col-xl-4 mb-4">
                                        <div class="result-card">
                                            <div class="result-header">
                                                <i class="bi bi-person result-icon"></i>
                                                <span class="result-category">Data Warga</span>
                                            </div>
                                            <div class="result-body">
                                                <h5 class="result-title">
                                                    <i class="bi bi-person-circle"></i>
                                                    <?= esc($warga['nama_lengkap']) ?>
                                                </h5>
                                                <p class="result-description">
                                                    NIK: <?= esc(substr($warga['nik'], 0, 8)) ?>****<br>
                                                    <?= esc($warga['alamat']) ?>
                                                </p>
                                                <div class="result-meta">
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-envelope"></i>
                                                        <?= esc($warga['email'] ?? 'Tidak ada email') ?>
                                                    </span>
                                                    <span class="result-meta-item">
                                                        <i class="bi bi-telephone"></i>
                                                        <?= esc($warga['no_telepon'] ?? 'Tidak ada telepon') ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="result-actions">
                                                <a href="/admin/warga/<?= $warga['id_warga'] ?>" class="btn-view-result">
                                                    <i class="bi bi-eye me-1"></i>Lihat Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- No Results -->
                    <div class="no-results">
                        <div class="no-results-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3>Tidak ada hasil ditemukan</h3>
                        <p>Kata kunci "<strong><?= esc($query) ?></strong>" tidak ditemukan dalam sistem kami.</p>
                        <a href="/search" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i>Coba Pencarian Lain
                        </a>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Search Tips -->
                <div class="search-tips">
                    <h4>
                        <i class="bi bi-lightbulb"></i>
                        Tips Pencarian
                    </h4>
                    <ul class="tips-list">
                        <li>
                            <i class="bi bi-check-circle"></i>
                            <strong>Gunakan kata kunci spesifik</strong> seperti "jalan rusak" atau "KTP hilang" untuk hasil yang lebih akurat
                        </li>
                        <li>
                            <i class="bi bi-check-circle"></i>
                            <strong>Cari berdasarkan kategori</strong> seperti nama layanan, judul pengaduan, atau nama warga
                        </li>
                        <li>
                            <i class="bi bi-check-circle"></i>
                            <strong>Minimal 2 karakter</strong> diperlukan untuk memulai pencarian
                        </li>
                        <li>
                            <i class="bi bi-check-circle"></i>
                            <strong>Hasil pencarian</strong> mencakup pengaduan, layanan administrasi, dan data warga (untuk admin)
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let searchTimeout;
            const $searchInput = $('#main-search-input');
            const $autocompleteResults = $('#autocomplete-results');

            // Autocomplete functionality
            $searchInput.on('input', function() {
                const query = $(this).val().trim();

                clearTimeout(searchTimeout);

                if (query.length >= 2) {
                    searchTimeout = setTimeout(() => {
                        performAutocomplete(query);
                    }, 300);
                } else {
                    $autocompleteResults.hide();
                }
            });

            // Hide autocomplete when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.main-search-form').length) {
                    $autocompleteResults.hide();
                }
            });

            // Handle autocomplete item click
            $(document).on('click', '.autocomplete-item', function() {
                const url = $(this).data('url');
                if (url) {
                    window.location.href = url;
                }
            });

            function performAutocomplete(query) {
                $.ajax({
                    url: '/api/search',
                    method: 'GET',
                    data: { q: query, limit: 8 },
                    dataType: 'json',
                    success: function(response) {
                        if (response.results && response.results.length > 0) {
                            displayAutocompleteResults(response.results);
                            $autocompleteResults.show();
                        } else {
                            $autocompleteResults.hide();
                        }
                    },
                    error: function() {
                        $autocompleteResults.hide();
                    }
                });
            }

            function displayAutocompleteResults(results) {
                let html = '';

                results.forEach(function(result) {
                    html += `
                        <div class="autocomplete-item" data-url="${result.url}">
                            <i class="bi ${result.icon} autocomplete-icon"></i>
                            <div class="autocomplete-content">
                                <div class="autocomplete-title">${result.title}</div>
                                <div class="autocomplete-description">${result.description}</div>
                                <div class="autocomplete-category">${result.category}</div>
                            </div>
                        </div>
                    `;
                });

                $autocompleteResults.html(html);
            }

            // Form submission enhancement
            $('.main-search-form').on('submit', function(e) {
                const query = $searchInput.val().trim();
                if (query.length < 2) {
                    e.preventDefault();
                    alert('Masukkan minimal 2 karakter untuk pencarian');
                    $searchInput.focus();
                    return false;
                }
            });

            // Add loading state to search button
            $('.main-search-btn').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.html('<i class="bi bi-spinner bi-spin me-1"></i>Mencari...');
                $btn.prop('disabled', true);

                // Re-enable after form submission or timeout
                setTimeout(() => {
                    $btn.html(originalHtml);
                    $btn.prop('disabled', false);
                }, 2000);
            });

            // Keyboard shortcuts
            $(document).on('keydown', function(e) {
                // Ctrl/Cmd + K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    $searchInput.focus();
                }

                // Escape to clear search
                if (e.key === 'Escape') {
                    $searchInput.val('');
                    $autocompleteResults.hide();
                }
            });

            // Add search result animations
            $('.result-card').each(function(index) {
                $(this).css('opacity', '0').delay(index * 100).animate({
                    opacity: 1
                }, 500);
            });
        });
    </script>

</body>
</html>
