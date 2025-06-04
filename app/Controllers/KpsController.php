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
use App\Models\UserModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\PedomanMagangModel; // Pastikan ini sesuai dengan controller pedoman

class KpsController extends BaseController
{
    protected $kpsModel;

    public function __construct()
    {
        $this->kpsModel = new Kps(); // Inisialisasi model Kps
    }

    public function dashboard()
    {
        if (session()->get('role') !== 'kps') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $userModel = new UserModel();
        $kpsId = session()->get('kps_id');
        $kps = $this->kpsModel->find($kpsId);

        // Ambil jumlah user berdasarkan role
        $jumlahMahasiswa = $userModel->where('role', 'mahasiswa')->countAllResults();
        $jumlahDosen = $userModel->where('role', 'pembimbing_dosen')->countAllResults();
        $jumlahIndustri = $userModel->where('role', 'pembimbing_industri')->countAllResults();

        return view('kps/dashboard', [
            'title' => 'Dashboard Mahasiswa',
            'kps'   => $kps,
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahDosen' => $jumlahDosen,
            'jumlahIndustri' => $jumlahIndustri
        ]);
    }

    public function unduhPedomanMagang()
    {
        $pedomanModel = new \App\Models\PedomanMagangModel();
        $pedoman = $pedomanModel->orderBy('created_at', 'DESC')->first();

        if (!$pedoman || empty($pedoman['file_path']) || !file_exists(WRITEPATH . 'uploads/pedoman/' . $pedoman['file_path'])) {
            return redirect()->back()->with('error', 'File pedoman magang tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/pedoman/' . $pedoman['file_path'];
        return $this->response->download($filePath, null);
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

        if (session()->get('role') !== 'kps') {
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
            'sortProdi' => $sortProdi,
            'sortDosen' => $sortDosen,


        ]);
    }

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

        // Ambil dosen pembimbing
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

        // Ambil data logbook industri untuk mahasiswa terkait
        $data['logbook_industri'] = $logbookModel->where('mahasiswa_id', $mahasiswa_id)->findAll();

        // Ambil data mahasiswa
        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);

        // Jika mahasiswa tidak ditemukan, redirect dengan error
        if (!$data['mahasiswa']) {
            return redirect()->to('/kps/logbook-aktivitas')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Tampilkan view detail logbook industri beserta informasi mahasiswa
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
        $data['user_requirements'] = $requirementModel->where('mahasiswa_id', $mahasiswa_id)->findAll();
            // ->orderBy('created_at', 'DESC')->findAll();

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
        // Pastikan hanya kps yang bisa akses
        if (session()->get('role') !== 'kps') {
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

        return view('kps/list_nilai_mahasiswa', $data);
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

    public function downloadReviewExcel()
{
    $reviewModel = new ReviewKinerjaModel();
    $reviews = $reviewModel->findAll(); // ambil semua data

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $headers = [
        'No', 'Nama Mahasiswa', 'NIM', 'Nama Perusahaan', 'Nama Pembimbing Perusahaan', 'Jabatan', 'Divisi',
        'Integritas', 'Keahlian Bidang', 'Kemampuan Bahasa Inggris', 'Pengetahuan Bidang',
        'Komunikasi & Adaptasi', 'Kerja Sama', 'Kemampuan Belajar', 'Kreativitas', 'Menuangkan Ide',
        'Pemecahan Masalah', 'Sikap', 'Kerja di Bawah Tekanan', 'Manajemen Waktu', 'Bekerja Mandiri',
        'Negosiasi', 'Analisis', 'Bekerja dgn Budaya Berbeda', 'Kepemimpinan', 'Tanggung Jawab',
        'Presentasi', 'Menulis Dokumen', 'Saran Lulusan', 'Kemampuan Teknik Diperlukan',
        'Profesi Cocok', 'Created At'
    ];

    $sheet->fromArray($headers, null, 'A1');

    // Isi data
    $row = 2;
    foreach ($reviews as $i => $review) {
        $sheet->setCellValue('A' . $row, $i + 1);
        $sheet->setCellValue('B' . $row, $review['nama_mahasiswa']);
        $sheet->setCellValue('C' . $row, $review['nim'] ?? '-');
        $sheet->setCellValue('D' . $row, $review['nama_perusahaan']);
        $sheet->setCellValue('E' . $row, $review['nama_pembimbing_perusahaan']);
        $sheet->setCellValue('F' . $row, $review['jabatan']);
        $sheet->setCellValue('G' . $row, $review['divisi']);
        $sheet->setCellValue('H' . $row, $review['integritas']);
        $sheet->setCellValue('I' . $row, $review['keahlian_bidang']);
        $sheet->setCellValue('J' . $row, $review['kemampuan_bahasa_inggris']);
        $sheet->setCellValue('K' . $row, $review['pengetahuan_bidang']);
        $sheet->setCellValue('L' . $row, $review['komunikasi_adaptasi']);
        $sheet->setCellValue('M' . $row, $review['kerja_sama']);
        $sheet->setCellValue('N' . $row, $review['kemampuan_belajar']);
        $sheet->setCellValue('O' . $row, $review['kreativitas']);
        $sheet->setCellValue('P' . $row, $review['menuangkan_ide']);
        $sheet->setCellValue('Q' . $row, $review['pemecahan_masalah']);
        $sheet->setCellValue('R' . $row, $review['sikap']);
        $sheet->setCellValue('S' . $row, $review['kerja_dibawah_tekanan']);
        $sheet->setCellValue('T' . $row, $review['manajemen_waktu']);
        $sheet->setCellValue('U' . $row, $review['bekerja_mandiri']);
        $sheet->setCellValue('V' . $row, $review['negosiasi']);
        $sheet->setCellValue('W' . $row, $review['analisis']);
        $sheet->setCellValue('X' . $row, $review['bekerja_dengan_budaya_berbeda']);
        $sheet->setCellValue('Y' . $row, $review['kepemimpinan']);
        $sheet->setCellValue('Z' . $row, $review['tanggung_jawab']);
        $sheet->setCellValue('AA' . $row, $review['presentasi']);
        $sheet->setCellValue('AB' . $row, $review['menulis_dokumen']);
        $sheet->setCellValue('AC' . $row, $review['saran_lulusan']);
        $sheet->setCellValue('AD' . $row, $review['kemampuan_teknik_dibutuhkan']);
        $sheet->setCellValue('AE' . $row, $review['profesi_cocok']);
        $sheet->setCellValue('AF' . $row, $review['created_at']);
        $row++;
    }

    // Set response
    $filename = 'review_kinerja_mahasiswa_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
