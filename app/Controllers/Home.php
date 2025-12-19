<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\PengaduanModel;
use App\Models\PermohonanModel;

/**
 * Controller untuk halaman utama/beranda sistem
 *
 * Menangani tampilan halaman depan dengan informasi dasar
 * seperti berita terbaru, statistik pengaduan, dan data permohonan.
 *
 * @author Developer Sistem Pelayanan Masyarakat
 * @version 1.0
 */
class Home extends BaseController
{
    /**
     * Menampilkan halaman beranda dengan data statistik dan berita
     *
     * Mengambil data berita terbaru, berita populer, dan statistik
     * pengaduan serta permohonan untuk ditampilkan di dashboard utama.
     *
     * @return string View halaman home
     */
    public function index(): string
    {
        // Inisialisasi model yang diperlukan
        $beritaModel = new BeritaModel();
        $pengaduanModel = new PengaduanModel();
        $permohonanModel = new PermohonanModel();

        // Mengumpulkan data untuk ditampilkan
        $data = [
            'title' => 'Beranda - Sistem Pelayanan Masyarakat Kembangan Raya',
            // Berita terbaru yang sudah dipublikasikan
            'berita_terbaru' => $beritaModel->where('status', 'published')
                                           ->orderBy('published_at', 'DESC')
                                           ->limit(6)
                                           ->find(),
            // Berita paling banyak dilihat
            'berita_populer' => $beritaModel->where('status', 'published')
                                           ->orderBy('views', 'DESC')
                                           ->limit(3)
                                           ->find(),
            // Statistik total pengaduan
            'total_pengaduan' => $pengaduanModel->countAll(),
            // Jumlah pengaduan dengan status baru
            'pengaduan_baru' => $pengaduanModel->where('status', 'baru')->countAllResults(),
            // Statistik total permohonan
            'total_permohonan' => $permohonanModel->countAll(),
            // Jumlah permohonan yang sedang diajukan
            'permohonan_baru' => $permohonanModel->where('status', 'diajukan')->countAllResults(),
        ];

        return view('home/index', $data);
    }
}
