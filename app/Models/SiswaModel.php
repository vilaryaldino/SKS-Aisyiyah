<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table      = 'data_siswa';
    protected $primaryKey = 'nisn'; 
    protected $useAutoIncrement = false; // NISN is manual, not auto-increment

    protected $allowedFields = [
        'nisn', 'nama', 'nik', 'kelas', 'jk', 'tanggal_lahir', 'alamat',
        'no_whatsapp', 'orang_tua', 'role', 'tahun_akademik'
    ];

    protected $beforeInsert = ['setTahunAkademik'];

    protected function setTahunAkademik(array $data)
    {
        $month = date('n');
        $year = date('Y');

        // Jika bulan Juni (6) ke atas (Juli - Des), masuk tahun ajaran Year / Year+1
        // Jika bulan Jan - Mei brt masuk tahun ajaran Year-1 / Year
        // (Biasanya tahun ajaran baru mulai Juli)
        
        if ($month >= 7) {
            $startYear = $year;
            $endYear = $year + 1;
        } else {
            $startYear = $year - 1;
            $endYear = $year;
        }

        $data['data']['tahun_akademik'] = "$startYear/$endYear";

        return $data;
    }
}
