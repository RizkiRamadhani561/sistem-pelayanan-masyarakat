<?php
/**
 * DashboardController - Controller untuk panel admin
 *
 * Controller ini mengelola dashboard admin untuk Sistem Pelayanan Masyarakat Kembangan Raya,
 * termasuk pengelolaan data warga, berita, dan wilayah administrasi.
 *
 * Fitur utama:
 * - Dashboard overview dengan statistik
 * - CRUD management untuk warga
 * - CRUD management untuk berita
 * - CRUD management untuk wilayah (RT/RW)
 * - Role-based access control untuk admin/petugas
 *
 * @package App\Controllers
 * @author Sistem Pelayanan Masyarakat Kembangan Raya
 * @version 1.0.0
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WargaModel;
use App\Models\BeritaModel;
use App\Models\PengaduanModel;
use App\Models\PermohonanModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class DashboardController
 *
 * Mengelola panel administrasi untuk admin dan petugas.
 * Hanya user dengan role 'admin' atau 'petugas' yang dapat mengakses.
 */
class DashboardController extends BaseController
{
    /**
     * Model untuk mengelola data user/admin
     * @var UserModel
     */
    protected $userModel;

    /**
     * Model untuk mengelola data warga
     * @var WargaModel
     */
    protected $wargaModel;

    /**
     * Model untuk mengelola data berita
     * @var BeritaModel
     */
    protected $beritaModel;

    /**
     * Model untuk mengelola data pengaduan
     * @var PengaduanModel
     */
    protected $pengaduanModel;

    /**
     * Model untuk mengelola data permohonan
     * @var PermohonanModel
     */
    protected $permohonanModel;

    /**
     * Constructor - Inisialisasi controller
     *
     * Melakukan dependency injection untuk model yang diperlukan
     * dan inisialisasi semua properti yang diperlukan.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->wargaModel = new WargaModel();
        $this->beritaModel = new BeritaModel();
        $this->pengaduanModel = new PengaduanModel();
        $this->permohonanModel = new PermohonanModel();
    }

    /**
     * Menampilkan dashboard utama admin
     *
     * Dashboard menampilkan statistik overview sistem dan navigasi
     * ke berbagai modul pengelolaan.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View dashboard admin
     */
    public function index()
    {
        // Cek akses admin/petugas
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak. Silakan login sebagai admin/petugas.');
        }

