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

	<!-- Bootstrap 4 CSS (Local) -->
	<link rel="stylesheet" href="/assets/bootstrap4/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
	<!-- Custom CSS -->
	<link href="/css/navbar.css" rel="stylesheet">
	<link href="/css/enhanced.css" rel="stylesheet">

	<style>
		/* Modern Navbar Styles - Enhanced Visibility & UX */
		.navbar {
			box-shadow: 0 2px 20px rgba(0,0,0,0.08) !important;
			border-bottom: 2px solid #f8f9fa;
			transition: all 0.3s ease;
		}

		.navbar-brand {
			transition: all 0.3s ease;
		}

		.navbar-brand:hover {
			transform: scale(1.02);
		}

		.brand-icon {
			background: linear-gradient(135deg, #667eea 0%, #764ba2);
			border-radius: 12px;
			padding: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
		}

		.brand-title {
			line-height: 1.2;
			font-size: 0.85rem !important;
		}

		.brand-subtitle {
			font-size: 0.65rem;
			margin-top: -2px;
		}

		/* Navigation Links */
		.nav-link {
			font-weight: 500 !important;
			color: #495057 !important;
			position: relative;
			transition: all 0.3s ease;
			border-radius: 25px !important;
			margin: 0 2px;
		}

		.nav-link:hover {
			background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(102, 126, 234, 0.1));
			color: #007bff !important;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
		}

		.nav-link i {
			opacity: 0.8;
		}

		.nav-link:hover i {
			opacity: 1;
			transform: scale(1.1);
		}

		.nav-indicator {
			position: absolute;
			bottom: -2px;
			left: 50%;
			width: 0;
			height: 2px;
			background: linear-gradient(90deg, #007bff, #6610f2);
			border-radius: 1px;
			transition: all 0.3s ease;
			transform: translateX(-50%);
		}

		.nav-link:hover .nav-indicator {
			width: 70%;
		}

		/* User Menu */
		.user-menu-link {
			border: 1px solid #e9ecef;
			background: rgba(255, 255, 255, 0.8);
			transition: all 0.3s ease;
		}

		.user-menu-link:hover {
			background: rgba(0, 123, 255, 0.05) !important;
			border-color: #007bff;
			transform: translateY(-1px);
			box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
		}

		.user-avatar {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			background: linear-gradient(135deg, #667eea, #764ba2);
			color: white;
			font-size: 1.1rem;
		}

		.user-name {
			font-size: 0.8rem;
			line-height: 1.2;
		}

		.user-role {
			font-size: 0.65rem;
			margin-top: -2px;
		}

		/* Dropdown Menu */
		.dropdown-menu {
			border: none;
			box-shadow: 0 8px 30px rgba(0,0,0,0.12);
			border-radius: 12px;
			padding: 8px 0;
			margin-top: 8px !important;
		}

		.dropdown-item {
			padding: 12px 20px;
			transition: all 0.3s ease;
			border-radius: 6px;
			margin: 2px 8px;
		}

		.dropdown-item:hover {
			background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(102, 126, 234, 0.1));
			color: #007bff;
			transform: translateX(4px);
		}

		.dropdown-header {
			padding: 12px 20px 8px;
			font-weight: 600;
			color: #6c757d;
			border-bottom: 1px solid #e9ecef;
			margin-bottom: 8px;
		}

		/* Search Bar */
		.input-group .form-control {
			border-right: none;
			border-radius: 25px 0 0 25px;
		}

		.input-group .btn {
			border-left: none;
			border-radius: 0 25px 25px 0;
			background: linear-gradient(135deg, #6c757d, #495057);
			border-color: #6c757d;
		}

		.input-group .btn:hover {
			background: linear-gradient(135deg, #5a6268, #343a40);
			transform: translateY(-1px);
		}

		/* Buttons */
		.btn {
			border-radius: 25px !important;
			font-weight: 500;
			transition: all 0.3s ease;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		}

		.btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 15px rgba(0,0,0,0.15);
		}

		.btn-outline-primary:hover {
			background: linear-gradient(135deg, #007bff, #6610f2) !important;
			border-color: #007bff;
			color: white !important;
		}

		.btn-primary {
			background: linear-gradient(135deg, #007bff, #6610f2);
			border: none;
		}

		.btn-primary:hover {
			background: linear-gradient(135deg, #0056b3, #4c0fe2);
		}

		/* Mobile Enhancements */
		@media (max-width: 991.98px) {
			.navbar-collapse {
				background: white;
				border-radius: 12px;
				margin-top: 16px;
				padding: 20px;
				box-shadow: 0 8px 30px rgba(0,0,0,0.1);
				border: 1px solid #e9ecef;
			}

			.nav-link {
				padding: 12px 16px !important;
				margin: 4px 0;
				text-align: center;
				justify-content: center;
			}

			.user-info {
				display: none !important;
			}

			.mobile-search {
				padding: 16px;
				background: #f8f9fa;
				border-top: 1px solid #e9ecef;
			}

			.navbar-toggler {
				border: 1px solid #dee2e6;
				border-radius: 8px;
			}

			.navbar-toggler:focus {
				box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
			}
		}

		/* Accessibility */
		.nav-link:focus,
		.btn:focus,
		.dropdown-item:focus {
			outline: 2px solid #007bff;
			outline-offset: 2px;
		}

		/* Loading States */
		.navbar-loading {
			opacity: 0.7;
			pointer-events: none;
		}

		/* Smooth animations */
		* {
			transition: all 0.3s ease;
		}

		/* Enhanced visibility */
		.navbar {
			z-index: 1030;
		}

		/* Sticky navbar enhancement */
		.navbar.sticky-top {
			top: 0;
			z-index: 1030;
		}

		/* Focus states */
		.form-control:focus {
			border-color: #007bff;
			box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
			transform: translateY(-1px);
		}

		/* Custom scrollbar for dropdown */
		.dropdown-menu::-webkit-scrollbar {
			width: 6px;
		}

		.dropdown-menu::-webkit-scrollbar-thumb {
			background: #ccc;
			border-radius: 3px;
		}

		.dropdown-menu::-webkit-scrollbar-thumb:hover {
			background: #999;
		}
	</style>
</head>
<body class="bg-light">
    <!-- Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="/">
                <div class="brand-icon me-3">
                    <i class="fas fa-building text-primary" style="font-size: 2rem;"></i>
                </div>
                <div class="brand-text">
                    <div class="brand-title h6 mb-0 fw-bold text-primary">PELAYANAN MASYARAKAT</div>
                    <div class="brand-subtitle small text-muted">Kembangan Raya</div>
                </div>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Main Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <!-- Navigation Links -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill position-relative" href="/">
                            <i class="fas fa-home me-2"></i>Beranda
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill position-relative" href="/layanan">
                            <i class="fas fa-concierge-bell me-2"></i>Layanan
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill position-relative" href="/pengaduan">
                            <i class="fas fa-exclamation-triangle me-2"></i>Pengaduan
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <?php if (session()->has('user') || session()->has('warga')): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill position-relative" href="/berita">
                            <i class="fas fa-newspaper me-2"></i>Berita
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Search Bar (Desktop) -->
                <form class="d-none d-lg-flex me-3" style="width: 250px;">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-sm border-end-0" placeholder="Cari informasi..." aria-label="Search">
                        <button class="btn btn-outline-secondary btn-sm border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- User Section -->
                <ul class="navbar-nav">
                    <?php if (session()->has('user')): ?>
                        <!-- Admin/Petugas Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-menu-link px-3 py-2 rounded-pill" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">
                                        <i class="fas fa-user-shield text-primary"></i>
                                    </div>
                                    <div class="user-info d-none d-lg-block">
                                        <div class="user-name small fw-bold text-dark"><?= session('user')['nama'] ?></div>
                                        <div class="user-role small text-muted"><?= ucfirst(session('user')['role']) ?></div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                                <li class="dropdown-header bg-light">
                                    <strong>Menu Admin</strong>
                                </li>
                                <li><a class="dropdown-item py-2" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item py-2" href="/admin/notifikasi"><i class="fas fa-bell me-2"></i>Notifikasi</a></li>
                                <li><a class="dropdown-item py-2" href="/admin/laporan"><i class="fas fa-chart-bar me-2"></i>Laporan</a></li>
                                <li><a class="dropdown-item py-2" href="/admin/warga"><i class="fas fa-users me-2"></i>Kelola Warga</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>

                    <?php elseif (session()->has('warga')): ?>
                        <!-- Warga Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-menu-link px-3 py-2 rounded-pill" href="#" id="wargaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <div class="user-info d-none d-lg-block">
                                        <div class="user-name small fw-bold text-dark"><?= session('warga')['nama_lengkap'] ?></div>
                                        <div class="user-role small text-muted">Warga</div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="wargaDropdown">
                                <li class="dropdown-header bg-light">
                                    <strong>Akun Saya</strong>
                                </li>
                                <li><a class="dropdown-item py-2" href="/pengaduan"><i class="fas fa-exclamation-triangle me-2"></i>Pengaduan Saya</a></li>
                                <li><a class="dropdown-item py-2" href="/permohonan"><i class="fas fa-file-alt me-2"></i>Permohonan Saya</a></li>
                                <li><a class="dropdown-item py-2" href="/notifikasi"><i class="fas fa-bell me-2"></i>Notifikasi</a></li>
                                <li><a class="dropdown-item py-2" href="/berita"><i class="fas fa-newspaper me-2"></i>Berita</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <!-- Guest Menu -->
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary btn-sm px-3 py-2 rounded-pill" href="/login">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-primary btn-sm px-3 py-2 rounded-pill" href="/register">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill" href="/admin/login">
                                <i class="fas fa-shield-alt me-1"></i>Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="d-lg-none bg-light border-top py-2 px-3">
            <form class="w-100">
                <div class="input-group">
                    <input type="search" class="form-control form-control-sm" placeholder="Cari informasi..." aria-label="Mobile search">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
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

    <!-- Animation System JS -->
    <script src="/js/animations.js"></script>

    <!-- Custom JS -->
    <script>
        // Initialize additional animations
        $(document).ready(function() {
            // Lazy loading images
            $('.lazy-img').each(function() {
                var img = $(this);
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            img.attr('src', img.data('src'));
                            img.addClass('loaded');
                            observer.unobserve(img[0]);
                        }
                    });
                });
                observer.observe(img[0]);
            });

            // Add animated classes to elements
            $('.card').addClass('fade-in-up');

            // Add floating animation to icons
            $('.bi').each(function(index) {
                if (index % 3 === 0) { // Add floating to every 3rd icon
                    $(this).addClass('floating-element');
                }
            });

            // Add counter animation to statistics
            $('.stat-number').each(function() {
                $(this).addClass('counter');
                var target = parseInt($(this).text().replace(/\D/g, ''));
                $(this).data('target', target);
            });

            // Add enhanced hover effects to service cards
            $('.card').addClass('card-hover-enhanced');

            // Add animated buttons
            $('.btn').addClass('btn-animated');

            // Add animated form inputs
            $('.form-control').addClass('form-control-animated');

            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navigation-clean-search').addClass('scrolled');
                } else {
                    $('.navigation-clean-search').removeClass('scrolled');
                }
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 70
                    }, 1000);
                }
            });
        });
    </script>

	<?= $this->renderSection('scripts') ?>
</body>
</html>
