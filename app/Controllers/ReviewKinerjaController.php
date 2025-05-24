<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReviewKinerjaModel;
use App\Models\BimbinganIndustriModel;
use App\Models\MahasiswaModel;

class ReviewKinerjaController extends BaseController
{
    public function berikanNilai($bimbingan_industri_id)
    {
        helper('form');

        $bimbinganModel = new BimbinganIndustriModel();
        $mahasiswaModel = new MahasiswaModel();
        $reviewModel = new ReviewKinerjaModel();

        $bimbingan = $bimbinganModel->find($bimbingan_industri_id);

        if (!$bimbingan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bimbingan tidak ditemukan');
        }

        $mahasiswa = $mahasiswaModel->find($bimbingan['mahasiswa_id']);

        // Cek apakah review sudah ada
        $review = $reviewModel->where('bimbingan_industri_id', $bimbingan_industri_id)->first();

        $data['bimbingan'] = array_merge($bimbingan, (array) $mahasiswa);

        if ($review) {
            $data['review'] = $review;
            $data['readonly'] = true;
        } else {
            $data['readonly'] = false;
        }

        return view('industri/form_review', $data);
    }

    public function simpanNilai()
    {
        $reviewModel = new ReviewKinerjaModel();
        $mahasiswaModel = new MahasiswaModel();

        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $data = [
            'bimbingan_industri_id' => $this->request->getPost('bimbingan_industri_id'),
            'mahasiswa_id' => $mahasiswa_id,
            'nama_mahasiswa' => $mahasiswa['nama_lengkap'],
            'email' => $mahasiswa['email'],
            'no_hp' => $mahasiswa['no_hp'],
            'nama_pembimbing_perusahaan' => $this->request->getPost('nama_pembimbing_perusahaan'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'jabatan' => $this->request->getPost('jabatan'),
            'divisi' => $this->request->getPost('divisi'),
            'integritas' => $this->request->getPost('integritas'),
            'keahlian_bidang' => $this->request->getPost('keahlian_bidang'),
            'kemampuan_bahasa_inggris' => $this->request->getPost('kemampuan_bahasa_inggris'),
            'pengetahuan_bidang' => $this->request->getPost('pengetahuan_bidang'),
            'komunikasi_adaptasi' => $this->request->getPost('komunikasi_adaptasi'),
            'kerja_sama' => $this->request->getPost('kerja_sama'),
            'kemampuan_belajar' => $this->request->getPost('kemampuan_belajar'),
            'kreativitas' => $this->request->getPost('kreativitas'),
            'menuangkan_ide' => $this->request->getPost('menuangkan_ide'),
            'pemecahan_masalah' => $this->request->getPost('pemecahan_masalah'),
            'sikap' => $this->request->getPost('sikap'),
            'kerja_dibawah_tekanan' => $this->request->getPost('kerja_dibawah_tekanan'),
            'manajemen_waktu' => $this->request->getPost('manajemen_waktu'),
            'bekerja_mandiri' => $this->request->getPost('bekerja_mandiri'),
            'negosiasi' => $this->request->getPost('negosiasi'),
            'analisis' => $this->request->getPost('analisis'),
            'bekerja_dengan_budaya_berbeda' => $this->request->getPost('bekerja_dengan_budaya_berbeda'),
            'kepemimpinan' => $this->request->getPost('kepemimpinan'),
            'tanggung_jawab' => $this->request->getPost('tanggung_jawab'),
            'presentasi' => $this->request->getPost('presentasi'),
            'menulis_dokumen' => $this->request->getPost('menulis_dokumen'),
            'saran_lulusan' => $this->request->getPost('saran_lulusan'),
            'kemampuan_teknik_dibutuhkan' => $this->request->getPost('kemampuan_teknik_dibutuhkan'),
            'profesi_cocok' => $this->request->getPost('profesi_cocok'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $reviewModel->insert($data);

        return redirect()->to('industri/dashboard')->with('message', 'Review kinerja berhasil disimpan!');
    }

    public function listReview()
    {
        $pembimbingId = session()->get('user_id');
        $bimbinganModel = new BimbinganIndustriModel();
        $reviewModel = new ReviewKinerjaModel();

        // Ambil daftar mahasiswa bimbingan dengan bimbingan_industri_id
        $mahasiswaList = $bimbinganModel->getMahasiswaByPembimbing($pembimbingId);

        // Ambil daftar mahasiswa_id yang sudah ada review-nya
        $mahasiswaReviewed = $reviewModel->select('mahasiswa_id')->findColumn('mahasiswa_id');

    //         echo '<pre>';
    // print_r($mahasiswaList);
    // echo '</pre>';
    // exit;

        return view('industri/list_review', [
            'mahasiswaList' => $mahasiswaList,
            'mahasiswaReviewed' => $mahasiswaReviewed,
        ]);
    }


    public function detailReview($mahasiswaId)
    {
        $reviewModel = new ReviewKinerjaModel();

        $review = $reviewModel->where('mahasiswa_id', $mahasiswaId)->first();

        if (!$review) {
            // Redirect ke halaman pemberian nilai jika belum ada review
            return redirect()->to('industri/review-kinerja/berikan/' . $mahasiswaId);
        }

        return view('industri/detail_review', ['review' => $review]);
    }

}