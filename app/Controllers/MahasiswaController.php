<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MahasiswaModel; // Pastikan untuk mengimpor model mahasiswa
use App\Models\DosenPembimbingModel; // Pastikan untuk mengimpor model dosen
use App\Models\Bimbingan; // Pastikan untuk mengimpor model bimbingan
use App\Models\LogbookBimbingan;
use App\Models\PedomanMagangModel; // Pastikan untuk mengimpor model pedoman

class MahasiswaController extends BaseController
{
public function index()
{
    $role = session()->get('role');
    $userId = session()->get('user_id');
    $mahasiswaModel = new MahasiswaModel();
    $bimbinganModel = new Bimbingan();
    $dosenModel = new DosenPembimbingModel();
    $bimbingan = new LogbookBimbingan();
    
    if ($role === 'mahasiswa') {
        // Get student data
        $mahasiswa = $mahasiswaModel->find($userId);
        
        if (!$mahasiswa) {
            return redirect()->to('/login')->with('error', 'Data mahasiswa tidak ditemukan. Silakan login kembali.');
        }
        
        // Get dosen pembimbing
        $dosenPembimbing = $bimbinganModel->getDosenPembimbingByMahasiswa($userId);
        
        // informasi dosen pembimbing
        $dosenDetails = [];
        foreach ($dosenPembimbing as $dosen) {
            $detail = $dosenModel->find($dosen['dosen_id']);
            if ($detail) {
                $dosenDetails[] = $detail;
            }
        }

        // Get the latest pedoman (guideline)
        $pedomanModel = new PedomanMagangModel();
        $pedoman = $pedomanModel->orderBy('created_at', 'DESC')->first();
        
        // Get report statistics
        $jumlahLaporan = $bimbingan->where('mahasiswa_id', $userId)->countAllResults();
        $jumlahDisetujui = $bimbingan->where('mahasiswa_id', $userId)
                                      ->where('status_validasi', 'disetujui')
                                      ->countAllResults();
        $jumlahMenunggu = $bimbingan->where('mahasiswa_id', $userId)
                                      ->where('status_validasi', 'menunggu')
                                      ->countAllResults();

        $mahasiswa = $mahasiswaModel->find($userId);
        $profilLengkap = true;

        if (empty($mahasiswa['nama_perusahaan']) || empty($mahasiswa['durasi_magang'])) {
            $profilLengkap = false;
        }

        
        return view('mahasiswa/dashboard', [
            'mahasiswa' => $mahasiswa,
            'dosenPembimbing' => $dosenDetails,
            'pedoman' => $pedoman,
            'jumlahLaporan' => $jumlahLaporan,
            'jumlahDisetujui' => $jumlahDisetujui,
            'jumlahMenunggu' => $jumlahMenunggu,
            'profilLengkap' => $profilLengkap,
            'title' => 'Dashboard Mahasiswa'
        ]);
    } else {
        return redirect()->to('/login')->with('error', 'Akses tidak valid.');
    }
}
        
public function edit()
{
    $userId = session()->get('user_id');
    $mahasiswaModel = new MahasiswaModel();
    $dosenModel = new DosenPembimbingModel();
    
    // Mengambil data mahasiswa
    $mahasiswa = $mahasiswaModel->find($userId);
    
    // Mengambil data dosen
    $dosen = $dosenModel->findAll();

    // Pastikan data mahasiswa ditemukan sebelum menampilkan form
    if (!$mahasiswa) {
        return redirect()->to('/login')->with('error', 'Data mahasiswa tidak ditemukan.');
    }

    return view('mahasiswa/edit', [
        'mahasiswa' => $mahasiswa,
        'dosen' => $dosen,
        'title' => 'Edit Profile Mahasiswa'
    ]);
}

    // public function update()
    // {
    //     $mahasiswaModel = new MahasiswaModel();
    //     $userId = session()->get('user_id'); // Ambil user_id dari session

    //     // Ambil data dari input
    //     $dataUpdate = [
    //         'nama_lengkap' => $this->request->getPost('nama_lengkap'),
    //         'nim'          => $this->request->getPost('nim'),
    //         'program_studi' => $this->request->getPost('program_studi'),
    //         'kelas'        => $this->request->getPost('kelas'),
    //         'email'        => $this->request->getPost('email'), // Pastikan email juga diambil
    //         'no_hp'        => $this->request->getPost('no_hp'),
    //         'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
    //         'divisi'       => $this->request->getPost('divisi'),
    //         'durasi_magang' => $this->request->getPost('durasi_magang'),
    //         'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
    //         'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
    //         'nama_pembimbing_perusahaan' => $this->request->getPost('nama_pembimbing_perusahaan'),
    //         'no_hp_pembimbing_perusahaan' => $this->request->getPost('no_hp_pembimbing_perusahaan'),
    //         'email_pembimbing_perusahaan' => $this->request->getPost('email_pembimbing_perusahaan'),
    //         'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
    //         'judul_magang' => $this->request->getPost('judul_magang'),
    //         'dospem1'      => $this->request->getPost('dospem1'),
    //         'dospem2'      => $this->request->getPost('dospem2'),
    //         'dospem3'      => $this->request->getPost('dospem3')
    //     ];

