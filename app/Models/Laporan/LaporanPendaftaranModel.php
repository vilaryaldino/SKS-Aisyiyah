<?php

namespace App\Models\Laporan;

use CodeIgniter\Model;

class LaporanPendaftaranModel extends Model
{
    protected $table = 'laporan_pendaftaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'keterangan', 'debit', 'kredit'];
    protected $useTimestamps = true;
}
