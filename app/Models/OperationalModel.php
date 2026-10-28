<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationalModel extends Model
{
    protected $table            = 'operational_expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tanggal', 'keterangan', 'kategori', 'jumlah', 'bukti_foto', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
