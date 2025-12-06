<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Pemerintah Kembangan Raya Luncurkan Program Vaksinasi Massal',
                'slug' => 'pemerintah-kembangan-raya-luncurkan-program-vaksinasi-massal',
                'isi' => 'Pemerintah Kembangan Raya meluncurkan program vaksinasi massal untuk seluruh warga. Program ini bertujuan untuk meningkatkan imunitas masyarakat terhadap berbagai penyakit menular. Vaksinasi akan dilakukan di puskesmas-puskesmas yang tersebar di seluruh wilayah Kembangan Raya.',
                'excerpt' => 'Program vaksinasi massal diluncurkan untuk meningkatkan imunitas masyarakat Kembangan Raya.',
                'gambar' => '/images/berita/vaksinasi.jpg',
                'status' => 'published',
                'penulis_id' => 2,
                'views' => 1250,
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Perbaikan Jalan Rusak di Kawasan Industri Prioritas Utama',
                'slug' => 'perbaikan-jalan-rusak-di-kawasan-industri-prioritas-utama',
                'isi' => 'Dinas Pekerjaan Umum Kembangan Raya memprioritaskan perbaikan jalan-jalan rusak di kawasan industri. Perbaikan ini melibatkan pengaspalan ulang dan peningkatan drainase untuk mengatasi masalah banjir yang sering terjadi.',
                'excerpt' => 'Perbaikan infrastruktur jalan di kawasan industri menjadi prioritas pembangunan.',
                'gambar' => '/images/berita/jalan.jpg',
                'status' => 'published',
                'penulis_id' => 2,
                'views' => 890,
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'judul' => 'Sosialisasi Program Pengaduan Online Kepada Masyarakat',
                'slug' => 'sosialisasi-program-pengaduan-online-kepada-masyarakat',
                'isi' => 'Pemerintah Kembangan Raya mengadakan sosialisasi program pengaduan online untuk memudahkan masyarakat menyampaikan aspirasi dan keluhan. Sistem ini terintegrasi dengan aplikasi mobile dan website resmi.',
                'excerpt' => 'Program pengaduan online disosialisasikan untuk memudahkan komunikasi masyarakat.',
                'gambar' => '/images/berita/pengaduan.jpg',
                'status' => 'published',
                'penulis_id' => 2,
                'views' => 756,
                'published_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
        ];

        $this->db->table('berita')->insertBatch($data);
    }
}
