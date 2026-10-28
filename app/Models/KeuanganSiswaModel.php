<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganSiswaModel extends Model
{
    protected $table = 'keuangan_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_siswa', 'kelas', 'pendaftaran', 'uis_uim', 'peralatan', 'lks', 'atribut', 'kegiatan', 'spp', 'dpp'];
}
