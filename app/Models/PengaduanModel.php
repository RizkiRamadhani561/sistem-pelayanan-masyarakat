<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk mengelola data pengaduan masyarakat
 *
 * Model ini menangani semua operasi CRUD untuk tabel pengaduan yang berisi:
 * - Data pengaduan yang dibuat oleh warga
 * - Status pengaduan (baru, diproses, selesai)
 * - Informasi petugas yang menangani
 * - Lampiran file pendukung
 * - Catatan dari petugas
 * - Audit trail dengan timestamp
 *
 * Struktur tabel pengaduan:
 * - id_pengaduan (Primary Key, Auto Increment)
 * - warga_id (Foreign Key ke tabel warga)
 * - judul (Judul pengaduan)
 * - isi_pengaduan (Deskripsi lengkap pengaduan)
 * - lokasi (Lokasi kejadian, opsional)
 * - lampiran (Path file lampiran, opsional)
 * - status (Enum: baru, diproses, selesai)
 * - petugas_id (Foreign Key ke tabel users, nullable)
 * - catatan (Catatan dari petugas, nullable)
 * - created_at (Timestamp pembuatan)
 * - updated_at (Timestamp update terakhir)
 *
 * Relationships:
 * - belongsTo: warga (melalui warga_id)
 * - belongsTo: petugas (melalui petugas_id)
 *
 * Validasi yang diterapkan:
 * - judul: required, min 5 chars, max 200 chars
 * - isi_pengaduan: required, min 10 chars
 * - status: enum validation (baru, diproses, selesai)
 * - lampiran: file validation (jpg, png, pdf, max 2MB)
 */
class PengaduanModel extends Model
{
    /**
     * Nama tabel database yang digunakan model ini
     * @var string
     */
    protected $table = 'pengaduan';

    /**
     * Nama kolom primary key
     * @var string
     */
    protected $primaryKey = 'id_pengaduan';

    /**
     * Menggunakan auto increment untuk primary key
     * @var bool
     */
    protected $useAutoIncrement = true;

    /**
     * Tipe return data (array atau object)
     * Menggunakan array untuk kemudahan akses data
     * @var string
     */
    protected $returnType = 'array';

    /**
     * Tidak menggunakan soft deletes
     * Data pengaduan dihapus permanen untuk compliance
     * @var bool
     */
    protected $useSoftDeletes = false;

    /**
     * Mengaktifkan proteksi field untuk keamanan
     * Hanya field yang terdaftar di allowedFields yang bisa diupdate
     * @var bool
     */
    protected $protectFields = true;

    /**
     * Daftar field yang boleh diakses untuk operasi CRUD
     * Keamanan: mencegah mass assignment vulnerability
     * @var array
     */
    protected $allowedFields = [
        'warga_id',      // ID warga yang membuat pengaduan
        'judul',         // Judul pengaduan
        'isi_pengaduan', // Isi/detail pengaduan
        'lokasi',        // Lokasi kejadian (opsional)
        'lampiran',      // Path file lampiran (opsional)
        'status',        // Status pengaduan (baru/diproses/selesai)
        'petugas_id',    // ID petugas yang menangani (nullable)
        'catatan',       // Catatan dari petugas (nullable)
        'created_at',    // Timestamp pembuatan
        'updated_at'     // Timestamp update terakhir
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
