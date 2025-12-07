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
		/* Modern Navbar Styles */
		.modern-navbar {
			backdrop-filter: blur(10px);
			background: rgba(255, 255, 255, 0.95) !important;
			border-bottom: 1px solid rgba(0, 0, 0, 0.1);
			transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
		}

		.modern-navbar.scrolled {
			background: rgba(255, 255, 255, 0.98) !important;
			box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
		}

		.modern-nav-link {
			position: relative;
			font-weight: 500;
			color: #495057 !important;
			padding: 0.75rem 1rem !important;
			transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
			border-radius: 8px;
			margin: 0 2px;
		}

		.modern-nav-link:hover {
			color: #007bff !important;
			background: rgba(0, 123, 255, 0.1);
			transform: translateY(-1px);
		}

		.modern-nav-link::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 50%;
			width: 0;
			height: 2px;
			background: linear-gradient(90deg, #007bff, #6610f2);
			transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
			transform: translateX(-50%);
		}

		.modern-nav-link:hover::after {
			width: 80%;
		}

		.modern-user-btn {
			padding: 0.5rem 1rem !important;
			border-radius: 50px !important;
			transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
		}

		.modern-user-btn:hover {
			background: rgba(0, 123, 255, 0.1) !important;
			transform: translateY(-1px);
		}

		.user-icon {
			width: 32px;
			height: 32px;
			border-radius: 50%;
			object-fit: cover;
			border: 2px solid #e9ecef;
		}

		.user-info strong {
			font-size: 0.875rem;
			color: #495057;
		}

		.user-info small {
			font-size: 0.75rem;
			margin-top: -2px;
		}

		/* Enhanced card hover effects */
		.card-hover:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 25px rgba(0,0,0,0.15);
			transition: all 0.3s ease;
		}

		/* Lazy loading animations */
		.lazy-img {
			opacity: 0;
			transition: opacity 0.3s ease;
		}
		.lazy-img.loaded {
			opacity: 1;
		}

		/* Status badges */
		.status-badge {
			font-size: 0.8em;
		}

		/* General animations */
		.fade-in {
			animation: fadeIn 0.5s ease-in;
		}
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(20px); }
			to { transform: translateY(0); opacity: 1; }
		}

		/* Button hover effects */
		.btn {
			transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
		}

		.btn:hover {
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		}

		/* Form enhancements */
		.form-control:focus {
			border-color: #007bff;
			box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
			transform: translateY(-1px);
		}

		/* Responsive enhancements */
		@media (max-width: 991.98px) {
			.modern-navbar {
				background: rgba(255, 255, 255, 1) !important;
			}

			.modern-nav-link {
				padding: 0.5rem 1rem !important;
				margin: 2px 0;
			}

			.navbar-collapse {
				background: rgba(255, 255, 255, 0.95);
				border-radius: 8px;
				margin-top: 1rem;
				padding: 1rem;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			}
		}

		/* Smooth scrolling */
		html {
			scroll-behavior: smooth;
		}

		/* Custom scrollbar */
		::-webkit-scrollbar {
			width: 8px;
		}

		::-webkit-scrollbar-track {
			background: #f1f1f1;
		}

		::-webkit-scrollbar-thumb {
			background: #888;
			border-radius: 4px;
		}

		::-webkit-scrollbar-thumb:hover {
			background: #555;
		}
	</style>
