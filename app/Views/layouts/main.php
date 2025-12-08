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
		/* Header Blue Navbar Styles - Based on Bootstrap 4 Theme */
		.header-blue {
			background: linear-gradient(135deg, #172a74, #21a9af);
			background-color: #184e8e;
			padding-bottom: 80px;
			font-family: 'Source Sans Pro', sans-serif;
		}

		@media (min-width: 768px) {
			.header-blue {
				padding-bottom: 120px;
			}
		}

		.header-blue .navbar {
			background: transparent;
			padding-top: 0.75rem;
			padding-bottom: 0.75rem;
			color: #fff;
			border-radius: 0;
			box-shadow: none;
			border: none;
		}

		@media (min-width: 768px) {
			.header-blue .navbar {
				padding-top: 1rem;
				padding-bottom: 1rem;
			}
		}

		.header-blue .navbar .navbar-brand {
			font-weight: bold;
			color: inherit;
		}

		.header-blue .navbar .navbar-brand:hover {
			color: #f0f0f0;
		}

		.header-blue .navbar .navbar-collapse {
			border-top: 1px solid rgba(255, 255, 255, 0.3);
			margin-top: 0.5rem;
		}

		@media (min-width: 768px) {
			.header-blue .navbar .navbar-collapse {
				border-color: transparent;
				margin: 0;
			}
		}

		.header-blue .navbar .navbar-collapse span .login {
			color: #d9d9d9;
			margin-right: 0.5rem;
			text-decoration: none;
		}

		.header-blue .navbar .navbar-collapse span .login:hover {
			color: #fff;
		}

		.header-blue .navbar .navbar-toggler {
			border-color: rgba(255, 255, 255, 0.3);
		}

		.header-blue .navbar .navbar-toggler:hover,
		.header-blue .navbar .navbar-toggler:focus {
			background: none;
		}

		.header-blue .navbar .navbar-nav a.active,
		.header-blue .navbar .navbar-nav>.show .dropdown-item {
			background: none;
			box-shadow: none;
		}

		@media (min-width: 768px) {
			.header-blue .navbar-nav .nav-link {
				padding-left: 0.7rem;
				padding-right: 0.7rem;
			}
		}

		@media (min-width: 992px) {
			.header-blue .navbar-nav .nav-link {
				padding-left: 1.2rem;
				padding-right: 1.2rem;
			}
		}

		.header-blue .navbar .navbar-nav>.li>.dropdown-menu {
			margin-top: -5px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			background-color: #fff;
			border-radius: 2px;
		}

		.header-blue .navbar .dropdown-menu .dropdown-item:focus,
		.header-blue .navbar .dropdown-menu .dropdown-item {
			line-height: 2;
			color: #37434d;
		}

		.header-blue .navbar .dropdown-menu .dropdown-item:focus,
		.header-blue .navbar .dropdown-menu .dropdown-item:hover {
			background: #ebeff1;
		}

		.header-blue .action-button,
		.header-blue .action-button:not(.disabled):active {
			border: 1px solid rgba(255, 255, 255, 0.7);
			border-radius: 40px;
			color: #ebeff1;
			box-shadow: none;
			text-shadow: none;
			padding: 0.3rem 0.8rem;
			background: transparent;
			transition: background-color 0.25s;
			outline: none;
		}

		.header-blue .action-button:hover {
			color: #fff;
		}

		.header-blue .navbar .form-inline label {
			color: #d9d9d9;
		}

		.header-blue .navbar .form-inline .search-field {
			display: inline-block;
			width: 80%;
			background: none;
			border: none;
			border-bottom: 1px solid transparent;
			border-radius: 0;
			color: #ccc;
			box-shadow: none;
			color: inherit;
			transition: border-bottom-color 0.3s;
		}

		.header-blue .navbar .form-inline .search-field:focus {
			border-bottom: 1px solid #ccc;
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
			to { opacity: 1; transform: translateY(0); }
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
<body>
    <div>
        <div class="header-blue">
            <nav class="navbar navbar-dark navbar-expand-lg navigation-clean-search">
                <div class="container">

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
                <ul class="navbar-nav">
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
                    <li class="nav-item">
                        <a class="nav-link" href="/berita">
                            <i class="bi bi-newspaper d-lg-none me-2"></i>Berita
                        </a>
                    </li>
                </ul>

                <!-- Right Side - Search & User Profile -->
                <div class="navbar-right d-flex align-items-center ms-auto">
                    <!-- Search Bar (Desktop) -->
                    <div class="navbar-search d-none d-lg-block me-3">
                        <form class="form-inline" action="/search" method="GET">
                            <div class="form-group">
                                <label for="search-field" class="mr-2"><i class="fa fa-search"></i></label>
                                <input class="form-control search-field" type="search" name="q" id="search-field" placeholder="Cari...">
                            </div>
                        </form>
                    </div>

                    <!-- User Profile / Auth Buttons -->
                    <div class="navbar-profile">
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
                                <a class="dropdown-item" href="/admin/berita">
                                    <i class="bi bi-newspaper"></i> Manajemen Berita
                                </a>
                                <a class="dropdown-item" href="/admin/notifikasi">
                                    <i class="bi bi-bell"></i> Manajemen Notifikasi
                                </a>
                                <a class="dropdown-item" href="/admin/laporan">
                                    <i class="bi bi-graph-up"></i> Laporan & Analitik
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
        </div>
    </div>


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

            // Search form enhancement for header-blue navbar
            $('.search-field').on('focus', function() {
                $(this).addClass('focused');
            }).on('blur', function() {
                $(this).removeClass('focused');
            });

            // Enhanced dropdown behavior for desktop
            if ($(window).width() > 991) {
                $('.dropdown').hover(
                    function() {
                        // Only apply hover effect if dropdown is not already open from click
                        if (!$(this).hasClass('show')) {
                            $(this).find('.dropdown-menu').stop(true, true).slideDown(200);
                        }
                    },
                    function() {
                        // Only hide on hover out if dropdown was opened by hover (not click)
                        if (!$(this).hasClass('show')) {
                            $(this).find('.dropdown-menu').stop(true, true).slideUp(200);
                        }
                    }
                );

                // Prevent dropdown from closing on mouse movement within the dropdown
                $('.dropdown-menu').on('mouseenter', function() {
                    $(this).stop(true, true).show();
                });

                $('.dropdown-menu').on('mouseleave', function() {
                    var dropdown = $(this).closest('.dropdown');
                    // Only hide if it was opened by hover, not by click
                    if (!dropdown.hasClass('show')) {
                        $(this).stop(true, true).slideUp(200);
                    }
                });
            }

            // Handle dropdown toggle button clicks
            $('.dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                var dropdown = $(this).closest('.dropdown');
                var menu = dropdown.find('.dropdown-menu');

                // Toggle the dropdown
                if (dropdown.hasClass('show')) {
                    dropdown.removeClass('show');
                    menu.stop(true, true).slideUp(200);
                } else {
                    // Close other open dropdowns first
                    $('.dropdown').removeClass('show').find('.dropdown-menu').stop(true, true).slideUp(200);

                    dropdown.addClass('show');
                    menu.stop(true, true).slideDown(200);
                }
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown').removeClass('show').find('.dropdown-menu').stop(true, true).slideUp(200);
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
