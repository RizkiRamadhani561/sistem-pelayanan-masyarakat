<?php
/**
 * AuthController - Controller untuk mengelola autentikasi pengguna
 *
 * Controller ini menangani semua proses autentikasi untuk Sistem Pelayanan Masyarakat Kembangan Raya,
 * termasuk registrasi warga baru, login menggunakan NIK, dan logout dari sistem.
 *
 * Fitur utama:
 * - Registrasi warga dengan validasi data lengkap
 * - Login menggunakan NIK sebagai autentikasi utama
 * - Session management untuk warga dan admin
 * - Role-based access control
 *
 * @package App\Controllers
 * @author Sistem Pelayanan Masyarakat Kembangan Raya
 * @version 1.0.0
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WargaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class AuthController
 *
 * Mengelola autentikasi untuk warga (masyarakat) dalam sistem.
 * Warga dapat mendaftar menggunakan data KTP dan login menggunakan NIK.
 */
class AuthController extends BaseController
{
    /**
     * Model untuk mengelola data warga
     * @var WargaModel
     */
    protected $wargaModel;

    /**
     * Model untuk mengelola data admin/petugas
     * @var UserModel
     */
    protected $userModel;

    /**
     * Constructor - Inisialisasi controller
     *
     * Melakukan dependency injection untuk model yang diperlukan
     * dan menginisialisasi semua properti yang diperlukan.
     */
    public function __construct()
    {
        $this->wargaModel = new WargaModel();
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman registrasi warga
     *
     * Method ini menampilkan form registrasi untuk warga baru yang ingin
     * mendaftar ke sistem. Form ini akan meminta data lengkap sesuai KTP
     * dan informasi domisili warga.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View halaman registrasi
     */
    public function register()
    {
        // Data yang akan dikirim ke view
        $data = [
            'title' => 'Daftar - Sistem Pelayanan Masyarakat Kembangan Raya',
        ];

        // Mengembalikan view dengan data
        return view('auth/register', $data);
    }

    /**
     * Memproses data registrasi warga
     *
     * Method ini menangani POST request dari form registrasi, melakukan validasi
     * data yang dikirim, dan menyimpan data warga baru ke database jika valid.
     *
     * Validasi yang dilakukan:
     * - NIK: wajib, numerik, tepat 16 digit, unik
     * - Nama lengkap: wajib, 3-150 karakter
     * - Jenis kelamin: wajib, L atau P
     * - Tempat/tanggal lahir: wajib, format valid
     * - Alamat & wilayah: wajib, sesuai format
     * - Kontak: nomor HP wajib, email opsional tapi unik jika diisi
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke login jika berhasil, kembali ke form jika gagal
     */
    public function store()
    {
        // Log untuk debugging - CEK APAKAH METHOD INI DIPANGGIL
        log_message('debug', '=== AUTH REGISTRATION STORE METHOD CALLED ===');
        log_message('debug', 'AuthController::store() dipanggil pada: ' . date('Y-m-d H:i:s'));

        // Log semua request data
        log_message('debug', 'REQUEST METHOD: ' . $this->request->getMethod());
        log_message('debug', 'REQUEST URI: ' . $this->request->getUri());
        log_message('debug', 'ALL POST DATA: ' . json_encode($this->request->getPost()));
        log_message('debug', 'ALL GET DATA: ' . json_encode($this->request->getGet()));

        // Aturan validasi untuk setiap field form
        $rules = [
            // NIK: wajib diisi, harus numerik, tepat 16 digit, unik di database
            'nik' => 'required|numeric|exact_length[16]|is_unique[warga.nik,id_warga,{id_warga}]',

            // Nama lengkap: wajib, minimal 3 karakter, maksimal 150 karakter
            'nama_lengkap' => 'required|min_length[3]|max_length[150]',

            // Jenis kelamin: wajib, hanya boleh L (Laki-laki) atau P (Perempuan)
            'jenis_kelamin' => 'required|in_list[L,P]',

            // Tempat lahir: wajib, maksimal 100 karakter
            'tempat_lahir' => 'required|max_length[100]',

            // Tanggal lahir: wajib, harus format tanggal Y-m-d yang valid
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',

            // Alamat lengkap: wajib, minimal 10 karakter
            'alamat' => 'required|min_length[10]',

            // RT/RW: wajib, format xx/xx (contoh: 01/02)
            'rt_rw' => 'required|regex_match[/^\d{1,2}\/\d{1,2}$/]',

            // Wilayah administrasi: wajib diisi
            'kecamatan' => 'required|max_length[100]',
            'kab_kota' => 'required|max_length[100]',
            'provinsi' => 'required|max_length[100]',

            // Kontak: nomor HP wajib dengan format yang valid
            'no_hp' => 'required|regex_match[/^[0-9+\-\s()]+$/]|min_length[10]',

            // Email: opsional, tapi jika diisi harus valid email dan unik
            'email' => 'permit_empty|valid_email|is_unique[warga.email,id_warga,{id_warga}]',

            // Password: wajib untuk form, minimal 6 karakter
            'password' => 'required|min_length[6]',

            // Konfirmasi password: wajib sama dengan password
            'confirm_password' => 'required|matches[password]',
        ];

        // Melakukan validasi data berdasarkan aturan di atas
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error dan input lama
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengumpulkan data yang telah divalidasi untuk disimpan
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'rt_rw' => $this->request->getPost('rt_rw'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kab_kota' => $this->request->getPost('kab_kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email') ?: null, // Null jika kosong
            'created_at' => date('Y-m-d H:i:s'), // Timestamp pembuatan
            'updated_at' => date('Y-m-d H:i:s'), // Timestamp update
        ];

        // Catatan: Password tidak disimpan untuk warga karena autentikasi menggunakan NIK
        // Dalam sistem nyata, mungkin perlu ditambahkan autentikasi password untuk warga

        // Menyimpan data ke database melalui model
        if ($this->wargaModel->insert($data)) {
            // Jika berhasil, redirect ke halaman login dengan pesan sukses
            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login dengan NIK Anda.');
        } else {
            // Jika gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman login warga
     *
     * Method ini menampilkan form login sederhana yang hanya meminta NIK.
     * Sistem menggunakan NIK sebagai autentikasi utama untuk warga.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View halaman login
     */
    public function login()
    {
        // Data untuk halaman login
        $data = [
            'title' => 'Login - Sistem Pelayanan Masyarakat Kembangan Raya',
        ];

        // Mengembalikan view login
        return view('auth/login', $data);
    }

    /**
     * Menampilkan halaman login admin/petugas
     *
     * Method ini menampilkan form login untuk admin dan petugas dengan
     * email dan password sebagai kredensial autentikasi.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View halaman admin login
     */
    public function adminLogin()
    {
        // Data untuk halaman admin login
        $data = [
            'title' => 'Login Admin/Petugas - Sistem Pelayanan Masyarakat Kembangan Raya',
        ];

        // Mengembalikan view admin login
        return view('auth/admin_login', $data);
    }

    /**
     * Memproses autentikasi login warga
     *
     * Method ini memverifikasi NIK yang dimasukkan user dan membuat session
     * jika NIK valid. Sistem akan mencari data warga berdasarkan NIK.
     *
     * Proses autentikasi:
     * 1. Validasi input NIK tidak kosong
     * 2. Query database untuk mencari warga dengan NIK tersebut
     * 3. Jika ditemukan, buat session dan redirect ke homepage
     * 4. Jika tidak ditemukan, kembali ke form dengan error
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke homepage jika berhasil, kembali ke login jika gagal
     */
    public function authenticate()
    {
        // Mengambil NIK dari form POST
        $nik = $this->request->getPost('nik');

        // Validasi dasar: NIK harus diisi
        if (!$nik) {
            return redirect()->back()->withInput()->with('error', 'NIK harus diisi.');
        }

        // Mencari data warga berdasarkan NIK
        $warga = $this->wargaModel->where('nik', $nik)->first();

        // Jika warga ditemukan dengan NIK tersebut
        if ($warga) {
            // Membuat session untuk warga yang berhasil login
            // Session ini akan digunakan di seluruh aplikasi untuk identifikasi user
            session()->set('warga', $warga);

            // Redirect ke homepage dengan pesan selamat datang
            return redirect()->to('/')->with('success', 'Login berhasil! Selamat datang, ' . $warga['nama_lengkap']);
        } else {
            // Jika NIK tidak ditemukan, kembali ke form login dengan error
            return redirect()->back()->withInput()->with('error', 'NIK tidak ditemukan. Silakan daftar terlebih dahulu.');
        }
    }

    /**
     * Memproses autentikasi login admin/petugas
     *
     * Method ini memverifikasi email dan password yang dimasukkan admin/petugas
     * dan membuat session jika kredensial valid.
     *
     * Proses autentikasi:
     * 1. Validasi input email dan password tidak kosong
     * 2. Query database untuk mencari user dengan email tersebut
     * 3. Verifikasi password menggunakan password_verify()
     * 4. Jika valid, buat session dan redirect ke dashboard
     * 5. Jika tidak valid, kembali ke form dengan error
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke dashboard jika berhasil, kembali ke login jika gagal
     */
    public function authenticateAdmin()
    {
        // Mengambil email dan password dari form POST
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi dasar: email dan password harus diisi
        if (!$email || !$password) {
            return redirect()->back()->withInput()->with('error', 'Email dan password harus diisi.');
        }

        // Mencari data user berdasarkan email
        $user = $this->userModel->where('email', $email)->first();

        // Jika user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            // Membuat session untuk admin/petugas yang berhasil login
            // Session ini akan digunakan di seluruh aplikasi untuk identifikasi user
            session()->set('user', $user);

            // Redirect ke dashboard dengan pesan selamat datang
            $roleName = $user['role'] == 'admin' ? 'Admin' : 'Petugas';
            return redirect()->to('/dashboard')->with('success', "Login berhasil! Selamat datang, {$roleName} " . $user['nama']);
        } else {
            // Jika kredensial tidak valid, kembali ke form login dengan error
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }
    }

    /**
     * Memproses logout pengguna
     *
     * Method ini menghapus semua session yang terkait dengan autentikasi
     * baik untuk warga maupun admin/petugas, kemudian redirect ke homepage.
     *
     * Proses logout:
     * 1. Hapus session 'warga' (untuk warga yang login)
     * 2. Hapus session 'user' (untuk admin/petugas yang login)
     * 3. Redirect ke homepage dengan pesan sukses
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke homepage
     */
    public function logout()
    {
        // Menghapus session warga jika ada
        session()->remove('warga');

        // Menghapus session user (admin/petugas) jika ada
        session()->remove('user');

        // Redirect ke homepage dengan pesan logout berhasil
        return redirect()->to('/')->with('success', 'Logout berhasil.');
    }
}
