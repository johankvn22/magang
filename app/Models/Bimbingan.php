<?php

namespace App\Models;

use CodeIgniter\Model;

class Bimbingan extends Model
{
    protected $table            = 'bimbingan';
    protected $primaryKey       = 'bimbingan_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mahasiswa_id', 'dosen_id'];

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

    public function getMahasiswaByDosen($dosenId)
    {
        return $this->db->table('bimbingan')
                    ->select('bimbingan.bimbingan_id, mahasiswa.mahasiswa_id, mahasiswa.nama_lengkap, mahasiswa.nim, mahasiswa.program_studi')
                    ->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan.mahasiswa_id')
                    ->where('bimbingan.dosen_id', $dosenId)
                    ->get()
                    ->getResultArray();
    }

    public function getDaftarBimbinganDenganDosen()
    {
        return $this->db->table('dosen_pembimbing')
            ->select('dosen_pembimbing.nama_lengkap AS nama_dosen, dosen_pembimbing.nip, mahasiswa.nama_lengkap AS nama_mahasiswa, mahasiswa.nim')
            ->join('bimbingan', 'bimbingan.dosen_id = dosen_pembimbing.dosen_id')
            ->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan.mahasiswa_id')
            ->orderBy('dosen_pembimbing.nama_lengkap')
            ->get()
            ->getResultArray();
    }

    public function getDosenPembimbingByMahasiswa($mahasiswaId)
    {
        return $this->db->table('bimbingan')
            ->select('dosen_id')
            ->where('mahasiswa_id', $mahasiswaId)
            ->get()
            ->getResultArray();
    }


}
