<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWarga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_warga' => ['type'=>'INT','auto_increment'=>true],
            'nik' => ['type'=>'CHAR','constraint'=>16,'unique'=>true],
            'nama_lengkap' => ['type'=>'VARCHAR','constraint'=>150],
            'jenis_kelamin' => ['type'=>'ENUM','constraint'=>['L','P']],
            'tempat_lahir' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'tanggal_lahir' => ['type'=>'DATE','null'=>true],
            'alamat' => ['type'=>'TEXT','null'=>true],
            'rt_rw' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'kecamatan' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'kab_kota' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'provinsi' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'no_hp' => ['type'=>'VARCHAR','constraint'=>30,'null'=>true],
            'email' => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_warga', true);
        $this->forge->createTable('warga');
    }

    public function down()
    {
        $this->forge->dropTable('warga', true);
    }
}
