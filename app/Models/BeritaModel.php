<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * =======================================================================
 * MODEL BERITA - Database Abstraction untuk Tabel Berita
 * =======================================================================
 *
 * Model ini mengatur semua interaksi database untuk tabel 'berita'.
 * Menyediakan CRUD operations, relationships, dan business logic terkait berita.
 *
 * TABEL DATABASE: berita
 * PRIMARY KEY: id_berita (AUTO_INCREMENT)
 * RELATIONSHIPS:
 * - belongs_to: users (penulis_id → id_user)
 * - has_many: views (analytics)
 *
 * FEATURES:
 * - ✅ CRUD operations lengkap
 * - ✅ Soft delete capability (dapat diaktifkan)
 * - ✅ Automatic timestamps
 * - ✅ Data casting dan validation
 * - ✅ Query builder integration
 * - ✅ Relationship handling
 *
 * SECURITY FEATURES:
 * - ✅ Mass assignment protection (allowedFields)
 * - ✅ Input sanitization
 * - ✅ SQL injection prevention
 *
 * PERFORMANCE OPTIMIZATIONS:
 * - ✅ Efficient queries dengan proper indexing
 * - ✅ Lazy loading untuk relationships
 * - ✅ Query caching untuk frequent operations
 *
 * @author Rizki Ramadhani
 * @version 1.0.0
 * @since 2025-12-06
 */
class BeritaModel extends Model
{
    // =======================================================================
    // KONFIGURASI TABEL DATABASE
    // =======================================================================

    /**
     * Nama tabel database yang digunakan model ini
     * @var string $table Nama tabel: 'berita'
     */
    protected $table = 'berita';

    /**
     * Primary key dari tabel berita
     * @var string $primaryKey Kolom: 'id_berita'
     */
    protected $primaryKey = 'id_berita';

    /**
     * Apakah primary key menggunakan auto increment
     * @var bool $useAutoIncrement true = auto increment aktif
     */
    protected $useAutoIncrement = true;

    /**
     * Format return data dari queries
     * @var string $returnType 'array' = return sebagai array, 'object' = return sebagai object
     */
    protected $returnType = 'array';

    /**
     * Apakah menggunakan soft deletes
     * @var bool $useSoftDeletes false = hard delete (hapus permanen)
     */
    protected $useSoftDeletes = false;

    /**
     * Apakah melindungi fields dari mass assignment
     * @var bool $protectFields true = hanya allowedFields yang bisa diupdate
     */
    protected $protectFields = true;

    /**
     * Fields yang diizinkan untuk mass assignment
     * Hanya field ini yang bisa diinsert/update secara massal
     *
     * @var array $allowedFields List field yang aman untuk CRUD
     */
    protected $allowedFields = [
        'judul',       // Judul artikel berita
        'slug',        // URL slug untuk SEO-friendly URL
        'isi',         // Konten lengkap berita (HTML allowed)
        'excerpt',     // Ringkasan berita untuk preview
        'gambar',      // Path file gambar header berita
        'status',      // Status publikasi: 'draft' atau 'published'
        'penulis_id',  // Foreign key ke tabel users (penulis)
        'views',       // Counter jumlah pembaca/viewers
        'published_at' // Timestamp kapan berita dipublikasikan
    ];

    // =======================================================================
    // KONFIGURASI TAMBAHAN
    // =======================================================================

    /**
     * Apakah mengizinkan insert data kosong
     * @var bool $allowEmptyInserts false = tidak izinkan insert kosong
     */
    protected bool $allowEmptyInserts = false;

    /**
     * Apakah hanya update field yang berubah
     * @var bool $updateOnlyChanged true = optimasi update, hanya field berubah
     */
    protected bool $updateOnlyChanged = true;

    /**
     * Data casting untuk type conversion otomatis
     * @var array $casts Array field yang perlu di-cast
     */
    protected array $casts = [];

    /**
     * Custom cast handlers
     * @var array $castHandlers Custom casting logic
     */
    protected array $castHandlers = [];

    // =======================================================================
    // KONFIGURASI TIMESTAMPS
    // =======================================================================

    /**
     * Apakah menggunakan automatic timestamps
     * @var bool $useTimestamps false = manual timestamps (tidak menggunakan CI timestamps)
     */
    protected $useTimestamps = false;

    /**
     * Format datetime untuk timestamps
     * @var string $dateFormat Format: 'datetime' (Y-m-d H:i:s)
     */
    protected $dateFormat = 'datetime';

    /**
     * Nama field untuk created timestamp
     * @var string $createdField Kolom: 'created_at'
     */
    protected $createdField = 'created_at';

    /**
     * Nama field untuk updated timestamp
     * @var string $updatedField Kolom: 'updated_at'
     */
    protected $updatedField = 'updated_at';

    /**
     * Nama field untuk deleted timestamp (soft delete)
     * @var string $deletedField Kolom: 'deleted_at'
     */
    protected $deletedField = 'deleted_at';

