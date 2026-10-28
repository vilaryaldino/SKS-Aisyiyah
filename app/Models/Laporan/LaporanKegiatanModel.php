<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanKegiatanModel extends Model
{
    protected $table = 'laporan_kegiatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
