<?php

namespace App\Controllers;

use App\Models\MahasiswaModel; // Untuk mengambil data mahasiswa
use App\Models\DosenPembimbingModel; // Untuk mengambil data dosen
use App\Models\BimbinganModel; // Model relasi bimbingan
use App\Models\PembimbingIndustriModel;
use App\Models\Bimbingan; // untuk dosen
use App\Models\BimbinganIndustriModel; // untuk industri
use App\Models\PembimbingIndustri;

class AdminController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        return view('admin_dashboard', [
        'title' => 'Dashboard Mahasiswa',
    ]);
    }

   // FORM BIMBINGAN DOSEN
    public function tambahBimbingan()
    {
        $mahasiswaModel = new MahasiswaModel();
        $dosenModel = new DosenPembimbingModel();

        $mahasiswa = $mahasiswaModel->findAll();
        $dosen = $dosenModel->findAll();

        return view('atur_bimbingan', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen
        ]);
    }


    public function saveBimbingan()
    {
        $bimbinganModel = new Bimbingan(); // model untuk relasi bimbingan_dosen

        $mahasiswa_id = $this->request->getPost('mahasiswa_id'); // array
        $dosen_id = $this->request->getPost('dosen_id');         // array

        $success = 0;
        $failed = 0;

        foreach ($mahasiswa_id as $index => $mhs_id) {
            $dosen_id = $dosen_id[$index];

            // Validasi agar dosen dipilih
            if (!empty($dosen_id)) {
                $inserted = $bimbinganModel->insert([
                    'mahasiswa_id' => $mhs_id,
                    'dosen_id'     => $dosen_id
                ]);

                $inserted ? $success++ : $failed++;
            }
        }

        if ($success > 0) {
            return redirect()->to('/admin/tambah-bimbingan')->with('success', "$success bimbingan berhasil disimpan. $failed gagal.");
        } else {
            return redirect()->back()->with('error', 'Tidak ada data bimbingan yang berhasil disimpan.');
        }
    }


    // 🔽 FORM BIMBINGAN INDUSTRI
    public function tambahBimbinganIndustri()
    {
        $mahasiswaModel = new MahasiswaModel();
        $pembimbingModel = new PembimbingIndustri();

        $mahasiswa = $mahasiswaModel->findAll();
        $pembimbing = $pembimbingModel->findAll();

        return view('atur_bimbingan_industri', [
            'mahasiswa' => $mahasiswa,
            'pembimbing' => $pembimbing
        ]);
    }

    public function saveBimbinganIndustri()
    {
        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $pembimbing_id = $this->request->getPost('pembimbing_id');

        $mahasiswaModel = new MahasiswaModel();
        $pembimbingModel = new PembimbingIndustri();
        $bimbinganModel = new BimbinganIndustriModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
        $pembimbing = $pembimbingModel->find($pembimbing_id);

        if (!$mahasiswa || !$pembimbing) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // Validasi kecocokan perusahaan
        if (strtolower($mahasiswa['nama_perusahaan']) !== strtolower($pembimbing['perusahaan'])) {
            return redirect()->back()->with('error', 'Perusahaan tidak cocok antara mahasiswa dan pembimbing industri.');
        }

        // Simpan relasi ke tabel bimbingan_industri
        if ($bimbinganModel->insert([
            'mahasiswa_id' => $mahasiswa_id,
            'pembimbing_id' => $pembimbing_id
        ])) {
            return redirect()->to('/admin')->with('success', 'Bimbingan industri berhasil ditentukan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data bimbingan industri.');
        }
    }


    // public function tambahBimbingan()
    // {
    //     $mahasiswaModel = new MahasiswaModel();
    //     $dosenModel = new DosenPembimbingModel();

    //     $mahasiswa = $mahasiswaModel->findAll(); // Ambil semua mahasiswa
    //     $dosen = $dosenModel->findAll(); // Ambil semua dosen

    //     return view('/atur_bimbingan', ['mahasiswa' => $mahasiswa, 'dosen' => $dosen]);
    // }

    // public function saveBimbingan()
    // {
    //     $bimbinganModel = new Bimbingan(); // gunakan model relasi bimbingan_dosen

    //     $data = [
    //         'mahasiswa_id' => $this->request->getPost('mahasiswa_id'), // ID mahasiswa
    //         'dosen_id'     => $this->request->getPost('dosen_id'), // ID dosen
    //     ];

    //     // Simpan data ke dalam tabel bimbingan
    //     if ($bimbinganModel->insert($data)) {
    //         return redirect()->to('/admin')->with('success', 'Bimbingan berhasil ditentukan.');
    //     } else {
    //         return redirect()->back()->with('error', 'Gagal menentukan bimbingan.');
    //     }
    // }

    //  // FORM BIMBINGAN INDUSTRI
    //  public function tambahBimbinganIndustri()
    //  {
    //      $mahasiswaModel = new MahasiswaModel();
    //      $pembimbingModel = new PembimbingIndustri();
 
    //      $mahasiswa = $mahasiswaModel->findAll();
    //      $pembimbing = $pembimbingModel->findAll();
 
    //      return view('atur_bimbingan_industri', [
    //          'mahasiswa' => $mahasiswa,
    //          'pembimbing' => $pembimbing
    //      ]);
    //  }
 
    //  public function saveBimbinganIndustri()
    //  {
    //      $mahasiswa_id = $this->request->getPost('mahasiswa_id');
    //      $pembimbing_id = $this->request->getPost('pembimbing_id');
 
    //      $mahasiswaModel = new MahasiswaModel();
    //      $pembimbingModel = new PembimbingIndustri();
    //      $bimbinganModel = new BimbinganIndustriModel();
 
    //      $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
    //      $pembimbing = $pembimbingModel->find($pembimbing_id);
 
    //      if (!$mahasiswa || !$pembimbing) {
    //          return redirect()->back()->with('error', 'Data tidak valid');
    //      }
 
    //     // Validasi kecocokan perusahaan
    //     // if (strtolower($mahasiswa->nama_perusahaan) !== strtolower($pembimbing->perusahaan)) {
    //     //      return redirect()->back()->with('error', 'Perusahaan tidak cocok antara mahasiswa dan pembimbing industri.');
    //     //  }
 
    //      // Simpan relasi ke tabel bimbingan_industri
    //      if ($bimbinganModel->insert([
    //          'mahasiswa_id' => $mahasiswa_id,
    //          'pembimbing_id' => $pembimbing_id
    //      ])) {
    //          return redirect()->to('/admin')->with('success', 'Bimbingan industri berhasil ditentukan.');
    //      } else {
    //          return redirect()->back()->with('error', 'Gagal menyimpan data bimbingan industri.');
    //      }
    //  }

    public function daftarUser()
    {
        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->findAll();
        return view('daftar_user', $data);
    }   

    public function deleteUser($id)
    {
        $userModel = new \App\Models\UserModel();

        // Cek apakah user ada
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/daftar_user')->with('error', 'User tidak ditemukan.');
        }

        // Hapus user
        $userModel->delete($id);
        return redirect()->to('/admin/daftar_user')->with('success', 'User berhasil dihapus.');
    }

    //daftar review mahasiswa 
    //paginasi
    public function daftarMahasiswa()
    {
        if (session()->get('role') !== 'admin') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $perPage = 10;

        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $data['mahasiswa'] = $mahasiswaModel->paginate($perPage);
        $data['pager'] = $mahasiswaModel->pager;
        $data['offset'] = $offset;

        return view('daftar_mahasiswa', $data);
    }




    



}