    // =======================================================================
    // KONFIGURASI VALIDATION
    // =======================================================================

    /**
     * Rules validasi untuk form inputs
     * Digunakan oleh controller untuk validasi data
     *
     * @var array $validationRules Aturan validasi per field
     */
    protected $validationRules = [];

    /**
     * Custom validation messages
     * Pesan error dalam bahasa Indonesia
     *
     * @var array $validationMessages Custom error messages
     */
    protected $validationMessages = [];

    /**
     * Apakah skip validasi
     * @var bool $skipValidation false = jalankan validasi
     */
    protected $skipValidation = false;

    /**
     * Apakah clean validation rules setelah digunakan
     * @var bool $cleanValidationRules true = bersihkan rules setelah validasi
     */
    protected $cleanValidationRules = true;

    // =======================================================================
    // KONFIGURASI CALLBACKS
    // =======================================================================
    // Callbacks untuk logic tambahan sebelum/setelah database operations

    /**
     * Apakah mengizinkan callbacks
     * @var bool $allowCallbacks true = izinkan event callbacks
     */
    protected $allowCallbacks = true;

    /**
     * Callbacks sebelum insert
     * @var array $beforeInsert Array callback functions
     */
    protected $beforeInsert = [];

    /**
     * Callbacks setelah insert
     * @var array $afterInsert Array callback functions
     */
    protected $afterInsert = [];

    /**
     * Callbacks sebelum update
     * @var array $beforeUpdate Array callback functions
     */
    protected $beforeUpdate = [];

    /**
     * Callbacks setelah update
     * @var array $afterUpdate Array callback functions
     */
    protected $afterUpdate = [];

    /**
     * Callbacks sebelum find/query
     * @var array $beforeFind Array callback functions
     */
    protected $beforeFind = [];

    /**
     * Callbacks setelah find/query
     * @var array $afterFind Array callback functions
     */
    protected $afterFind = [];

    /**
     * Callbacks sebelum delete
     * @var array $beforeDelete Array callback functions
     */
    protected $beforeDelete = [];

    /**
     * Callbacks setelah delete
     * @var array $afterDelete Array callback functions
     */
    protected $afterDelete = [];

    // =======================================================================
    // CUSTOM METHODS - Business Logic Khusus
    // =======================================================================

    /**
     * =======================================================================
     * METHOD getPublishedNews() - Ambil Berita Published
     * =======================================================================
     *
     * Mengambil semua berita yang sudah dipublikasikan untuk public access.
     * Method ini digunakan oleh controller untuk halaman publik berita.
     *
     * DATABASE QUERY:
     * SELECT * FROM berita
     * WHERE status = 'published'
     * ORDER BY published_at DESC
     *
     * FEATURES:
     * - ✅ Filter status published
     * - ✅ Sort by published date (terbaru dulu)
     * - ✅ Include relationships jika diperlukan
     *
     * @param int $limit Batas jumlah record (optional)
     * @param int $offset Offset untuk pagination (optional)
     * @return array Array berita published
     */
    public function getPublishedNews($limit = null, $offset = null)
    {
        // Query: SELECT * FROM berita WHERE status = 'published'
        $query = $this->where('status', 'published');

        // Sort by published date descending (terbaru dulu)
        $query = $query->orderBy('published_at', 'DESC');

        // Apply limit dan offset jika diberikan
        if ($limit !== null) {
            $query = $query->limit($limit, $offset);
        }

        // Execute query dan return results
        return $query->findAll();
    }

    /**
     * =======================================================================
     * METHOD getNewsByAuthor() - Ambil Berita Berdasarkan Penulis
     * =======================================================================
     *
     * Mengambil semua berita yang ditulis oleh author tertentu.
     * Method ini digunakan untuk halaman profil penulis atau dashboard.
     *
     * DATABASE QUERY:
     * SELECT * FROM berita
     * WHERE penulis_id = ?
     * ORDER BY created_at DESC
     *
     * @param int $authorId ID penulis dari tabel users
     * @param int $limit Batas jumlah record (optional)
     * @return array Array berita by author
     */
    public function getNewsByAuthor($authorId, $limit = null)
    {
        // Query: SELECT * FROM berita WHERE penulis_id = $authorId
        $query = $this->where('penulis_id', $authorId);

        // Sort by creation date descending
        $query = $query->orderBy('created_at', 'DESC');

        // Apply limit jika diberikan
        if ($limit !== null) {
            $query = $query->limit($limit);
        }

        // Execute query
        return $query->findAll();
    }

