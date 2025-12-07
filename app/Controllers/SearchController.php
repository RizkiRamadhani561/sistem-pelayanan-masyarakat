<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\JenisLayananModel;
use App\Models\WargaModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk menangani fungsi pencarian di seluruh sistem
 *
 * Fitur ini menyediakan kemampuan pencarian global untuk:
 * - Pengaduan masyarakat
 * - Jenis layanan
 * - Informasi warga (untuk admin)
 * - Konten sistem lainnya
 */
class SearchController extends BaseController
{
    protected $pengaduanModel;
    protected $jenisLayananModel;
    protected $wargaModel;

    /**
     * Konstruktor untuk inisialisasi model
     * Mengatur dependency injection untuk model yang diperlukan
     */
    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->jenisLayananModel = new JenisLayananModel();
        $this->wargaModel = new WargaModel();
    }

    /**
     * Halaman utama pencarian
     * Menampilkan form pencarian dan hasil jika ada
     *
     * Method: GET
     * Route: /search
     * Akses: Semua pengguna
     */
    public function index()
    {
        $query = $this->request->getGet('q');
        $results = [];

        if ($query && strlen($query) >= 2) {
            $results = $this->performSearch($query);
        }

        $data = [
            'title' => 'Pencarian - Sistem Pelayanan Masyarakat',
            'query' => $query,
            'results' => $results,
            'total_results' => $this->countTotalResults($results)
        ];

        return view('search/index', $data);
    }

    /**
     * API endpoint untuk pencarian real-time (autocomplete)
     * Mengembalikan hasil pencarian dalam format JSON
     *
     * Method: GET
     * Route: /api/search
     * Akses: Semua pengguna
     */
    public function apiSearch()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Request tidak valid']);
        }

        $query = $this->request->getGet('q');
        $limit = $this->request->getGet('limit') ?? 10;

        if (!$query || strlen($query) < 2) {
            return $this->response->setJSON(['results' => []]);
        }

        $results = $this->performSearch($query, $limit);

        // Format results for autocomplete
        $formattedResults = $this->formatAutocompleteResults($results);

        return $this->response->setJSON([
            'query' => $query,
            'results' => $formattedResults,
            'total' => count($formattedResults)
        ]);
    }

    /**
     * Melakukan pencarian di seluruh sistem
     * Menggabungkan hasil dari berbagai model
     *
     * @param string $query Kata kunci pencarian
     * @param int $limit Batas jumlah hasil
     * @return array Hasil pencarian terstruktur
     */
    private function performSearch($query, $limit = null)
    {
        $results = [
            'pengaduan' => [],
            'layanan' => [],
            'warga' => []
        ];

        // Pencarian pengaduan (untuk semua pengguna)
        $pengaduanQuery = $this->pengaduanModel
            ->like('judul', $query)
            ->orLike('deskripsi', $query)
            ->orLike('lokasi', $query);

        // Jika user adalah warga, hanya tampilkan pengaduan mereka sendiri
        if (session()->has('warga')) {
            $pengaduanQuery->where('warga_id', session('warga')['id_warga']);
        }
        // Jika user adalah admin/petugas, tampilkan semua pengaduan

        if ($limit) {
            $results['pengaduan'] = $pengaduanQuery->limit($limit)->findAll();
        } else {
            $results['pengaduan'] = $pengaduanQuery->findAll();
        }

        // Pencarian jenis layanan (untuk semua pengguna)
        $layananQuery = $this->jenisLayananModel
            ->like('nama_pelayanan', $query)
            ->orLike('deskripsi', $query)
            ->orLike('syarat', $query);

        if ($limit) {
            $results['layanan'] = $layananQuery->limit($limit)->findAll();
        } else {
            $results['layanan'] = $layananQuery->findAll();
        }

        // Pencarian warga (hanya untuk admin/petugas)
        if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])) {
            $wargaQuery = $this->wargaModel
                ->like('nama_lengkap', $query)
                ->orLike('nik', $query)
                ->orLike('email', $query)
                ->orLike('alamat', $query);

            if ($limit) {
                $results['warga'] = $wargaQuery->limit($limit)->findAll();
            } else {
                $results['warga'] = $wargaQuery->findAll();
            }
        }

        return $results;
    }

    /**
     * Menghitung total hasil pencarian
     *
     * @param array $results Hasil pencarian
     * @return int Total hasil
     */
    private function countTotalResults($results)
    {
        $total = 0;
        foreach ($results as $category) {
            $total += count($category);
        }
        return $total;
    }

    /**
     * Memformat hasil pencarian untuk autocomplete
     *
     * @param array $results Hasil pencarian mentah
     * @return array Hasil yang diformat untuk autocomplete
     */
    private function formatAutocompleteResults($results)
    {
        $formatted = [];

        // Format pengaduan
        foreach ($results['pengaduan'] as $item) {
            $formatted[] = [
                'id' => $item['id_pengaduan'],
                'type' => 'pengaduan',
                'title' => $item['judul'],
                'description' => substr($item['deskripsi'], 0, 100) . '...',
                'url' => '/pengaduan/' . $item['id_pengaduan'],
                'icon' => 'bi-exclamation-triangle',
                'category' => 'Pengaduan'
            ];
        }

        // Format layanan
        foreach ($results['layanan'] as $item) {
            $formatted[] = [
                'id' => $item['id_jenis'],
                'type' => 'layanan',
                'title' => $item['nama_pelayanan'],
                'description' => substr($item['deskripsi'], 0, 100) . '...',
                'url' => '/layanan/' . $item['id_jenis'],
                'icon' => 'bi-file-earmark-text',
                'category' => 'Layanan'
            ];
        }

        // Format warga (hanya untuk admin)
        foreach ($results['warga'] as $item) {
            $formatted[] = [
                'id' => $item['id_warga'],
                'type' => 'warga',
                'title' => $item['nama_lengkap'],
                'description' => 'NIK: ' . substr($item['nik'], 0, 8) . '**** | ' . $item['alamat'],
                'url' => '/admin/warga/' . $item['id_warga'],
                'icon' => 'bi-person',
                'category' => 'Warga'
            ];
        }

        return array_slice($formatted, 0, 10); // Batasi 10 hasil untuk autocomplete
    }

    /**
     * Pencarian lanjutan dengan filter
     * Menyediakan pencarian dengan kategori tertentu
     *
     * Method: GET
     * Route: /search/advanced
     * Akses: Semua pengguna
     */
    public function advanced()
    {
        $query = $this->request->getGet('q');
        $category = $this->request->getGet('category');
        $results = [];

        if ($query && strlen($query) >= 2) {
            if ($category && $category !== 'all') {
                $results = $this->searchByCategory($query, $category);
            } else {
                $results = $this->performSearch($query);
            }
        }

        $data = [
            'title' => 'Pencarian Lanjutan - Sistem Pelayanan Masyarakat',
            'query' => $query,
            'category' => $category,
            'results' => $results,
            'total_results' => $this->countTotalResults($results)
        ];

        return view('search/advanced', $data);
    }

    /**
     * Pencarian berdasarkan kategori tertentu
     *
     * @param string $query Kata kunci
     * @param string $category Kategori pencarian
     * @return array Hasil pencarian
     */
    private function searchByCategory($query, $category)
    {
        $results = [
            'pengaduan' => [],
            'layanan' => [],
            'warga' => []
        ];

        switch ($category) {
            case 'pengaduan':
                $queryBuilder = $this->pengaduanModel
                    ->like('judul', $query)
                    ->orLike('deskripsi', $query)
                    ->orLike('lokasi', $query);

                if (session()->has('warga')) {
                    $queryBuilder->where('warga_id', session('warga')['id_warga']);
                }

                $results['pengaduan'] = $queryBuilder->findAll();
                break;

            case 'layanan':
                $results['layanan'] = $this->jenisLayananModel
                    ->like('nama_pelayanan', $query)
                    ->orLike('deskripsi', $query)
                    ->orLike('syarat', $query)
                    ->findAll();
                break;

            case 'warga':
                if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])) {
                    $results['warga'] = $this->wargaModel
                        ->like('nama_lengkap', $query)
                        ->orLike('nik', $query)
                        ->orLike('email', $query)
                        ->orLike('alamat', $query)
                        ->findAll();
                }
                break;
        }

        return $results;
    }
}
