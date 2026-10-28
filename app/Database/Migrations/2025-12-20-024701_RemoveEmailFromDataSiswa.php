<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveEmailFromDataSiswa extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('email', 'data_siswa')) {
            $this->forge->dropColumn('data_siswa', 'email');
        }
    }

    public function down()
    {
        $this->forge->addColumn('data_siswa', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'username'
            ],
        ]);
    }
}
