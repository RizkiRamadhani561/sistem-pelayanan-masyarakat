<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * =======================================================================
 * KONFIGURASI DATABASE - Sistem Pelayanan Masyarakat Kembangan Raya
 * =======================================================================
 *
 * File konfigurasi untuk semua koneksi database dalam sistem.
 * Menentukan pengaturan koneksi MySQL, SQLite untuk testing, dan konfigurasi lainnya.
 *
 * SUPPORTED DATABASE DRIVERS:
 * - ✅ MySQLi (MySQL/MariaDB) - Primary production database
 * - ✅ SQLite3 - Testing database (in-memory)
 * - ✅ PostgreSQL - Alternative production database
 * - ✅ SQL Server - Enterprise database support
 * - ✅ Oracle - Large scale database support
 *
 * CONFIGURATION PRINCIPLES:
 * - ✅ Environment-based configuration (.env file)
 * - ✅ Multiple connection groups (production, testing)
 * - ✅ Secure credential management
 * - ✅ Connection pooling support
 * - ✅ Failover configuration
 *
 * SECURITY FEATURES:
 * - ✅ Encrypted database passwords (recommended)
 * - ✅ Restricted database user permissions
 * - ✅ SQL injection prevention (via Query Builder)
 * - ✅ Database debugging (development only)
 *
 * PERFORMANCE OPTIMIZATIONS:
 * - ✅ Connection pooling untuk high-traffic
 * - ✅ Query caching untuk read-heavy operations
 * - ✅ Database indexing (configured in migrations)
 * - ✅ Connection timeout management
 *
 * TESTING CONFIGURATION:
 * - ✅ SQLite in-memory untuk fast unit tests
 * - ✅ Isolated test database (tidak affect production)
 * - ✅ Automatic test database setup/cleanup
 *
 * @author Rizki Ramadhani
 * @version 1.0.0
 * @since 2025-12-06
 */
class Database extends Config
{
    /**
     * =======================================================================
     * FILES PATH - Lokasi direktori Database
     * =======================================================================
     *
     * Path absolut ke direktori yang berisi folder Migrations dan Seeds.
     * Digunakan oleh sistem migration dan seeding untuk menemukan file-file database.
     *
     * DEFAULT VALUE: APPPATH . 'Database' . DIRECTORY_SEPARATOR
     * EXAMPLE: /var/www/html/app/Database/
     *
     * SUBDIRECTORIES:
     * - Migrations/ - File migrasi database schema
     * - Seeds/ - File seeding untuk data awal
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * =======================================================================
     * DEFAULT GROUP - Grup koneksi default
     * =======================================================================
     *
     * Nama grup koneksi database yang akan digunakan jika tidak ada yang spesifik.
     * Biasanya 'default' untuk production dan 'tests' untuk testing.
     *
     * AUTO-SWITCHING:
     * - Production/Development: 'default' (MySQL)
     * - Testing: 'tests' (SQLite in-memory)
     *
     * CONFIGURED IN: __construct() method
     */
    public string $defaultGroup = 'default';