    //     // Update data mahasiswa
    //     if ($mahasiswaModel->update($userId, $dataUpdate)) {
    //         return redirect()->to('/mahasiswa/edit')->with('success', 
    //         'Profil berhasil diperbarui.'); // Redirect ke dashboard
    //     } else {
    //         return redirect()->back()->with('error', 'Update profil gagal.'); // Pesan error jika gagal
    //     }
    // }

   public function update()
{
    $mahasiswaModel = new MahasiswaModel();
    $userId = session()->get('user_id');

    // Validasi upload foto
    $validationRules = [
        'foto_profil' => [
            'rules' => 'max_size[foto_profil,2048]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Ukuran foto maksimal 2MB',
                'is_image' => 'File harus berupa gambar (JPG/PNG)',
                'mime_in' => 'Format file harus JPG/JPEG/PNG'
            ]
        ],
    ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Ambil data lama
    $mahasiswa = $mahasiswaModel->find($userId);
    $oldFoto = $mahasiswa['foto_profil'] ?? 'default.jpg';

    // Ambil data input
    $dataUpdate = [
        'nama_lengkap' => $this->request->getPost('nama_lengkap'),
        'nim' => $this->request->getPost('nim'),
        'program_studi' => $this->request->getPost('program_studi'),
        'kelas' => $this->request->getPost('kelas'),
        'email' => $this->request->getPost('email'),
        'no_hp' => $this->request->getPost('no_hp'),
        'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
        'divisi' => $this->request->getPost('divisi'),
        'durasi_magang' => $this->request->getPost('durasi_magang'),
        'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        'nama_pembimbing_perusahaan' => $this->request->getPost('nama_pembimbing_perusahaan'),
        'no_hp_pembimbing_perusahaan' => $this->request->getPost('no_hp_pembimbing_perusahaan'),
        'email_pembimbing_perusahaan' => $this->request->getPost('email_pembimbing_perusahaan'),
        'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
        'judul_magang' => $this->request->getPost('judul_magang'),
        'dospem1' => $this->request->getPost('dospem1'),
        'dospem2' => $this->request->getPost('dospem2'),
        'dospem3' => $this->request->getPost('dospem3'),
    ];

    // Proses upload foto jika ada
    $file = $this->request->getFile('foto_profil');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/foto_profil', $newName);

        // Hapus foto lama jika bukan default
        if ($oldFoto && $oldFoto !== 'default.jpg') {
            $oldPath = ROOTPATH . 'public/uploads/foto_profil/' . $oldFoto;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $dataUpdate['foto_profil'] = $newName;
    }

    // Update database
    if ($mahasiswaModel->update($userId, $dataUpdate)) {
        return redirect()->to('/mahasiswa/edit')->with('success', 'Profil berhasil diperbarui.');
    } else {
        return redirect()->back()->with('error', 'Update profil gagal.');
    }
}


   public function update_password()
{
    $userId = session()->get('user_id');

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    $userModel = new UserModel();
    $user = $userModel->find($userId); // Ambil user dari tabel 'users'

    if ($user && password_verify($currentPassword, $user['password'])) {
        if ($newPassword === $confirmPassword) {
            $dataUpdate = [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ];

            if ($userModel->update($userId, $dataUpdate)) {
                return redirect()->to('/mahasiswa/dashboard')->with('success', 'Password berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui password.');
            }
        } else {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
        }
    } else {
        return redirect()->back()->with('error', 'Password lama salah.');
    }
}


    public function ganti_password()
    {
        return view('mahasiswa/ganti_password');
    }

public function pilihPembimbing()
{
    if (!session()->get('logged_in') || session()->get('role') != 'mahasiswa') {
        return redirect()->to('/login')->with('error', 'Silakan login sebagai mahasiswa terlebih dahulu');
    }

    $userModel = new \App\Models\UserModel();
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $bimbinganModel = new \App\Models\BimbinganIndustriModel();

    $user = $userModel->find(session()->get('user_id'));
    $mahasiswa = $mahasiswaModel->where('nim', $user['nomor_induk'])->first();

    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
    }

