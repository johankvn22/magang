<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\LogbookBimbingan;
use App\Models\PenilaianDosenModel;
use App\Models\UserRequirement;
use App\Models\ReviewKinerjaModel;
use App\Models\BimbinganIndustriModel;
use App\Models\LogbookIndustri;

class AdminLogbookController extends BaseController
{
    // Monitoring semua mahasiswa
    public function index()
    {
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithStatus(); // method ini yang kita buat tadi
        return view('/logbook_mahasiswa', $data);
    }

    // Detail logbook mahasiswa
    public function detail($id)
    {
        $logbookModel = new LogbookBimbingan();
        $data['logbook'] = $logbookModel->where('mahasiswa_id', $id)->findAll();
        return view('/detail_logbook', $data);
    }

    public function aktivitas()
    {
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithStatusIndustri(); // method dari MahasiswaModel
        return view('/logbook_aktivitas_mahasiswa', $data);
    }

   public function detailAktivitas($mahasiswa_id)
    {
        $logbookModel = new LogbookIndustri();
        $mahasiswaModel = new MahasiswaModel();

        $data['logbook_industri'] = $logbookModel->where('mahasiswa_id', $mahasiswa_id)->orderBy('created_at', 'DESC')->findAll();
        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);

        return view('/detail_logbook_industri', $data);
    }

    public function userRequirement()
    {
        $requirementModel = new UserRequirement();
        $data['mahasiswaList'] = $requirementModel->getMahasiswaPengisiRequirement(); // model dan method sekarang benar

        return view('user_requirement_mahasiswa', $data);
    }

    public function detailUserRequirement($mahasiswa_id)
    {
        $requirementModel = new UserRequirement();
        $mahasiswaModel = new MahasiswaModel();

        $data['mahasiswa'] = $mahasiswaModel->find($mahasiswa_id);
        $data['user_requirements'] = $requirementModel->where('mahasiswa_id', $mahasiswa_id)
        ->orderBy('created_at', 'DESC')->findAll();

        return view('detail_user_requirement', $data);  
    }

       public function listReview()
    {
        $reviewModel = new ReviewKinerjaModel();
        $listReview = $reviewModel->getAll();

        return view('list_review', ['reviews' => $listReview]);
    }

    public function detailReview($id)
    {
        $reviewModel = new ReviewKinerjaModel();
        $review = $reviewModel->getDetail($id);

        if (!$review) {
            return redirect()->to('/admin/review-kinerja')->with('error', 'Review tidak ditemukan.');
        }

        return view('detail_review', ['review_id' => $review]);
    }

    
    

}
