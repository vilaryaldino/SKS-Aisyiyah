<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalLahirToDataSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('data_siswa', [
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'jenis_kelamin'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('data_siswa', 'tanggal_lahir');
    }
}
