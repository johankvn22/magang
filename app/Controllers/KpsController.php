<?php

namespace App\Controllers;

use App\Models\Kps; // Pastikan menggunakan model Kps yang tepat
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingModel;
use App\Models\Bimbingan;
use App\Models\LogbookBimbingan;
use App\Models\LogbookIndustri;
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


    public function bagikanBimbingan()
    {
        $mahasiswaModel = new MahasiswaModel();
        $dosenModel = new DosenPembimbingModel();

        $data = [
            'title' => 'Bagikan Dosen Pembimbing',
            'mahasiswa' => $mahasiswaModel->findAll(),
            'dosen' => $dosenModel->findAll()
        ];

        return view('kps/bagikan_bimbingan', $data);
    }

    public function simpanBimbingan()
    {
        $bimbinganModel = new Bimbingan();

        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $dosen_id     = $this->request->getPost('dosen_id');

        // Cek apakah mahasiswa sudah memiliki dosen pembimbing
        $cekMahasiswa = $bimbinganModel->where('mahasiswa_id', $mahasiswa_id)->first();
        if ($cekMahasiswa) {
            return redirect()->to('/kps/bagikan-bimbingan')
                ->with('error', 'Mahasiswa ini sudah memiliki dosen pembimbing.');
        }

        // Insert data karena mahasiswa belum punya pembimbing
        $data = [
            'mahasiswa_id' => $mahasiswa_id,
            'dosen_id'     => $dosen_id,
        ];

        $bimbinganModel->insert($data);

        return redirect()->to('/kps/bagikan-bimbingan')
            ->with('success', 'Dosen pembimbing berhasil dibagikan!');
    }


    public function daftarDosen()
    {
        $bimbinganModel = new Bimbingan();

        $data['bimbingan'] = $bimbinganModel->getDaftarBimbinganDenganDosen();

        return view('kps/daftar_dosen', $data);
    }

    public function daftarMahasiswa()
    {
        if (session()->get('role') !== 'kps') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $mahasiswaModel = new MahasiswaModel();
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $data['mahasiswa'] = $mahasiswaModel->paginate($perPage);
        $data['pager'] = $mahasiswaModel->pager;
        $data['offset'] = $offset;

        return view('kps/daftar_mahasiswa', $data); // letakkan view di folder views/kps
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


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    
}