<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => ['type'=>'INT','auto_increment'=>true],
            'nama' => ['type'=>'VARCHAR','constraint'=>100],
            'email' => ['type'=>'VARCHAR','constraint'=>150,'unique'=>true],
            'password' => ['type'=>'VARCHAR','constraint'=>255],
            'role' => ['type'=>'ENUM','constraint'=>['admin','petugas'],'default'=>'petugas'],
            'phone' => ['type'=>'VARCHAR','constraint'=>30,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
