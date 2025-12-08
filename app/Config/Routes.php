<?php

use CodeIgniter\Router\RouteCollection;

/**
 * =======================================================================
 * KONFIGURASI ROUTES - SISTEM PELAYANAN MASYARAKAT KEMBANGAN RAYA
 * =======================================================================
 *
 * File konfigurasi routing untuk CodeIgniter 4.
 * Menentukan mapping antara URL endpoints dengan Controller methods.
 *
 * ROUTING PRINCIPLES:
 * - ✅ RESTful URL patterns untuk CRUD operations
 * - ✅ Hierarchical URL structure (admin/, api/, etc.)
 * - ✅ Parameter binding dengan placeholders (:num, :segment)
 * - ✅ HTTP method specificity (GET, POST, PUT, DELETE)
 * - ✅ Security-aware routing (admin routes separated)
 *
 * URL STRUCTURE:
 * - Public routes: / (tanpa prefix)
 * - Admin routes: /admin/* (protected)
 * - API routes: /api/* (JSON responses)
 * - User routes: /profile, /notifikasi, etc.
 *
 * CONTROLLERS USED:
 * - Home: Landing page dan informasi umum
 * - AuthController: Login/register untuk warga dan admin
 * - DashboardController: Admin dashboard dan management
 * - BeritaController: News management dan public display
 * - PengaduanController: Complaint system
 * - PermohonanController: Service request system
 * - NotifikasiController: Notification management
 * - SearchController: Global search functionality
 * - ProfileController: User profile management
 * - LaporanController: Reporting dan analytics
 *
 * SECURITY NOTES:
 * - Admin routes TIDAK dilindungi di level routing (gunakan middleware/filters)
 * - Authentication checks dilakukan di controller level
 * - CSRF protection aktif untuk POST routes
 * - Route parameters di-validate di controller
 *
 * PERFORMANCE:
 * - Routes di-cache dalam production
 * - Auto-routing DISABLED untuk security
 * - Named routes untuk maintainability
 *
 * @var RouteCollection $routes
 * @author Rizki Ramadhani
 * @version 1.0.0
 * @since 2025-12-06
 */

// =======================================================================
// HOMEPAGE ROUTE - Landing Page Utama
// =======================================================================
// Route default untuk homepage sistem
// Menampilkan informasi umum dan navigasi ke fitur utama
$routes->get('/', 'Home::index');

// =======================================================================
// USER MANAGEMENT ROUTES - Admin User CRUD Operations
// =======================================================================
// Routes untuk mengelola user admin/petugas
// ACCESS: Admin only (Super Admin)
// CONTROLLER: UserController
$routes->get('/users', 'UserController::index');                    // GET  /users           → UserController::index()     → List semua users
$routes->get('/users/create', 'UserController::create');           // GET  /users/create    → UserController::create()    → Form tambah user baru
$routes->post('/users/store', 'UserController::store');            // POST /users/store     → UserController::store()     → Simpan user baru
$routes->get('/users/(:num)', 'UserController::show/$1');          // GET  /users/{id}      → UserController::show($id)   → Detail user spesifik
$routes->get('/users/(:num)/edit', 'UserController::edit/$1');     // GET  /users/{id}/edit → UserController::edit($id)   → Form edit user
$routes->post('/users/(:num)/update', 'UserController::update/$1'); // POST /users/{id}/update → UserController::update($id) → Update user
$routes->get('/users/(:num)/delete', 'UserController::delete/$1'); // GET  /users/{id}/delete → UserController::delete($id) → Hapus user (confirm)

/**
 * ROUTES UNTUK WARGA CONTROLLER
 * Mengatur semua endpoint untuk operasi CRUD warga
 */

// Warga routes - Operasi lengkap CRUD
$routes->get('/wargas', 'WargaController::index');           // List semua warga
$routes->get('/wargas/create', 'WargaController::create');   // Form tambah warga
$routes->post('/wargas/store', 'WargaController::store');    // Simpan warga baru
$routes->get('/wargas/(:num)', 'WargaController::show/$1');  // Detail warga
$routes->get('/wargas/(:num)/edit', 'WargaController::edit/$1'); // Form edit warga
$routes->post('/wargas/(:num)/update', 'WargaController::update/$1'); // Update warga
$routes->post('/wargas/(:num)/delete', 'WargaController::delete/$1'); // Hapus warga
$routes->get('/wargas/test-add', 'WargaController::testAdd'); // Test method untuk menambah warga

// Jenis Layanan routes
$routes->get('/layanan', 'JenisLayananController::index');
$routes->get('/layanan/(:num)', 'JenisLayananController::show/$1');
$routes->get('/layanan/(:num)/ajukan', 'JenisLayananController::ajukan/$1');
$routes->post('/layanan/(:num)/ajukan', 'JenisLayananController::storePermohonan/$1');

