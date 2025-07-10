<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel; // Memanggil model dosen pembimbing
use CodeIgniter\Exceptions\PageNotFoundException; // Untuk menangani exception
use App\Models\MahasiswaModel; // Memanggil model mahasiswa
use App\Models\LogbookBimbingan; // Memanggil model logbook bimbingan
use App\Models\PedomanMagangModel; // Memanggil model pedoman magang
use App\Models\Bimbingan; // Memanggil model bimbingan
use App\Models\PenilaianDosenModel; // Memanggil model penilaian dosen

class DosenPembimbingController extends BaseController
{
public function index()
{
    $userId = session()->get('user_id');

    $dosenModel = new DosenPembimbingModel();
    $dosen = $dosenModel->where('dosen_id', $userId)->first();

    $profilLengkap = $dosen && $dosen['nama_lengkap'] && $dosen['nip'] && $dosen['email'] && $dosen['no_telepon'];

    $pedomanModel = new PedomanMagangModel();
    $pedoman = $pedomanModel->orderBy('created_at', 'DESC')->first();

    // Tambahan model
    $bimbinganModel = new Bimbingan();
    $logbookModel = new LogbookBimbingan();
    $penilaianModel = new PenilaianDosenModel();
    $broadcastModel = new \App\Models\BroadcastModel(); // Tambahan model broadcast

    $bimbinganList = $bimbinganModel->where('dosen_id', $userId)->findAll();
    $mahasiswaIds = array_column($bimbinganList, 'mahasiswa_id');
    $bimbinganIds = array_column($bimbinganList, 'bimbingan_id');

    $jumlahMahasiswaBimbingan = count($mahasiswaIds);

    $jumlahBimbinganMasuk = 0;
    $jumlahLaporanDiterima = 0;
    $jumlahLaporanMenunggu = 0;
    $jumlahSudahDinilai = 0;
    $jumlahBelumDinilai = 0;

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
    }

    if (!empty($bimbinganIds)) {
        $jumlahSudahDinilai = $penilaianModel
            ->whereIn('bimbingan_id', $bimbinganIds)
            ->countAllResults();

        $jumlahBelumDinilai = count($bimbinganIds) - $jumlahSudahDinilai;
    }

    // === Ambil broadcast untuk role dosen ===
    $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
    $broadcasts = $broadcastModel
        ->groupStart()
            ->where('untuk', 'dosen')
            ->orWhere('untuk', 'semua')
        ->groupEnd()
        ->where('created_at >=', $sevenDaysAgo)
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('dosen/dashboard', [
        'profilLengkap'             => $profilLengkap,
        'pedoman'                   => $pedoman,
        'jumlahMahasiswaBimbingan'  => $jumlahMahasiswaBimbingan,
        'jumlahBimbinganMasuk'      => $jumlahBimbinganMasuk,
        'jumlahLaporanDiterima'     => $jumlahLaporanDiterima,
        'jumlahLaporanMenunggu'     => $jumlahLaporanMenunggu,
        'jumlahSudahDinilai'        => $jumlahSudahDinilai,
        'jumlahBelumDinilai'        => $jumlahBelumDinilai,
        'broadcasts'                => $broadcasts
    ]);
}


    // Fungsi untuk edit profil
    public function editProfile()
    {
        helper('form'); // <--- tambahkan ini
        $dosenModel = new DosenPembimbingModel();
        $userId = session()->get('user_id');

        // Mengambil data dosen berdasarkan user_id
        $dosen = $dosenModel->where('dosen_id', $userId)->first();

        if (!$dosen) {
            throw PageNotFoundException::forPageNotFound(); // Tangani jika data tidak ditemukan
        }

        // Tampilkan form edit profil
        return view('dosen/edit_profile', ['dosen' => $dosen]);
    }

    // Fungsi untuk memperbarui profil
    public function updateProfile()
    {
        $dosenModel = new DosenPembimbingModel();
        $userId = session()->get('user_id');

        // Validasi input yang diterima
        $this->validate([
            'nama' => 'required',
            'email' => 'required|valid_email',
        ]);


        // Update data dosen
        $dosenModel->update($userId, [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'nip' => $this->request->getPost('nip'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'link_whatsapp' => $this->request->getPost('link_whatsapp'),
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        return redirect()->to('/dosen/editProfile')->with('success', 'Profil berhasil diperbarui.');
    }

    // Fungsi untuk ganti password
    public function changePassword()
    {
        helper('form'); // <--- tambahkan ini
        return view('dosen/change_password'); // Tampilkan form ganti password
    }

    // Fungsi untuk memperbarui password
   public function updatePassword()
{
    $userId = session()->get('user_id');

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    $userModel = new \App\Models\UserModel(); // Gunakan UserModel, karena password di tabel users
    $user = $userModel->find($userId);

    if (!$user) {
        return redirect()->back()->with('error', 'Data user tidak ditemukan.');
    }

    if (!isset($user['password']) || !password_verify($currentPassword, $user['password'])) {
        return redirect()->back()->with('error', 'Password lama salah.');
    }

    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
    }

    $dataUpdate = [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
    ];

    if ($userModel->update($userId, $dataUpdate)) {
       return redirect()->to('/dosen')->with('success', 'Password berhasil diperbarui.');

    } else {
        return redirect()->back()->with('error', 'Gagal memperbarui password.');
    }
}

}
