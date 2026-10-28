<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanLksModel extends Model
{
    protected $table = 'laporan_lks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
