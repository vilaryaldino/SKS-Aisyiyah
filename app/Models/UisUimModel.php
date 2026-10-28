<?php

namespace App\Models;

use CodeIgniter\Model;

class UisUimModel extends Model
{
    protected $table = 'uis_uim';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_siswa', 'debit', 'kredit'];
}
