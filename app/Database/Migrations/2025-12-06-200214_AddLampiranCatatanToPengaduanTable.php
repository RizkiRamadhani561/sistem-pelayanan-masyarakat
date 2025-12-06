<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLampiranCatatanToPengaduanTable extends Migration
{
    public function up()
    {
        // Add lampiran column for file attachments
        $this->forge->addColumn('pengaduan', [
            'lampiran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'lokasi'
            ]
        ]);

        // Add catatan column for petugas notes
        $this->forge->addColumn('pengaduan', [
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'petugas_id'
            ]
        ]);
    }

    public function down()
    {
        // Remove the columns if rolling back
        $this->forge->dropColumn('pengaduan', 'lampiran');
        $this->forge->dropColumn('pengaduan', 'catatan');
    }
}
