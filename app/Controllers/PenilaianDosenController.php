<?php

namespace App\Controllers;

use App\Models\PenilaianDosenModel;
use App\Models\PenilaianIndustriModel;
use App\Models\Bimbingan;
use App\Models\MahasiswaModel;

class PenilaianDosenController extends BaseController
{
    // Form penilaian untuk mahasiswa berdasarkan ID
    public function showForm($bimbingan_id)
    {
        $dosen_id = session()->get('user_id');
        $bimbinganModel = new Bimbingan();
        $mahasiswaModel = new MahasiswaModel();
        $penilaianModel = new PenilaianDosenModel(); // Tambahkan model ini
        $penilaianIndustriModel = new PenilaianIndustriModel(); // ✅ Tambahkan model ini


        // Ambil data bimbingan berdasarkan ID
        $bimbingan = $bimbinganModel->find($bimbingan_id);

        if (!$bimbingan) {
            return redirect()->to('/penilaian-dosen')->with('error', 'Bimbingan tidak ditemukan.');
        }

        // Pastikan mahasiswa tersebut dibimbing oleh dosen yang sedang login
        if ($bimbingan['dosen_id'] != $dosen_id) {
            return redirect()->to('/penilaian-dosen')->with('error', 'Anda tidak berhak menilai mahasiswa ini.');
        }

        // Cek apakah penilaian sudah ada
        $existing = $penilaianModel->where('bimbingan_id', $bimbingan_id)->first();
        if ($existing) {
            return redirect()->to('/dosen/penilaian-dosen/detail/' . $bimbingan_id)
                            ->with('info', 'Penilaian sudah pernah dilakukan untuk mahasiswa ini.');
        }

        // Ambil data mahasiswa
        $mahasiswa = $mahasiswaModel->find($bimbingan['mahasiswa_id']);

        // ✅ Ambil nilai industri jika tersedia
        $nilaiIndustri = $penilaianIndustriModel->getByMahasiswa($bimbingan['mahasiswa_id']);


        return view('dosen/form_penilaian_dosen', [
            'mahasiswa' => $mahasiswa,
            'bimbingan_id' => $bimbingan_id,
            'nilaiIndustri' => $nilaiIndustri // ✅ Dikirim ke view
        ]);
    }


    public function showNilai($bimbingan_id)
    {
        $bimbinganModel = new Bimbingan();
        $penilaianModel = new PenilaianDosenModel();
        $mahasiswaModel = new MahasiswaModel();
        $penilaianIndustriModel = new PenilaianIndustriModel();

        // Ambil data bimbingan berdasarkan ID
        $bimbingan = $bimbinganModel->find($bimbingan_id);
        if (!$bimbingan) {
            return redirect()->to('/dosen/penilaian-dosen')->with('error', 'Bimbingan tidak ditemukan.');
        }

        // Pastikan mahasiswa tersebut dibimbing oleh dosen yang sedang login
        $penilaian = $penilaianModel->where('bimbingan_id', $bimbingan_id)->first();
        if (!$penilaian) {
            return redirect()->to('/dosen/penilaian-dosen')->with('error', 'Penilaian belum tersedia.');
        }

        $mahasiswa = $mahasiswaModel->find($bimbingan['mahasiswa_id']);
        $nilaiIndustri = $penilaianIndustriModel->where('mahasiswa_id', $bimbingan['mahasiswa_id'])->first();

        return view('dosen/detail_nilai_mahasiswa', [
            'penilaian' => $penilaian,
            'mahasiswa' => $mahasiswa,
            'nilaiIndustri' => $nilaiIndustri // ✅ Dikirim ke view
        ]);
    }

