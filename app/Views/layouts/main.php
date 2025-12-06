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
	<!-- Minimalistic Navbar -->
	<!-- Navbar Modern -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top modern-navbar">
            <div class="container py-2">

                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="/">
                    <i class="bi bi-building fs-4 me-2 text-primary"></i>
                    <span class="brand-text">Kembangan Raya</span>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="mainNavbar">

                    <!-- Left Menu -->
                    <ul class="navbar-nav mx-auto gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="/">
                                <i class="bi bi-house-door d-lg-none me-2"></i> Beranda
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="/layanan">
                                <i class="bi bi-file-earmark-text d-lg-none me-2"></i> Layanan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="/pengaduan">
                                <i class="bi bi-exclamation-triangle d-lg-none me-2"></i> Pengaduan
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side / User Section -->
                    <ul class="navbar-nav ms-auto">

                        <?php if (session()->has('user')): ?>
                        <!-- Admin/Petugas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle modern-user-btn" href="#" data-bs-toggle="dropdown">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iMTYiIGZpbGw9IiNFNUU3RUIiLz4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxMSIgcj0iNSIgZmlsbD0iIzlCOUI5NCIvPgo8cGF0aCBkPSJNMCAyNGgzMnY4SDB2LThaIiBmaWxsPSIjOUI5QkE0Ii8+Cjwvc3ZnPgo=" class="user-icon me-2">
                                <span class="user-info d-none d-lg-inline">
                                    <strong><?= session('user')['nama'] ?></strong>
                                    <small class="text-muted d-block"><?= ucfirst(session('user')['role']) ?></small>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item py-2" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item py-2" href="/admin/notifikasi"><i class="bi bi-bell me-2"></i>Notifikasi</a></li>
                                <li><a class="dropdown-item py-2" href="/admin/laporan"><i class="bi bi-graph-up me-2"></i>Laporan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </li>

                        <?php elseif (session()->has('warga')): ?>
                        <!-- Warga -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle modern-user-btn" href="#" data-bs-toggle="dropdown">
                                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iMTYiIGZpbGw9IiNFNUU3RUIiLz4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxMSIgcj0iNSIgZmlsbD0iIzlCOUI5NCIvPgo8cGF0aCBkPSJNMCAyNGgzMnY4SDB2LThaIiBmaWxsPSIjOUI5QkE0Ii8+Cjwvc3ZnPgo=" class="user-icon me-2">
                                <span class="user-info d-none d-lg-inline">
                                    <strong><?= session('warga')['nama_lengkap'] ?></strong>
                                    <small class="text-muted d-block">Warga</small>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item py-2" href="/pengaduan"><i class="bi bi-exclamation-triangle me-2"></i>Pengaduan Saya</a></li>
                                <li><a class="dropdown-item py-2" href="/permohonan"><i class="bi bi-file-earmark-text me-2"></i>Permohonan Saya</a></li>
                                <li><a class="dropdown-item py-2" href="/notifikasi"><i class="bi bi-bell me-2"></i>Notifikasi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </li>

                        <?php else: ?>
                        <!-- Guest -->
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary px-3" href="/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>

                        <li class="nav-item me-3">
                            <a class="btn btn-primary px-3" href="/register">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <button class="btn btn-secondary dropdown-toggle px-3" data-bs-toggle="dropdown">
                                <i class="bi bi-shield-lock me-1"></i> Admin
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item py-2" href="/admin/login"><i class="bi bi-shield-lock me-2"></i>Login Admin/Petugas</a></li>
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

    <!-- Animation System JS -->
    <script src="/js/animations.js"></script>

    <!-- Custom JS -->
    <script>
        // Initialize additional animations
        document.addEventListener('DOMContentLoaded', function() {
            // Lazy loading images
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

            // Add animated classes to elements
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('fade-in-up');
            });

            // Add floating animation to icons
            const icons = document.querySelectorAll('.bi');
            icons.forEach((icon, index) => {
                if (index % 3 === 0) { // Add floating to every 3rd icon
                    icon.classList.add('floating-element');
                }
            });

            // Add counter animation to statistics
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                stat.classList.add('counter');
                stat.dataset.target = stat.textContent.replace(/\D/g, '');
            });

            // Add enhanced hover effects to service cards
            const serviceCards = document.querySelectorAll('.card');
            serviceCards.forEach(card => {
                card.classList.add('card-hover-enhanced');
            });

            // Add animated buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.classList.add('btn-animated');
            });

            // Add animated form inputs
            const formInputs = document.querySelectorAll('.form-control');
            formInputs.forEach(input => {
                input.classList.add('form-control-animated');
            });
        });
    </script>

	<?= $this->renderSection('scripts') ?>
</body>
</html>
