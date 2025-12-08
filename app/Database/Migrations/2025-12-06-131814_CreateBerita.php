<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =======================================================================
 * MIGRATION: CREATE BERITA TABLE
 * =======================================================================
 *
 * Migration ini membuat tabel 'berita' untuk menyimpan artikel berita
 * dalam Sistem Pelayanan Masyarakat Kembangan Raya.
 *
 * TABEL DATABASE: berita
 * TOTAL FIELDS: 12 fields
 * PRIMARY KEY: id_berita (BIGINT AUTO_INCREMENT)
 * FOREIGN KEY: penulis_id → users.id_user
 *
 * FUNGSI TABEL:
 * - ✅ Menyimpan artikel berita dengan konten lengkap
 * - ✅ SEO-friendly dengan slug unik
 * - ✅ Status management (draft/published)
 * - ✅ View counter untuk analytics
 * - ✅ Relationship dengan tabel users (penulis)
 *
 * MIGRATION TYPE: Schema Creation
 * RUN ORDER: Setelah migration users table
 * DEPENDENCIES: users table harus sudah ada
 *
 * SQL EQUIVALENT:
 * CREATE TABLE berita (
 *     id_berita BIGINT PRIMARY KEY AUTO_INCREMENT,
 *     judul VARCHAR(255) NOT NULL,
 *     slug VARCHAR(255) UNIQUE NOT NULL,
 *     isi TEXT NOT NULL,
 *     excerpt VARCHAR(300),
 *     gambar VARCHAR(500),
 *     status ENUM('draft','published') DEFAULT 'draft',
 *     penulis_id INT NOT NULL,
 *     views INT DEFAULT 0,
 *     published_at DATETIME,
 *     created_at DATETIME,
 *     updated_at DATETIME,
 *     FOREIGN KEY (penulis_id) REFERENCES users(id_user) ON DELETE CASCADE
 * );
 *
 * @author Rizki Ramadhani
 * @version 1.0.0
 * @created 2025-12-06
 * @migration_timestamp 131814
 */
