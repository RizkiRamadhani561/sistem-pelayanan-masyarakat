<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerkasPersyaratan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas' => ['type'=>'BIGINT','auto_increment'=>true],
            'permohonan_id' => ['type'=>'INT'],
            'nama_berkas' => ['type'=>'VARCHAR','constraint'=>150],
            'file_path' => ['type'=>'VARCHAR','constraint'=>500],
            'file_type' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'file_size' => ['type'=>'BIGINT','null'=>true],
            'uploaded_by' => ['type'=>'INT','null'=>true],
            'uploaded_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_berkas', true);
        $this->forge->addForeignKey('permohonan_id','permohonan','id_permohonan','CASCADE','CASCADE');
        $this->forge->addForeignKey('uploaded_by','users','id_user','SET NULL','CASCADE');
        $this->forge->createTable('berkas_persyaratan');
    }

    public function down()
    {
        $this->forge->dropTable('berkas_persyaratan', true);
    }
}
