<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * URL Dasar Situs
     * --------------------------------------------------------------------------
     *
     * URL ke root CodeIgniter Anda. Biasanya, ini akan menjadi URL dasar Anda,
     * DENGAN garis miring di akhir:
     *
     * Contoh: http://example.com/
     */
    public string $baseURL = 'http://localhost:8081/';

    /**
     * Hostname yang Diizinkan di URL Situs selain hostname di baseURL.
     * Jika Anda ingin menerima beberapa Hostname, atur ini.
     *
     * Contoh:
     * Ketika URL situs Anda ($baseURL) adalah 'http://example.com/', dan situs Anda
     * juga menerima 'http://media.example.com/' dan 'http://accounts.example.com/':
     *     ['media.example.com', 'accounts.example.com']
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * --------------------------------------------------------------------------
     * File Index
     * --------------------------------------------------------------------------
     *
     * Biasanya, ini akan menjadi file `index.php` Anda, kecuali Anda telah mengubah namanya
     * menjadi yang lain. Jika Anda telah mengonfigurasi server web untuk menghapus file ini
     * dari URI situs Anda, atur variabel ini ke string kosong.
     */
    public string $indexPage = 'index.php';

    /**
     * --------------------------------------------------------------------------
     * PROTOKOL URI
     * --------------------------------------------------------------------------
     *
     * Item ini menentukan global server mana yang harus digunakan untuk mengambil
     * string URI. Pengaturan default 'REQUEST_URI' berfungsi untuk sebagian besar server.
     * Jika tautan Anda tidak berfungsi, coba salah satu rasa lezat lainnya:
     *
     *  'REQUEST_URI': Menggunakan $_SERVER['REQUEST_URI']
     * 'QUERY_STRING': Menggunakan $_SERVER['QUERY_STRING']
     *    'PATH_INFO': Menggunakan $_SERVER['PATH_INFO']
     *
     * PERINGATAN: Jika Anda mengatur ini ke 'PATH_INFO', URI akan selalu di-decode URL!
     */
    public string $uriProtocol = 'REQUEST_URI';

    /*
    |--------------------------------------------------------------------------
    | Karakter URL yang Diizinkan
    |--------------------------------------------------------------------------
    |
    | Ini memungkinkan Anda menentukan karakter mana yang diizinkan dalam URL Anda.
    | Ketika seseorang mencoba mengirimkan URL dengan karakter yang tidak diizinkan,
    | mereka akan mendapat pesan peringatan.
    |
    | Sebagai langkah keamanan, Anda SANGAT disarankan untuk membatasi URL
    | ke sesedikit mungkin karakter.
    |
    | Secara default, hanya karakter ini yang diizinkan: `a-z 0-9~%.:_-`
    |
    | Atur string kosong untuk mengizinkan semua karakter -- tetapi hanya jika Anda gila.
    |
    | Nilai yang dikonfigurasi sebenarnya adalah grup karakter ekspresi reguler
    | dan akan digunakan sebagai: '/\A[<permittedURIChars>]+\z/iu'
    |
    | JANGAN UBAH INI KECUALI ANDA SEPENUHNYA MEMAHAMI KONSEKUENSINYA!!
    |
    */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * --------------------------------------------------------------------------
     * Locale Default
     * --------------------------------------------------------------------------
     *
     * Locale secara kasar mewakili bahasa dan lokasi dari mana pengunjung Anda
     * melihat situs. Ini memengaruhi string bahasa dan string lainnya
     * (seperti penanda mata uang, angka, dll), yang program Anda
     * harus jalankan untuk permintaan ini.
     */
    public string $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negosiasi Locale
     * --------------------------------------------------------------------------
     *
     * Jika true, objek Request saat ini akan secara otomatis menentukan
     * bahasa yang akan digunakan berdasarkan nilai header Accept-Language.
     *
     * Jika false, tidak ada deteksi otomatis yang akan dilakukan.
     */
    public bool $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Locale yang Didukung
     * --------------------------------------------------------------------------
     *
     * Jika $negotiateLocale adalah true, array ini mencantumkan locale yang didukung
     * oleh aplikasi dalam urutan prioritas menurun. Jika tidak ada kecocokan
     * yang ditemukan, locale pertama akan digunakan.
     *
     * IncomingRequest::setLocale() juga menggunakan daftar ini.
     *
     * @var list<string>
     */
    public array $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Zona Waktu Aplikasi
     * --------------------------------------------------------------------------
     *
     * Zona waktu default yang akan digunakan dalam aplikasi Anda untuk menampilkan
     * tanggal dengan helper tanggal, dan dapat diambil melalui app_timezone()
     *
     * @see https://www.php.net/manual/en/timezones.php untuk daftar zona waktu
     *      yang didukung oleh PHP.
     */
    public string $appTimezone = 'UTC';

    /**
     * --------------------------------------------------------------------------
     * Set Karakter Default
     * --------------------------------------------------------------------------
     *
     * Ini menentukan set karakter mana yang digunakan secara default dalam berbagai metode
     * yang memerlukan set karakter yang disediakan.
     *
     * @see http://php.net/htmlspecialchars untuk daftar charset yang didukung.
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Paksa Permintaan Aman Global
     * --------------------------------------------------------------------------
     *
     * Jika true, ini akan memaksa setiap permintaan yang dibuat ke aplikasi ini untuk
     * dibuat melalui koneksi aman (HTTPS). Jika permintaan yang masuk tidak
     * aman, pengguna akan diarahkan ke versi aman halaman
     * dan header HTTP Strict Transport Security (HSTS) akan diatur.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * IP Reverse Proxy
     * --------------------------------------------------------------------------
     *
     * Jika server Anda berada di belakang reverse proxy, Anda harus melakukan whitelist
     * alamat IP proxy dari mana CodeIgniter harus mempercayai header seperti
     * X-Forwarded-For atau Client-IP untuk mengidentifikasi dengan benar
     * alamat IP pengunjung.
     *
     * Anda perlu mengatur alamat IP proxy atau alamat IP dengan subnet dan
     * header HTTP untuk alamat IP klien.
     *
     * Berikut adalah beberapa contoh:
     *     [
     *         '10.0.1.200'     => 'X-Forwarded-For',
     *         '192.168.5.0/24' => 'X-Real-IP',
     *     ]
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    /**
     * --------------------------------------------------------------------------
     * Kebijakan Keamanan Konten
     * --------------------------------------------------------------------------
     *
     * Mengaktifkan Kebijakan Keamanan Konten Response untuk membatasi sumber yang
     * dapat digunakan untuk gambar, skrip, file CSS, audio, video, dll. Jika diaktifkan,
     * objek Response akan mengisi nilai default kebijakan dari file
     * `ContentSecurityPolicy.php`. Controller selalu dapat menambahkan batasan tersebut
     * pada waktu proses.
     *
     * Untuk pemahaman yang lebih baik tentang CSP, lihat dokumen berikut:
     *
     * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
     * @see http://www.w3.org/TR/CSP/
     */
    public bool $CSPEnabled = false;
}
