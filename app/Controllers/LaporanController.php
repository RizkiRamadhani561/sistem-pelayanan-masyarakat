<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\PermohonanModel;
use App\Models\WargaModel;
use App\Models\UserModel;
use App\Models\NotifikasiModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk mengelola sistem laporan dan analitik
 *
 * Fitur ini menyediakan berbagai laporan dan statistik untuk:
 * - Analisis kinerja sistem pelayanan masyarakat
 * - Monitoring tren pengaduan dan permohonan
 * - Pelaporan untuk keperluan manajemen
 * - Dashboard metrics untuk pengambil keputusan
 */
class LaporanController extends BaseController
{
    protected $pengaduanModel;
    protected $permohonanModel;
    protected $wargaModel;
    protected $userModel;
    protected $notifikasiModel;

    /**
     * Konstruktor untuk inisialisasi semua model yang diperlukan
     * Mengatur dependency injection untuk analitik data
     */
    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->permohonanModel = new PermohonanModel();
        $this->wargaModel = new WargaModel();
        $this->userModel = new UserModel();
        $this->notifikasiModel = new NotifikasiModel();
    }

    /**
     * Menampilkan dashboard laporan utama
     * Berisi overview semua statistik sistem
     *
     * Method: GET
     * Route: /admin/laporan
     * Akses: Admin & Petugas
     */
    public function index()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        try {
            $data = [
                'title' => 'Dashboard Laporan & Analitik',
                'stats' => $this->getDashboardStats(),
                'charts' => $this->getChartData(),
            ];

            return view('admin/laporan/index', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanController::index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan laporan pengaduan detail
     * Analisis mendalam tentang pengaduan masyarakat
     *
     * Method: GET
     * Route: /admin/laporan/pengaduan
     * Akses: Admin & Petugas
     */
    public function laporanPengaduan()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Laporan Pengaduan Masyarakat',
            'pengaduan_stats' => $this->getPengaduanStats(),
            'pengaduan_trend' => $this->getPengaduanTrend(),
            'kategori_stats' => $this->getKategoriPengaduan(),
        ];

        return view('admin/laporan/pengaduan', $data);
    }

    /**
     * Menampilkan laporan permohonan layanan
     * Analisis permohonan layanan administrasi
     *
     * Method: GET
     * Route: /admin/laporan/permohonan
     * Akses: Admin & Petugas
     */
    public function laporanPermohonan()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Laporan Permohonan Layanan',
            'permohonan_stats' => $this->getPermohonanStats(),
            'layanan_populer' => $this->getLayananPopuler(),
            'waktu_proses' => $this->getWaktuProsesStats(),
        ];

        return view('admin/laporan/permohonan', $data);
    }

    /**
     * Menampilkan laporan pengguna dan aktivitas
     * Analisis perilaku pengguna dalam sistem
     *
     * Method: GET
     * Route: /admin/laporan/pengguna
     * Akses: Admin & Petugas
     */
    public function laporanPengguna()
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Laporan Aktivitas Pengguna',
            'user_stats' => $this->getUserStats(),
            'aktivitas_stats' => $this->getAktivitasStats(),
            'demografi_warga' => $this->getDemografiWarga(),
        ];

        return view('admin/laporan/pengguna', $data);
    }

    /**
     * Export laporan ke format PDF atau Excel
     * Menghasilkan file laporan untuk keperluan dokumentasi
     *
     * Method: GET
     * Route: /admin/laporan/export/{type}/{period}
     * Akses: Admin & Petugas
     */
    public function export($type, $period = 'month')
    {
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        switch ($type) {
            case 'pengaduan':
                return $this->exportPengaduanReport($period);
            case 'permohonan':
                return $this->exportPermohonanReport($period);
            case 'pengguna':
                return $this->exportUserReport($period);
            default:
                return redirect()->back()->with('error', 'Tipe laporan tidak valid');
        }
    }

    /**
     * Mendapatkan statistik dashboard utama
     * Menghitung metrics penting untuk overview sistem
     *
     * @return array Statistik dashboard
     */
    private function getDashboardStats()
    {
        try {
            $bulan_ini = date('Y-m');

            return [
                'total_warga' => $this->wargaModel->countAll(),
                'total_pengaduan' => $this->pengaduanModel->countAll(),
                'total_perMohonan' => $this->permohonanModel->countAll(),
                'pengaduan_bulan_ini' => $this->pengaduanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $bulan_ini)->countAllResults(),
                'permohonan_bulan_ini' => $this->permohonanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $bulan_ini)->countAllResults(),
                'pengaduan_selesai' => $this->pengaduanModel->where('status', 'selesai')->countAllResults(),
                'permohonan_selesai' => $this->permohonanModel->where('status', 'selesai')->countAllResults(),
                'rata_waktu_pengaduan' => $this->hitungRataWaktuProses('pengaduan'),
                'rata_waktu_perMohonan' => $this->hitungRataWaktuProses('permohonan'),
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error in getDashboardStats: ' . $e->getMessage());
            return [
                'total_warga' => 0,
                'total_pengaduan' => 0,
                'total_perMohonan' => 0,
                'pengaduan_bulan_ini' => 0,
                'permohonan_bulan_ini' => 0,
                'pengaduan_selesai' => 0,
                'permohonan_selesai' => 0,
                'rata_waktu_pengaduan' => 0,
                'rata_waktu_perMohonan' => 0,
            ];
        }
    }

    /**
     * Mendapatkan data untuk chart dashboard
     * Menyiapkan data time series untuk visualisasi
     *
     * @return array Data chart
     */
    private function getChartData()
    {
        $bulanLabels = [];
        $pengaduanData = [];
        $permohonanData = [];

        // Data 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-{$i} months"));
            $label = date('M Y', strtotime("-{$i} months"));

            $bulanLabels[] = $label;
            $pengaduanData[] = $this->pengaduanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $date)->countAllResults();
            $permohonanData[] = $this->permohonanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $date)->countAllResults();
        }

        return [
            'labels' => $bulanLabels,
            'pengaduan' => $pengaduanData,
            'permohonan' => $permohonanData,
        ];
    }

    /**
     * Mendapatkan statistik pengaduan detail
     * Analisis mendalam tentang pengaduan
     *
     * @return array Statistik pengaduan
     */
    private function getPengaduanStats()
    {
        return [
            'total_pengaduan' => $this->pengaduanModel->countAll(),
            'pengaduan_baru' => $this->pengaduanModel->where('status', 'baru')->countAllResults(),
            'pengaduan_diproses' => $this->pengaduanModel->where('status', 'diproses')->countAllResults(),
            'pengaduan_selesai' => $this->pengaduanModel->where('status', 'selesai')->countAllResults(),
            'rata_respons' => $this->hitungRataWaktuRespons('pengaduan'),
            'kepuasan_pengguna' => $this->hitungTingkatKepuasan(),
        ];
    }

    /**
     * Mendapatkan tren pengaduan per periode
     * Analisis pola pengaduan dari waktu ke waktu
     *
     * @return array Data tren pengaduan
     */
    private function getPengaduanTrend()
    {
        $tren = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $tren[] = [
                'tanggal' => $date,
                'jumlah' => $this->pengaduanModel->where('DATE(created_at)', $date)->countAllResults(),
            ];
        }

        return $tren;
    }

    /**
     * Mendapatkan statistik kategori pengaduan
     * Mengelompokkan pengaduan berdasarkan kategori
     *
     * @return array Statistik kategori
     */
    private function getKategoriPengaduan()
    {
        // Karena belum ada field kategori, kita analisis berdasarkan judul
        $pengaduan = $this->pengaduanModel->findAll();
        $kategori = [];

        foreach ($pengaduan as $item) {
            $kat = $this->kategorikanPengaduan($item['judul']);
            if (!isset($kategori[$kat])) {
                $kategori[$kat] = 0;
            }
            $kategori[$kat]++;
        }

        arsort($kategori);
        return array_slice($kategori, 0, 10, true);
    }

    /**
     * Mengkategorikan pengaduan berdasarkan judul
     * Menggunakan keyword matching untuk klasifikasi
     *
     * @param string $judul Judul pengaduan
     * @return string Kategori pengaduan
     */
    private function kategorikanPengaduan($judul)
    {
        $judul = strtolower($judul);

        if (strpos($judul, 'jalan') !== false || strpos($judul, 'aspal') !== false) {
            return 'Infrastruktur Jalan';
        } elseif (strpos($judul, 'lampu') !== false || strpos($judul, 'listrik') !== false) {
            return 'Fasilitas Listrik';
        } elseif (strpos($judul, 'kebersihan') !== false || strpos($judul, 'sampah') !== false) {
            return 'Kebersihan Lingkungan';
        } elseif (strpos($judul, 'air') !== false) {
            return 'Air Bersih';
        } elseif (strpos($judul, 'kesehatan') !== false || strpos($judul, 'rumah sakit') !== false) {
            return 'Kesehatan';
        } elseif (strpos($judul, 'pendidikan') !== false || strpos($judul, 'sekolah') !== false) {
            return 'Pendidikan';
        } elseif (strpos($judul, 'keamanan') !== false || strpos($judul, 'kamling') !== false) {
            return 'Keamanan';
        } else {
            return 'Lainnya';
        }
    }

    /**
     * Mendapatkan statistik permohonan layanan
     * Analisis permohonan berdasarkan berbagai parameter
     *
     * @return array Statistik permohonan
     */
    private function getPermohonanStats()
    {
        return [
            'total_permohonan' => $this->permohonanModel->countAll(),
            'permohonan_diajukan' => $this->permohonanModel->where('status', 'diajukan')->countAllResults(),
            'permohonan_diproses' => $this->permohonanModel->where('status', 'diproses')->countAllResults(),
            'permohonan_selesai' => $this->permohonanModel->where('status', 'selesai')->countAllResults(),
            'permohonan_ditolak' => $this->permohonanModel->where('status', 'ditolak')->countAllResults(),
            'tingkat_kelulusan' => $this->hitungTingkatKelulusan(),
        ];
    }

    /**
     * Mendapatkan layanan yang paling diminati
     * Ranking layanan berdasarkan jumlah permohonan
     *
     * @return array Data layanan populer
     */
    private function getLayananPopuler()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("
                SELECT jl.nama_pelayanan, COUNT(p.id_permohonan) as jumlah
                FROM jenis_pelayanan jl
                LEFT JOIN permohonan p ON jl.id_jenis = p.jenis_id
                GROUP BY jl.id_jenis, jl.nama_pelayanan
                ORDER BY jumlah DESC
                LIMIT 10
            ");

            return $query->getResultArray();
        } catch (\Exception $e) {
            // Return empty array if query fails
            log_message('error', 'Error in getLayananPopuler: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan statistik waktu proses permohonan
     * Analisis efisiensi penanganan permohonan
     *
     * @return array Statistik waktu proses
     */
    private function getWaktuProsesStats()
    {
        $permohonan_selesai = $this->permohonanModel
            ->where('status', 'selesai')
            ->where('tanggal_selesai IS NOT NULL')
            ->findAll();

        $total_waktu = 0;
        $count = 0;

        foreach ($permohonan_selesai as $p) {
            $waktu_pengajuan = strtotime($p['tanggal_pengajuan']);
            $waktu_selesai = strtotime($p['tanggal_selesai']);

            if ($waktu_selesai > $waktu_pengajuan) {
                $total_waktu += ($waktu_selesai - $waktu_pengajuan) / (60 * 60 * 24); // dalam hari
                $count++;
            }
        }

        return [
            'rata_rata_hari' => $count > 0 ? round($total_waktu / $count, 1) : 0,
            'total_selesai' => count($permohonan_selesai),
            'distribusi' => $this->getDistribusiWaktuProses(),
        ];
    }

    /**
     * Mendapatkan statistik pengguna
     * Analisis demografi dan aktivitas pengguna
     *
     * @return array Statistik pengguna
     */
    private function getUserStats()
    {
        return [
            'total_warga' => $this->wargaModel->countAll(),
            'total_petugas' => $this->userModel->where('role', 'petugas')->countAllResults(),
            'total_admin' => $this->userModel->where('role', 'admin')->countAllResults(),
            'warga_aktif' => $this->wargaModel->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults(),
            'petugas_aktif' => $this->userModel->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults(),
        ];
    }

    /**
     * Mendapatkan statistik aktivitas sistem
     * Monitoring penggunaan sistem
     *
     * @return array Statistik aktivitas
     */
    private function getAktivitasStats()
    {
        $bulan_ini = date('Y-m');

        return [
            'pengaduan_bulan_ini' => $this->pengaduanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $bulan_ini)->countAllResults(),
            'permohonan_bulan_ini' => $this->permohonanModel->where('DATE_FORMAT(created_at, "%Y-%m")', $bulan_ini)->countAllResults(),
            'notifikasi_dikirim' => $this->notifikasiModel->where('DATE_FORMAT(created_at, "%Y-%m")', $bulan_ini)->countAllResults(),
            'login_terakhir' => $this->getLastLoginStats(),
        ];
    }

    /**
     * Mendapatkan demografi warga
     * Analisis distribusi warga berdasarkan berbagai kriteria
     *
     * @return array Data demografi
     */
    private function getDemografiWarga()
    {
        try {
            $db = \Config\Database::connect();

            return [
                'jenis_kelamin' => $db->query("SELECT jenis_kelamin, COUNT(*) as jumlah FROM warga GROUP BY jenis_kelamin")->getResultArray(),
                'kecamatan' => $db->query("SELECT kecamatan, COUNT(*) as jumlah FROM warga GROUP BY kecamatan ORDER BY jumlah DESC LIMIT 10")->getResultArray(),
                'kelompok_umur' => $this->getKelompokUmur(),
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error in getDemografiWarga: ' . $e->getMessage());
            return [
                'jenis_kelamin' => [],
                'kecamatan' => [],
                'kelompok_umur' => [],
            ];
        }
    }

    /**
     * Mengelompokkan warga berdasarkan kelompok umur
     * Analisis demografi berdasarkan usia
     *
     * @return array Distribusi kelompok umur
     */
    private function getKelompokUmur()
    {
        $warga = $this->wargaModel->findAll();
        $kelompok = [
            '0-17' => 0,
            '18-30' => 0,
            '31-45' => 0,
            '46-60' => 0,
            '61+' => 0,
        ];

        foreach ($warga as $w) {
            if ($w['tanggal_lahir']) {
                $umur = date_diff(date_create($w['tanggal_lahir']), date_create('now'))->y;

                if ($umur <= 17) $kelompok['0-17']++;
                elseif ($umur <= 30) $kelompok['18-30']++;
                elseif ($umur <= 45) $kelompok['31-45']++;
                elseif ($umur <= 60) $kelompok['46-60']++;
                else $kelompok['61+']++;
            }
        }

        return $kelompok;
    }

    /**
     * Menghitung rata-rata waktu proses
     * Menghitung efisiensi penanganan
     *
     * @param string $tipe Tipe ('pengaduan' atau 'permohonan')
     * @return float Rata-rata waktu dalam hari
     */
    private function hitungRataWaktuProses($tipe)
    {
        if ($tipe === 'pengaduan') {
            $items = $this->pengaduanModel->where('status', 'selesai')->findAll();
        } else {
            $items = $this->permohonanModel->where('status', 'selesai')->where('tanggal_selesai IS NOT NULL')->findAll();
        }

        $total_waktu = 0;
        $count = 0;

        foreach ($items as $item) {
            $waktu_mulai = strtotime($item['created_at']);
            $waktu_selesai = $tipe === 'pengaduan' ?
                strtotime($item['updated_at']) :
                strtotime($item['tanggal_selesai']);

            if ($waktu_selesai > $waktu_mulai) {
                $total_waktu += ($waktu_selesai - $waktu_mulai) / (60 * 60 * 24);
                $count++;
            }
        }

        return $count > 0 ? round($total_waktu / $count, 1) : 0;
    }

    /**
     * Menghitung rata-rata waktu respons
     * Mengukur kecepatan respons petugas
     *
     * @param string $tipe Tipe ('pengaduan' atau 'permohonan')
     * @return float Rata-rata waktu respons dalam jam
     */
    private function hitungRataWaktuRespons($tipe)
    {
        if ($tipe === 'pengaduan') {
            $items = $this->pengaduanModel->where('petugas_id IS NOT NULL')->findAll();
        } else {
            $items = $this->permohonanModel->where('petugas_id IS NOT NULL')->findAll();
        }

        $total_waktu = 0;
        $count = 0;

        foreach ($items as $item) {
            $waktu_dibuat = strtotime($item['created_at']);
            $waktu_ditugaskan = strtotime($item['updated_at']);

            if ($waktu_ditugaskan > $waktu_dibuat) {
                $total_waktu += ($waktu_ditugaskan - $waktu_dibuat) / (60 * 60); // dalam jam
                $count++;
            }
        }

        return $count > 0 ? round($total_waktu / $count, 1) : 0;
    }

    /**
     * Menghitung tingkat kepuasan pengguna
     * Berdasarkan rasio pengaduan yang diselesaikan
     *
     * @return float Persentase kepuasan
     */
    private function hitungTingkatKepuasan()
    {
        $total_pengaduan = $this->pengaduanModel->countAll();
        $pengaduan_selesai = $this->pengaduanModel->where('status', 'selesai')->countAllResults();

        return $total_pengaduan > 0 ? round(($pengaduan_selesai / $total_pengaduan) * 100, 1) : 0;
    }

    /**
     * Menghitung tingkat kelulusan permohonan
     * Rasio permohonan yang disetujui
     *
     * @return float Persentase kelulusan
     */
    private function hitungTingkatKelulusan()
    {
        $total_permohonan = $this->permohonanModel->countAll();
        $permohonan_disetujui = $this->permohonanModel->where('status', 'selesai')->countAllResults();

        return $total_permohonan > 0 ? round(($permohonan_disetujui / $total_permohonan) * 100, 1) : 0;
    }

    /**
     * Mendapatkan distribusi waktu proses
     * Mengelompokkan berdasarkan rentang waktu
     *
     * @return array Distribusi waktu proses
     */
    private function getDistribusiWaktuProses()
    {
        $permohonan = $this->permohonanModel
            ->where('status', 'selesai')
            ->where('tanggal_selesai IS NOT NULL')
            ->findAll();

        $distribusi = [
            '1-3 hari' => 0,
            '4-7 hari' => 0,
            '8-14 hari' => 0,
            '15-30 hari' => 0,
            '30+ hari' => 0,
        ];

        foreach ($permohonan as $p) {
            $waktu = (strtotime($p['tanggal_selesai']) - strtotime($p['tanggal_pengajuan'])) / (60 * 60 * 24);

            if ($waktu <= 3) $distribusi['1-3 hari']++;
            elseif ($waktu <= 7) $distribusi['4-7 hari']++;
            elseif ($waktu <= 14) $distribusi['8-14 hari']++;
            elseif ($waktu <= 30) $distribusi['15-30 hari']++;
            else $distribusi['30+ hari']++;
        }

        return $distribusi;
    }

    /**
     * Mendapatkan statistik login terakhir
     * Monitoring aktivitas pengguna
     *
     * @return array Statistik login
     */
    private function getLastLoginStats()
    {
        $seminggu_terakhir = $this->userModel->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))->countAllResults();
        $sebulan_terakhir = $this->userModel->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();

        return [
            'seminggu_terakhir' => $seminggu_terakhir,
            'sebulan_terakhir' => $sebulan_terakhir,
            'total_user' => $this->userModel->countAll(),
        ];
    }

    /**
     * Export laporan pengaduan ke PDF
     * Menghasilkan file PDF untuk dokumentasi
     *
     * @param string $period Periode laporan
     */
    private function exportPengaduanReport($period)
    {
        // Implementasi export PDF
        // Menggunakan library seperti TCPDF atau DomPDF

        $data = [
            'stats' => $this->getPengaduanStats(),
            'trend' => $this->getPengaduanTrend(),
            'kategori' => $this->getKategoriPengaduan(),
            'period' => $period,
        ];

        // Generate PDF
        $filename = 'laporan_pengaduan_' . date('Y-m-d') . '.pdf';

        // Return file download
        return $this->response->download($filename, 'PDF content here');
    }

    /**
     * Export laporan permohonan ke Excel
     * Menghasilkan file Excel untuk analisis lanjutan
     *
     * @param string $period Periode laporan
     */
    private function exportPermohonanReport($period)
    {
        // Implementasi export Excel
        // Menggunakan library seperti PhpSpreadsheet

        $data = [
            'stats' => $this->getPermohonanStats(),
            'layanan' => $this->getLayananPopuler(),
            'waktu' => $this->getWaktuProsesStats(),
            'period' => $period,
        ];

        $filename = 'laporan_permohonan_' . date('Y-m-d') . '.xlsx';

        return $this->response->download($filename, 'Excel content here');
    }

    /**
     * Export laporan pengguna ke CSV
     * Menghasilkan file CSV untuk database eksternal
     *
     * @param string $period Periode laporan
     */
    private function exportUserReport($period)
    {
        // Implementasi export CSV
        $data = [
            'stats' => $this->getUserStats(),
            'aktivitas' => $this->getAktivitasStats(),
            'demografi' => $this->getDemografiWarga(),
            'period' => $period,
        ];

        $filename = 'laporan_pengguna_' . date('Y-m-d') . '.csv';

        return $this->response->download($filename, 'CSV content here');
    }
}