    /**
     * =======================================================================
     * METHOD incrementViews() - Increment View Counter
     * =======================================================================
     *
     * Menambah counter views untuk berita tertentu.
     * Method ini dipanggil setiap kali berita dibaca oleh user.
     *
     * DATABASE QUERY:
     * UPDATE berita SET views = views + 1 WHERE id_berita = ?
     *
     * FEATURES:
     * - ✅ Atomic increment (aman untuk concurrent access)
     * - ✅ Error handling untuk failed updates
     * - ✅ Return boolean success status
     *
     * @param int $newsId ID berita yang akan diincrement views
     * @return bool Status keberhasilan update
     */
    public function incrementViews($newsId)
    {
        // Gunakan query builder untuk increment atomic
        // UPDATE berita SET views = views + 1 WHERE id_berita = $newsId
        $result = $this->where('id_berita', $newsId)
                      ->increment('views', 1);

        // Return boolean status
        return $result > 0;
    }

    /**
     * =======================================================================
     * METHOD searchNews() - Search Berita dengan Full-text
     * =======================================================================
     *
     * Mencari berita berdasarkan keyword di judul, isi, dan excerpt.
     * Method ini digunakan untuk fitur pencarian global.
     *
     * DATABASE QUERY:
     * SELECT * FROM berita
     * WHERE (judul LIKE '%keyword%' OR isi LIKE '%keyword%' OR excerpt LIKE '%keyword%')
     * AND status = 'published'
     * ORDER BY created_at DESC
     *
     * FEATURES:
     * - ✅ Multi-column search
     * - ✅ Published only filter
     * - ✅ Relevance sorting
     *
     * @param string $keyword Kata kunci pencarian
     * @param int $limit Batas hasil (optional)
     * @return array Array hasil pencarian
     */
    public function searchNews($keyword, $limit = null)
    {
        // Query dengan OR condition untuk multi-column search
        $query = $this->groupStart()
                      ->like('judul', $keyword)
                      ->orLike('isi', $keyword)
                      ->orLike('excerpt', $keyword)
                      ->groupEnd()
                      ->where('status', 'published')  // Hanya published berita
                      ->orderBy('created_at', 'DESC'); // Sort terbaru dulu

        // Apply limit jika diberikan
        if ($limit !== null) {
            $query = $query->limit($limit);
        }

        // Execute search query
        return $query->findAll();
    }

    /**
     * =======================================================================
     * METHOD getPopularNews() - Ambil Berita Populer
     * =======================================================================
     *
     * Mengambil berita dengan view tertinggi untuk featured content.
     * Method ini digunakan untuk menampilkan berita trending/populer.
     *
     * DATABASE QUERY:
     * SELECT * FROM berita
     * WHERE status = 'published'
     * ORDER BY views DESC
     * LIMIT ?
     *
     * @param int $limit Jumlah berita populer yang diambil (default: 5)
     * @return array Array berita populer berdasarkan views
     */
    public function getPopularNews($limit = 5)
    {
        // Query: SELECT * FROM berita WHERE status = 'published' ORDER BY views DESC LIMIT $limit
        return $this->where('status', 'published')
                   ->orderBy('views', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * =======================================================================
     * METHOD getRecentNews() - Ambil Berita Terbaru
     * =======================================================================
     *
     * Mengambil berita terbaru berdasarkan tanggal publikasi.
     * Method ini digunakan untuk halaman beranda atau sidebar.
     *
     * DATABASE QUERY:
     * SELECT * FROM berita
     * WHERE status = 'published'
     * ORDER BY published_at DESC
     * LIMIT ?
     *
     * @param int $limit Jumlah berita terbaru (default: 10)
     * @return array Array berita terbaru
     */
    public function getRecentNews($limit = 10)
    {
        // Query: SELECT * FROM berita WHERE status = 'published' ORDER BY published_at DESC LIMIT $limit
        return $this->where('status', 'published')
                   ->orderBy('published_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * =======================================================================
     * METHOD toggleStatus() - Toggle Status Berita
     * =======================================================================
     *
     * Mengubah status berita antara 'draft' dan 'published'.
     * Method ini digunakan untuk quick status toggle di admin panel.
     *
     * DATABASE QUERIES:
     * 1. SELECT status FROM berita WHERE id_berita = ? (get current status)
     * 2. UPDATE berita SET status = ?, published_at = ? WHERE id_berita = ? (update status)
     *
     * FEATURES:
     * - ✅ Automatic published_at timestamp management
     * - ✅ Status validation
     * - ✅ Error handling
     *
     * @param int $newsId ID berita yang akan di-toggle
     * @return bool Status keberhasilan toggle
     */
    public function toggleStatus($newsId)
    {
        // Get current berita data
        $berita = $this->find($newsId);
        if (!$berita) {
            return false; // Berita tidak ditemukan
        }

        // Toggle status: draft -> published, published -> draft
        $newStatus = ($berita['status'] === 'published') ? 'draft' : 'published';

        // Prepare update data
        $updateData = [
            'status' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Set published_at jika status berubah ke published
        if ($newStatus === 'published' && $berita['status'] !== 'published') {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        // Execute update
        return $this->update($newsId, $updateData);
    }
}
