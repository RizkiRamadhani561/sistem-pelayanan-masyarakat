<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pelayanan Masyarakat Kembangan Raya - Portal Berita dan Pengaduan Online">
    <meta name="keywords" content="kembangan raya, pengaduan masyarakat, pelayanan publik, berita">
    <title><?= $title ?? 'Sistem Pelayanan Masyarakat Kembangan Raya' ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- Bootstrap 5 CSS (Local) -->
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/enhanced.css" rel="stylesheet">
    <!-- Enhanced CSS for better UI -->
    <link href="/css/enhanced.css" rel="stylesheet">

    <style>
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .lazy-img {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .lazy-img.loaded {
            opacity: 1;
        }
        .status-badge {
            font-size: 0.8em;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Minimalistic Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="bi bi-building-fill text-primary fs-5"></i>
                </div>
                <span class="d-none d-sm-inline">Kembangan Raya</span>
                <span class="d-inline d-sm-none">KR</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Main Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2" href="/">
                            <i class="bi bi-house-door me-1 d-lg-none"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2" href="/layanan">
                            <i class="bi bi-file-earmark-text me-1 d-lg-none"></i>
                            <span>Layanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2" href="/pengaduan">
                            <i class="bi bi-exclamation-triangle me-1 d-lg-none"></i>
                            <span>Pengaduan</span>
                        </a>
                    </li>
                </ul>

                <!-- User Menu -->
                <ul class="navbar-nav">
                    <?php if (session()->has('user')): ?>
                        <!-- Admin/Petugas Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 py-2 d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="bi bi-person-circle text-primary"></i>
                                </div>
                                <div class="d-none d-lg-block">
                                    <div class="fw-semibold small"><?= session('user')['nama'] ?></div>
                                    <div class="text-muted small opacity-75"><?= ucfirst(session('user')['role']) ?></div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item py-2" href="/dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item py-2" href="/admin/notifikasi">
                                    <i class="bi bi-bell me-2"></i>Notifikasi
                                </a></li>
                                <li><a class="dropdown-item py-2" href="/admin/laporan">
                                    <i class="bi bi-graph-up me-2"></i>Laporan
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php elseif (session()->has('warga')): ?>
                        <!-- Warga Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 py-2 d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="bi bi-person-circle text-success"></i>
                                </div>
                                <div class="d-none d-lg-block">
                                    <div class="fw-semibold small"><?= session('warga')['nama_lengkap'] ?></div>
                                    <div class="text-muted small opacity-75">Warga</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item py-2" href="/pengaduan">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Pengaduan Saya
                                </a></li>
                                <li><a class="dropdown-item py-2" href="/permohonan">
                                    <i class="bi bi-file-earmark-text me-2"></i>Permohonan Saya
                                </a></li>
                                <li><a class="dropdown-item py-2" href="/notifikasi">
                                    <i class="bi bi-bell me-2"></i>Notifikasi
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Guest Menu -->
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-sm me-2" href="/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                <span class="d-none d-sm-inline">Login</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="/register">
                                <i class="bi bi-person-plus me-1"></i>
                                <span class="d-none d-sm-inline">Daftar</span>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-shield me-1"></i>
                                    <span class="d-none d-sm-inline">Admin</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item py-2" href="/admin/login">
                                        <i class="bi bi-shield-lock me-2"></i>Login Admin/Petugas
                                    </a></li>
                                </ul>
                            </div>
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

    <!-- Custom JS -->
    <script>
        // Lazy loading images
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

            // Toast notifications
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });

            // Auto show toasts
            toastList.forEach(toast => toast.show());
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
