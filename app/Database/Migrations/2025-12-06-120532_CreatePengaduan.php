<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengaduan' => ['type'=>'BIGINT','auto_increment'=>true],
            'warga_id' => ['type'=>'INT'],
            'judul' => ['type'=>'VARCHAR','constraint'=>200],
            'isi_pengaduan' => ['type'=>'TEXT'],
            'status' => ['type'=>'ENUM','constraint'=>['baru','diproses','selesai'],'default'=>'baru'],
            'petugas_id' => ['type'=>'INT','null'=>true],
            'lokasi' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_pengaduan', true);
        $this->forge->addForeignKey('warga_id','warga','id_warga','RESTRICT','CASCADE');
        $this->forge->addForeignKey('petugas_id','users','id_user','SET NULL','CASCADE');
        $this->forge->createTable('pengaduan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaduan', true);
    }
}
