<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasToDataSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'nik' // Place it after NIK or wherever appropriate
            ],
        ];
        $this->forge->addColumn('data_siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('data_siswa', 'kelas');
    }
}
