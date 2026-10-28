<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanTables extends Migration
{
    public function up()
    {
        $tables = [
            'laporan_pendaftaran',
            'laporan_uis_uim',
            'laporan_peralatan',
            'laporan_lks',
            'laporan_seragam_tas',
            'laporan_kegiatan',
            'laporan_spp',
            'laporan_dpp'
        ];

        foreach ($tables as $table) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'tanggal' => [
                    'type' => 'DATE',
                ],
                'keterangan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'debit' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '15,2',
                    'default'    => 0.00,
                ],
                'kredit' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '15,2',
                    'default'    => 0.00,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable($table);
        }
    }

    public function down()
    {
        $tables = [
            'laporan_pendaftaran',
            'laporan_uis_uim',
            'laporan_peralatan',
            'laporan_lks',
            'laporan_seragam_tas',
            'laporan_kegiatan',
            'laporan_spp',
            'laporan_dpp'
        ];

        foreach ($tables as $table) {
            $this->forge->dropTable($table);
        }
    }
}
