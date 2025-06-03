<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\UserModel;
use App\Models\MahasiswaModel; // Memanggil model mahasiswa
use App\Models\DosenPembimbingModel; // Memanggil model dosen

class UploadUserController extends BaseController
{
    public function index()
    {
        return view('upload_user_excel');
    }

public function upload()
{
    $file = $this->request->getFile('excel_file');

    if (!$file->isValid()) {
        return redirect()->back()->with('message', 'File tidak valid.');
    }

    $spreadsheet = IOFactory::load($file->getTempName());
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    $userModel = new UserModel();
    $mahasiswaModel = new MahasiswaModel();
    $dosenModel = new DosenPembimbingModel();
    $bimbinganModel = new \App\Models\Bimbingan(); // Tambahkan ini

    $errors = [];
    $successCount = 0;

    foreach ($sheetData as $index => $row) {
        if ($index === 0) continue; // Skip header

        [$nama, $email, $password, $role, $nomor_induk, $prodi] = $row;

        if (!$nama || !$nomor_induk || !$password || !$role || !$email || !$prodi) {
            $errors[] = "Baris " . ($index + 1) . " tidak lengkap.";
            continue;
        }

        if ($userModel->where('email', $email)->first()) {
            $errors[] = "Baris " . ($index + 1) . ": Email $email sudah terdaftar.";
            continue;
        }

        $daftarProdi = ['TI', 'TMJ', 'TMD'];
        if (!in_array($prodi, $daftarProdi)) {
            $errors[] = "Baris " . ($index + 1) . ": Prodi $prodi tidak valid.";
            continue;
        }

        // Insert ke tabel users
        $userModel->insert([
            'nama'        => $nama,
            'email'       => $email,
            'password'    => password_hash($password, PASSWORD_DEFAULT),
            'role'        => strtolower($role),
            'nomor_induk' => $nomor_induk,
                'prodi'       => $prodi // ← Tambahkan ini

        ]);
        $userId = $userModel->insertID();

        // Insert ke tabel mahasiswa
        if (strtolower($role) === 'mahasiswa') {
            $mahasiswaModel->insert([
                'mahasiswa_id' => $userId,
                'nim' => $nomor_induk,
                'nama_lengkap' => $nama,
                'email' => $email,
                'program_studi'=> $prodi,
                'kelas' => '',
                'no_hp' => '',
                
                // kolom lainnya jika ada
            ]);

            // Insert ke tabel bimbingan
            $bimbinganModel->insert([
                'mahasiswa_id' => $userId,
                'dosen_id' => null // default NULL
            ]);
        }

        // Insert ke tabel dosen pembimbing
        if (strtolower($role) === 'dosen_pembimbing') {
            $dosenModel->insert([
                'dosen_id' => $userId,
                'nama_lengkap' => $nama,
                'nip' => $nomor_induk,
                'email' => $email,
                'no_telepon' => '', // Atur jika tersedia di Excel
                'link_whatsapp' => '',
                'prodi'         => $prodi
            ]);
        }

        $successCount++;
    }

    $message = "$successCount akun berhasil diimport.";
    if (!empty($errors)) {
        $message .= "<br>Beberapa baris gagal:<br>" . implode("<br>", $errors);
    }

    return redirect()->back()->with('message', $message);
}

}
