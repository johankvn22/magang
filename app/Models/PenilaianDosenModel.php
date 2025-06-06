<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianDosenModel extends Model
{
    protected $table = 'penilaian_dosen';
    protected $primaryKey = 'id_penilaian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'bimbingan_id',
        'nilai_1_1',
        'nilai_1_2',
        'nilai_1_3',
        'nilai_2_1',
        'nilai_2_2',
        'nilai_2_3',
        'nilai_2_4',
        'nilai_3_1',
        'nilai_3_2',
        'total_nilai'
    ];

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
    public function getNilaiByMahasiswa($mahasiswa_id)
    {
        return $this->select('penilaian_dosen.*')
            ->join('bimbingan', 'bimbingan.bimbingan_id = penilaian_dosen.bimbingan_id')
            ->where('bimbingan.mahasiswa_id', $mahasiswa_id)
            ->first(); // Gunakan ->first() jika hanya satu nilai dosen per mahasiswa
    }
}
