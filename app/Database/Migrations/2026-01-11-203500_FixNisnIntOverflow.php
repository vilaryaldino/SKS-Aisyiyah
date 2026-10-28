<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixNisnIntOverflow extends Migration
{
    public function up()
    {
        // 1. Drop Foreign Key Constraint on notifications table
        // We catch exception in case it doesn't exist or name is slightly different, though checking generic names is hard.
        // We know the name 'notifications_nis_foreign' from the error log.
        try {
            $this->forge->dropForeignKey('notifications', 'notifications_nis_foreign');
        } catch (\Throwable $e) {
            // Ignore if fk not found
        }

        // 2. Modify 'nisn' in 'data_siswa' to VARCHAR(25)
        $fieldsSiswa = [
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => false,
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsSiswa);

        // 3. Modify 'nis' in 'notifications' to VARCHAR(25) to match
        // Note: notifications table uses 'nis' based on creation migration.
        $fieldsNotif = [
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => false, 
            ],
        ];
        $this->forge->modifyColumn('notifications', $fieldsNotif);

        // 4. Restore Foreign Key
        // column 'nis' in 'notifications' -> 'nisn' in 'data_siswa'
        $this->forge->addForeignKey('nis', 'data_siswa', 'nisn', 'CASCADE', 'CASCADE', 'notifications_nis_foreign');
        $this->forge->processIndexes('notifications'); // Required for addForeignKey in some CI versions/drivers if not auto-triggered
    }

    public function down()
    {
        // Revert NOT recommended but required structure.
        // We'll revert to previous known state (INT?) or just VARCHAR(50) if that was the intent.
        // Actually, reverting to INT will likely fail due to data having 'text'.
        // We keep it as is or do nothing safe. 
        // But for completeness:
        
        try {
            $this->forge->dropForeignKey('notifications', 'notifications_nis_foreign');
        } catch (\Throwable $e) {}

        $fieldsSiswa = [
            'nisn' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ];
        $this->forge->modifyColumn('data_siswa', $fieldsSiswa);
        
        $fieldsNotif = [
            'nis' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ];
        $this->forge->modifyColumn('notifications', $fieldsNotif);

         $this->forge->addForeignKey('nis', 'data_siswa', 'nisn', 'CASCADE', 'CASCADE', 'notifications_nis_foreign');
    }
}
