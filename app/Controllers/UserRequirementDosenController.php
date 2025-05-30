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
        $keyword = $this->request->getGet('keyword');

        $bimbinganModel = new Bimbingan();
        $mahasiswaModel = new MahasiswaModel();

        // Ambil semua mahasiswa yang dibimbing oleh dosen ini
        $bimbinganList = $bimbinganModel->where('dosen_id', $dosenId)->findAll();

        $mahasiswaList = [];

        foreach ($bimbinganList as $bimbingan) {
            $mahasiswa = $mahasiswaModel->find($bimbingan['mahasiswa_id']);
            if ($mahasiswa) {
                $mahasiswaList[] = $mahasiswa;
            }
        }

        // Filter jika ada keyword pencarian
        if ($keyword) {
            $kw = mb_strtolower($keyword);
            $mahasiswaList = array_filter($mahasiswaList, function ($item) use ($kw) {
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw);
            });
            $mahasiswaList = array_values($mahasiswaList); // Re-index
        }

        return view('dosen/list_mahasiswa_userrequirement', [
            'mahasiswaList' => $mahasiswaList,
            'keyword' => $keyword
        ]);
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