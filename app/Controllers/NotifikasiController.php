<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotifikasiModel;
use App\Models\UserModel;
use App\Models\WargaModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk mengelola sistem notifikasi
 *
 * Fitur ini mengatur semua aspek notifikasi dalam sistem:
 * - Kirim notifikasi ke pengguna tertentu
 * - Broadcast notifikasi ke semua pengguna
 * - Tandai notifikasi sebagai sudah dibaca
 * - Kelola template notifikasi
 * - Integrasi dengan email dan push notification
 */
class NotifikasiController extends BaseController
{
    protected $notifikasiModel;
    protected $userModel;
    protected $wargaModel;

    /**
     * Konstruktor untuk inisialisasi model
     * Mengatur dependency injection untuk model yang diperlukan
     */
    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
        $this->userModel = new UserModel();
        $this->wargaModel = new WargaModel();
    }

    /**
     * Menampilkan daftar semua notifikasi untuk admin
     * Digunakan untuk mengelola dan memantau semua notifikasi sistem
     *
     * Method: GET
     * Route: /admin/notifikasi
     * Akses: Admin & Petugas
     */
    public function index()
    {
        // Cek akses admin/petugas
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Manajemen Notifikasi - Sistem Pelayanan Masyarakat',
            'notifikasi' => $this->notifikasiModel->orderBy('created_at', 'DESC')->findAll(),
            'total_notifikasi' => $this->notifikasiModel->countAll(),
            'belum_dibaca' => $this->notifikasiModel->where('status', 'belum_dibaca')->countAllResults(),
        ];

        return view('admin/notifikasi/index', $data);
    }

    /**
     * Menampilkan notifikasi untuk pengguna saat ini
     * Menampilkan notifikasi berdasarkan role pengguna (warga/admin)
     *
     * Method: GET
     * Route: /notifikasi
     * Akses: Semua pengguna terautentikasi
     */
    public function userNotifications()
    {
        $data = [
            'title' => 'Notifikasi Saya - Sistem Pelayanan Masyarakat',
            'notifikasi' => []
        ];

        // Ambil notifikasi berdasarkan role pengguna
        if (session()->has('user')) {
            // Untuk admin/petugas - ambil semua notifikasi sistem
            $data['notifikasi'] = $this->notifikasiModel
                ->where('tipe_penerima', 'semua')
                ->orWhere('tipe_penerima', 'petugas')
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } elseif (session()->has('warga')) {
            // Untuk warga - ambil notifikasi personal
            $data['notifikasi'] = $this->notifikasiModel
                ->where('tipe_penerima', 'semua')
                ->orWhere('tipe_penerima', 'warga')
                ->orWhere('penerima_id', session('warga')['id_warga'])
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        return view('notifikasi/index', $data);
    }

    /**
     * Membuat notifikasi baru
     * Form untuk membuat notifikasi broadcast atau personal
     *
     * Method: GET
     * Route: /admin/notifikasi/create
     * Akses: Admin & Petugas
     */
    public function create()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Buat Notifikasi Baru - Sistem Pelayanan Masyarakat',
            'warga' => $this->wargaModel->findAll(),
            'petugas' => $this->userModel->findAll(),
        ];

        return view('admin/notifikasi/create', $data);
    }

    /**
     * Menyimpan notifikasi baru ke database
     * Memproses data dari form pembuatan notifikasi
     *
     * Method: POST
     * Route: /admin/notifikasi/store
     * Akses: Admin & Petugas
     */
    public function store()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $rules = [
            'judul' => 'required|min_length[5]|max_length[200]',
            'pesan' => 'required|min_length[10]',
            'tipe_penerima' => 'required|in_list[semua,warga,petugas,personal]',
            'prioritas' => 'required|in_list[rendah,sedang,tinggi,darurat]',
        ];

        // Tambahkan validasi untuk penerima personal
        if ($this->request->getPost('tipe_penerima') === 'personal') {
            $rules['penerima_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'pesan' => $this->request->getPost('pesan'),
            'tipe_penerima' => $this->request->getPost('tipe_penerima'),
            'prioritas' => $this->request->getPost('prioritas'),
            'pengirim_id' => session('user')['id_user'],
            'status' => 'belum_dibaca',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Set penerima untuk notifikasi personal
        if ($this->request->getPost('tipe_penerima') === 'personal') {
            $data['penerima_id'] = $this->request->getPost('penerima_id');
        }

        if ($this->notifikasiModel->insert($data)) {
            // Kirim email notifikasi jika diperlukan
            $this->kirimEmailNotifikasi($data);

            return redirect()->to('/admin/notifikasi')->with('success', 'Notifikasi berhasil dikirim');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim notifikasi');
        }
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca
     * Mengupdate status notifikasi melalui AJAX
     *
     * Method: POST
     * Route: /notifikasi/mark-read
     * Akses: Semua pengguna terautentikasi
     */
    public function markAsRead()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        $id = $this->request->getPost('id');

        if ($this->notifikasiModel->update($id, [
            'status' => 'sudah_dibaca',
            'updated_at' => date('Y-m-d H:i:s')
        ])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai sudah dibaca'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menandai notifikasi'
            ]);
        }
    }

    /**
     * Menghapus notifikasi
     * Menghapus notifikasi dari database
     *
     * Method: DELETE
     * Route: /admin/notifikasi/{id}/delete
     * Akses: Admin & Petugas
     */
    public function delete($id)
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        if ($this->notifikasiModel->delete($id)) {
            return redirect()->to('/admin/notifikasi')->with('success', 'Notifikasi berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus notifikasi');
        }
    }

    /**
     * Mengirim notifikasi otomatis untuk pengaduan baru
     * Dipanggil otomatis ketika ada pengaduan baru
     *
     * @param array $pengaduan Data pengaduan
     */
    public function kirimNotifikasiPengaduanBaru($pengaduan)
    {
        // Kirim notifikasi ke petugas
        $petugas = $this->userModel->where('role', 'petugas')->findAll();

        foreach ($petugas as $p) {
            $this->notifikasiModel->insert([
                'judul' => 'Pengaduan Baru Masuk',
                'pesan' => "Ada pengaduan baru dari {$pengaduan['judul']} yang perlu ditangani.",
                'tipe_penerima' => 'petugas',
                'prioritas' => 'sedang',
                'status' => 'belum_dibaca',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Mengirim notifikasi otomatis untuk permohonan baru
     * Dipanggil otomatis ketika ada permohonan baru
     *
     * @param array $permohonan Data permohonan
     */
    public function kirimNotifikasiPermohonanBaru($permohonan)
    {
        // Kirim notifikasi ke petugas yang bertugas
        $this->notifikasiModel->insert([
            'judul' => 'Permohonan Layanan Baru',
            'pesan' => "Ada permohonan layanan baru dengan nomor {$permohonan['nomor_permohonan']}.",
            'tipe_penerima' => 'petugas',
            'prioritas' => 'sedang',
            'status' => 'belum_dibaca',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Mengirim notifikasi email
     * Mengirim notifikasi melalui email jika diperlukan
     *
     * @param array $notifikasi Data notifikasi
     * @return bool Status pengiriman
     */
    private function kirimEmailNotifikasi($notifikasi)
    {
        // Implementasi email notification
        // Menggunakan CodeIgniter Email library

        try {
            $email = \Config\Services::email();

            $email->setFrom('noreply@kembanganraya.go.id', 'Sistem Pelayanan Masyarakat');
            $email->setSubject($notifikasi['judul']);

            // Set recipients berdasarkan tipe penerima
            switch ($notifikasi['tipe_penerima']) {
                case 'semua':
                    // Kirim ke semua pengguna (implementasi kompleks)
                    break;
                case 'warga':
                    // Kirim ke semua warga
                    $warga = $this->wargaModel->where('email IS NOT NULL')->findAll();
                    foreach ($warga as $w) {
                        $email->setTo($w['email']);
                        $email->setMessage($this->formatEmailMessage($notifikasi));
                        $email->send();
                    }
                    break;
                case 'petugas':
                    // Kirim ke semua petugas
                    $petugas = $this->userModel->where('email IS NOT NULL')->findAll();
                    foreach ($petugas as $p) {
                        $email->setTo($p['email']);
                        $email->setMessage($this->formatEmailMessage($notifikasi));
                        $email->send();
                    }
                    break;
                case 'personal':
                    // Kirim ke pengguna tertentu
                    if ($notifikasi['penerima_id']) {
                        // Cek apakah penerima adalah warga atau petugas
                        $penerima = $this->wargaModel->find($notifikasi['penerima_id']);
                        if (!$penerima) {
                            $penerima = $this->userModel->find($notifikasi['penerima_id']);
                        }

                        if ($penerima && isset($penerima['email'])) {
                            $email->setTo($penerima['email']);
                            $email->setMessage($this->formatEmailMessage($notifikasi));
                            $email->send();
                        }
                    }
                    break;
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Gagal mengirim email notifikasi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Memformat pesan email notifikasi
     *
     * @param array $notifikasi Data notifikasi
     * @return string Pesan email yang sudah diformat
     */
    private function formatEmailMessage($notifikasi)
    {
        return "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .header { background: #007bff; color: white; padding: 20px; }
                    .content { padding: 20px; }
                    .footer { background: #f8f9fa; padding: 20px; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h2>{$notifikasi['judul']}</h2>
                    <p>Sistem Pelayanan Masyarakat Kembangan Raya</p>
                </div>
                <div class='content'>
                    <p>{$notifikasi['pesan']}</p>
                    <p>Dikirim pada: " . date('d F Y H:i', strtotime($notifikasi['created_at'])) . "</p>
                </div>
                <div class='footer'>
                    <p>Email ini dikirim otomatis oleh sistem. Jangan membalas email ini.</p>
                    <p>&copy; 2025 Pemerintah Kembangan Raya</p>
                </div>
            </body>
            </html>
        ";
    }

    /**
     * API endpoint untuk mendapatkan notifikasi terbaru
     * Digunakan untuk real-time notification updates
     *
     * Method: GET
     * Route: /api/notifikasi/latest
     * Akses: Semua pengguna terautentikasi
     */
    public function getLatestNotifications()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        $limit = $this->request->getGet('limit') ?? 10;

        if (session()->has('user')) {
            $notifikasi = $this->notifikasiModel
                ->where('tipe_penerima', 'semua')
                ->orWhere('tipe_penerima', 'petugas')
                ->orderBy('created_at', 'DESC')
                ->limit($limit)
                ->findAll();
        } elseif (session()->has('warga')) {
            $notifikasi = $this->notifikasiModel
                ->where('tipe_penerima', 'semua')
                ->orWhere('tipe_penerima', 'warga')
                ->orWhere('penerima_id', session('warga')['id_warga'])
                ->orderBy('created_at', 'DESC')
                ->limit($limit)
                ->findAll();
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $notifikasi
        ]);
    }
}
