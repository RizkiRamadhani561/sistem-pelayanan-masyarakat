<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigApp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'config_key' => ['type'=>'VARCHAR','constraint'=>100,'primary'=>true],
            'config_value' => ['type'=>'TEXT','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->createTable('config_app');
    }

    public function down()
    {
        $this->forge->dropTable('config_app', true);
    }
}
