<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WargaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik' => '1234567890123456',
                'nama_lengkap' => 'Ahmad Surya',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'alamat' => 'Jl. Sudirman No. 123',
                'rt_rw' => '01/02',
                'kecamatan' => 'Menteng',
                'kab_kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'no_hp' => '081234567892',
                'email' => 'ahmad@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '1234567890123457',
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-08-20',
                'alamat' => 'Jl. Asia Afrika No. 45',
                'rt_rw' => '03/04',
                'kecamatan' => 'Coblong',
                'kab_kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'no_hp' => '081234567893',
                'email' => 'siti@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('warga')->insertBatch($data);
    }
}
