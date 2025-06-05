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

    // Tampilkan daftar dosen pembimbing dengan mahasiswa bimbingannya
    // Tampilkan daftar dosen pembimbing   
    public function daftarDosen()
    {
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $dosenModel = new DosenPembimbingModel();

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }


        // Ambil parameter search & pagination
        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        // Ambil data mahasiswa + dosen
        $allMahasiswa = $mahasiswaModel->getMahasiswaWithDosen();
        if ($allMahasiswa instanceof \CodeIgniter\Model) {
            $allMahasiswa = $allMahasiswa->findAll();
        }

        // sort berdasarkan program studi
        $sortProdi = $this->request->getGet('sortProdi');
        if ($sortProdi && in_array($sortProdi, ['TI', 'TMJ', 'TMD'])) {
            $allMahasiswa = array_filter($allMahasiswa, function($m) use ($sortProdi) {
                return $m['program_studi'] === $sortProdi;
            });
            $allMahasiswa = array_values($allMahasiswa); // Reindex
        }
        
        $sortDosen = $this->request->getGet('sortDosen');
        if ($sortDosen !== null && $sortDosen !== '') {
            $allMahasiswa = array_filter($allMahasiswa, function ($m) use ($sortDosen, $bimbinganModel) {
                $dosenIds = array_column(
                    $bimbinganModel->where('mahasiswa_id', $m['mahasiswa_id'])->findAll(),
                    'dosen_id'
                );

                if ($sortDosen == '-1') {
                    // Belum ada dosen pembimbing
                    return empty($dosenIds);
                } else {
                    return in_array((int) $sortDosen, $dosenIds);
                }
            });
            $allMahasiswa = array_values($allMahasiswa); // Reindex
        }

        // Filter jika ada keyword
        if ($keyword) {
            $allMahasiswa = array_filter($allMahasiswa, function($m) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($m['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($m['nim']), $kw)
                    || str_contains(mb_strtolower($m['program_studi']), $kw)
                    || str_contains(mb_strtolower($m['kelas']), $kw)
                    || str_contains(mb_strtolower($m['nama_perusahaan'] ?? ''), $kw);
            });
            $allMahasiswa = array_values($allMahasiswa); // reindex
        }

        $total = count($allMahasiswa);
        $pagedMahasiswa = array_slice($allMahasiswa, $offset, $perPage);

        // Mahasiswa + dosen terpilih
        foreach ($pagedMahasiswa as &$m) {
            $m['dosen_terpilih'] = array_column(
                $bimbinganModel->where('mahasiswa_id', $m['mahasiswa_id'])->findAll(),
                'dosen_id'
            );
        }

        // Ambil semua dosen
        $listDosen = $dosenModel->findAll();
        
        // Buat map ID => nama
        $dosenMap = [];
        foreach ($listDosen as $dosen) {
            $dosenMap[$dosen['dosen_id']] = $dosen['nama_lengkap'];
        }

        // Tambahkan nama dospem ke data mahasiswa
        foreach ($pagedMahasiswa as &$m) {
            $m['nama_dospem1'] = $dosenMap[$m['dospem1']] ?? '-';
            $m['nama_dospem2'] = $dosenMap[$m['dospem2']] ?? '-';
            $m['nama_dospem3'] = $dosenMap[$m['dospem3']] ?? '-';
        }

        // Jumlah bimbingan per dosen
        $bimbinganCount = $bimbinganModel->select('dosen_id, COUNT(*) as total')
            ->groupBy('dosen_id')
            ->findAll();

        $bimbinganMap = [];
        foreach ($bimbinganCount as $bc) {
            $bimbinganMap[$bc['dosen_id']] = $bc['total'];
        }

        // Tambahkan total ke listDosen
        foreach ($listDosen as &$d) {
            $d['total_bimbingan'] = $bimbinganMap[$d['dosen_id']] ?? 0;
        }

        // Pager manual
        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('atur_bimbingan', [
            'mahasiswa' => $pagedMahasiswa,
            'pager' => $pager,
            'offset' => $offset,
            'listDosen' => $listDosen,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'sortProdi' => $sortProdi,
            'sortDosen' => $sortDosen,


        ]);
    }

    // Update pembagian dosen pembimbing
    public function updateDosen()
{
    $mahasiswaIds = $this->request->getPost('mahasiswa_id');
    $bimbinganModel = new Bimbingan();

    if (is_array($mahasiswaIds)) {
        foreach ($mahasiswaIds as $mahasiswaId) {
            $dosenId = $this->request->getPost('dosen_id_' . $mahasiswaId);

            if ($dosenId) {
                // Cek apakah ada entri bimbingan untuk mahasiswa ini
                $existingBimbingan = $bimbinganModel->where('mahasiswa_id', $mahasiswaId)->first();

                if ($existingBimbingan) {
                    // Update dosen pembimbing
                    $bimbinganModel->update($existingBimbingan['bimbingan_id'], [
                        'dosen_id' => $dosenId
                    ]);
                } else {
                    // Jika belum ada entri, tambahkan baru
                    $bimbinganModel->insert([
                        'mahasiswa_id' => $mahasiswaId,
                        'dosen_id'     => $dosenId
                    ]);
                }
            }
        }
    }

    return redirect()->to('admin/tambah-bimbingan')->with('success', 'Data pembimbing berhasil diperbarui.');
}


    // FORM TAMBAH BIMBINGAN (untuk multiple assignment)
    // public function tambahBimbingan()
    // {
    //     $mahasiswaModel = new MahasiswaModel();
    //     $dosenModel = new DosenPembimbingModel();

    //     $mahasiswa = $mahasiswaModel->findAll();
    //     $dosen = $dosenModel->findAll();

    //     return view('atur_bimbingan', [
    //         'mahasiswa' => $mahasiswa,
    //         'dosen' => $dosen
    //     ]);
    // }

    // // SIMPAN BIMBINGAN (untuk multiple assignment)
    // public function saveBimbingan()
    // {
    //     $bimbinganModel = new Bimbingan();

    //     $mahasiswa_id = $this->request->getPost('mahasiswa_id'); // array
    //     $dosen_id = $this->request->getPost('dosen_id');         // array

    //     $success = 0;
    //     $failed = 0;

    //     foreach ($mahasiswa_id as $index => $mhs_id) {
    //         $current_dosen_id = $dosen_id[$index] ?? null;

    //         // Validasi agar dosen dipilih
    //         if (!empty($current_dosen_id)) {
    //             // Cek apakah bimbingan sudah ada
    //             $existing = $bimbinganModel->where('mahasiswa_id', $mhs_id)
    //                 ->where('dosen_id', $current_dosen_id)
    //                 ->first();

    //             if (!$existing) {
    //                 $inserted = $bimbinganModel->insert([
    //                     'mahasiswa_id' => $mhs_id,
    //                     'dosen_id'     => $current_dosen_id
    //                 ]);

    //                 $inserted ? $success++ : $failed++;
    //             } else {
    //                 $success++; // Skip jika sudah ada
    //             }
    //         }
    //     }

    //     if ($success > 0) {
    //         return redirect()->to('/admin/tambah-bimbingan')->with('success', "$success bimbingan berhasil disimpan. $failed gagal.");
    //     } else {
    //         return redirect()->back()->with('error', 'Tidak ada data bimbingan yang berhasil disimpan.');
    //     }
    // }

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
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $dosenModel = new DosenPembimbingModel();
        $nilaiIndustriModel = new PenilaianIndustriModel();
        $nilaiDosenModel = new PenilaianDosenModel();
        $bimbinganModel = new Bimbingan(); // Relasi mahasiswa - dosen

        // Ambil data mahasiswa
        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
        if (!$mahasiswa) {
            return redirect()->to('/admin/nilai')->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Ambil data dosen pembimbing dari tabel bimbingan
        $bimbingan = $bimbinganModel->where('mahasiswa_id', $mahasiswa_id)->findAll();
        $dosenIds = array_column($bimbingan, 'dosen_id');
        $dosenPembimbing = [];
        if (!empty($dosenIds)) {
            $dosenPembimbing = $dosenModel->whereIn('dosen_id', $dosenIds)->findAll();
        }

        // Ambil nilai
        $nilai_industri = $nilaiIndustriModel->getNilaiByMahasiswa($mahasiswa_id);
        $nilai_dosen = $nilaiDosenModel->getNilaiByMahasiswa($mahasiswa_id);

        // Kirim data ke view
        return view('kps/detail_nilai_mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'dosen_pembimbing' => $dosenPembimbing,
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
            ->select('mahasiswa_id, nama_lengkap, nim, program_studi, kelas, nama_perusahaan')
            ->findAll();

        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        // Filter berdasarkan keyword
        if ($keyword) {
            $mahasiswaList = array_filter($mahasiswaList, function($mhs) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($mhs['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($mhs['nim']), $kw)
                    || str_contains(mb_strtolower($mhs['program_studi']), $kw)
                    || str_contains(mb_strtolower($mhs['kelas']), $kw)
                    || str_contains(mb_strtolower($mhs['nama_perusahaan'] ?? ''), $kw);
            });
            $mahasiswaList = array_values($mahasiswaList); // reindex
        }

        $total = count($mahasiswaList);
        $mahasiswaList = array_slice($mahasiswaList, $offset, $perPage);

        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        $data['pager'] = $pager;
        $data['keyword'] = $keyword;
        $data['perPage'] = $perPage;
        $data['offset'] = $offset;

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
