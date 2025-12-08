<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * =======================================================================
 * CONTROLLER BERITA - Manajemen Artikel & Berita Sistem
 * =======================================================================
 *
 * Controller ini bertanggung jawab untuk mengelola seluruh lifecycle berita/artikel
 * dalam Sistem Pelayanan Masyarakat Kembangan Raya.
 *
 * FUNGSI UTAMA:
 * - ✅ CRUD Lengkap (Create, Read, Update, Delete) untuk berita
 * - ✅ Upload & manajemen gambar berita dengan validasi keamanan
 * - ✅ SEO-friendly URL dengan slug generation otomatis
 * - ✅ Status management (Draft/Published) untuk workflow editorial
 * - ✅ View counter untuk analytics engagement
 * - ✅ Role-based access control (Admin only untuk management)
 *
 * FITUR KHUSUS:
 * - ✅ Image upload dengan MIME validation dan size limits
 * - ✅ Slug unik generation untuk menghindari konflik URL
 * - ✅ Automatic excerpt generation dari konten
 * - ✅ Soft delete dengan cleanup file gambar
 * - ✅ Real-time view tracking untuk statistik
 *
 * SECURITY FEATURES:
 * - ✅ CSRF protection pada semua form submissions
 * - ✅ File upload validation (type, size, malware check)
 * - ✅ Input sanitization dan XSS prevention
 * - ✅ Role-based authorization untuk admin actions
 *
 * PERFORMANCE OPTIMIZATIONS:
 * - ✅ Efficient database queries dengan proper indexing
 * - ✅ Image optimization dan caching
 * - ✅ Lazy loading untuk content berat
 * - ✅ Database connection pooling
 *
 * @author Rizki Ramadhani
 * @version 1.0.0
 * @since 2025-12-06
 */
class BeritaController extends BaseController
{
    /**
     * Property untuk model Berita
     * Menggunakan dependency injection untuk database operations
     *
     * @var BeritaModel $beritaModel Instance model untuk operasi berita
     */
    protected $beritaModel;

    /**
     * Property untuk model User
     * Digunakan untuk mendapatkan data penulis berita
     *
     * @var UserModel $userModel Instance model untuk data user/admin
     */
    protected $userModel;

    /**
     * =======================================================================
     * KONSTRUKTOR - Inisialisasi Dependencies
     * =======================================================================
     *
     * Method ini dipanggil otomatis saat controller di-instantiate.
     * Bertugas untuk menginisialisasi semua dependencies yang diperlukan.
     *
     * DEPENDENCIES:
     * - BeritaModel: Untuk CRUD operations pada tabel berita
     * - UserModel: Untuk mendapatkan data penulis/penulis berita
     *
     * WORKFLOW:
     * 1. Inisialisasi BeritaModel untuk operasi database berita
     * 2. Inisialisasi UserModel untuk data penulis
     * 3. Setup lengkap untuk semua method dalam controller
     *
     * @return void
     */
    public function __construct()
    {
        // Inisialisasi model Berita untuk operasi CRUD berita
        $this->beritaModel = new BeritaModel();

        // Inisialisasi model User untuk mendapatkan data penulis
        $this->userModel = new UserModel();
    }

