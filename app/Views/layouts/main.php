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
    <!-- Font Awesome for Social Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/enhanced.css" rel="stylesheet">
    <!-- Modern UI Design System -->
    <link href="/css/modern-ui.css" rel="stylesheet">

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
    <!-- Modern Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-scroll">
        <div class="container">
            <!-- Logo/Brand -->
            <a class="navbar-brand" href="/">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <i class="bi bi-building text-white fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-primary mb-0 fs-5">Kembangan Raya</div>
                        <small class="text-muted d-block" style="font-size: 0.7rem; margin-top: -2px;">Pelayanan Masyarakat</small>
                    </div>
                </div>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="/berita">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="/pengaduan">Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="/layanan">Layanan</a>
                    </li>
                </ul>

                <!-- User Menu & Social Links -->
                <div class="d-flex align-items-center">
                    <?php if (session()->has('user')): ?>
                        <!-- Admin/Petugas Menu -->
                        <div class="dropdown me-3">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span class="d-none d-lg-inline"><?= session('user')['nama'] ?></span>
                                <small class="text-muted ms-1">(<?= session('user')['role'] ?>)</small>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="/dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    <?php elseif (session()->has('warga')): ?>
                        <!-- Warga Menu -->
                        <div class="dropdown me-3">
                            <button class="btn btn-outline-success dropdown-toggle d-flex align-items-center"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span class="d-none d-lg-inline"><?= session('warga')['nama_lengkap'] ?></span>
                                <small class="text-muted ms-1">(Warga)</small>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="/pengaduan">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Pengaduan Saya
                                </a></li>
                                <li><a class="dropdown-item" href="/permohonan">
                                    <i class="bi bi-file-earmark-text me-2"></i>Permohonan Saya
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Guest Menu -->
                        <div class="d-flex gap-2 me-3">
                            <a href="/login" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                <span class="d-none d-lg-inline">Login</span>
                            </a>
                            <a href="/register" class="btn btn-primary btn-sm">
                                <i class="bi bi-person-plus me-1"></i>
                                <span class="d-none d-lg-inline">Daftar</span>
                            </a>
                        </div>

                        <!-- Admin Login Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-shield me-1"></i>
                                <span class="d-none d-lg-inline">Admin</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="/admin/login">
                                    <i class="bi bi-shield-lock me-2"></i>Login Admin/Petugas
                                </a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Social Media Links -->
                    <div class="d-flex align-items-center ms-3 border-start ps-3">
                        <a href="#" class="text-decoration-none me-2" title="Facebook">
                            <i class="fab fa-facebook-square text-primary fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none me-2" title="Instagram">
                            <i class="fab fa-instagram text-danger fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none" title="YouTube">
                            <i class="fab fa-youtube text-danger fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div style="height: 80px;"></div>

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
