<?php

namespace App\Models;

use CodeIgniter\Model;

class PeralatanModel extends Model
{
    protected $table = 'peralatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}