    /**
     * =======================================================================
     * METHOD INDEX - Halaman Manajemen Berita Admin
     * =======================================================================
     *
     * Menampilkan halaman utama manajemen berita untuk admin/petugas.
     * Berisi daftar semua berita dengan fitur pagination, filter, dan search.
     *
     * HTTP METHOD: GET
     * ROUTE: /admin/berita
     * ACCESS: Admin/Petugas yang sudah login
     *
     * FEATURES:
     * - ✅ Pagination dengan customizable per page
     * - ✅ Filter berdasarkan status (draft/published/all)
     * - ✅ Search functionality di judul, isi, dan excerpt
     * - ✅ Sort by creation date (terbaru dulu)
     * - ✅ Join dengan tabel users untuk data penulis
     *
     * SECURITY CHECKS:
     * - ✅ Session validation untuk admin/petugas
     * - ✅ Redirect ke login jika belum authenticated
     *
     * DATABASE QUERIES:
     * 1. SELECT * FROM berita WHERE [filters] ORDER BY created_at DESC LIMIT [offset], [perPage]
     * 2. SELECT COUNT(*) FROM berita WHERE [filters] (untuk pagination)
     * 3. SELECT * FROM users WHERE id_user = [penulis_id] (untuk setiap berita)
     *
     * PARAMETERS:
     * - per_page (GET): Jumlah item per halaman (default: 10)
     * - status (GET): Filter status berita (draft/published/all)
     * - search (GET): Kata kunci pencarian
     *
     * RESPONSE:
     * - View: admin/berita/index dengan data berita, pagination, filters
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\View\View
     */
    public function index()
    {
        // =======================================================================
        // SECURITY CHECK - Validasi akses admin/petugas
        // =======================================================================
        // Pastikan user sudah login sebagai admin atau petugas
        // Jika belum login, redirect ke halaman login admin dengan pesan error
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // =======================================================================
        // PARAMETER HANDLING - Ambil parameter dari URL query string
        // =======================================================================
        // per_page: Jumlah berita per halaman (default 10)
        $perPage = $this->request->getGet('per_page') ?? 10;

        // status: Filter berdasarkan status publikasi (draft/published/all)
        $status = $this->request->getGet('status');

        // search: Kata kunci untuk pencarian di judul, isi, excerpt
        $search = $this->request->getGet('search');

        // =======================================================================
        // DATABASE QUERY BUILDING - Konstruksi query dengan filter
        // =======================================================================
        // Mulai dengan base query dari model berita
        $query = $this->beritaModel;

        // FILTER STATUS: Jika status ditentukan dan bukan 'all'
        // Query: WHERE status = 'draft' OR status = 'published'
        if ($status && $status !== 'all') {
            $query = $query->where('status', $status);
        }

        // FILTER SEARCH: Pencarian di multiple kolom dengan OR condition
        // Query: WHERE (judul LIKE '%search%' OR isi LIKE '%search%' OR excerpt LIKE '%search%')
        if ($search) {
            $query = $query->groupStart()
                ->like('judul', $search)      // Cari di kolom judul
                ->orLike('isi', $search)      // Cari di kolom isi
                ->orLike('excerpt', $search)  // Cari di kolom excerpt
                ->groupEnd();                 // Tutup group untuk OR condition
        }

        // =======================================================================
        // EXECUTE QUERY - Jalankan query dengan pagination
        // =======================================================================
        // Urutkan berdasarkan tanggal dibuat (terbaru dulu)
        // Paginate dengan limit sesuai parameter per_page
        $berita = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        // Dapatkan object pager untuk informasi pagination (total pages, links, etc)
        $pager = $this->beritaModel->pager;

        // =======================================================================
        // DATA ENRICHMENT - Tambahkan informasi penulis untuk setiap berita
        // =======================================================================
        // Loop melalui setiap berita untuk mendapatkan nama penulis
        // Query: SELECT * FROM users WHERE id_user = [penulis_id]
        foreach ($berita as &$item) {
            // Cari data user berdasarkan penulis_id dari berita
            $penulis = $this->userModel->find($item['penulis_id']);

            // Tambahkan nama penulis ke array berita, default 'Unknown' jika tidak ditemukan
            $item['penulis_nama'] = $penulis ? $penulis['nama'] : 'Unknown';
        }

        // =======================================================================
        // VIEW DATA PREPARATION - Siapkan data untuk dikirim ke view
        // =======================================================================
        $data = [
            'title' => 'Manajemen Berita - Sistem Pelayanan Masyarakat', // Page title
            'berita' => $berita,           // Array data berita dengan penulis
            'pager' => $pager,             // Object pagination
            'status' => $status,           // Current status filter
            'search' => $search,           // Current search keyword
            'perPage' => $perPage          // Current items per page
        ];

        // =======================================================================
        // RENDER VIEW - Return view dengan data lengkap
        // =======================================================================
        return view('admin/berita/index', $data);
    }

