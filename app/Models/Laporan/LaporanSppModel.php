<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanSppModel extends Model
{
    protected $table = 'laporan_spp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
