<?php

namespace App\Controllers;

use App\Models\Kps; // Pastikan menggunakan model Kps yang tepat
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingModel;
use App\Models\Bimbingan;
use App\Models\LogbookBimbingan;
use App\Models\LogbookIndustri;
use App\Models\PenilaianDosenModel;
use App\Models\PenilaianIndustriModel;
use App\Models\UserRequirement;
use App\Models\ReviewKinerjaModel;

class KpsController extends BaseController
{
    protected $kpsModel;

    public function __construct()
    {
        $this->kpsModel = new Kps(); // Inisialisasi model Kps
    }

    public function dashboard()
    {
        $kpsId = session()->get('kps_id');
        if (!$kpsId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid.');
        }

        $kps = $this->kpsModel->find($kpsId);
        if (!$kps) {
            return redirect()->to('/login')->with('error', 'Data KPS tidak ditemukan.');
        }

        return view('kps/dashboard', [
            'title' => 'Dashboard KPS',
            'kps'   => $kps
        ]);
    }

    public function editProfile()
    {
        helper('form'); // Tambahkan helper form
        $kpsModel = new Kps();
        $kpsId = session()->get('kps_id');

        // Ambil data KPS
        $kps = $this->kpsModel->find($kpsId);
        $kps = $kpsModel->where('kps_id', $kpsId)->first();

        if (!$kps) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('kps/edit_profile', [
            'title' => 'Edit Profil',
            'kps'   => $kps
        ]);
    }

    public function updateProfile()
    {
        $kpsModel = new Kps();
        $userId = session()->get('user_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required',
            'email' => 'required|valid_email',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        $kpsModel->update($userId, [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'nip' => $this->request->getPost('nip'),
            'no_telepon' => $this->request->getPost('no_telepon'),
        ]);

        return redirect()->to('/kps/dashboard')->with('success', 'Profil berhasil diperbarui.');
    }

    public function gantiPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $kpsId = session()->get('kps_id');
            $newPassword = $this->request->getPost('password');

            // Enkripsi password (disesuaikan dengan implementasi aslinya)
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $this->kpsModel->update($kpsId, ['password' => $hashedPassword]);

            return redirect()->to('/kps/profil')->with('success', 'Password berhasil diganti.');
        }

