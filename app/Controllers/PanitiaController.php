<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Panitia;
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingModel;
use App\Models\Bimbingan;
use App\Models\LogbookBimbingan;
use App\Models\LogbookIndustri;
use App\Models\PenilaianDosenModel;
use App\Models\PenilaianIndustriModel;
use App\Models\UserRequirement;
use App\Models\ReviewKinerjaModel;

class PanitiaController extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login dan role-nya panitia
        if (session()->get('logged_in') && session()->get('role') === 'panitia') {
            return view('panitia/dashboard');
        } else {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }
    }

    public function editProfil()
    {
        $userModel = new Panitia();
        $user = $userModel->find(session()->get('panitia_id'));
        return view('panitia/edit_profil', ['panitia' => $user]);
    }


    public function updateProfil()
    {
        $userModel = new Panitia();
        $data = [
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon')
        ];

        $userModel->update(session()->get('user_id'), $data);
        return redirect()->to('/panitia/dashboard')->with('message', 'Profil berhasil diperbarui!');
    }

    public function gantiPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $panitiaId = session()->get('panitia_id');
            $newPassword = $this->request->getPost('password');

            // Enkripsi password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $panitiaModel = new \App\Models\Panitia(); // Pastikan model sudah sesuai
            $panitiaModel->update($panitiaId, ['password' => $hashedPassword]);

            return redirect()->to('/panitia/dashboard')->with('success', 'Password berhasil diganti.');
        }

        return view('panitia/ganti_password', [
            'title' => 'Ganti Password'
        ]);
    }

    public function daftarDosen()
    {
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $dosenModel = new DosenPembimbingModel();

        // Pagination setup
        $perPage = 10;
        $data['mahasiswa'] = $mahasiswaModel->getMahasiswaWithDosen()->paginate($perPage, 'default');
        $data['pager'] = $mahasiswaModel->pager;

        // Hitung offset
        $currentPage = $data['pager']->getCurrentPage('default');
        $data['offset'] = ($currentPage - 1) * $perPage;

        // Ambil semua dosen
        $data['listDosen'] = $dosenModel->findAll();

        // Ambil dosen pembimbing masing-masing mahasiswa
        foreach ($data['mahasiswa'] as &$m) {
            $m['dosen_terpilih'] = array_column(
                $bimbinganModel->where('mahasiswa_id', $m['mahasiswa_id'])->findAll(),
                'dosen_id'
            );
        }

        // Hitung total bimbingan per dosen
        $bimbinganCount = $bimbinganModel->select('dosen_id, COUNT(*) as total')
            ->groupBy('dosen_id')
            ->findAll();

        $bimbinganMap = [];
        foreach ($bimbinganCount as $bc) {
            $bimbinganMap[$bc['dosen_id']] = $bc['total'];
        }

        foreach ($data['listDosen'] as &$d) {
            $d['total_bimbingan'] = $bimbinganMap[$d['dosen_id']] ?? 0;
        }

        return view('panitia/daftar_dosen', $data); // Ganti sesuai nama view untuk panitia
    }

    public function updateDosen()
    {
        $mahasiswaIds = $this->request->getPost('mahasiswa_id');
        $bimbinganModel = new Bimbingan();

        if (is_array($mahasiswaIds)) {
            foreach ($mahasiswaIds as $mahasiswaId) {
                $dosenId = $this->request->getPost('dosen_id_' . $mahasiswaId);

                if ($dosenId) {
                    // Hapus pembimbing lama hanya untuk mahasiswa ini
                    $bimbinganModel->where('mahasiswa_id', $mahasiswaId)->delete();

                    // Simpan dosen baru
                    $bimbinganModel->insert([
                        'mahasiswa_id' => $mahasiswaId,
                        'dosen_id'     => $dosenId
                    ]);
                }
            }
        }

        return redirect()->to('panitia/daftar-dosen')->with('success', 'Data pembimbing berhasil diperbarui.');
    }



    public function daftarMahasiswa()
    {
        if (session()->get('role') !== 'panitia') {
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

        return view('panitia/daftar_mahasiswa', $data);
    }

    public function logbookMahasiswa()
    {
        if (session()->get('role') !== 'panitia') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithStatus(); // method sama seperti admin
        return view('panitia/logbook_mahasiswa', $data);
    }

    public function detailLogbook($id)
    {
        if (session()->get('role') !== 'panitia') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $logbookModel = new LogbookBimbingan();
        $data['logbook'] = $logbookModel->where('mahasiswa_id', $id)->findAll();
        return view('panitia/detail_logbook', $data);
    }

    public function logbookAktivitas()
    {
        if (session()->get('role') !== 'panitia') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $model = new MahasiswaModel();
        $logbookIndustriModel = new LogbookIndustri();

        // 1. Ambil semua data mahasiswa dengan status industri
        $allData = $model->getMahasiswaWithStatusIndustri();

        // Tambahkan jumlah logbook aktivitas disetujui untuk setiap mahasiswa
        foreach ($allData as &$mhs) {
            $mhs['jumlah_aktivitas_disetujui'] = $logbookIndustriModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }

        // 2. Ambil parameter pencarian dan pagination
        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (! in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);

        // 3. Filter data jika keyword pencarian tersedia
        if ($keyword) {
            $allData = array_filter($allData, function ($mhs) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($mhs['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($mhs['nim']), $kw)
                    || str_contains(mb_strtolower($mhs['program_studi']), $kw)
                    || str_contains(mb_strtolower($mhs['kelas']), $kw)
                    || str_contains(mb_strtolower($mhs['status']), $kw);
            });
            $allData = array_values($allData); // reindex array
        }

        // 4. Hitung total dan data sesuai halaman
        $total     = count($allData);
        $offset    = ($currentPage - 1) * $perPage;
        $pagedData = array_slice($allData, $offset, $perPage);

        // 5. Buat pager manual
        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // 6. Kirim ke view
        return view('panitia/logbook_aktivitas_mahasiswa', [
            'mahasiswa' => $pagedData,
            'pager'     => $pager,
            'offset'    => $offset,
            'perPage'   => $perPage,
            'keyword'   => $keyword,
        ]);
    }

    public function detailAktivitas($mahasiswa_id)
    {
        if (session()->get('role') !== 'panitia') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $logbookModel = new LogbookIndustri();
        $mahasiswaModel = new MahasiswaModel();

        $data['logbook_industri'] = $logbookModel->where('mahasiswa_id', $mahasiswa_id)->orderBy('created_at', 'DESC')->findAll();
        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);

        return view('panitia/detail_logbook_industri', $data);
    }

    // Tampilkan daftar user requirement seluruh mahasiswa
    public function userRequirement()
    {
        $model = new UserRequirement();

        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }

        $dataAll = $model->getMahasiswaPengisiRequirement();

        // Filter berdasarkan keyword
        if ($keyword) {
            $dataAll = array_filter($dataAll, function ($item) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw);
            });
            $dataAll = array_values($dataAll); // reindex
        }

        $total = count($dataAll);
        $pagedData = array_slice($dataAll, $offset, $perPage);

        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('panitia/user_requirement_mahasiswa', [
            'mahasiswaList' => $pagedData,
            'pager' => $pager,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'offset' => $offset,
        ]);
    }

    // Detail user requirement per mahasiswa
    public function detail($mahasiswa_id)
    {
        $requirementModel = new UserRequirement();
        $mahasiswaModel = new MahasiswaModel();

        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);
        $data['user_requirements'] = $requirementModel->where('mahasiswa_id', $mahasiswa_id)
            ->orderBy('created_at', 'DESC')->findAll();

        return view('panitia/detail_user_requirement', $data);
    }

    public function listReview()
    {
        $reviewModel = new ReviewKinerjaModel();
        $listReview = $reviewModel->getAll(); // pastikan sudah join ke mahasiswa

        return view('panitia/list_review', ['reviews' => $listReview]);
    }

    public function detailReview($id)
    {
        $reviewModel = new ReviewKinerjaModel();
        $review = $reviewModel->getDetail($id);

        if (!$review) {
            return redirect()->to('/kps/review-kinerja')->with('error', 'Review tidak ditemukan.');
        }

        return view('panitia/detail_review', ['review_id' => $review]);
    }

    // Di dalam PanitiaController
    public function listNilaiMahasiswa()
    {
        // Pastikan hanya kps yang bisa akses
        if (session()->get('role') !== 'panitia') {
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
            $mahasiswaList = array_filter($mahasiswaList, function ($mhs) use ($keyword) {
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

        return view('panitia/list_nilai_mahasiswa', $data);
    }

    public function detail_nilai($mahasiswa_id)
    {
        if (session()->get('role') !== 'panitia') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $nilaiIndustriModel = new PenilaianIndustriModel();
        $nilaiDosenModel = new PenilaianDosenModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
        $nilai_industri = $nilaiIndustriModel->getNilaiByMahasiswa($mahasiswa_id);
        $nilai_dosen = $nilaiDosenModel->getNilaiByMahasiswa($mahasiswa_id);

        if (!$mahasiswa) {
            return redirect()->to('/panitia/nilai')->with('error', 'Mahasiswa tidak ditemukan.');
        }

        return view('panitia/detail_nilai_mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'nilai_industri' => $nilai_industri,
            'nilai_dosen' => $nilai_dosen
        ]);
    }
}
