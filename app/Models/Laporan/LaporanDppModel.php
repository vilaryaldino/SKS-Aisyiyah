<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanDppModel extends Model
{
    protected $table = 'laporan_dpp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
