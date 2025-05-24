<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRequirement extends Model
{
    protected $table            = 'user_requirement';
    protected $primaryKey       = 'requirement_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mahasiswa_id', 'tanggal', 'dikerjakan', 'user_requirement', 'status_validasi'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

public function getMahasiswaPengisiRequirement()
{
    return $this->select('m.mahasiswa_id, m.nama_lengkap, m.nim, m.program_studi, MAX(user_requirement.tanggal) as terakhir_diisi')
                ->join('mahasiswa m', 'm.mahasiswa_id = user_requirement.mahasiswa_id')
                ->groupBy('m.mahasiswa_id, m.nama_lengkap, m.nim, m.program_studi')
                ->orderBy('terakhir_diisi', 'DESC')
                ->findAll();
}


}