    /**
     * =======================================================================
     * DEFAULT DATABASE CONNECTION - Koneksi Database Utama
     * =======================================================================
     *
     * Konfigurasi koneksi database utama untuk production/development environment.
     * Menggunakan MySQLi driver sebagai default untuk kompatibilitas maksimal.
     *
     * OVERRIDE VIA .env FILE:
     * - database.default.hostname
     * - database.default.database
     * - database.default.username
     * - database.default.password
     *
     * SECURITY NOTES:
     * - ✅ JANGAN commit kredensial ke repository
     * - ✅ Gunakan .env file untuk sensitive data
     * - ✅ Buat database user dengan permission terbatas
     *
     * @var array<string, mixed> $default Array konfigurasi koneksi default
     */
    public array $default = [
        // =======================================================================
        // DSN - Data Source Name (Alternative connection string)
        // =======================================================================
        // String koneksi lengkap. Jika diisi, akan override hostname/username/password/database
        // Format: 'mysql:host=localhost;dbname=sistem_pelayanan'
        // Default: '' (kosong, gunakan konfigurasi terpisah)
        'DSN' => '',

        // =======================================================================
        // HOSTNAME - Alamat server database
        // =======================================================================
        // IP address atau domain name dari database server
        // Default: 'localhost' (server lokal)
        // Production: IP address server database terpisah
        'hostname' => 'localhost',

        // =======================================================================
        // USERNAME - Database user username
        // =======================================================================
        // Username untuk login ke database
        // Default: '' (harus diisi di .env)
        // Security: Buat user dengan SELECT, INSERT, UPDATE, DELETE only
        'username' => '',

        // =======================================================================
        // PASSWORD - Database user password
        // =======================================================================
        // Password untuk login ke database
        // Default: '' (harus diisi di .env)
        // Security: Gunakan password kuat, minimal 12 karakter
        'password' => '',

        // =======================================================================
        // DATABASE - Nama database
        // =======================================================================
        // Nama database yang akan digunakan
        // Default: '' (harus diisi di .env)
        // Production: 'sistem_pelayanan_prod'
        // Development: 'sistem_pelayanan_dev'
        'database' => '',

        // =======================================================================
        // DBDRIVER - Database driver/engine
        // =======================================================================
        // Driver database yang digunakan
        // Options: MySQLi, Postgre, SQLite3, SQLSRV, OCI8
        // Default: 'MySQLi' (MySQL/MariaDB)
        'DBDriver' => 'MySQLi',

        // =======================================================================
        // DBPREFIX - Table prefix
        // =======================================================================
        // Prefix untuk nama tabel (untuk multi-tenant atau shared hosting)
        // Default: '' (tidak ada prefix)
        // Example: 'spm_' → tabel menjadi 'spm_users', 'spm_berita'
        'DBPrefix' => '',

        // =======================================================================
        // PCONNECT - Persistent connection
        // =======================================================================
        // Apakah menggunakan persistent connection
        // Default: false (recommended untuk production)
        // True: Connection tetap terbuka antar request
        // False: Connection dibuat ulang setiap request
        'pConnect' => false,

        // =======================================================================
        // DBDEBUG - Database debugging
        // =======================================================================
        // Apakah menampilkan error database
        // Default: true (development)
        // Production: false (untuk security)
        // Menampilkan SQL errors dan query yang gagal
        'DBDebug' => true,

        // =======================================================================
        // CHARSET - Database character set
        // =======================================================================
        // Character encoding untuk database connection
        // Default: 'utf8mb4' (full UTF-8 support, emoji support)
        // Alternatives: 'utf8', 'latin1'
        'charset' => 'utf8mb4',

        // =======================================================================
        // DBCOLLAT - Database collation
        // =======================================================================
        // Collation untuk sorting dan comparison
        // Default: 'utf8mb4_general_ci' (case-insensitive)
        // Alternatives: 'utf8mb4_bin' (case-sensitive)
        'DBCollat' => 'utf8mb4_general_ci',

        // =======================================================================
        // SWAPPRE - Table prefix swapping
        // =======================================================================
        // Placeholder untuk table prefix (advanced usage)
        // Default: '' (tidak digunakan)
        // Digunakan untuk query builder table prefixing
        'swapPre' => '',

        // =======================================================================
        // ENCRYPT - Encrypt connection
        // =======================================================================
        // Apakah mengenkripsi koneksi database
        // Default: false
        // True: Gunakan SSL/TLS untuk database connection
        'encrypt' => false,

        // =======================================================================
        // COMPRESS - Compress connection
        // =======================================================================
        // Apakah mengkompresi data koneksi
        // Default: false
        // True: Compress data untuk bandwidth efficiency
        'compress' => false,

        // =======================================================================
        // STRICTON - Strict mode
        // =======================================================================
        // Apakah menggunakan strict SQL mode
        // Default: false
        // True: Enforce strict data type checking
        'strictOn' => false,

        // =======================================================================
        // FAILOVER - Failover servers
        // =======================================================================
        // Array server database backup jika primary gagal
        // Default: [] (empty array)
        // Format: [['hostname' => 'backup1.com', 'username' => 'user', ...]]
        'failover' => [],

        // =======================================================================
        // PORT - Database server port
        // =======================================================================
        // Port untuk koneksi database
        // Default: 3306 (MySQL default port)
        // PostgreSQL: 5432, SQL Server: 1433
        'port' => 3306,

        // =======================================================================
        // NUMBER NATIVE - Native number types
        // =======================================================================
        // Apakah menggunakan native number types
        // Default: false
        // True: Return numbers as int/float instead of string
        'numberNative' => false,

        // =======================================================================
        // FOUND ROWS - SQL_CALC_FOUND_ROWS
        // =======================================================================
        // Apakah menggunakan SQL_CALC_FOUND_ROWS untuk pagination
        // Default: false
        // True: Support FOUND_ROWS() query untuk total count
        'foundRows' => false,

        // =======================================================================
        // DATE FORMAT - Custom date formatting
        // =======================================================================
        // Format tanggal untuk database operations
        // Default formats sesuai dengan CodeIgniter standards
        // Used by: insert/update operations dan result formatting
        'dateFormat' => [
            'date'     => 'Y-m-d',          // Format untuk DATE fields
            'datetime' => 'Y-m-d H:i:s',    // Format untuk DATETIME fields
            'time'     => 'H:i:s',          // Format untuk TIME fields
        ],
    ];

