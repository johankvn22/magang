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

        // Pagination setup
        $perPage = 10;
        $data['mahasiswa'] = $mahasiswaModel->getMahasiswaWithDosen()->paginate($perPage, 'default');
        $data['pager'] = $mahasiswaModel->pager;

        // Hitung offset untuk penomoran
        $currentPage = $data['pager']->getCurrentPage('default');
        $data['offset'] = ($currentPage - 1) * $perPage;

        // Ambil semua dosen
        $data['listDosen'] = $dosenModel->findAll();

        // Mahasiswa + dosen terpilih
        foreach ($data['mahasiswa'] as &$m) {
            $m['dosen_terpilih'] = array_column(
                $bimbinganModel->where('mahasiswa_id', $m['mahasiswa_id'])->findAll(),
                'dosen_id'
            );
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
        foreach ($data['listDosen'] as &$d) {
            $d['total_bimbingan'] = $bimbinganMap[$d['dosen_id']] ?? 0;
        }

        return view('kps/daftar_dosen', $data);
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
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithStatus(); // method sama seperti admin
        return view('kps/logbook_mahasiswa', $data);
    }

    public function detailLogbook($id)
    {
        $logbookModel = new LogbookBimbingan();
        $data['logbook'] = $logbookModel->where('mahasiswa_id', $id)->findAll();
        return view('kps/detail_logbook', $data);
    }

    public function logbookAktivitas()
    {
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithStatusIndustri(); // method sama
        return view('kps/logbook_aktivitas_mahasiswa', $data);
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
        $requirementModel = new UserRequirement();
        $data['mahasiswaList'] = $requirementModel->getMahasiswaPengisiRequirement(); // model dan method sekarang benar

        return view('kps/user_requirement_mahasiswa', $data);
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
        $listReview = $reviewModel->getAll(); // pastikan ini sudah join ke mahasiswa

        return view('kps/list_review', ['reviews' => $listReview]);
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
