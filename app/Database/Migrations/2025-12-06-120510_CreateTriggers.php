<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTriggers extends Migration
{
    public function up()
    {
        // Trigger auto-generate nomor_permohonan
        $this->db->query("
            CREATE TRIGGER trg_nomor_permohonan
            BEFORE INSERT ON permohonan
            FOR EACH ROW
            BEGIN
                DECLARE new_no VARCHAR(100);
                SET new_no = CONCAT('PLY-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD((SELECT IFNULL(MAX(id_permohonan),0)+1 FROM permohonan),5,'0'));
                SET NEW.nomor_permohonan = new_no;
            END;
        ");

        // Trigger log_status otomatis
        $this->db->query("
            CREATE TRIGGER trg_log_status
            AFTER UPDATE ON permohonan
            FOR EACH ROW
            BEGIN
                IF OLD.status <> NEW.status THEN
                    INSERT INTO log_status(permohonan_id, status_lama, status_baru, catatan, petugas_id, created_at)
                    VALUES (OLD.id_permohonan, OLD.status, NEW.status, NEW.keterangan, NEW.petugas_id, NOW());
                END IF;
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS trg_nomor_permohonan;");
        $this->db->query("DROP TRIGGER IF EXISTS trg_log_status;");
    }
}
