<?php

namespace App\Models;

use CodeIgniter\Model;

class LksModel extends Model
{
    protected $table = 'lks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}

