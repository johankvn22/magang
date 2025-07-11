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
    protected $allowedFields = ['mahasiswa_id', 'pembimbing_id', 'status', 'created_at', 'updated_at'];
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

    public function getPembimbingDenganMahasiswa()
    {
        $builder = $this->db->table('pembimbing_industri');
        $builder->select('
            pembimbing_industri.pembimbing_id,
            pembimbing_industri.nama AS nama_pembimbing,
            pembimbing_industri.perusahaan,
            mahasiswa.nama_lengkap AS nama_mahasiswa,
            mahasiswa.nim
        ');
        $builder->join('bimbingan_industri', 'bimbingan_industri.pembimbing_id = pembimbing_industri.pembimbing_id', 'left');
        $builder->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan_industri.mahasiswa_id', 'left');
        $builder->orderBy('pembimbing_industri.nama', 'ASC');

        $result = $builder->get()->getResultArray();

        // Kelompokkan mahasiswa berdasarkan pembimbing
        $grouped = [];
        foreach ($result as $row) {
            $id = $row['pembimbing_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'nama_pembimbing' => $row['nama_pembimbing'],
                    'perusahaan' => $row['perusahaan'],
                    'mahasiswa' => []
                ];
            }

            if (!empty($row['nama_mahasiswa'])) {
                $grouped[$id]['mahasiswa'][] = [
                    'nama' => $row['nama_mahasiswa'],
                    'nim' => $row['nim']
                ];
            }
        }

        return $grouped;
    }
}
