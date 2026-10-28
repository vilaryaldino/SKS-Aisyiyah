<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FixDb extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        try {
            echo "Attempting to fix NISN column...\n";
            // Check if column exists, we assume yes.
            // Direct Alter
            $db->query("ALTER TABLE data_siswa MODIFY COLUMN nisn VARCHAR(50) NOT NULL");
            echo "SUCCESS: NISN column converted to VARCHAR(50).\n";
        } catch (\Throwable $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
        }
    }
}
