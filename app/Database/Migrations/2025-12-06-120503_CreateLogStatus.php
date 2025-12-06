<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => ['type'=>'INT','auto_increment'=>true],
            'permohonan_id' => ['type'=>'INT'],
            'status_lama' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'status_baru' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'catatan' => ['type'=>'TEXT','null'=>true],
            'petugas_id' => ['type'=>'INT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('permohonan_id','permohonan','id_permohonan','CASCADE','CASCADE');
        $this->forge->addForeignKey('petugas_id','users','id_user','SET NULL','CASCADE');
        $this->forge->createTable('log_status');
    }

    public function down()
    {
        $this->forge->dropTable('log_status', true);
    }
}
