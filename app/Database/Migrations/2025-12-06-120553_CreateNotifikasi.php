<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notif' => ['type'=>'BIGINT','auto_increment'=>true],
            'warga_id' => ['type'=>'INT','null'=>true],
            'user_id' => ['type'=>'INT','null'=>true],
            'pesan' => ['type'=>'VARCHAR','constraint'=>500],
            'link' => ['type'=>'VARCHAR','constraint'=>500,'null'=>true],
            'is_read' => ['type'=>'TINYINT','default'=>0],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_notif', true);
        $this->forge->addForeignKey('warga_id','warga','id_warga','CASCADE','CASCADE');
        $this->forge->addForeignKey('user_id','users','id_user','CASCADE','CASCADE');
        $this->forge->createTable('notifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi', true);
    }
}
