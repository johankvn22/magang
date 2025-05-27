<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'mahasiswa_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'mahasiswa_id',
        'nama_lengkap',
        'nim',
        'program_studi',
        'kelas',
        'no_hp',
        'email',
        'nama_perusahaan',
        'divisi',
        'durasi_magang',
        'tanggal_mulai',
        'tanggal_selesai',
        'nama_pembimbing_perusahaan',
        'no_hp_pembimbing_perusahaan',
        'email_pembimbing_perusahaan',
        'judul_magang',
        'dospem1',
        'dospem2',
        'dospem3'
    ];
    // Metode untuk mengambil semua mahasiswa
    public function getAllMahasiswa()
    {
        return $this->findAll(); // Mengambil semua data mahasiswa
    }
    public function getMahasiswaWithStatus()
    {
        $db = \Config\Database::connect();

        // Subquery: ambil logbook terakhir (created_at terbaru) per mahasiswa
        $latestLogbookSubquery = $db->table('logbook_bimbingan')
            ->select('mahasiswa_id, MAX(created_at) AS latest_created_at')
            ->groupBy('mahasiswa_id');

        // Join ke logbook_bimbingan untuk ambil status_validasi-nya
        $logbookJoin = $db->table('logbook_bimbingan lb')
            ->select('lb.mahasiswa_id, lb.status_validasi')
            ->join('(' . $latestLogbookSubquery->getCompiledSelect() . ') AS latest', 'lb.mahasiswa_id = latest.mahasiswa_id AND lb.created_at = latest.latest_created_at', 'inner');

        // Final join ke mahasiswa
        $builder = $db->table('mahasiswa');
        $builder->select('mahasiswa.*, logbook.status_validasi AS status');
        $builder->join('(' . $logbookJoin->getCompiledSelect() . ') AS logbook', 'logbook.mahasiswa_id = mahasiswa.mahasiswa_id', 'left');

        return $builder->get()->getResultArray();
    }

    public function getMahasiswaWithStatusIndustri()
    {
        $db = \Config\Database::connect();

        $latestLogbookSubquery = $db->table('logbook_industri')
            ->select('mahasiswa_id, MAX(created_at) AS latest_created_at')
            ->groupBy('mahasiswa_id');

        $logbookJoin = $db->table('logbook_industri li')
            ->select('li.mahasiswa_id, li.status_validasi')
            ->join('(' . $latestLogbookSubquery->getCompiledSelect() . ') AS latest', 'li.mahasiswa_id = latest.mahasiswa_id AND li.created_at = latest.latest_created_at');

        $builder = $db->table('mahasiswa');
        $builder->select('mahasiswa.*, logbook.status_validasi AS status');
        $builder->join('(' . $logbookJoin->getCompiledSelect() . ') AS logbook', 'logbook.mahasiswa_id = mahasiswa.mahasiswa_id', 'left');

        return $builder->get()->getResultArray();
    }

    // public function getMahasiswaWithDosen()
    // {
    //     return $this->select('mahasiswa.*, GROUP_CONCAT(dosen_pembimbing.nama_lengkap SEPARATOR ", ") AS nama_dosen')
    //                 ->join('bimbingan', 'bimbingan.mahasiswa_id = mahasiswa.mahasiswa_id', 'left')
    //                 ->join('dosen_pembimbing', 'dosen_pembimbing.dosen_id = bimbingan.dosen_id', 'left')
    //                 ->groupBy('mahasiswa.mahasiswa_id');
    // }

    public function getMahasiswaWithDosen()
    {
        return $this->select('mahasiswa.*, GROUP_CONCAT(dosen_pembimbing.nama_lengkap SEPARATOR ", ") AS nama_dosen')
            ->join('bimbingan', 'bimbingan.mahasiswa_id = mahasiswa.mahasiswa_id', 'left')
            ->join('dosen_pembimbing', 'dosen_pembimbing.dosen_id = bimbingan.dosen_id', 'left')
            ->groupBy('mahasiswa.mahasiswa_id');
    }


  public function getAllPenilaianByMahasiswa($mahasiswa_id)
{
    return $this->db->table('mahasiswa')
        ->select('mahasiswa.*, 
              penilaian_dosen.total_nilai AS nilai_dosen, 
              penilaian_industri.total_nilai_industri AS nilai_industri,
              (COALESCE(penilaian_industri.total_nilai_industri, 0) * 0.6 + 
              (COALESCE(penilaian_dosen.total_nilai, 0) * 0.4 AS total_nilai_akhir')
        ->join('bimbingan', 'bimbingan.mahasiswa_id = mahasiswa.mahasiswa_id')
        ->join('penilaian_dosen', 'penilaian_dosen.bimbingan_id = bimbingan.bimbingan_id', 'left')
        ->join('penilaian_industri', 'penilaian_industri.mahasiswa_id = mahasiswa.mahasiswa_id', 'left')
        ->where('mahasiswa.mahasiswa_id', $mahasiswa_id)
        ->get()
        ->getRowArray();
}


    protected bool $allowEmptyInserts = true;
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
}
