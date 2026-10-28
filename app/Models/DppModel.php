<?php

namespace App\Models;

use CodeIgniter\Model;

class DppModel extends Model
{
    protected $table = 'dpp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}

