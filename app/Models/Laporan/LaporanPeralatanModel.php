<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanPeralatanModel extends Model
{
    protected $table = 'laporan_peralatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