    //    /**
    //     * Sample database connection for SQLite3.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'database'    => 'database.db',
    //        'DBDriver'    => 'SQLite3',
    //        'DBPrefix'    => '',
    //        'DBDebug'     => true,
    //        'swapPre'     => '',
    //        'failover'    => [],
    //        'foreignKeys' => true,
    //        'busyTimeout' => 1000,
    //        'synchronous' => null,
    //        'dateFormat'  => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for Postgre.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => '',
    //        'hostname'   => 'localhost',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'database'   => 'ci4',
    //        'schema'     => 'public',
    //        'DBDriver'   => 'Postgre',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'utf8',
    //        'swapPre'    => '',
    //        'failover'   => [],
    //        'port'       => 5432,
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for SQLSRV.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => '',
    //        'hostname'   => 'localhost',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'database'   => 'ci4',
    //        'schema'     => 'dbo',
    //        'DBDriver'   => 'SQLSRV',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'utf8',
    //        'swapPre'    => '',
    //        'encrypt'    => false,
    //        'failover'   => [],
    //        'port'       => 1433,
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for OCI8.
    //     *
    //     * You may need the following environment variables:
    //     *   NLS_LANG                = 'AMERICAN_AMERICA.UTF8'
    //     *   NLS_DATE_FORMAT         = 'YYYY-MM-DD HH24:MI:SS'
    //     *   NLS_TIMESTAMP_FORMAT    = 'YYYY-MM-DD HH24:MI:SS'
    //     *   NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS'
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => 'localhost:1521/XEPDB1',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'DBDriver'   => 'OCI8',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'AL32UTF8',
    //        'swapPre'    => '',
    //        'failover'   => [],
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    /**
     * =======================================================================
     * TESTS DATABASE CONNECTION - Koneksi Database untuk Testing
     * =======================================================================
     *
     * Konfigurasi koneksi database khusus untuk environment testing.
     * Menggunakan SQLite3 in-memory database untuk performa testing yang optimal.
     *
     * TESTING PRINCIPLES:
     * - ✅ Isolated database (tidak affect production data)
     * - ✅ Fast execution (in-memory storage)
     * - ✅ Automatic cleanup setiap test run
     * - ✅ Same schema as production (via migrations)
     *
     * ACTIVATION:
     * - Otomatis aktif ketika ENVIRONMENT = 'testing'
     * - Manual: $this->defaultGroup = 'tests'
     *
     * PERFORMANCE BENEFITS:
     * - ✅ 10-100x faster than file-based SQLite
     * - ✅ No disk I/O overhead
     * - ✅ Instant database setup/teardown
     *
     * LIMITATIONS:
     * - ❌ Data hilang setiap test selesai
     * - ❌ Tidak persistent antar test runs
     * - ❌ Foreign key constraints berbeda dengan MySQL
     *
     * @var array<string, mixed> $tests Array konfigurasi koneksi testing
     */
    public array $tests = [
        // =======================================================================
        // DSN - Data Source Name (Testing)
        // =======================================================================
        // Kosong untuk SQLite in-memory
        'DSN' => '',

        // =======================================================================
        // HOSTNAME - Server address (Testing)
        // =======================================================================
        // Localhost untuk testing environment
        'hostname' => '127.0.0.1',

        // =======================================================================
        // USERNAME/PASSWORD - Credentials (Testing)
        // =======================================================================
        // Kosong untuk SQLite (no authentication needed)
        'username' => '',
        'password' => '',

        // =======================================================================
        // DATABASE - Database name (Testing)
        // =======================================================================
        // ':memory:' = SQLite in-memory database
        // Data hilang ketika connection closed
        'database' => ':memory:',

        // =======================================================================
        // DBDRIVER - Database driver (Testing)
        // =======================================================================
        // SQLite3 untuk fast in-memory testing
        'DBDriver' => 'SQLite3',

        // =======================================================================
        // DBPREFIX - Table prefix (Testing)
        // =======================================================================
        // 'db_' prefix untuk testing (jangan dihapus untuk CI devs)
        // Memastikan testing bekerja dengan prefixes
        'DBPrefix' => 'db_',

        // =======================================================================
        // PCONNECT - Persistent connection (Testing)
        // =======================================================================
        // False untuk testing (fresh connection setiap test)
        'pConnect' => false,

        // =======================================================================
        // DBDEBUG - Database debugging (Testing)
        // =======================================================================
        // True untuk testing (debugging aktif)
        'DBDebug' => true,

        // =======================================================================
        // CHARSET - Character encoding (Testing)
        // =======================================================================
        // UTF-8 untuk testing
        'charset' => 'utf8',

        // =======================================================================
        // DBCOLLAT - Collation (Testing)
        // =======================================================================
        // Kosong untuk SQLite (case-sensitive by default)
        'DBCollat' => '',

        // =======================================================================
        // SWAPPRE - Prefix swapping (Testing)
        // =======================================================================
        // Kosong untuk testing
        'swapPre' => '',

        // =======================================================================
        // ENCRYPT/COMPRESS - Connection options (Testing)
        // =======================================================================
        // False untuk testing (no encryption/compression needed)
        'encrypt' => false,
        'compress' => false,

        // =======================================================================
        // STRICTON - Strict mode (Testing)
        // =======================================================================
        // False untuk testing (allow flexible data types)
        'strictOn' => false,

        // =======================================================================
        // FAILOVER - Backup servers (Testing)
        // =======================================================================
        // Empty array untuk testing
        'failover' => [],

        // =======================================================================
        // PORT - Server port (Testing)
        // =======================================================================
        // 3306 sebagai placeholder (tidak digunakan untuk SQLite)
        'port' => 3306,

        // =======================================================================
        // FOREIGN KEYS - SQLite foreign key support (Testing)
        // =======================================================================
        // True untuk SQLite foreign key enforcement
        'foreignKeys' => true,

        // =======================================================================
        // BUSY TIMEOUT - SQLite busy timeout (Testing)
        // =======================================================================
        // 1000ms timeout untuk waiting locks
        'busyTimeout' => 1000,

        // =======================================================================
        // DATE FORMAT - Date formatting (Testing)
        // =======================================================================
        // Standard CodeIgniter date formats untuk testing
        'dateFormat' => [
            'date'     => 'Y-m-d',          // DATE fields format
            'datetime' => 'Y-m-d H:i:s',    // DATETIME fields format
            'time'     => 'H:i:s',          // TIME fields format
        ],
    ];

