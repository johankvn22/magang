<?php

namespace App\Controllers;

use App\Models\DosenPembimbingModel; // Memanggil model dosen pembimbing
use CodeIgniter\Exceptions\PageNotFoundException; // Untuk menangani exception

class DosenPembimbingController extends BaseController
{
    public function index()
    {
        $dosenModel = new DosenPembimbingModel(); // Membuat instance dari model
        $userId = session()->get('user_id'); // Mengambil user_id dari session

        // Mencari dosen berdasarkan user_id
        $dosen = $dosenModel->where('dosen_id', $userId)->first();

        // Memastikan data dosen ditemukan
        if (!$dosen) {
            return redirect()->to('/login')->with('error', 'Data dosen tidak ditemukan.'); // Redirect jika tidak ditemukan
        }
        // Mengembalikan view dashboard dengan data dosen
        return view('dosen/dashboard', ['dosen' => $dosen]);
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

        return redirect()->to('/dosen/dashboard')->with('success', 'Profil berhasil diperbarui.');
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