        // Statistik untuk dashboard
        $stats = [
            'total_warga' => $this->wargaModel->countAll(),
            'total_berita' => $this->beritaModel->countAll(),
            'total_pengaduan' => $this->pengaduanModel->countAll(),
            'pengaduan_baru' => $this->pengaduanModel->where('status', 'baru')->countAllResults(),
            'total_permohonan' => $this->permohonanModel->countAll(),
            'permohonan_baru' => $this->permohonanModel->where('status', 'diajukan')->countAllResults(),
        ];

        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard Admin - Sistem Pelayanan Masyarakat Kembangan Raya',
            'user' => session('user'),
            'stats' => $stats,
            'recent_pengaduan' => $this->pengaduanModel->orderBy('created_at', 'DESC')->limit(5)->find(),
            'recent_permohonan' => $this->permohonanModel->orderBy('tanggal_pengajuan', 'DESC')->limit(5)->find(),
            'recent_berita' => $this->beritaModel->where('status', 'published')->orderBy('published_at', 'DESC')->limit(3)->find(),
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Menampilkan daftar warga untuk management
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View management warga
     */
    public function manageWarga()
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Kelola Warga - Dashboard Admin',
            'user' => session('user'),
            'wargas' => $this->wargaModel->findAll(),
        ];

        return view('admin/warga/index', $data);
    }

    /**
     * Menampilkan form tambah warga baru
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View form tambah warga
     */
    public function createWarga()
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah Warga Baru - Dashboard Admin',
            'user' => session('user'),
        ];

        return view('admin/warga/create', $data);
    }

    /**
     * Menyimpan data warga baru
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga
     */
    public function storeWarga()
    {
        // Log untuk debugging
        log_message('debug', 'storeWarga called');

        if (!$this->checkAccess()) {
            log_message('debug', 'Access denied');
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        log_message('debug', 'Access granted, processing form');

        // Debug: Log semua POST data
        $postData = $this->request->getPost();
        log_message('debug', 'POST data: ' . json_encode($postData));

        $rules = [
            'nik' => 'required|numeric|exact_length[16]|is_unique[warga.nik,id_warga,{id_warga}]',
            'nama_lengkap' => 'required|min_length[3]|max_length[150]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[100]',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',
            'alamat' => 'required|min_length[10]',
            'rt_rw' => 'required|regex_match[/^\d{1,2}\/\d{1,2}$/]',
            'kecamatan' => 'required|max_length[100]',
            'kab_kota' => 'required|max_length[100]',
            'provinsi' => 'required|max_length[100]',
            'no_hp' => 'required|regex_match[/^[0-9+\-\s()]+$/]|min_length[10]',
            'email' => 'permit_empty|valid_email|is_unique[warga.email,id_warga,{id_warga}]',
        ];

        if (!$this->validate($rules)) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        log_message('debug', 'Validation passed, preparing data');

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
            'email' => $this->request->getPost('email') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        log_message('debug', 'Data prepared: ' . json_encode($data));

        try {
            $result = $this->wargaModel->insert($data);
            log_message('debug', 'Insert result: ' . ($result ? 'Success (ID: ' . $result . ')' : 'Failed'));

            if ($result) {
                log_message('debug', 'Redirecting to success');
                return redirect()->to('/dashboard/warga')->with('success', 'Data warga berhasil ditambahkan.');
            } else {
                log_message('debug', 'Insert failed, redirecting back');
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data warga.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in storeWarga: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\ResponseInterface View detail warga
     */
    public function showWarga($id)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $warga = $this->wargaModel->find($id);
        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Warga - ' . $warga['nama_lengkap'],
            'user' => session('user'),
            'warga' => $warga,
        ];

        return view('admin/warga/show', $data);
    }

    /**
     * Menampilkan form edit warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\ResponseInterface View form edit warga
     */
    public function editWarga($id)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $warga = $this->wargaModel->find($id);
        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Warga - ' . $warga['nama_lengkap'],
            'user' => session('user'),
            'warga' => $warga,
        ];

        return view('admin/warga/edit', $data);
    }

    /**
     * Update data warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga
     */
    public function updateWarga($id)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $warga = $this->wargaModel->find($id);
        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nik' => 'required|numeric|exact_length[16]|is_unique[warga.nik,id_warga,' . $id . ']',
            'nama_lengkap' => 'required|min_length[3]|max_length[150]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[100]',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',
            'alamat' => 'required|min_length[10]',
            'rt_rw' => 'required|regex_match[/^\d{1,2}\/\d{1,2}$/]',
            'kecamatan' => 'required|max_length[100]',
            'kab_kota' => 'required|max_length[100]',
            'provinsi' => 'required|max_length[100]',
            'no_hp' => 'required|regex_match[/^[0-9+\-\s()]+$/]|min_length[10]',
            'email' => 'permit_empty|valid_email|is_unique[warga.email,id_warga,' . $id . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

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
            'email' => $this->request->getPost('email') ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->wargaModel->update($id, $data)) {
            return redirect()->to('/dashboard/warga')->with('success', 'Data warga berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data warga.');
        }
    }

    /**
     * Hapus data warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga
     */
    public function deleteWarga($id)
    {
        if (!$this->checkAccess()) {
            return redirect()->to('/admin/login')->with('error', 'Akses ditolak.');
        }

        $warga = $this->wargaModel->find($id);
        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->wargaModel->delete($id)) {
            return redirect()->to('/dashboard/warga')->with('success', 'Data warga berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data warga.');
        }
    }

    /**
     * Cek akses admin/petugas
     *
     * @return bool True jika user adalah admin/petugas, false jika tidak
     */
    private function checkAccess()
    {
        if (!session()->has('user')) {
            return false;
        }

        $user = session('user');
        return in_array($user['role'], ['admin', 'petugas']);
    }
}
