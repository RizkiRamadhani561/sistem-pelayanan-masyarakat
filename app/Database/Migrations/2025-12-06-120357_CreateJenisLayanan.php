<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisLayanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenis' => ['type'=>'INT','auto_increment'=>true],
            'nama_pelayanan' => ['type'=>'VARCHAR','constraint'=>150,'unique'=>true],
            'kode' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'deskripsi' => ['type'=>'TEXT','null'=>true],
            'syarat' => ['type'=>'TEXT','null'=>true],
            'estimasi_hari' => ['type'=>'INT','default'=>0],
            'aktif' => ['type'=>'TINYINT','default'=>1],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_jenis', true);
        $this->forge->createTable('jenis_pelayanan');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_pelayanan', true);
    }
}
