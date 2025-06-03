<?php

namespace App\Controllers;

use App\Models\LogbookIndustri;
use App\Models\UserModel;
use App\Models\PembimbingIndustri;
use App\Models\BimbinganIndustriModel;
use App\Models\MahasiswaModel;

class PembimbingIndustriController extends BaseController
{
    // Fungsi dashboard tetap seperti yang ada
    public function dashboard()
    {
        $userId = session()->get('user_id');

        // Get industrial supervisor data
        $pembimbingModel = new PembimbingIndustri();
        $pembimbing = $pembimbingModel->where('pembimbing_id', $userId)->first();

        // Check if profile is complete
        $profilLengkap = $pembimbing && $pembimbing['nama'] && $pembimbing['no_telepon'] && $pembimbing['email'];

        // Initialize models
        $logbookModel = new LogbookIndustri();
        $bimbinganModel = new BimbinganIndustriModel();

        // Get all students supervised by this industrial supervisor
        $bimbinganList = $bimbinganModel->where('pembimbing_id', $userId)->findAll();
        $mahasiswaIds = array_column($bimbinganList, 'mahasiswa_id');

        // Calculate various statistics
        $totalMahasiswa = count(array_unique($mahasiswaIds));

        $jumlahBimbinganMasuk = 0;
        $jumlahLaporanDiterima = 0;
        $jumlahLaporanMenunggu = 0;
        $jumlahLaporanDitolak = 0;

        if (!empty($mahasiswaIds)) {
            $jumlahBimbinganMasuk = $logbookModel->whereIn('mahasiswa_id', $mahasiswaIds)->countAllResults();

            $jumlahLaporanDiterima = $logbookModel
                ->whereIn('mahasiswa_id', $mahasiswaIds)
                ->where('status_validasi', 'disetujui')
                ->countAllResults();

            $jumlahLaporanMenunggu = $logbookModel
                ->whereIn('mahasiswa_id', $mahasiswaIds)
                ->where('status_validasi', 'menunggu')
                ->countAllResults();

            $jumlahLaporanDitolak = $logbookModel
                ->whereIn('mahasiswa_id', $mahasiswaIds)
                ->where('status_validasi', 'ditolak')
                ->countAllResults();
        }

        return view('industri/dashboard', [
            'profilLengkap'         => $profilLengkap,
            'totalMahasiswa'        => $totalMahasiswa,
            'jumlahBimbinganMasuk'  => $jumlahBimbinganMasuk,
            'laporanDisetujui'      => $jumlahLaporanDiterima,
            'laporanMenunggu'       => $jumlahLaporanMenunggu,
            'laporanDitolak'        => $jumlahLaporanDitolak,
        ]);
    }

    // Fungsi baru untuk menampilkan daftar mahasiswa bimbingan
    public function index()
    {
        $userId = session()->get('user_id');

        // Get industrial supervisor's students with logbook counts
        $bimbinganModel = new BimbinganIndustriModel();
        $logbookModel = new LogbookIndustri();

        $mahasiswaList = $bimbinganModel
            ->select('mahasiswa.*, perusahaan.nama as nama_perusahaan')
            ->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan_industri.mahasiswa_id')
            ->join('perusahaan', 'perusahaan.perusahaan_id = mahasiswa.perusahaan_id', 'left')
            ->where('bimbingan_industri.pembimbing_id', $userId)
            ->findAll();

        // Add logbook counts for each student
        foreach ($mahasiswaList as &$mhs) {
            $mhs['total_bimbingan'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->countAllResults();

            $mhs['bimbingan_disetujui'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }

        return view('industri/bimbingan/index', [
            'mahasiswaList' => $mahasiswaList,
            'keyword' => $this->request->getGet('search')
        ]);
    }
    public function editProfil()
    {
        $industriModel = new PembimbingIndustri();
        $pembimbingId = session()->get('pembimbing_id');

        $profil = $industriModel->find($pembimbingId); // atau where('pembimbing_id', $pembimbingId)
        return view('industri/edit_profile', ['profil' => $profil]);
    }

    public function updateProfil()
    {
        $industriModel = new PembimbingIndustri();
        $userId = session()->get('user_id');

        $data = [
            'nama'       => $this->request->getPost('nama'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email'      => $this->request->getPost('email'),
            'perusahaan' => $this->request->getPost('perusahaan'),
            'nip'        => $this->request->getPost('nip'),
        ];

        $industriModel->update($userId, $data);
        return redirect()->to('/industri/dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
    public function gantiPassword()
    {
        return view('industri/ganti_password');
    }

    public function simpanPassword()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');

        $passwordBaru = $this->request->getPost('password');
        $konfirmasi  = $this->request->getPost('konfirmasi_password');

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Password tidak cocok.');
        }

        $hashedPassword = password_hash($passwordBaru, PASSWORD_DEFAULT);
        $userModel->update($userId, ['password' => $hashedPassword]);

        return redirect()->to('/industri/dashboard')->with('success', 'Password berhasil diubah.');
    }
}
