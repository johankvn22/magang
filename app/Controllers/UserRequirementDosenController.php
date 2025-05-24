<?php 

namespace App\Controllers;

use App\Models\UserRequirement;
use App\Models\DosenPembimbingModel;
use App\Models\MahasiswaModel;
use App\Models\Bimbingan;

class UserRequirementDosenController extends BaseController
{
    public function index()
    {
        $dosenId = session()->get('user_id');

        $dosenModel = new Bimbingan();
        $mahasiswaList = $dosenModel->getMahasiswaByDosen($dosenId);

        return view('dosen/list_mahasiswa_userrequirement', ['mahasiswaList' => $mahasiswaList]);
    }

    public function detail($mahasiswaId)
    {
        $requirementModel = new UserRequirement();
        $mahasiswaModel = new MahasiswaModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswaId);
        $requirements = $requirementModel->where('mahasiswa_id', $mahasiswaId)->findAll();
        

        return view('dosen/detail_userrequirement', [
            'mahasiswa' => $mahasiswa,
            'requirements' => $requirements,
        ]);
    }
}


?>