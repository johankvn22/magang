<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewKinerjaModel extends Model
{
    protected $table = 'review_kinerja';
    protected $primaryKey = 'review_id';

    protected $allowedFields = [
        'bimbingan_industri_id',
        'mahasiswa_id',
        'email',
        'no_hp',
        'nama_mahasiswa',
        'nama_pembimbing_perusahaan',
        'nama_perusahaan',
        'jabatan',
        'divisi',
        'integritas',
        'keahlian_bidang',
        'kemampuan_bahasa_inggris',
        'pengetahuan_bidang',
        'komunikasi_adaptasi',
        'kerja_sama',
        'kemampuan_belajar',
        'kreativitas',
        'menuangkan_ide',
        'pemecahan_masalah',
        'sikap',
        'kerja_dibawah_tekanan',
        'manajemen_waktu',
        'bekerja_mandiri',
        'negosiasi',
        'analisis',
        'bekerja_dengan_budaya_berbeda',
        'kepemimpinan',
        'tanggung_jawab',
        'presentasi',
        'menulis_dokumen',
        'saran_lulusan',
        'kemampuan_teknik_dibutuhkan',
        'profesi_cocok',
        'created_at'
    ];
    // Ambil semua review
    public function getAll()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Ambil detail review berdasarkan ID
    public function getDetail($id)
    {
        return $this->where('review_id', $id)->first();
    }

    
}
