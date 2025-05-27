<?php

namespace App\Controllers;

use App\Models\BimbinganIndustriModel;
use App\Models\LogbookIndustri;
use App\Models\MahasiswaModel;
use App\Models\PenilaianIndustriModel;

class BimbinganIndustriController extends BaseController
{
    public function index()
    {
        $pembimbingId = session()->get('user_id');
         
        $bimbinganModel = new BimbinganIndustriModel();

        $mahasiswaList = $bimbinganModel->getMahasiswaByPembimbing($pembimbingId);

    

        return view('industri/list_mahasiswa_bimbingan', ['mahasiswaList' => $mahasiswaList]);
    }

    public function detail($mahasiswaId)
    {
        $logbookModel     = new LogbookIndustri();
        $mahasiswaModel   = new MahasiswaModel();
        $bimbinganModel   = new BimbinganIndustriModel();

        // Ambil data mahasiswa
        $mahasiswa = $mahasiswaModel->find($mahasiswaId);

        if (!$mahasiswa) {
            // Handle jika mahasiswa tidak ditemukan
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Ambil semua logbook untuk mahasiswa ini
        $logbooks = $logbookModel
            ->where('mahasiswa_id', $mahasiswaId)
            ->findAll();

        // Hitung logbook yang disetujui
        $disetujuiCount = $logbookModel
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('status_validasi', 'disetujui')
            ->countAllResults();

        // Hitung total logbook
        $totalCount = $logbookModel
            ->where('mahasiswa_id', $mahasiswaId)
            ->countAllResults();

        // Ambil ID pembimbing industri dari session
        $pembimbingId = session()->get('user_id');

        // Cari data bimbingan yang cocok
        $bimbingan = $bimbinganModel->where([
            'mahasiswa_id' => $mahasiswaId,
            'pembimbing_id' => $pembimbingId
        ])->first();

        // Ambil ID bimbingan jika ada
        $bimbingan_id = $bimbingan['bimbingan_industri_id'] ?? null;

        // Cek apakah penilaian sudah ada untuk mahasiswa ini
        $penilaianModel = new PenilaianIndustriModel();
        $penilaian_sudah_ada = $penilaianModel
            ->where('mahasiswa_id', $mahasiswaId)
            ->first() !== null;

        return view('industri/aktivitas_logbook', [
            'mahasiswa'           => $mahasiswa,
            'logbooks'            => $logbooks,
            'disetujuiCount'      => $disetujuiCount,
            'totalCount'          => $totalCount,
            'bimbingan_id'        => $bimbingan_id,
            'penilaian_sudah_ada' => $penilaian_sudah_ada,
        ]);
    }

    public function setujui($logbookId)
    {
        $logbookModel = new LogbookIndustri();

        $logbook = $logbookModel->find($logbookId);
        if (!$logbook) {
            return redirect()->back()->with('error', 'Logbook tidak ditemukan.');
        }

        $logbookModel->update($logbookId, ['status_validasi' => 'disetujui']);
        return redirect()->back()->with('success', 'Logbook disetujui.');
    }

    public function tolak($logbookId)
    {
        $logbookModel = new LogbookIndustri();

        $logbook = $logbookModel->find($logbookId);
        if (!$logbook) {
            return redirect()->back()->with('error', 'Logbook tidak ditemukan.');
        }

        $logbookModel->update($logbookId, ['status_validasi' => 'ditolak']);
        return redirect()->back()->with('success', 'Logbook ditolak.');
    }

    public function updateCatatanIndustri($id)
    {
        $model = new LogbookIndustri();
        $logbook = $model->find($id);

        if (!$logbook) {
            return redirect()->back()->with('error', 'Data logbook tidak ditemukan.');
        }

        if ($logbook['status_validasi'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Catatan hanya bisa ditambahkan saat status logbook masih menunggu.');
        }

        $model->update($id, [
            'catatan_industri' => $this->request->getPost('catatan_industri')
        ]);

        return redirect()->back()->with('success', 'Catatan industri berhasil disimpan.');
    }



}
