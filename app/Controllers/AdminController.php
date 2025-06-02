<?php

namespace App\Controllers;

use App\Models\MahasiswaModel; // Untuk mengambil data mahasiswa
use App\Models\DosenPembimbingModel; // Untuk mengambil data dosen
use App\Models\BimbinganModel; // Model relasi bimbingan
use App\Models\PembimbingIndustriModel;
use App\Models\Bimbingan; // untuk dosen
use App\Models\BimbinganIndustriModel; // untuk industri
use App\Models\PembimbingIndustri;
use App\Models\PenilaianDosenModel;
use App\Models\PenilaianIndustriModel;
use App\Models\UserModel; // Untuk mengambil data user
use App\Models\PedomanMagangModel;

class AdminController extends BaseController
{


    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $userModel = new UserModel();

        // Ambil jumlah user berdasarkan role
        $jumlahMahasiswa = $userModel->where('role', 'mahasiswa')->countAllResults();
        $jumlahDosen = $userModel->where('role', 'pembimbing_dosen')->countAllResults();
        $jumlahIndustri = $userModel->where('role', 'pembimbing_industri')->countAllResults();

        return view('admin_dashboard', [
            'title' => 'Dashboard Mahasiswa',
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahDosen' => $jumlahDosen,
            'jumlahIndustri' => $jumlahIndustri
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

//fungsi untuk memasukkan pedoman magang
public function uploadPedoman()
{
    $file = $this->request->getFile('file_pedoman');
    $judul = $this->request->getPost('judul');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move('uploads/pedoman', $newName);

        $pedomanModel = new PedomanMagangModel();

        // Hapus file lama jika ada
        $lama = $pedomanModel->first();
        if ($lama) {
            if (file_exists($lama['file_path'])) {
                unlink($lama['file_path']);
            }
            $pedomanModel->delete($lama['id']);
        }

        $pedomanModel->insert([
            'judul' => $judul,
            'file_path' => '' . $newName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'File pedoman berhasil diupload.');
    }

    return redirect()->back()->with('error', 'Gagal mengupload file.');
}

public function deletePedoman($id)
{
    $pedomanModel = new PedomanMagangModel();
    $data = $pedomanModel->find($id);

    if ($data) {
        if (file_exists($data['file_path'])) {
            unlink($data['file_path']);
        }
        $pedomanModel->delete($id);
        return redirect()->back()->with('success', 'File pedoman berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'File tidak ditemukan.');
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

    public function daftarUser()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('daftar_user', $data);
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();

        // Cek apakah user ada
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/daftar_user')->with('error', 'User tidak ditemukan.');
        }

        // Hapus user
        $userModel->delete($id);
        return redirect()->to('/admin/daftar_user')->with('success', 'User berhasil dihapus.');
    }

    //paginasi
    public function daftarMahasiswa()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();

        // Ambil jumlah per halaman dari GET, default 10
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10; // fallback jika isian tak valid
        }

        $keyword = $this->request->getGet('keyword');


        if ($keyword) {
            $mahasiswaModel->groupStart()
                ->like('nama_lengkap', $keyword)
                ->orLike('nim', $keyword)
                ->orLike('email', $keyword)
                ->orLike('program_studi', $keyword)
                ->orLike('kelas', $keyword)
                ->orLike('no_hp', $keyword)
                ->orLike('nama_perusahaan', $keyword)
                ->orLike('judul_magang', $keyword)
                ->groupEnd();
        }

        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        $data = [
            'mahasiswa' => $mahasiswaModel->paginate($perPage, 'default'),
            'pager'     => $mahasiswaModel->pager,
            'offset'    => $offset,
            'keyword'   => $keyword,
            'perPage'   => $perPage, // Kirim ke view
        ];

        return view('daftar_mahasiswa', $data);
    }





    public function detail_nilai($mahasiswa_id)
    {
        // Validasi role admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $nilaiIndustriModel = new PenilaianIndustriModel();
        $nilaiDosenModel = new PenilaianDosenModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
        $nilai_industri = $nilaiIndustriModel->getNilaiByMahasiswa($mahasiswa_id);
        $nilai_dosen = $nilaiDosenModel->getNilaiByMahasiswa($mahasiswa_id);

        if (!$mahasiswa) {
            return redirect()->to('/admin/nilai')->with('error', 'Mahasiswa tidak ditemukan.');
        }

        return view('detail_nilai_mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'nilai_industri' => $nilai_industri,
            'nilai_dosen' => $nilai_dosen
        ]);
    }
    public function listNilaiMahasiswa()
    {
        // Pastikan hanya admin yang bisa akses
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $penilaianDosenModel = new PenilaianDosenModel();
        $penilaianIndustriModel = new PenilaianIndustriModel();

        // Ambil semua data mahasiswa beserta total nilai akhir
        $mahasiswaList = $mahasiswaModel
            ->select('mahasiswa_id, nama_lengkap, nim, program_studi, nama_perusahaan')
            ->findAll();

        // Gabungkan dengan nilai dosen, industri, dan hitung total nilai
        foreach ($mahasiswaList as &$mhs) {
            $nilaiDosen = $penilaianDosenModel->getNilaiByMahasiswa($mhs['mahasiswa_id']);
            $nilaiIndustri = $penilaianIndustriModel->getNilaiByMahasiswa($mhs['mahasiswa_id']);

            $mhs['nilai_dosen'] = $nilaiDosen;
            $mhs['nilai_industri'] = $nilaiIndustri;

            // Hitung total nilai akhir (60% industri + 40% dosen)
            $totalNilaiDosen = $nilaiDosen ? $nilaiDosen['total_nilai'] : 0;
            $totalNilaiIndustri = $nilaiIndustri ? $nilaiIndustri['total_nilai_industri'] : 0;
            $mhs['total_nilai'] = ($totalNilaiIndustri * 0.6) + ($totalNilaiDosen * 0.4);
        }

        $data['mahasiswa_list'] = $mahasiswaList;

        return view('list_nilai_mahasiswa', $data);
    }
}
