<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermohonanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'warga_id' => 1,
                'jenis_id' => 1,
                'status' => 'selesai',
                'keterangan' => 'Permohonan disetujui dan selesai diproses',
                'petugas_id' => 2,
                'tanggal_pengajuan' => '2025-12-01 10:00:00',
                'tanggal_selesai' => '2025-12-04 14:00:00',
                'created_at' => '2025-12-01 10:00:00',
                'updated_at' => '2025-12-04 14:00:00',
            ],
            [
                'warga_id' => 2,
                'jenis_id' => 2,
                'status' => 'diproses',
                'keterangan' => 'Sedang dalam proses verifikasi dokumen',
                'petugas_id' => 2,
                'tanggal_pengajuan' => '2025-12-05 09:30:00',
                'tanggal_selesai' => null,
                'created_at' => '2025-12-05 09:30:00',
                'updated_at' => '2025-12-05 09:30:00',
            ],
        ];

        $this->db->table('permohonan')->insertBatch($data);
    }
}
