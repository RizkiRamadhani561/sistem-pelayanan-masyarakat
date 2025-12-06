<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermohonan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_permohonan' => ['type'=>'INT','auto_increment'=>true],
            'nomor_permohonan' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'warga_id' => ['type'=>'INT'],
            'jenis_id' => ['type'=>'INT'],
            'status' => ['type'=>'ENUM','constraint'=>['diajukan','diproses','ditolak','selesai'],'default'=>'diajukan'],
            'keterangan' => ['type'=>'TEXT','null'=>true],
            'petugas_id' => ['type'=>'INT','null'=>true],
            'tanggal_pengajuan' => ['type'=>'DATETIME','null'=>true],
            'tanggal_selesai' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id_permohonan', true);
        $this->forge->addForeignKey('warga_id','warga','id_warga','CASCADE','RESTRICT');
        $this->forge->addForeignKey('jenis_id','jenis_pelayanan','id_jenis','CASCADE','RESTRICT');
        $this->forge->addForeignKey('petugas_id','users','id_user','SET NULL','CASCADE');

        $this->forge->createTable('permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('permohonan', true);
    }
}
