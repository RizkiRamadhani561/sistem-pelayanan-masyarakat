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

	<!-- Bootstrap 4 CSS (CDN) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
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
    <div>
        <div class="header-blue">
            <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
                <div class="container">
                    <a class="navbar-brand" href="/">Sistem Pelayanan Masyarakat</a>
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="/">Beranda</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/layanan">Layanan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/pengaduan">Pengaduan</a>
                            </li>
                            <?php if (session()->has('user')): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                                    Admin <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" role="presentation" href="/dashboard">Dashboard</a>
                                    <a class="dropdown-item" role="presentation" href="/admin/notifikasi">Notifikasi</a>
                                    <a class="dropdown-item" role="presentation" href="/admin/laporan">Laporan</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="presentation" href="/logout">Logout</a>
                                </div>
                            </li>
                            <?php elseif (session()->has('warga')): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                                    Akun Saya <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" role="presentation" href="/pengaduan">Pengaduan Saya</a>
                                    <a class="dropdown-item" role="presentation" href="/permohonan">Permohonan Saya</a>
                                    <a class="dropdown-item" role="presentation" href="/notifikasi">Notifikasi</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="presentation" href="/logout">Logout</a>
                                </div>
                            </li>
                            <?php endif; ?>
                        </ul>

                        <form class="form-inline mr-auto" target="_self">
                            <div class="form-group">
                                <label for="search-field"><i class="fa fa-search"></i></label>
                                <input class="form-control search-field" type="search" name="search" id="search-field" placeholder="Cari...">
                            </div>
                        </form>

                        <?php if (!session()->has('user') && !session()->has('warga')): ?>
                        <span class="navbar-text">
                            <a href="/login" class="login">Log In</a>
                        </span>
                        <a class="btn btn-light action-button" role="button" href="/register">Sign Up</a>
                        <a class="btn btn-outline-light ml-2" role="button" href="/admin/login">Admin</a>
                        <?php endif; ?>
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

	<!-- Bootstrap 4 JS (CDN) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

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
