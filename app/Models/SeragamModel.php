<?php

namespace App\Models;

use CodeIgniter\Model;

class SeragamModel extends Model
{
    protected $table = 'atribut';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}