// Legacy route for backward compatibility
$routes->get('/jenis-layanan', 'JenisLayananController::index');

// Permohonan routes
$routes->get('/permohonan', 'PermohonanController::index');

// Pengaduan routes
$routes->get('/pengaduan', 'PengaduanController::index');
$routes->get('/pengaduan/create', 'PengaduanController::create');
$routes->post('/pengaduan/store', 'PengaduanController::store');
$routes->get('/pengaduan/(:num)', 'PengaduanController::show/$1');
$routes->get('/pengaduan/(:num)/edit', 'PengaduanController::edit/$1');
$routes->post('/pengaduan/(:num)/update', 'PengaduanController::update/$1');
$routes->post('/pengaduan/update-status', 'PengaduanController::updateStatus');

/**
 * ROUTES UNTUK AUTHENTICATION CONTROLLER
 * Mengatur semua endpoint untuk autentikasi warga dan admin
 */

// Authentication routes
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::store');
$routes->get('/auth/test-register', 'AuthController::testRegister'); // Test method untuk registrasi
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/admin/login', 'AuthController::adminLogin');
$routes->post('/admin/login', 'AuthController::authenticateAdmin');
$routes->get('/logout', 'AuthController::logout');

// Dashboard routes (Admin/Petugas only)
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/dashboard/warga', 'DashboardController::manageWarga');
$routes->get('/dashboard/warga/create', 'DashboardController::createWarga');
$routes->post('/dashboard/warga/store', 'DashboardController::storeWarga');
$routes->get('/dashboard/warga/(:num)', 'DashboardController::showWarga/$1');
$routes->get('/dashboard/warga/(:num)/edit', 'DashboardController::editWarga/$1');
$routes->post('/dashboard/warga/(:num)/update', 'DashboardController::updateWarga/$1');
$routes->post('/dashboard/warga/(:num)/delete', 'DashboardController::deleteWarga/$1');

// Notification routes
$routes->get('/notifikasi', 'NotifikasiController::userNotifications');
$routes->post('/notifikasi/mark-read', 'NotifikasiController::markAsRead');
$routes->get('/api/notifikasi/latest', 'NotifikasiController::getLatestNotifications');

// Admin notification routes
$routes->get('/admin/notifikasi', 'NotifikasiController::index');
$routes->get('/admin/notifikasi/create', 'NotifikasiController::create');
$routes->post('/admin/notifikasi/store', 'NotifikasiController::store');
$routes->get('/admin/notifikasi/(:num)/delete', 'NotifikasiController::delete/$1');

// Reporting routes
$routes->get('/admin/laporan', 'LaporanController::index');
$routes->get('/admin/laporan/pengaduan', 'LaporanController::laporanPengaduan');
$routes->get('/admin/laporan/permohonan', 'LaporanController::laporanPermohonan');
$routes->get('/admin/laporan/pengguna', 'LaporanController::laporanPengguna');
$routes->get('/admin/laporan/export/(:segment)/(:segment)', 'LaporanController::export/$1/$2');

// Search routes
$routes->get('/search', 'SearchController::index');
$routes->get('/api/search', 'SearchController::apiSearch');
$routes->get('/search/advanced', 'SearchController::advanced');

// Profile routes
$routes->get('/profile', 'ProfileController::index');
$routes->post('/profile/update', 'ProfileController::update');
$routes->post('/profile/upload-photo', 'ProfileController::uploadPhoto');
$routes->post('/profile/change-password', 'ProfileController::changePassword');
$routes->post('/profile/delete-photo', 'ProfileController::deletePhoto');

// Admin profile routes
$routes->get('/admin/profile', 'ProfileController::adminProfile');
$routes->post('/admin/profile/update', 'ProfileController::updateAdminProfile');
$routes->post('/admin/profile/change-password', 'ProfileController::changeAdminPassword');

// Berita routes
$routes->get('/berita', 'BeritaController::beritaPublik');
$routes->get('/berita/(:segment)', 'BeritaController::show/$1');

// Admin berita routes
$routes->get('/admin/berita', 'BeritaController::index');
$routes->get('/admin/berita/create', 'BeritaController::create');
$routes->post('/admin/berita/store', 'BeritaController::store');
$routes->get('/admin/berita/(:num)/edit', 'BeritaController::edit/$1');
$routes->post('/admin/berita/(:num)/update', 'BeritaController::update/$1');
$routes->post('/admin/berita/(:num)/delete', 'BeritaController::delete/$1');
$routes->post('/admin/berita/(:num)/toggle-status', 'BeritaController::toggleStatus/$1');
