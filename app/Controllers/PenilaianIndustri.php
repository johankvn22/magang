<?php

namespace App\Controllers;

use App\Models\BimbinganIndustriModel;
use App\Models\PenilaianIndustriModel;
use App\Models\MahasiswaModel;
use CodeIgniter\Controller;


class PenilaianIndustri extends Controller
{
    protected $penilaianModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianIndustriModel();
        $this->mahasiswaModel = new MahasiswaModel();
        helper(['form']);
    }

    // Menampilkan form input


    public function create()
    {
        $pembimbingId = session()->get('pembimbing_id');

        // Ambil hanya mahasiswa yang dibimbing oleh pembimbing ini
        $data['mahasiswa'] = $this->mahasiswaModel
            ->join('bimbingan_industri', 'bimbingan_industri.mahasiswa_id = mahasiswa.mahasiswa_id')
            ->where('bimbingan_industri.pembimbing_id', $pembimbingId)
            ->findAll();

        return view('industri/penilaian_industri', $data);
    }


    // Proses simpan data
 public function store()
{
    $input = $this->request->getPost();

    // Cek apakah penilaian untuk mahasiswa ini sudah ada
    $existing = $this->penilaianModel
        ->where('mahasiswa_id', $input['mahasiswa_id'])
        ->first();

    if ($existing) {
        return redirect()->to('industri/list_mahasiswa_bimbingan')->with('error', 'Penilaian untuk mahasiswa ini sudah pernah diberikan.');
    }

    // Hitung total nilai
    $total = (
        $input['komunikasi'] + $input['berpikir_kritis'] + $input['kerja_tim'] +
        $input['inisiatif'] + $input['literasi_digital'] + $input['deskripsi_produk'] +
        $input['spesifikasi_produk'] + $input['desain_produk'] +
        $input['implementasi_produk'] + $input['pengujian_produk']
    ) / 10;

    $data = [
        'mahasiswa_id' => $input['mahasiswa_id'],
        'komunikasi' => $input['komunikasi'],
        'berpikir_kritis' => $input['berpikir_kritis'],
        'kerja_tim' => $input['kerja_tim'],
        'inisiatif' => $input['inisiatif'],
        'literasi_digital' => $input['literasi_digital'],
        'deskripsi_produk' => $input['deskripsi_produk'],
        'spesifikasi_produk' => $input['spesifikasi_produk'],
        'desain_produk' => $input['desain_produk'],
        'implementasi_produk' => $input['implementasi_produk'],
        'pengujian_produk' => $input['pengujian_produk'],
        'total_nilai_industri' => $total
    ];

    $this->penilaianModel->insert($data);
    return redirect()->to('industri/bimbingan')->with('success', 'Data penilaian berhasil disimpan!');
}


    public function detail($mahasiswa_id)
    {
        $penilaian = $this->penilaianModel->getByMahasiswa($mahasiswa_id);

        if (!$penilaian) {
            return redirect()->to('/industri/dashboard')->with('error', 'Data penilaian tidak ditemukan.');
        }

        return view('industri/detail_nilai_industri', ['penilaian' => $penilaian]);
    }

    public function listNilaiMahasiswa()
    {
        $pembimbingId = session()->get('pembimbing_id');

        $bimbinganModel = new BimbinganIndustriModel();
        $mahasiswaList = $bimbinganModel->getMahasiswaByPembimbing($pembimbingId);

        return view('industri/list_nilai_mahasiswa', ['mahasiswaList' => $mahasiswaList]);
    }


}
