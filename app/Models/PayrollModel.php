<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    protected $table            = 'payrolls';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'teacher_id', 'bulan', 'tahun', 
        'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji', 
        'tunjangan_jabatan', 'tunjangan_walas', 'tunjangan_masa_kerja', 
        'kesejahteraan', 'transport_kehadiran', 'kinerja', 'rapat_dll', 'tahfidz',
        'tanggal_cetak'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPayrollsWithTeacher($id = null)
    {
        $builder = $this->builder();
        $builder->select('payrolls.*, teachers.nama, teachers.nip, teachers.jabatan');
        $builder->join('teachers', 'teachers.id = payrolls.teacher_id');
        
        if ($id != null) {
            $builder->where('payrolls.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