    // ✅ Fix: select field lengkap termasuk bimbingan_id
 $pengajuan = $bimbinganModel
    ->select('
        bimbingan_industri.bimbingan_industri_id,
        bimbingan_industri.status,
        pembimbing_industri.nama as nama_pembimbing,
        pembimbing_industri.perusahaan,
        pembimbing_industri.email,
        pembimbing_industri.no_telepon
    ')
    ->join('pembimbing_industri', 'pembimbing_industri.pembimbing_id = bimbingan_industri.pembimbing_id', 'left')
    ->where('bimbingan_industri.mahasiswa_id', $mahasiswa['mahasiswa_id'])
    ->orderBy('bimbingan_industri.created_at', 'DESC')
    ->first();
// dd($pengajuan);


    $pembimbing = (new \App\Models\PembimbingIndustri())->findAll();

    return view('mahasiswa/pilih_pembimbing', [
        'pembimbing' => $pembimbing,
        'pengajuan' => $pengajuan,
        'mahasiswa_id' => $mahasiswa['mahasiswa_id'],
    ]);
}



    public function ajukanBimbingan()
    {
        // Validasi session dan role
        if (!session()->get('logged_in') || session()->get('role') != 'mahasiswa') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai mahasiswa terlebih dahulu');
        }

        $bimbinganModel = new \App\Models\BimbinganIndustriModel();
        
        // Ambil data mahasiswa berdasarkan user yang login
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Data user tidak ditemukan');
        }

        // Ambil mahasiswa_id dari tabel mahasiswa berdasarkan nomor induk
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('nim', $user['nomor_induk'])->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan. Hubungi admin.');
        }

        $mahasiswaId = $mahasiswa['mahasiswa_id'];
        $pembimbingId = $this->request->getPost('pembimbing_id');

        // Debug untuk memastikan data ada
        log_message('debug', 'Mahasiswa ID: ' . $mahasiswaId);
        log_message('debug', 'Pembimbing ID: ' . $pembimbingId);

        // Validasi input
        if (!$mahasiswaId || !$pembimbingId) {
            return redirect()->back()->with('error', 'Data tidak lengkap. Pastikan Anda sudah login dan memilih pembimbing.');
        }

        // Cek apakah mahasiswa sudah pernah mengajukan
        $sudahAda = $bimbinganModel->where('mahasiswa_id', $mahasiswaId)->first();
        if ($sudahAda) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan pembimbing sebelumnya.');
        }

        try {
            $result = $bimbinganModel->insert([
                'mahasiswa_id' => $mahasiswaId,
                'pembimbing_id' => $pembimbingId,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                return redirect()->to('/mahasiswa/pilih-pembimbing')->with('success', 'Pengajuan berhasil dikirim. Menunggu persetujuan dari pembimbing.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim pengajuan. Silakan coba lagi.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error saat mengajukan bimbingan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    // Method untuk melihat status pengajuan
    public function statusPengajuan()
    {
        // Validasi session dan role
        if (!session()->get('logged_in') || session()->get('role') != 'mahasiswa') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai mahasiswa terlebih dahulu');
        }

        // Ambil data mahasiswa berdasarkan user yang login
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Data user tidak ditemukan');
        }

        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('nim', $user['nomor_induk'])->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan. Hubungi admin.');
        }

        $bimbinganModel = new \App\Models\BimbinganIndustriModel();
        $pengajuan = $bimbinganModel->select('bimbingan_industri.*, pembimbing_industri.nama as nama_pembimbing, pembimbing_industri.perusahaan')
            ->join('pembimbing_industri', 'pembimbing_industri.pembimbing_id = bimbingan_industri.pembimbing_id')
            ->where('bimbingan_industri.mahasiswa_id', $mahasiswa['mahasiswa_id'])
            ->first();

        return view('mahasiswa/status_pengajuan', ['pengajuan' => $pengajuan]);
    }

public function batalkanPengajuan($id)
{
    if (!session()->get('logged_in') || session()->get('role') != 'mahasiswa') {
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $bimbinganModel = new \App\Models\BimbinganIndustriModel();
    $pengajuan = $bimbinganModel->find($id);

    if (!$pengajuan) {
        return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
    }

    // Pastikan hanya mahasiswa yang bisa hapus pengajuan miliknya sendiri
    $userModel = new \App\Models\UserModel();
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $user = $userModel->find(session()->get('user_id'));
    $mahasiswa = $mahasiswaModel->where('nim', $user['nomor_induk'])->first();

    if (!$mahasiswa || $pengajuan['mahasiswa_id'] != $mahasiswa['mahasiswa_id']) {
        return redirect()->back()->with('error', 'Anda tidak berhak menghapus pengajuan ini');
    }

    try {
        $bimbinganModel->delete($id);
        return redirect()->to('/mahasiswa/pilih-pembimbing')->with('success', 'Pengajuan berhasil dibatalkan dan dihapus');
    } catch (\Exception $e) {
        log_message('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengajuan');
    }
}


}
