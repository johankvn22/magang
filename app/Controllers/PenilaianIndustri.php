<?php

namespace App\Controllers;

use App\Models\BimbinganIndustriModel;
use App\Models\PenilaianIndustriModel;
use App\Models\MahasiswaModel;
use CodeIgniter\Controller;
use App\Models\LogbookIndustri;

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


public function create($mahasiswaId)
{
    $mahasiswaModel = new MahasiswaModel();
    $logbookModel = new LogbookIndustri();

    $mahasiswa = $mahasiswaModel->find($mahasiswaId);
    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
    }

    // Cek apakah mahasiswa ini memiliki cukup logbook yang disetujui
    $disetujuiCount = $logbookModel
        ->where('mahasiswa_id', $mahasiswaId)
        ->where('status_validasi', 'disetujui')
        ->countAllResults();

    if ($disetujuiCount < 2) {
        return redirect()->to('industri/bimbingan/detail/' . $mahasiswaId)
                         ->with('error', 'Minimal 2 logbook harus disetujui untuk memberi penilaian.');
    }

    // Cek apakah sudah dinilai
    $penilaianModel = new PenilaianIndustriModel();
    $sudahAda = $penilaianModel->where('mahasiswa_id', $mahasiswaId)->first();
    if ($sudahAda) {
        return redirect()->to('industri/bimbingan/detail/' . $mahasiswaId)
                         ->with('error', 'Mahasiswa ini sudah dinilai.');
    }

    return view('industri/penilaian_industri', [
        'mahasiswa' => $mahasiswa,
        'mahasiswa_id' => $mahasiswaId,
    ]);
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
    );

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

    // Update status penilaian di tabel mahasiswa
    return redirect()->to('industri/penilaian-industri/detail/' . $data['mahasiswa_id'])
                    ->with('success', 'Penilaian berhasil disimpan.');
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

        // Tambahkan status penilaian untuk masing-masing mahasiswa
        foreach ($mahasiswaList as &$mhs) {
            $penilaian = $this->penilaianModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->first();

            $mhs['sudah_dinilai'] = $penilaian ? true : false;
        }

        return view('industri/list_nilai_mahasiswa', ['mahasiswaList' => $mahasiswaList]);
    }



}
