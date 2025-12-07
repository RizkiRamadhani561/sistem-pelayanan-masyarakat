<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// User routes
$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/(:num)', 'UserController::show/$1');
$routes->get('/users/(:num)/edit', 'UserController::edit/$1');
$routes->post('/users/(:num)/update', 'UserController::update/$1');
$routes->get('/users/(:num)/delete', 'UserController::delete/$1');

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