        return view('kps/ganti_password', [
            'title' => 'Ganti Password'
        ]);
    }

    // Tampilkan daftar dosen pembimbing   
    public function daftarDosen()
    {
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $dosenModel = new DosenPembimbingModel();

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

        return view('kps/daftar_dosen', [
            'mahasiswa' => $pagedMahasiswa,
            'pager' => $pager,
            'offset' => $offset,
            'listDosen' => $listDosen,
            'keyword' => $keyword,
            'perPage' => $perPage,
        ]);
    }

    // public function updateDosen()
    // {
    //     $mahasiswaIds = $this->request->getPost('mahasiswa_id');
    //     $bimbinganModel = new Bimbingan();

    //     if (is_array($mahasiswaIds)) {
    //         foreach ($mahasiswaIds as $mahasiswaId) {
    //             // Hapus pembimbing lama
    //             $bimbinganModel->where('mahasiswa_id', $mahasiswaId)->delete();

    //             // Ambil dosen baru dari input
    //             $dosenId = $this->request->getPost('dosen_id_' . $mahasiswaId);
    //             if (!empty($dosenId)) {
    //                 $bimbinganModel->insert([
    //                     'mahasiswa_id' => $mahasiswaId,
    //                     'dosen_id' => $dosenId
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->to('kps/daftar-dosen')->with('success', 'Semua data pembimbing diperbarui.');
    // }

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

        return redirect()->to('kps/daftar-dosen')->with('success', 'Data pembimbing berhasil diperbarui.');
    }

    // Tampilkan daftar mahasiswa
    public function daftarMahasiswa()
    {
        if (session()->get('role') !== 'kps') {
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

        return view('kps/daftar_mahasiswa', $data);
    }

    public function logbookMahasiswa()
    {
        // Pastikan hanya KPS yang bisa akses
        if (session()->get('role') !== 'kps') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $model = new MahasiswaModel();
        $logbookModel   = new LogbookBimbingan();

        // 1. Ambil semua data mahasiswa + status
        $allData = $model->getMahasiswaWithStatus();

            // Tambahkan jumlah bimbingan diverifikasi ke setiap mahasiswa
        foreach ($allData as &$mhs) {
            $mhs['jumlah_verifikasi'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }

        // 2. Ambil parameter search & perPage dari query string
        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (! in_array($perPage, [5,10,25,50,100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);

        // 3. Filter data jika ada keyword
        if ($keyword) {
            $allData = array_filter($allData, function($mhs) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($mhs['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($mhs['nim']), $kw)
                    || str_contains(mb_strtolower($mhs['program_studi']), $kw)
                    || str_contains(mb_strtolower($mhs['kelas']), $kw)
                    || str_contains(mb_strtolower($mhs['status']), $kw);
            });
            // reindex array agar pagination benar
            $allData = array_values($allData);
        }

        // 4. Hitung total & slice untuk pagination
        $total      = count($allData);
        $offset     = ($currentPage - 1) * $perPage;
        $pagedData  = array_slice($allData, $offset, $perPage);

        // 5. Buat pager manual
        $pager = \Config\Services::pager();
        // 'default_full' bisa diganti ke template pager custom-mu
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // 6. Kirim ke view
        return view('kps/logbook_mahasiswa', [
            'mahasiswa' => $pagedData,
            'pager'     => $pager,
            'offset'    => $offset,
            'perPage'   => $perPage,
            'keyword'   => $keyword,
        ]);
    }


    public function detailLogbook($id)
    {
        $logbookModel = new LogbookBimbingan();
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $dosenModel = new DosenPembimbingModel();

        // Ambil data logbook
        $data['logbook'] = $logbookModel->where('mahasiswa_id', $id)->findAll();

        // Ambil data mahasiswa
        $data['mahasiswa'] = $mahasiswaModel->find($id);

        // Ambil dosen pembimbing (bisa lebih dari satu)
        $bimbingan = $bimbinganModel->where('mahasiswa_id', $id)->findAll();
        $dosenIds = array_column($bimbingan, 'dosen_id');
        $data['dosen_pembimbing'] = [];
        if (!empty($dosenIds)) {
            $data['dosen_pembimbing'] = $dosenModel->whereIn('dosen_id', $dosenIds)->findAll();
        }

        return view('kps/detail_logbook', $data);
    }
    public function logbookAktivitas()
    {
        // Hanya role KPS yang bisa mengakses
        if (session()->get('role') !== 'kps') {
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
            $allData = array_filter($allData, function($mhs) use ($keyword) {
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
        return view('kps/logbook_aktivitas_mahasiswa', [
            'mahasiswa' => $pagedData,
            'pager'     => $pager,
            'offset'    => $offset,
            'perPage'   => $perPage,
            'keyword'   => $keyword,
        ]);
    }

    public function detailAktivitas($mahasiswa_id)
    {
        $logbookModel = new LogbookIndustri();
        $mahasiswaModel = new MahasiswaModel();

        $data['logbook_industri'] = $logbookModel->where('mahasiswa_id', $mahasiswa_id)->orderBy('created_at', 'DESC')->findAll();
        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);

        return view('kps/detail_logbook_industri', $data);
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

        return view('kps/user_requirement_mahasiswa', [
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

        return view('kps/detail_user_requirement', $data);
    }

    public function listReview()
    {
        $reviewModel = new ReviewKinerjaModel();

        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }

        $allReviews = $reviewModel->getAll(); // pastikan sudah join ke mahasiswa

        // Filter berdasarkan keyword
        if ($keyword) {
            $allReviews = array_filter($allReviews, function ($item) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($item['nama_mahasiswa'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nim'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nama_perusahaan'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nama_pembimbing_perusahaan'] ?? ''), $kw);
            });
            $allReviews = array_values($allReviews); // reindex
        }

        $total = count($allReviews);
        $pagedData = array_slice($allReviews, $offset, $perPage);

        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('kps/list_review', [
            'reviews' => $pagedData,
            'pager' => $pager,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'offset' => $offset,
        ]);
    }

    public function detailReview($id)
    {
        $reviewModel = new ReviewKinerjaModel();
        $review = $reviewModel->getDetail($id);

        if (!$review) {
            return redirect()->to('/kps/review-kinerja')->with('error', 'Review tidak ditemukan.');
        }

        return view('kps/detail_review', ['review_id' => $review]); // fix: gunakan key 'review_id'
    }
    // Di dalam KpsController
    public function listNilaiMahasiswa()
    {
        if (session()->get('role') !== 'kps') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $penilaianDosenModel = new PenilaianDosenModel();
        $penilaianIndustriModel = new PenilaianIndustriModel();

        $mahasiswaList = $mahasiswaModel
            ->select('mahasiswa_id, nama_lengkap, nim, program_studi, nama_perusahaan')
            ->findAll();

        foreach ($mahasiswaList as &$mhs) {
            $mhs['nilai_dosen'] = $penilaianDosenModel->getNilaiByMahasiswa($mhs['mahasiswa_id']);
            $mhs['nilai_industri'] = $penilaianIndustriModel->getNilaiByMahasiswa($mhs['mahasiswa_id']);
        }

        return view('kps/list_nilai_mahasiswa', ['mahasiswa_list' => $mahasiswaList]);
    }

    public function detail_nilai($mahasiswa_id)
    {
        if (session()->get('role') !== 'kps') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $nilaiIndustriModel = new PenilaianIndustriModel();
        $nilaiDosenModel = new PenilaianDosenModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswa_id);
        $nilai_industri = $nilaiIndustriModel->getNilaiByMahasiswa($mahasiswa_id);
        $nilai_dosen = $nilaiDosenModel->getNilaiByMahasiswa($mahasiswa_id);

        if (!$mahasiswa) {
            return redirect()->to('/kps/nilai')->with('error', 'Mahasiswa tidak ditemukan.');
        }

        return view('kps/detail_nilai_mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'nilai_industri' => $nilai_industri,
            'nilai_dosen' => $nilai_dosen
        ]);
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