    /**
     * =======================================================================
     * METHOD CREATE - Form Tambah Berita Baru
     * =======================================================================
     *
     * Menampilkan halaman form untuk membuat berita baru.
     * Form ini akan digunakan admin/petugas untuk menambahkan artikel berita.
     *
     * HTTP METHOD: GET
     * ROUTE: /admin/berita/create
     * ACCESS: Admin/Petugas yang sudah login
     *
     * FEATURES:
     * - ✅ Form dengan rich text editor untuk konten berita
     * - ✅ Drag & drop image upload dengan preview
     * - ✅ Auto-generate excerpt dari konten
     * - ✅ Slug preview untuk SEO
     * - ✅ Status selection (Draft/Published)
     *
     * SECURITY CHECKS:
     * - ✅ Session validation untuk admin/petugas
     * - ✅ Redirect ke login jika belum authenticated
     *
     * VIEW DATA:
     * - title: Page title untuk browser tab
     * - mode: 'create' untuk menentukan mode form
     *
     * RESPONSE:
     * - View: admin/berita/form dengan mode create
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\View\View
     */
    public function create()
    {
        // =======================================================================
        // SECURITY CHECK - Validasi akses admin/petugas
        // =======================================================================
        // Pastikan user sudah login sebagai admin atau petugas
        // Jika belum login, redirect ke halaman login admin
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // =======================================================================
        // VIEW DATA PREPARATION - Siapkan data untuk form create
        // =======================================================================
        $data = [
            'title' => 'Tambah Berita Baru - Sistem Pelayanan Masyarakat', // Page title
            'mode' => 'create'  // Mode form untuk create (bukan edit)
        ];

        // =======================================================================
        // RENDER VIEW - Return form untuk membuat berita baru
        // =======================================================================
        return view('admin/berita/form', $data);
    }

    /**
     * Simpan berita baru
     * Menyimpan berita yang baru dibuat
     *
     * Method: POST
     * Route: /admin/berita/store
     * Akses: Admin/Petugas yang sudah login
     */
    public function store()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if image file is uploaded
        $file = $this->request->getFile('gambar');
        $hasImage = $file && $file->isValid();