</head>
<body class="bg-light">
    <!-- Modern Professional Navbar -->
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container-fluid px-4">

            <!-- Brand Logo -->
            <a class="navbar-brand" href="/">
                <i class="bi bi-building-fill"></i>
                <span>Kembangan Raya</span>
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu (Desktop) -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">
                            <i class="bi bi-house-door d-lg-none me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/layanan">
                            <i class="bi bi-file-earmark-text d-lg-none me-2"></i>Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pengaduan">
                            <i class="bi bi-exclamation-triangle d-lg-none me-2"></i>Pengaduan
                        </a>
                    </li>
                </ul>

                <!-- Search Bar (Desktop - Centered) -->
                <div class="navbar-search-container d-none d-lg-block">
                    <form class="search-form" action="/search" method="GET">
                        <input type="text" class="search-input" name="q" placeholder="Cari layanan, pengaduan, berita..." autocomplete="off">
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side - User Profile / Auth Buttons -->
                <div class="navbar-profile ms-auto">
                    <?php if (session()->has('user')): ?>
                        <!-- Admin/Petugas Profile -->
                        <div class="dropdown">
                            <a class="user-profile-btn dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzYiIGhlaWdodD0iMzYiIHZpZXdCb3g9IjAgMCAzNiAzNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTgiIGN5PSIxOCIgcj0iMTgiIGZpbGw9IiNFNUU3RUIiLz4KPGNpcmNsZSBjeD0iMTgiIGN5PSI5IiByPSI2IiBmaWxsPSIjOUI5QkE0Ii8+CjxwYXRoIGQ9Ik0wIDI0aDM2djEySDB2LTEyWiIgZmlsbD0iIzlCOUI5NCIvPgo8L3N2Zz4K" alt="Avatar" class="user-avatar">
                                <div class="user-info d-none d-lg-block">
                                    <strong><?= session('user')['nama'] ?></strong>
                                    <small>Administrator</small>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/dashboard">
                                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                                </a>
                                <a class="dropdown-item" href="/admin/notifikasi">
                                    <i class="bi bi-bell"></i> Manajemen Notifikasi
                                </a>
                                <a class="dropdown-item" href="/admin/laporan">
                                    <i class="bi bi-graph-up"></i> Laporan & Analitik
                                </a>
                                <a class="dropdown-item" href="/admin/warga">
                                    <i class="bi bi-people"></i> Kelola Warga
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </div>
                        </div>

                    <?php elseif (session()->has('warga')): ?>
                        <!-- Warga Profile -->
                        <div class="dropdown">
                            <a class="user-profile-btn dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzYiIGhlaWdodD0iMzYiIHZpZXdCb3g9IjAgMCAzNiAzNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTgiIGN5PSIxOCIgcj0iMTgiIGZpbGw9IiNGM0Y0RjYiLz4KPGNpcmNsZSBjeD0iMTgiIGN5PSI5IiByPSI2IiBmaWxsPSIjQ0RDQ0RBIi8+CjxwYXRoIGQ9Ik0wIDI0aDM2djEySDB2LTEyWiIgZmlsbD0iIzlCOUI5NCIvPgo8L3N2Zz4K" alt="Avatar" class="user-avatar">
                                <div class="user-info d-none d-lg-block">
                                    <strong><?= session('warga')['nama_lengkap'] ?></strong>
                                    <small>Warga</small>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/pengaduan">
                                    <i class="bi bi-exclamation-triangle"></i> Pengaduan Saya
                                </a>
                                <a class="dropdown-item" href="/permohonan">
                                    <i class="bi bi-file-earmark-text"></i> Permohonan Saya
                                </a>
                                <a class="dropdown-item" href="/notifikasi">
                                    <i class="bi bi-bell"></i> Notifikasi
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/profile">
                                    <i class="bi bi-person-gear"></i> Pengaturan Profil
                                </a>
                                <a class="dropdown-item" href="/profile?tab=password">
                                    <i class="bi bi-shield-lock"></i> Ubah Kata Sandi
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Guest Authentication -->
                        <div class="guest-actions">
                            <a href="/login" class="btn-login">
                                <i class="bi bi-box-arrow-in-right d-lg-none me-1"></i>
                                <span class="d-none d-lg-inline">Masuk</span>
                                <span class="d-lg-none">Login</span>
                            </a>
                            <a href="/register" class="btn-register">
                                <i class="bi bi-person-plus d-lg-none me-1"></i>
                                <span class="d-none d-lg-inline">Daftar</span>
                                <span class="d-lg-none">Register</span>
                            </a>
                            <a href="/admin/login" class="btn-admin">
                                <i class="bi bi-shield-lock d-lg-none me-1"></i>
                                <span class="d-none d-lg-inline">Admin</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="d-lg-none w-100 mt-3 px-3">
                <form class="search-form" action="/search" method="GET">
                    <input type="text" class="search-input" name="q" placeholder="Cari layanan, pengaduan, berita..." autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
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

	<!-- Bootstrap 4 JS (Local) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

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

            // Navbar scroll effect for modern navbar
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.modern-navbar').addClass('scrolled');
                } else {
                    $('.modern-navbar').removeClass('scrolled');
                }
            });

            // Search form enhancement
            $('.search-input').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });

            // Mobile menu enhancement
            $('.navbar-toggler').on('click', function() {
                $('.modern-navbar').toggleClass('menu-open');
            });

            // Dropdown hover effects for desktop
            if ($(window).width() > 991) {
                $('.dropdown').hover(
                    function() {
                        $(this).find('.dropdown-menu').stop(true, true).slideDown(200);
                    },
                    function() {
                        $(this).find('.dropdown-menu').stop(true, true).slideUp(200);
                    }
                );
            }

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
