<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorJkEnum extends Migration
{
    public function up()
    {
        // 1. Change to VARCHAR temporarily to allow loose data modification
        $fieldsVa = [
            'jk' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsVa);

        // 2. Update Data: 'Laki-laki' -> 'L', 'Perempuan' -> 'P'
        // Using direct SQL execution
        $this->db->query("UPDATE data_siswa SET jk = 'L' WHERE jk = 'Laki-laki' OR jk = 'L'");
        $this->db->query("UPDATE data_siswa SET jk = 'P' WHERE jk = 'Perempuan' OR jk = 'P'");
        
        // 3. Change to ENUM('L', 'P')
        $fieldsEnum = [
            'jk' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'default' => 'L',
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsEnum);
    }

    public function down()
    {
        // Revert Process
        
        // 1. Change to VARCHAR
        $fieldsVa = [
            'jk' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsVa);

        // 2. Update Data Back: 'L' -> 'Laki-laki', 'P' -> 'Perempuan'
        $this->db->query("UPDATE data_siswa SET jk = 'Laki-laki' WHERE jk = 'L'");
        $this->db->query("UPDATE data_siswa SET jk = 'Perempuan' WHERE jk = 'P'");

        // 3. Change back to original ENUM (assuming it was this)
        // Note: Previous state was ENUM('Laki-laki', 'Perempuan') based on inspection
        // But inspection said: jk (enum('Laki-laki','Perempuan'))
        $fieldsEnum = [
            'jk' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'default' => 'Laki-laki',
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsEnum);
    }
}