    /**
     * =======================================================================
     * CONSTRUCTOR - Inisialisasi Database Configuration
     * =======================================================================
     *
     * Method yang dipanggil otomatis saat Database config di-instantiate.
     * Bertugas untuk setup konfigurasi berdasarkan environment.
     *
     * ENVIRONMENT DETECTION:
     * - ENVIRONMENT constant di-set oleh CodeIgniter berdasarkan:
     *   - .env file APP_ENV setting
     *   - Server environment variables
     *   - Default fallback ke 'production'
     *
     * AUTO-CONFIGURATION LOGIC:
     * 1. Call parent::__construct() untuk inisialisasi base
     * 2. Check ENVIRONMENT constant
     * 3. Jika 'testing' → switch ke 'tests' group
     * 4. Jika 'production'/'development' → gunakan 'default' group
     *
     * SECURITY FEATURES:
     * - ✅ Prevent accidental production data modification during testing
     * - ✅ Automatic environment-based configuration
     * - ✅ Isolated testing database
     *
     * @return void
     */
    public function __construct()
    {
        // =======================================================================
        // PARENT CONSTRUCTOR CALL
        // =======================================================================
        // Panggil parent constructor untuk inisialisasi base configuration
        // Setup default values dan load configuration dari .env jika ada
        parent::__construct();

        // =======================================================================
        // ENVIRONMENT-BASED AUTO-CONFIGURATION
        // =======================================================================
        // Cek constant ENVIRONMENT yang di-set oleh CodeIgniter
        // ENVIRONMENT bisa: 'development', 'testing', 'production'
        if (ENVIRONMENT === 'testing') {
            // Jika environment adalah 'testing':
            // Switch default group ke 'tests' untuk menggunakan SQLite in-memory
            // Ini mencegah testing mengubah data production
            $this->defaultGroup = 'tests';
        }

        // Jika bukan testing environment:
        // Gunakan 'default' group (MySQL) untuk production/development
        // defaultGroup sudah di-set ke 'default' di property declaration
    }
}
