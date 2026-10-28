<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanSeragamTasModel extends Model
{
    protected $table = 'laporan_seragam_tas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
