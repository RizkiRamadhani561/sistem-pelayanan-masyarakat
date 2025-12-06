<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berita' => ['type'=>'BIGINT','auto_increment'=>true],
            'judul' => ['type'=>'VARCHAR','constraint'=>255],
            'slug' => ['type'=>'VARCHAR','constraint'=>255,'unique'=>true],
            'isi' => ['type'=>'TEXT'],
            'excerpt' => ['type'=>'VARCHAR','constraint'=>300,'null'=>true],
            'gambar' => ['type'=>'VARCHAR','constraint'=>500,'null'=>true],
            'status' => ['type'=>'ENUM','constraint'=>['draft','published'],'default'=>'draft'],
            'penulis_id' => ['type'=>'INT'],
            'views' => ['type'=>'INT','default'=>0],
            'published_at' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_berita', true);
        $this->forge->addForeignKey('penulis_id','users','id_user','CASCADE','CASCADE');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita', true);
    }
}
