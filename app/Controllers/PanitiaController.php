<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Panitia;
use App\Models\MahasiswaModel;
use App\Models\DosenPembimbingModel;
use App\Models\Bimbingan;
use App\Models\LogbookBimbingan;
use App\Models\LogbookIndustri;
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

public function bagikanBimbingan()
{
    $mahasiswaModel = new MahasiswaModel();
    $dosenModel = new DosenPembimbingModel();

    $data = [
        'title' => 'Bagikan Dosen Pembimbing',
        'mahasiswa' => $mahasiswaModel->findAll(),
        'dosen' => $dosenModel->findAll()
    ];

    return view('panitia/bagikan_bimbingan', $data);
}

public function simpanBimbingan()
{
    $bimbinganModel = new Bimbingan();

    $mahasiswa_id = $this->request->getPost('mahasiswa_id');
    $dosen_id     = $this->request->getPost('dosen_id');

    // Cek apakah mahasiswa sudah memiliki dosen pembimbing
    $cekMahasiswa = $bimbinganModel->where('mahasiswa_id', $mahasiswa_id)->first();
    if ($cekMahasiswa) {
        return redirect()->to('/panitia/bagikan-bimbingan')
            ->with('error', 'Mahasiswa ini sudah memiliki dosen pembimbing.');
    }

    // Insert data karena mahasiswa belum punya pembimbing
    $data = [
        'mahasiswa_id' => $mahasiswa_id,
        'dosen_id'     => $dosen_id,
    ];

    $bimbinganModel->insert($data);

    return redirect()->to('/panitia/bagikan-bimbingan')
        ->with('success', 'Dosen pembimbing berhasil dibagikan!');
}

public function daftarDosen()
{
    $db = \Config\Database::connect();

    // Join tabel dosen_pembimbing, bimbingan, dan mahasiswa
    $builder = $db->table('dosen_pembimbing');
    $builder->select('dosen_pembimbing.nama_lengkap AS nama_dosen, dosen_pembimbing.nip, mahasiswa.nama_lengkap AS nama_mahasiswa, mahasiswa.nim');
    $builder->join('bimbingan', 'bimbingan.dosen_id = dosen_pembimbing.dosen_id');
    $builder->join('mahasiswa', 'mahasiswa.mahasiswa_id = bimbingan.mahasiswa_id');
    $builder->orderBy('dosen_pembimbing.nama_lengkap');

    $data['bimbingan'] = $builder->get()->getResultArray();

    return view('panitia/daftar_dosen', $data);
}

public function daftarMahasiswa()
{
    if (session()->get('role') !== 'panitia') {
        return redirect()->to('/login')->with('error', 'Akses ditolak.');
    }

    $mahasiswaModel = new MahasiswaModel();
    $perPage = 10;
    $currentPage = $this->request->getVar('page') ?? 1;
    $offset = ($currentPage - 1) * $perPage;

    $data['mahasiswa'] = $mahasiswaModel->paginate($perPage);
    $data['pager'] = $mahasiswaModel->pager;
    $data['offset'] = $offset;

    return view('panitia/daftar_mahasiswa', $data); // letakkan view di folder views/panitia
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
    $data['mahasiswa'] = $model->getMahasiswaWithStatusIndustri(); // method sama
    return view('panitia/logbook_aktivitas_mahasiswa', $data);
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
        $requirementModel = new UserRequirement();
        $data['mahasiswaList'] = $requirementModel->getMahasiswaPengisiRequirement(); // model dan method sekarang benar

        return view('panitia/user_requirement_mahasiswa', $data);
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





}
