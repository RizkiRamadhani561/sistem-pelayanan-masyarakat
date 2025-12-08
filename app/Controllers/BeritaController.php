<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk mengelola berita/artikel
 *
 * Fitur ini memungkinkan admin untuk:
 * - Melihat daftar berita
 * - Menambah berita baru dengan gambar
 * - Mengedit berita yang sudah ada
 * - Menghapus berita
 * - Mengubah status publikasi
 * - Melihat detail berita
 */
class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $userModel;

    /**
     * Konstruktor untuk inisialisasi model
     */
    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->userModel = new UserModel();
    }

    /**
     * Halaman daftar berita (Admin)
     * Menampilkan semua berita dengan pagination dan filter
     *
     * Method: GET
     * Route: /admin/berita
     * Akses: Admin/Petugas yang sudah login
     */
    public function index()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Pagination
        $perPage = $this->request->getGet('per_page') ?? 10;
        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $query = $this->beritaModel;

        // Filter berdasarkan status
        if ($status && $status !== 'all') {
            $query = $query->where('status', $status);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query = $query->groupStart()
                ->like('judul', $search)
                ->orLike('isi', $search)
                ->orLike('excerpt', $search)
                ->groupEnd();
        }

        $berita = $query->orderBy('created_at', 'DESC')->paginate($perPage);
        $pager = $this->beritaModel->pager;

        // Ambil data penulis untuk setiap berita
        foreach ($berita as &$item) {
            $penulis = $this->userModel->find($item['penulis_id']);
            $item['penulis_nama'] = $penulis ? $penulis['nama'] : 'Unknown';
        }

        $data = [
            'title' => 'Manajemen Berita - Sistem Pelayanan Masyarakat',
            'berita' => $berita,
            'pager' => $pager,
            'status' => $status,
            'search' => $search,
            'perPage' => $perPage
        ];

        return view('admin/berita/index', $data);
    }

    /**
     * Form tambah berita baru
     * Menampilkan form untuk membuat berita baru
     *
     * Method: GET
     * Route: /admin/berita/create
     * Akses: Admin/Petugas yang sudah login
     */
    public function create()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'Tambah Berita Baru - Sistem Pelayanan Masyarakat',
            'mode' => 'create'
        ];

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
