<?php

namespace App\Models;

use CodeIgniter\Model;

class BimbinganIndustriModel extends Model
{
    protected $table            = 'bimbingan_industri';
    protected $primaryKey       = 'bimbingan_industri_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mahasiswa_id', 'pembimbing_id', 'created_at', 'updated_at'];


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

    public function getMahasiswaByPembimbing($pembimbingId)
    {
        return $this->db->table('bimbingan_industri')
                    ->select('bimbingan_industri.bimbingan_industri_id, mahasiswa.mahasiswa_id, mahasiswa.nama_lengkap, mahasiswa.nim, mahasiswa.program_studi')
                    ->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan_industri.mahasiswa_id')
                    ->where('bimbingan_industri.pembimbing_id', $pembimbingId)
                    ->get()
                    ->getResultArray();
    }
}