class CreateBerita extends Migration
{
    /**
     * =======================================================================
     * METHOD UP - Membuat Tabel Berita
     * =======================================================================
     *
     * Method ini menjalankan migration untuk membuat tabel berita.
     * Dijalankan ketika migration dijalankan (php spark migrate).
     *
     * SCHEMA DEFINITION:
     * Menggunakan CodeIgniter Schema Builder untuk mendefinisikan struktur tabel.
     * Setiap field didefinisikan dengan tipe data, constraint, dan properties.
     *
     * WORKFLOW:
     * 1. Define semua fields dengan properties
     * 2. Set primary key
     * 3. Add foreign key constraint
     * 4. Create table di database
     *
     * ROLLBACK: Menggunakan method down() untuk menghapus tabel
     *
     * @return void
     */
    public function up()
    {
        // =======================================================================
        // DEFINISI FIELD TABEL BERITA
        // =======================================================================
        // Menggunakan array associative untuk mendefinisikan setiap kolom
        // Format: 'field_name' => ['property' => 'value', ...]
        $this->forge->addField([
            // =======================================================================
            // PRIMARY KEY - ID Berita
            // =======================================================================
            // BIGINT untuk mendukung banyak data
            // AUTO_INCREMENT untuk generate ID otomatis
            'id_berita' => [
                'type' => 'BIGINT',           // Tipe data: BIGINT (64-bit integer)
                'auto_increment' => true      // Auto increment aktif
            ],

            // =======================================================================
            // JUDUL BERITA - Title field
            // =======================================================================
            // VARCHAR(255) cukup untuk judul artikel
            'judul' => [
                'type' => 'VARCHAR',          // Tipe data: VARCHAR
                'constraint' => 255           // Max length: 255 karakter
            ],

            // =======================================================================
            // SLUG - SEO-friendly URL identifier
            // =======================================================================
            // URL slug unik untuk setiap berita
            // Contoh: "berita-tentang-kesehatan" dari "Berita Tentang Kesehatan"
            'slug' => [
                'type' => 'VARCHAR',          // Tipe data: VARCHAR
                'constraint' => 255,          // Max length: 255 karakter
                'unique' => true              // UNIQUE constraint - tidak boleh duplikat
            ],

            // =======================================================================
            // ISI BERITA - Main content
            // =======================================================================
            // TEXT untuk konten artikel yang panjang
            // Mendukung HTML formatting
            'isi' => [
                'type' => 'TEXT'              // Tipe data: TEXT (unlimited length)
            ],

            // =======================================================================
            // EXCERPT - Ringkasan berita
            // =======================================================================
            // Ringkasan singkat untuk preview di list
            // Nullable karena bisa auto-generated dari isi
            'excerpt' => [
                'type' => 'VARCHAR',          // Tipe data: VARCHAR
                'constraint' => 300,          // Max length: 300 karakter
                'null' => true                // Nullable - boleh kosong
            ],

            // =======================================================================
            // GAMBAR - Path file gambar header
            // =======================================================================
            // Path relatif ke file gambar berita
            // Contoh: "uploads/berita/berita_123.jpg"
            'gambar' => [
                'type' => 'VARCHAR',          // Tipe data: VARCHAR
                'constraint' => 500,          // Max length: 500 karakter (untuk path panjang)
                'null' => true                // Nullable - berita boleh tanpa gambar
            ],

            // =======================================================================
            // STATUS PUBLIKASI - Publication status
            // =======================================================================
            // Enum dengan 2 nilai: draft (belum publish) atau published (sudah publish)
            'status' => [
                'type' => 'ENUM',             // Tipe data: ENUM
                'constraint' => ['draft', 'published'], // Nilai yang diperbolehkan
                'default' => 'draft'          // Default value: draft
            ],

            // =======================================================================
            // PENULIS ID - Foreign key ke users table
            // =======================================================================
            // ID user yang membuat/menulis berita
            // Relasi ke tabel users (admin/petugas)
            'penulis_id' => [
                'type' => 'INT'               // Tipe data: INT (32-bit integer)
            ],

            // =======================================================================
            // VIEWS - View counter
            // =======================================================================
            // Counter jumlah berapa kali berita dibaca
            // Digunakan untuk analytics dan sorting populer
            'views' => [
                'type' => 'INT',              // Tipe data: INT
                'default' => 0                // Default value: 0
            ],

            // =======================================================================
            // PUBLISHED AT - Timestamp publikasi
            // =======================================================================
            // Tanggal dan waktu kapan berita dipublikasikan
            // Null untuk berita draft, diisi saat publish
            'published_at' => [
                'type' => 'DATETIME',         // Tipe data: DATETIME
                'null' => true                // Nullable - diisi saat publish
            ],

            // =======================================================================
            // CREATED AT - Timestamp pembuatan
            // =======================================================================
            // Tanggal dan waktu kapan berita dibuat
            'created_at' => [
                'type' => 'DATETIME',         // Tipe data: DATETIME
                'null' => true                // Nullable - diisi otomatis
            ],

            // =======================================================================
            // UPDATED AT - Timestamp update terakhir
            // =======================================================================
            // Tanggal dan waktu kapan berita terakhir diupdate
            'updated_at' => [
                'type' => 'DATETIME',         // Tipe data: DATETIME
                'null' => true                // Nullable - diisi otomatis
            ],
        ]);

        // =======================================================================
        // MENAMBAHKAN PRIMARY KEY
        // =======================================================================
        // Set id_berita sebagai primary key
        // Parameter kedua 'true' berarti primary key
        $this->forge->addKey('id_berita', true);

        // =======================================================================
        // MENAMBAHKAN FOREIGN KEY CONSTRAINT
        // =======================================================================
        // Relasi: berita.penulis_id → users.id_user
        // ON DELETE CASCADE: jika user dihapus, berita juga ikut dihapus
        // ON UPDATE CASCADE: jika user id diupdate, foreign key juga ikut update
        $this->forge->addForeignKey(
            'penulis_id',      // Field di tabel berita
            'users',          // Tabel reference
            'id_user',        // Field reference di tabel users
            'CASCADE',        // On delete action
            'CASCADE'         // On update action
        );

        // =======================================================================
        // CREATE TABLE DI DATABASE
        // =======================================================================
        // Eksekusi pembuatan tabel dengan semua definisi di atas
        // Jika tabel sudah ada, akan throw error (harus di-drop dulu)
        $this->forge->createTable('berita');
    }

    /**
     * =======================================================================
     * METHOD DOWN - Rollback Migration
     * =======================================================================
     *
     * Method ini menjalankan rollback migration untuk menghapus tabel berita.
     * Dijalankan ketika migration di-rollback (php spark migrate:rollback).
     *
     * ROLLBACK ACTIONS:
     * - Drop tabel berita beserta semua data
     * - Hapus foreign key constraints
     * - Hapus indexes dan primary key
     *
     * WARNING: Method ini akan menghapus SELURUH DATA di tabel berita!
     * Pastikan untuk backup data sebelum rollback.
     *
     * PARAMETER: true = force drop (hapus walaupun ada foreign key constraints)
     *
     * @return void
     */
    public function down()
    {
        // =======================================================================
        // DROP TABLE BERITA
        // =======================================================================
        // Menghapus tabel berita dari database
        // Parameter 'true' untuk force drop walaupun ada foreign key constraints
        // WARNING: Ini akan menghapus SELURUH DATA BERITA!
        $this->forge->dropTable('berita', true);
    }
}
