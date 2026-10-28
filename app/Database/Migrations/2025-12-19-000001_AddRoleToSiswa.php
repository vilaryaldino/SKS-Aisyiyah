<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'siswa'],
                'default'    => 'siswa',
                'after'      => 'ortu', // Place it after the last known column
            ],
        ];

        $this->forge->addColumn('data_siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('data_siswa', 'role');
    }
}
