<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanUisUimModel extends Model
{
    protected $table = 'laporan_uis_uim';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
