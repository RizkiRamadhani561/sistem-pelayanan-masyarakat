<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisLayananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pelayanan' => 'Surat Keterangan Domisili',
                'kode' => 'SKD',
                'deskripsi' => 'Pembuatan surat keterangan domisili untuk keperluan administrasi',
                'syarat' => 'KTP, KK, Surat Pengantar RT/RW',
                'estimasi_hari' => 3,
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_pelayanan' => 'Surat Keterangan Tidak Mampu',
                'kode' => 'SKTM',
                'deskripsi' => 'Pembuatan surat keterangan tidak mampu untuk keperluan sosial',
                'syarat' => 'KTP, KK, Surat Pengantar RT/RW',
                'estimasi_hari' => 2,
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_pelayanan' => 'Surat Keterangan Usaha',
                'kode' => 'SKU',
                'deskripsi' => 'Pembuatan surat keterangan usaha untuk perijinan',
                'syarat' => 'KTP, NPWP, Surat Pengantar RT/RW',
                'estimasi_hari' => 5,
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('jenis_pelayanan')->insertBatch($data);
    }
}
