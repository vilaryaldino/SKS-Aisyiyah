<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table            = 'teachers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nip', 'nama', 'alamat', 'no_telp', 'jabatan', 
        'gaji_pokok', 'tunjangan', 'tunjangan_jabatan', 'tunjangan_walas', 'tunjangan_masa_kerja', 
        'kesejahteraan', 'transport_kehadiran', 'kinerja', 'rapat_dll', 'tahfidz',
        'status_aktif'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id' => 'permit_empty',
        'nip' => 'required|is_unique[teachers.nip,id,{id}]',
        'nama' => 'required',
        'gaji_pokok' => 'required|numeric',
        // 'tunjangan_jabatan' => 'numeric',

    ];
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
}
