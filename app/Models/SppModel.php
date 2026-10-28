<?php

namespace App\Models;

use CodeIgniter\Model;

class SppModel extends Model
{
    protected $table = 'spp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}

