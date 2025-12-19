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
 * - RESTful URL patterns untuk CRUD operations
 * - Hierarchical URL structure (admin/, api/, etc.)
 * - Parameter binding dengan placeholders (:num, :segment)
 * - HTTP method specificity (GET, POST, PUT, DELETE)
 * - Security-aware routing (admin routes separated)
 *
 * =======================================================================
 * ROUTE PLACEHOLDERS - PENJELASAN LENGKAP DAN DETAIL
 * =======================================================================
 *
 * CodeIgniter 4 menggunakan sistem placeholders untuk menangani parameter dinamis
 * dalam URL routing. Placeholders ini secara otomatis dikonversi ke regular expressions.
 *
 * ================================ :num PLACEHOLDER ================================
 *
 * DEFINISI DETAIL:
 * :num adalah placeholder yang MATCH dengan satu atau lebih karakter digit (0-9).
 * Ini adalah placeholder PALING AMAN untuk data numerik karena hanya menerima angka.
 *
 * TEKNIS:
 * - REGEX EQUIVALENT: ([0-9]+)
 * - MINIMUM LENGTH: 1 karakter (tidak boleh kosong)
 * - MAXIMUM LENGTH: Tidak terbatas (teori), tapi praktis terbatas oleh URL limits
 * - CHARACTER SET: Hanya 0-9 (tidak ada huruf, simbol, atau spasi)
 *
 * CONTOH YANG COCOK (VALID):
 * /users/123          → $1 = "123"
 * /pengaduan/1        → $1 = "1"
 * /wargas/999999      → $1 = "999999"
 * /layanan/42         → $1 = "42"
 *
 * CONTOH YANG TIDAK COCOK (INVALID - akan return 404):
 * /users/abc          → bukan angka
 * /users/123abc       → mengandung huruf
 * /users/12 3         → ada spasi
 * /users/12.34        → ada titik desimal
 * /users/-123         → ada tanda minus
 * /users/             → kosong setelah slash
 *
 * KEGUNAAN DALAM SISTEM INI:
 * 1. USER MANAGEMENT: /users/(:num) → UserController::show($id)
 * 2. WARGA MANAGEMENT: /wargas/(:num) → WargaController::show($id)
 * 3. PENGADUAN: /pengaduan/(:num) → PengaduanController::show($id)
 * 4. LAYANAN: /layanan/(:num) → JenisLayananController::show($id)
 * 5. DASHBOARD WARGA: /dashboard/warga/(:num) → DashboardController::showWarga($id)
 * 6. BERITA ADMIN: /admin/berita/(:num)/edit → BeritaController::edit($id)
 * 7. NOTIFIKASI: /admin/notifikasi/(:num)/delete → NotifikasiController::delete($id)
 *
 * IMPLEMENTASI DI CONTROLLER:
 * public function show($id)
 * {
 *     // $id sudah terjamin numerik karena :num placeholder
 *     $user = $this->userModel->find($id);
 *     if (!$user) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *     return view('user/show', ['user' => $user]);
 * }
 *
 * KEAMANAN (SECURITY):
 * INPUT VALIDATION: Otomatis memfilter hanya angka
 * SQL INJECTION: Tidak mungkin karena hanya numerik
 * XSS PROTECTION: Numerik tidak mengandung script
 * DIRECTORY TRAVERSAL: Tidak bisa akses ../ atau path traversal
 * ZERO TRUST: Tetap perlu validasi eksistensi data di database
 *
 * KESALAHAN UMUM :
 * Menggunakan :segment untuk ID → Berbahaya, bisa inject string
 * Tidak validasi di controller → Meski :num aman, tetap cek eksistensi
 * Menggunakan :any untuk ID → Sangat berbahaya, bisa path traversal
 *
 * ================================ :segment PLACEHOLDER ================================
 *
 * DEFINISI DETAIL:
 * :segment adalah placeholder yang MATCH dengan semua karakter KECUALI slash (/).
 * Digunakan untuk string identifier seperti slug, nama, atau kode alfanumerik.
 *
 * TEKNIS:
 * - REGEX EQUIVALENT: ([^/]+)
 * - MINIMUM LENGTH: 1 karakter
 * - MAXIMUM LENGTH: Tidak terbatas hingga URL limit
 * - CHARACTER SET: Semua karakter KECUALI forward slash (/)
 * - CASE SENSITIVE: Ya, membedakan huruf besar-kecil
 *
 * CONTOH YANG COCOK:
 * /berita/judul-artikel-2024    → $1 = "judul-artikel-2024"
 * /berita/pengumuman-penting    → $1 = "pengumuman-penting"
 * /berita/berita-123            → $1 = "berita-123"
 * /search/query+pencarian       → $1 = "query+pencarian"
 *
 * CONTOH YANG TIDAK COCOK:
 * /berita/judul/artikel         → ada slash, akan dipecah jadi 2 segment
 * /berita/                      → kosong setelah slash
 *
 * KEGUNAAN DALAM SISTEM INI:
 * 1. BERITA SLUG: /berita/(:segment) → BeritaController::show($slug)
 * 2. EXPORT LAPORAN: /admin/laporan/export/(:segment)/(:segment) → LaporanController::export($type, $format)
 *
 * IMPLEMENTASI DI CONTROLLER:
 * public function show($slug)
 * {
 *     // $slug bisa berisi apa saja kecuali slash
 *     // PERLU VALIDASI MANUAL untuk keamanan
 *     $berita = $this->beritaModel->where('slug', $slug)->first();
 *     if (!$berita) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *     return view('berita/show', ['berita' => $berita]);
 * }
 *
 * VALIDASI YANG DIPERLUKAN:
 * - Escape SQL injection
 * - Sanitize XSS
 * - Validasi panjang string
 * - Validasi format (jika diperlukan)
 *
 * ================================ :any PLACEHOLDER ================================
 *
 * DEFINISI DETAIL:
 * :any adalah placeholder yang MATCH dengan semua karakter TERMASUK slash (/).
 * Placeholder ini SANGAT BERBAHAYA dan jarang digunakan.
 *
 * TEKNIS:
 * - REGEX EQUIVALENT: (.+)
 * - MINIMUM LENGTH: 1 karakter
 * - CHARACTER SET: Semua karakter termasuk slash
 * - RISK LEVEL: TINGGI - gunakan hanya untuk path file terkontrol
 *
 * CONTOH PENGGUNAAN (JARANG):
 * /files/path/to/document.pdf    → $1 = "path/to/document.pdf"
 * /download/folder/subfolder/file.zip → $1 = "folder/subfolder/file.zip"
 *
 * KEGUNAAN DALAM SISTEM INI:
 * - TIDAK DIGUNAKAN dalam sistem ini (karena berbahaya)
 * - Jika perlu, gunakan untuk file download dengan validasi ketat
 *
 * ================================ PARAMETER PASSING ================================
 *
 * Cara CodeIgniter melewatkan parameter ke controller:
 *
 * SINTAKS ROUTE: 'ControllerName::methodName/$1/$2/$3...'
 * - $1 = Parameter pertama (dari placeholder pertama)
 * - $2 = Parameter kedua (dari placeholder kedua)
 * - dst...
 *
 * CONTOH REAL DARI FILE INI:
 * $routes->get('/users/(:num)', 'UserController::show/$1');
 * URL: /users/123
 * RESULT: UserController::show(123)
 *
 * $routes->get('/users/(:num)/edit', 'UserController::edit/$1');
 * URL: /users/123/edit
 * RESULT: UserController::edit(123)
 *
 * $routes->get('/admin/laporan/export/(:segment)/(:segment)', 'LaporanController::export/$1/$2');
 * URL: /admin/laporan/export/pengaduan/pdf
 * RESULT: LaporanController::export('pengaduan', 'pdf')
 *
 * ================================ BEST PRACTICES ================================
 *
 * 1. SECURITY FIRST:
 *    - Selalu gunakan :num untuk database ID
 *    - Gunakan :segment dengan validasi ketat
 *    - Hindari :any kecuali benar-benar diperlukan
 *    - Validasi semua parameter di controller
 *
 * 2. PERFORMANCE:
 *    - :num lebih cepat diproses karena regex sederhana
 *    - :segment sedikit lebih lambat karena lebih kompleks
 *    - :any paling lambat dan berbahaya
 *
 * 3. NAMING CONVENTIONS:
 *    - ID fields: selalu (:num)
 *    - Slugs: (:segment) dengan URL-friendly format
 *    - Status codes: (:segment) dengan enum validation
 *    - File paths: hindari (:any), gunakan validasi ketat
 *
 * 4. ERROR HANDLING:
 *    - Selalu cek eksistensi data di database
 *    - Return 404 jika data tidak ditemukan
 *    - Log invalid parameter attempts
 *
 * 5. MIGRATION FROM OTHER FRAMEWORKS:
 *    - Laravel: {id} → (:num), {slug} → (:segment)
 *    - Express.js: :id → (:num), :slug → (:segment)
 *    - Django: <int:id> → (:num), <slug:slug> → (:segment)
 *
 * ================================ VALIDATION EXAMPLES ================================
 *
 * Di Controller, selalu validasi meski menggunakan :num:
 *
 * public function show($id)
 * {
 *     // Validasi numerik (redundant tapi aman)
 *     if (!is_numeric($id)) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     // Validasi range
 *     if ($id < 1 || $id > 999999) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     // Cek eksistensi di database
 *     $user = $this->userModel->find($id);
 *     if (!$user) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     return view('user/show', ['user' => $user]);
 * }
 *
 * Untuk :segment, validasi lebih ketat:
 *
 * public function show($slug)
 * {
 *     // Validasi format slug (hanya alphanumeric, dash, underscore)
 *     if (!preg_match('/^[a-zA-Z0-9_-]+$/', $slug)) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     // Validasi panjang
 *     if (strlen($slug) < 3 || strlen($slug) > 100) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     // Cek di database
 *     $berita = $this->beritaModel->where('slug', $slug)->first();
 *     if (!$berita) {
 *         throw new \CodeIgniter\Exceptions\PageNotFoundException();
 *     }
 *
 *     return view('berita/show', ['berita' => $berita]);
 * }
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
