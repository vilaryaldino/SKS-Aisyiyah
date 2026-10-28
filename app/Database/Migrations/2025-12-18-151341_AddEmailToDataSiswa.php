<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToDataSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('data_siswa', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true, // Or false default value depending on need. Making nullable for safety with existing data.
                'after' => 'username'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('data_siswa', 'email');
    }
}
