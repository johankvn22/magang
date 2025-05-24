<?php

namespace App\Controllers;

use App\Models\UserRequirement;
use App\Models\MahasiswaModel;
use App\Models\BimbinganIndustriModel;

class UserRequirementIndustriController extends BaseController
{
    public function index()
    {
        $pembimbingId = session()->get('user_id');

        $bimbinganModel = new BimbinganIndustriModel();
        $mahasiswaList = $bimbinganModel->getMahasiswaByPembimbing($pembimbingId);

        return view('industri/list_mahasiswa_userrequirement', ['mahasiswaList' => $mahasiswaList]);
    }

    public function detail($mahasiswaId)
    {
        $userRequirementModel = new UserRequirement();
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new BimbinganIndustriModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswaId);
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        $requirements = $userRequirementModel
            ->where('mahasiswa_id', $mahasiswaId)
            ->findAll();

        $pembimbingId = session()->get('user_id');
        $bimbingan = $bimbinganModel->where([
            'mahasiswa_id' => $mahasiswaId,
            'pembimbing_id' => $pembimbingId
        ])->first();

        $bimbingan_id = $bimbingan['detail_industri_id'] ?? null;

        return view('industri/detail_userrequirement', [
            'mahasiswa'    => $mahasiswa,
            'requirements' => $requirements,
            'bimbingan_id' => $bimbingan_id
        ]);
    }

    public function setujui($requirementId)
    {
        $model = new UserRequirement();
        $item = $model->find($requirementId);
        if (!$item) {
            return redirect()->back()->with('error', 'User Requirement tidak ditemukan.');
        }

        $model->update($requirementId, ['status_validasi' => 'disetujui']);
        return redirect()->back()->with('success', 'User Requirement disetujui.');
    }

    public function tolak($requirementId)
    {
        $model = new UserRequirement();
        $item = $model->find($requirementId);
        if (!$item) {
            return redirect()->back()->with('error', 'User Requirement tidak ditemukan.');
        }

        $model->update($requirementId, ['status_validasi' => 'ditolak']);
        return redirect()->back()->with('success', 'User Requirement ditolak.');
    }
}