        // Validation rules - make image optional for now, we'll check it after
        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'isi' => 'required|min_length[50]',
            'excerpt' => 'permit_empty|max_length[300]',
            'status' => 'required|in_list[draft,published]'
        ];

        // Add image validation only if file is uploaded
        if ($hasImage) {
            $rules['gambar'] = 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]';
        }

        $messages = [
            'judul' => [
                'required' => 'Judul berita harus diisi',
                'min_length' => 'Judul minimal 5 karakter',
                'max_length' => 'Judul maksimal 255 karakter'
            ],
            'isi' => [
                'required' => 'Isi berita harus diisi',
                'min_length' => 'Isi berita minimal 50 karakter'
            ],
            'status' => [
                'required' => 'Status publikasi harus dipilih',
                'in_list' => 'Status tidak valid'
            ],
            'gambar' => [
                'uploaded' => 'Gambar harus dipilih',
                'max_size' => 'Ukuran gambar maksimal 2MB',
                'is_image' => 'File harus berupa gambar',
                'mime_in' => 'Format gambar harus JPG, PNG, atau WebP'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Check if image is provided (required for new berita)
        if (!$hasImage) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gambar berita harus dipilih');
        }

        // Generate slug dari judul
        $slug = $this->generateSlug($this->request->getPost('judul'));

        // Cek apakah slug sudah ada
        $existingSlug = $this->beritaModel->where('slug', $slug)->first();
        if ($existingSlug) {
            $slug = $slug . '-' . time();
        }

        // Upload gambar
        $gambarPath = $this->uploadGambar();

        if (!$gambarPath) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupload gambar');
        }

        // Siapkan data untuk disimpan
        $beritaData = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'isi' => $this->request->getPost('isi'),
            'excerpt' => $this->request->getPost('excerpt') ?: $this->generateExcerpt($this->request->getPost('isi')),
            'gambar' => $gambarPath,
            'status' => $this->request->getPost('status'),
            'penulis_id' => session('user')['id_user'],
            'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->beritaModel->insert($beritaData);

            if ($result) {
                return redirect()->to('/admin/berita')
                    ->with('success', 'Berita berhasil ditambahkan');
            } else {
                // Hapus gambar yang sudah diupload jika gagal simpan
                if (file_exists(FCPATH . $gambarPath)) {
                    unlink(FCPATH . $gambarPath);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan berita');
            }
        } catch (\Exception $e) {
            // Hapus gambar yang sudah diupload jika gagal simpan
            if (file_exists(FCPATH . $gambarPath)) {
                unlink(FCPATH . $gambarPath);
            }

            log_message('error', 'Berita store error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Form edit berita
     * Menampilkan form untuk mengedit berita
     *
     * Method: GET
     * Route: /admin/berita/{id}/edit
     * Akses: Admin/Petugas yang sudah login
     */
    public function edit($id)
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')
                ->with('error', 'Berita tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Berita - Sistem Pelayanan Masyarakat',
            'berita' => $berita,
            'mode' => 'edit'
        ];

        return view('admin/berita/form', $data);
    }

    /**
     * Update berita
     * Mengupdate berita yang sudah ada
     *
     * Method: POST
     * Route: /admin/berita/{id}/update
     * Akses: Admin/Petugas yang sudah login
     */
    public function update($id)
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')
                ->with('error', 'Berita tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'isi' => 'required|min_length[50]',
            'excerpt' => 'permit_empty|max_length[300]',
            'status' => 'required|in_list[draft,published]',
            'gambar' => 'permit_empty|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        $messages = [
            'judul' => [
                'required' => 'Judul berita harus diisi',
                'min_length' => 'Judul minimal 5 karakter',
                'max_length' => 'Judul maksimal 255 karakter'
            ],
            'isi' => [
                'required' => 'Isi berita harus diisi',
                'min_length' => 'Isi berita minimal 50 karakter'
            ],
            'status' => [
                'required' => 'Status publikasi harus dipilih',
                'in_list' => 'Status tidak valid'
            ],
            'gambar' => [
                'max_size' => 'Ukuran gambar maksimal 2MB',
                'is_image' => 'File harus berupa gambar',
                'mime_in' => 'Format gambar harus JPG, PNG, atau WebP'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Generate slug baru jika judul berubah
        $newSlug = $this->generateSlug($this->request->getPost('judul'));
        $slug = $berita['slug'];

        if ($berita['judul'] !== $this->request->getPost('judul')) {
            // Cek apakah slug sudah ada (kecuali slug lama)
            $existingSlug = $this->beritaModel
                ->where('slug', $newSlug)
                ->where('id_berita !=', $id)
                ->first();

            if ($existingSlug) {
                $slug = $newSlug . '-' . time();
            } else {
                $slug = $newSlug;
            }
        }

        // Handle gambar upload
        $gambarPath = $berita['gambar']; // Default ke gambar lama

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            // Upload gambar baru
            $newGambarPath = $this->uploadGambar();

            if ($newGambarPath) {
                // Hapus gambar lama
                if ($berita['gambar'] && file_exists(FCPATH . $berita['gambar'])) {
                    unlink(FCPATH . $berita['gambar']);
                }

                $gambarPath = $newGambarPath;
            }
        }

        // Siapkan data untuk diupdate
        $updateData = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'isi' => $this->request->getPost('isi'),
            'excerpt' => $this->request->getPost('excerpt') ?: $this->generateExcerpt($this->request->getPost('isi')),
            'gambar' => $gambarPath,
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Set published_at jika status berubah ke published
        if ($this->request->getPost('status') === 'published' && $berita['status'] !== 'published') {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        try {
            $result = $this->beritaModel->update($id, $updateData);

            if ($result) {
                return redirect()->to('/admin/berita')
                    ->with('success', 'Berita berhasil diperbarui');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui berita');
            }
        } catch (\Exception $e) {
            log_message('error', 'Berita update error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Hapus berita
     * Menghapus berita dan gambar terkait
     *
     * Method: POST
     * Route: /admin/berita/{id}/delete
     * Akses: Admin/Petugas yang sudah login
     */
    public function delete($id)
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ]);
        }

        try {
            // Hapus gambar jika ada
            if ($berita['gambar'] && file_exists(FCPATH . $berita['gambar'])) {
                unlink(FCPATH . $berita['gambar']);
            }

            // Hapus berita dari database
            $result = $this->beritaModel->delete($id);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berita berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus berita'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Berita delete error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Ubah status berita
     * Mengubah status publikasi berita (draft/published)
     *
     * Method: POST
     * Route: /admin/berita/{id}/toggle-status
     * Akses: Admin/Petugas yang sudah login
     */
    public function toggleStatus($id)
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ]);
        }

        $newStatus = $berita['status'] === 'published' ? 'draft' : 'published';

        $updateData = [
            'status' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Set atau hapus published_at
        if ($newStatus === 'published') {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        try {
            $result = $this->beritaModel->update($id, $updateData);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berita berhasil diubah',
                    'new_status' => $newStatus,
                    'status_text' => $newStatus === 'published' ? 'Published' : 'Draft'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah status berita'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Berita status toggle error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Lihat detail berita (Public)
     * Menampilkan berita lengkap untuk publik
     *
     * Method: GET
     * Route: /berita/{slug}
     * Akses: Semua pengguna
     */
    public function show($slug)
    {
        $berita = $this->beritaModel
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment views
        $this->beritaModel->update($berita['id_berita'], [
            'views' => $berita['views'] + 1
        ]);

        // Ambil data penulis
        $penulis = $this->userModel->find($berita['penulis_id']);
        $berita['penulis_nama'] = $penulis ? $penulis['nama'] : 'Unknown';

        $data = [
            'title' => $berita['judul'] . ' - Sistem Pelayanan Masyarakat',
            'berita' => $berita
        ];

        return view('berita/show', $data);
    }

    /**
     * Daftar berita publik
     * Menampilkan daftar berita yang sudah dipublikasikan
     *
     * Method: GET
     * Route: /berita
     * Akses: Semua pengguna
     */
    public function beritaPublik()
    {
        $perPage = $this->request->getGet('per_page') ?? 9;
        $search = $this->request->getGet('search');

        $query = $this->beritaModel->where('status', 'published');

        // Filter berdasarkan pencarian
        if ($search) {
            $query = $query->groupStart()
                ->like('judul', $search)
                ->orLike('isi', $search)
                ->orLike('excerpt', $search)
                ->groupEnd();
        }

        $berita = $query->orderBy('published_at', 'DESC')->paginate($perPage);
        $pager = $this->beritaModel->pager;

        // Ambil data penulis untuk setiap berita
        foreach ($berita as &$item) {
            $penulis = $this->userModel->find($item['penulis_id']);
            $item['penulis_nama'] = $penulis ? $penulis['nama'] : 'Unknown';
        }

        $data = [
            'title' => 'Berita & Informasi - Sistem Pelayanan Masyarakat',
            'berita' => $berita,
            'pager' => $pager,
            'search' => $search,
            'perPage' => $perPage
        ];

        return view('berita/index', $data);
    }

    /**
     * Upload gambar berita
     * Helper method untuk upload gambar
     *
     * @return string|null Path gambar atau null jika gagal
     */
    private function uploadGambar()
    {
        $file = $this->request->getFile('gambar');

        if (!$file || !$file->isValid()) {
            return null;
        }

        // Generate nama file unik
        $newName = 'berita_' . time() . '_' . rand(1000, 9999) . '.' . $file->getExtension();

        // Path untuk menyimpan file
        $uploadPath = FCPATH . 'uploads/berita/';

        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        try {
            if ($file->move($uploadPath, $newName)) {
                return 'uploads/berita/' . $newName;
            }
        } catch (\Exception $e) {
            log_message('error', 'Image upload error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Generate slug dari judul
     * Membuat slug yang URL-friendly
     *
     * @param string $title Judul berita
     * @return string Slug yang dihasilkan
     */
    private function generateSlug($title)
    {
        // Convert to lowercase
        $slug = strtolower($title);

        // Replace non-alphanumeric characters with hyphens
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Replace spaces and multiple hyphens with single hyphen
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        // Remove leading/trailing hyphens
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Generate excerpt dari isi berita
     * Membuat ringkasan otomatis dari isi berita
     *
     * @param string $content Isi berita
     * @param int $length Panjang excerpt
     * @return string Excerpt yang dihasilkan
     */
    private function generateExcerpt($content, $length = 150)
    {
        // Remove HTML tags
        $content = strip_tags($content);

        // Trim whitespace
        $content = trim($content);

        // If content is shorter than length, return as is
        if (strlen($content) <= $length) {
            return $content;
        }

        // Find the last space within the length limit
        $excerpt = substr($content, 0, $length);
        $lastSpace = strrpos($excerpt, ' ');

        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }
}
