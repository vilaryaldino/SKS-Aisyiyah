<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        // 1. Create Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('admins');

        // 2. Migrate existing Admin from data_siswa to admins
        $db = \Config\Database::connect();
        $builder = $db->table('data_siswa');
        $existingAdmin = $builder->where('role', 'admin')->get()->getRowArray();

        if ($existingAdmin) {
            $db->table('admins')->insert([
                'username' => $existingAdmin['username'],
                'password' => $existingAdmin['password'],
                'nama'     => $existingAdmin['nama'],
            ]);
            
            // Optional: Delete from data_siswa? 
            // Better to keep safe for now, or delete if strictly requested "don't mix".
            // User said "don't be in one database (table)". So I should delete.
            $builder->where('role', 'admin')->delete();
        }
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
