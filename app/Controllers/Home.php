<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\PengaduanModel;
use App\Models\PermohonanModel;

class Home extends BaseController
{
    public function index(): string
    {
        $beritaModel = new BeritaModel();
        $pengaduanModel = new PengaduanModel();
        $permohonanModel = new PermohonanModel();

        $data = [
            'title' => 'Beranda - Sistem Pelayanan Masyarakat Kembangan Raya',
            'berita_terbaru' => $beritaModel->where('status', 'published')
                                           ->orderBy('published_at', 'DESC')
                                           ->limit(6)
                                           ->find(),
            'berita_populer' => $beritaModel->where('status', 'published')
                                           ->orderBy('views', 'DESC')
                                           ->limit(3)
                                           ->find(),
            'total_pengaduan' => $pengaduanModel->countAll(),
            'pengaduan_baru' => $pengaduanModel->where('status', 'baru')->countAllResults(),
            'total_permohonan' => $permohonanModel->countAll(),
            'permohonan_baru' => $permohonanModel->where('status', 'diajukan')->countAllResults(),
        ];

        return view('home/index', $data);
    }
}
