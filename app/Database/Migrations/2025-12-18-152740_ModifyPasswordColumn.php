<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPasswordColumn extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('data_siswa', [
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('data_siswa', [
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
    }
}
