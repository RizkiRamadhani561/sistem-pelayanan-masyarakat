<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pelayanan Masyarakat Kembangan Raya - Portal Berita dan Pengaduan Online">
    <meta name="keywords" content="kembangan raya, pengaduan masyarakat, pelayanan publik, berita">
    <title><?= $title ?? 'Sistem Pelayanan Masyarakat Kembangan Raya' ?></title>

    <!-- Favicon - Ikon situs -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- Google Fonts - Inter - Font modern untuk tampilan yang lebih baik -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS (Lokal) - Framework CSS utama -->
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons - Koleksi ikon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- CSS Kustom - Styling khusus untuk sistem -->
    <link href="/css/enhanced.css" rel="stylesheet">

    <style>
        /* Override navbar brand untuk konsistensi */
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
        /* Efek hover untuk card */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        /* Lazy loading untuk gambar */
        .lazy-img {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .lazy-img.loaded {
            opacity: 1;
        }
        /* Styling badge status */
        .status-badge {
            font-size: 0.8em;
        }
        /* Animasi fade in untuk elemen */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        /* Keyframe animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar - Navigasi Utama -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top" style="background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%); backdrop-filter: blur(8px); border-bottom: 1px solid var(--gray-200);">
        <div class="container">
            <!-- Brand/Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <i class="bi bi-building text-white fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-primary mb-0" style="font-size: 1.1rem; line-height: 1.2;">Kembangan Raya</div>
                    <small class="text-muted" style="font-size: 0.7rem;">Pemerintah Daerah</small>
                </div>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu Utama -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="/" title="Halaman Beranda">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>

                    <!-- Dropdown Layanan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium" href="#" id="layananDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Layanan Pemerintah">
                            <i class="bi bi-grid me-1"></i>Layanan
                        </a>
                        <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="layananDropdown">
                            <li><h6 class="dropdown-header fw-bold text-primary">
                                <i class="bi bi-file-earmark-text me-1"></i>Layanan Administrasi
                            </h6></li>
                            <li><a class="dropdown-item" href="/permohonan">
                                <i class="bi bi-file-earmark-plus me-2 text-success"></i>Permohonan Layanan
                            </a></li>
                            <li><a class="dropdown-item" href="/layanan">
                                <i class="bi bi-list-check me-2 text-info"></i>Jenis Layanan
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header fw-bold text-primary">
                                <i class="bi bi-megaphone me-1"></i>Layanan Publik
                            </h6></li>
                            <li><a class="dropdown-item" href="/pengaduan">
                                <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Pengaduan Masyarakat
                            </a></li>
                            <li><a class="dropdown-item" href="/berita">
                                <i class="bi bi-newspaper me-2 text-primary"></i>Berita & Informasi
                            </a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Informasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Informasi Publik">
                            <i class="bi bi-info-circle me-1"></i>Informasi
                        </a>
                        <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="informasiDropdown">
                            <li><a class="dropdown-item" href="/berita">
                                <i class="bi bi-newspaper me-2 text-primary"></i>Berita Terbaru
                            </a></li>
                            <li><a class="dropdown-item" href="/pengumuman">
                                <i class="bi bi-megaphone me-2 text-info"></i>Pengumuman
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/kontak">
                                <i class="bi bi-telephone me-2 text-success"></i>Kontak & Lokasi
                            </a></li>
                            <li><a class="dropdown-item" href="/tentang">
                                <i class="bi bi-building me-2 text-secondary"></i>Tentang Kami
                            </a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Menu Pengguna (Kanan) -->
                <ul class="navbar-nav">
                    <?php if (session()->has('user')): ?>
                        <!-- Menu Admin/Petugas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-fill text-white" style="font-size: 14px;"></i>
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="fw-semibold" style="font-size: 0.9rem; line-height: 1.1;">
                                        <?= session('user')['nama'] ?>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <?= ucfirst(session('user')['role']) ?>
                                    </small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header fw-bold">
                                    <i class="bi bi-person-badge me-1"></i>Panel <?= ucfirst(session('user')['role']) ?>
                                </h6></li>
                                <li><a class="dropdown-item" href="/dashboard">
                                    <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="/dashboard/warga">
                                    <i class="bi bi-people me-2 text-success"></i>Kelola Warga
                                </a></li>
                                <li><a class="dropdown-item" href="/dashboard/pengaduan">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Kelola Pengaduan
                                </a></li>
                                <li><a class="dropdown-item" href="/dashboard/laporan">
                                    <i class="bi bi-bar-chart me-2 text-info"></i>Laporan & Statistik
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/profil">
                                    <i class="bi bi-person-gear me-2 text-secondary"></i>Pengaturan Profil
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a></li>
                            </ul>
                        </li>
                    <?php elseif (session()->has('warga')): ?>
                        <!-- Menu Warga -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium" href="#" id="wargaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-check-fill text-white" style="font-size: 14px;"></i>
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="fw-semibold" style="font-size: 0.9rem; line-height: 1.1;">
                                        <?= session('warga')['nama_lengkap'] ?>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Warga</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="wargaDropdown">
                                <li><h6 class="dropdown-header fw-bold">
                                    <i class="bi bi-house-heart me-1"></i>Layanan Warga
                                </h6></li>
                                <li><a class="dropdown-item" href="/pengaduan">
                                    <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Pengaduan Saya
                                </a></li>
                                <li><a class="dropdown-item" href="/permohonan">
                                    <i class="bi bi-file-earmark-text me-2 text-info"></i>Permohonan Saya
                                </a></li>
                                <li><a class="dropdown-item" href="/riwayat">
                                    <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Aktivitas
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/profil">
                                    <i class="bi bi-person-gear me-2 text-secondary"></i>Pengaturan Profil
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Menu Tamu/Pengunjung -->
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="/login" title="Masuk ke Sistem">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                <span class="d-none d-sm-inline">Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium" href="#" id="daftarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Pendaftaran & Admin">
                                <i class="bi bi-person-plus me-1"></i>
                                <span class="d-none d-sm-inline">Daftar</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="daftarDropdown">
                                <li><h6 class="dropdown-header fw-bold">
                                    <i class="bi bi-person-add me-1"></i>Pendaftaran
                                </h6></li>
                                <li><a class="dropdown-item" href="/register">
                                    <i class="bi bi-person-plus me-2 text-success"></i>Daftar sebagai Warga
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header fw-bold">
                                    <i class="bi bi-shield me-1"></i>Panel Admin
                                </h6></li>
                                <li><a class="dropdown-item" href="/admin/login">
                                    <i class="bi bi-shield-lock me-2 text-primary"></i>Login Admin/Petugas
                                </a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistem Pelayanan Masyarakat</h5>
                    <p>Kembangan Raya - Melayani masyarakat dengan sepenuh hati</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Kontak</h5>
                    <p><i class="bi bi-telephone me-2"></i>(021) 123-4567</p>
                    <p><i class="bi bi-envelope me-2"></i>info@kembanganraya.go.id</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2025 Pemerintah Kembangan Raya. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS (Local) -->
    <script src="/assets/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- JavaScript Kustom -->
    <script>
        // Lazy loading gambar - memuat gambar saat diperlukan
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.lazy-img');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));

            // Notifikasi toast - pesan popup
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });

            // Tampilkan toast secara otomatis
            toastList.forEach(toast => toast.show());
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