    public function listNilai()
    {
        $dosen_id = session()->get('user_id');
        $bimbinganModel = new Bimbingan();
        $mahasiswaModel = new MahasiswaModel();
        $penilaianModel = new PenilaianDosenModel();

        // Ambil keyword dari input pencarian
        $keyword = $this->request->getGet('keyword');

        // Ambil data bimbingan milik dosen
        $bimbinganList = $bimbinganModel->where('dosen_id', $dosen_id)->findAll();

        $mahasiswaList = [];
        foreach ($bimbinganList as $bimbingan) {
            $mhs = $mahasiswaModel->find($bimbingan['mahasiswa_id']);
            if ($mhs) {
                $mhs['bimbingan_id'] = $bimbingan['bimbingan_id'];

                // Tambahkan flag apakah sudah dinilai
                $penilaian = $penilaianModel->where('bimbingan_id', $bimbingan['bimbingan_id'])->first();
                $mhs['sudah_dinilai'] = $penilaian ? true : false;

                $mahasiswaList[] = $mhs;
            }
        }

        // Jika ada keyword, lakukan filter
        if ($keyword) {
            $kw = mb_strtolower($keyword);
            $mahasiswaList = array_filter($mahasiswaList, function ($item) use ($kw) {
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw);
            });
            $mahasiswaList = array_values($mahasiswaList); // Reset index
        }

        return view('dosen/list_nilai_mahasiswa', [
            'mahasiswaList' => $mahasiswaList,
            'keyword' => $keyword
        ]);
    }



private function hitungTotal()
{
    // Ambil nilai-nilai
    $nilai1 = [
        $this->request->getPost('nilai_1_1'),
        $this->request->getPost('nilai_1_2'),
        $this->request->getPost('nilai_1_3'),
    ];

    $nilai2 = [
        $this->request->getPost('nilai_2_1'),
        $this->request->getPost('nilai_2_2'),
        $this->request->getPost('nilai_2_3'),
        $this->request->getPost('nilai_2_4'),
    ];

    $nilai3 = [
        $this->request->getPost('nilai_3_1'),
        $this->request->getPost('nilai_3_2'),
    ];

    // Hitung total untuk nilai1 (bobot 30%)
    $total_nilai1 = array_sum($nilai1);

    // Hitung total untuk nilai2 (bobot 40%)
    $total_nilai2 = array_sum($nilai2);

    // Hitung total untuk nilai3 (bobot 30%)
    $total_nilai3 = array_sum($nilai3);

    // Hitung total keseluruhan
    $total = $total_nilai1 + $total_nilai2 + $total_nilai3;

    return $total;
}



    // Menyimpan penilaian dosen
    public function save()
    {
        $penilaianModel = new PenilaianDosenModel();

        $bimbingan_id = $this->request->getPost('bimbingan_id');

        // Cek apakah bimbingan ini sudah pernah dinilai
        $existing = $penilaianModel->where('bimbingan_id', $bimbingan_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Mahasiswa ini sudah pernah dinilai.');
        }

        // Hitung nilai total
        $total = $this->hitungTotal();

        // Simpan data
        $data = [
            'bimbingan_id' => $bimbingan_id,
            'nilai_1_1'    => $this->request->getPost('nilai_1_1'),
            'nilai_1_2'    => $this->request->getPost('nilai_1_2'),
            'nilai_1_3'    => $this->request->getPost('nilai_1_3'),
            'nilai_2_1'    => $this->request->getPost('nilai_2_1'),
            'nilai_2_2'    => $this->request->getPost('nilai_2_2'),
            'nilai_2_3'    => $this->request->getPost('nilai_2_3'),
            'nilai_2_4'    => $this->request->getPost('nilai_2_4'),
            'nilai_3_1'    => $this->request->getPost('nilai_3_1'),
            'nilai_3_2'    => $this->request->getPost('nilai_3_2'),
            'total_nilai' => $total,
        ];

        $penilaianModel->insert($data);

    return redirect()->to('dosen/penilaian-dosen/detail/' . $bimbingan_id)->with('success', 'Penilaian berhasil disimpan.');
    }

}
