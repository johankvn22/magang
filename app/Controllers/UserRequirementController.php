<?php

namespace App\Controllers;

use App\Models\UserRequirement; // Memanggil model user requirement

class UserRequirementController extends BaseController
{
    // Menampilkan daftar user requirement untuk mahasiswa tertentu
    public function index()
    {
        $requirementModel = new UserRequirement();
        $mahasiswaId = session()->get('user_id'); // Ambil user_id mahasiswa dari session

        // Mengambil data user requirement dari database
        $requirements = $requirementModel->where('mahasiswa_id', $mahasiswaId)->findAll();

        // Mengembalikan view dengan data requirements
        return view('mahasiswa/UserRequirement', ['requirements' => $requirements]);
    }

    // Menambah user requirement baru
    public function create()
    {
        $requirementModel = new UserRequirement();
        $mahasiswaId = session()->get('user_id'); // Ambil user_id mahasiswa dari session

        // Ambil data dari form
        $data = [
            'mahasiswa_id'     => $mahasiswaId,
            'tanggal'          => $this->request->getPost('tanggal'),
            'dikerjakan'       => $this->request->getPost('dikerjakan'),
            'user_requirement' => $this->request->getPost('user_requirement'),
        ];

        // Simpan data
        if ($requirementModel->insert($data)) {
            return redirect()->to('mahasiswa/user-requirement')->with('success', 'User Requirement berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan User Requirement.');
        }
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $requirementModel = new UserRequirement();
        $requirement = $requirementModel->find($id);

        // Cek apakah data ditemukan dan milik user & belum disetujui
        if (!$requirement || $requirement['mahasiswa_id'] != session()->get('user_id') || $requirement['status_validasi'] === 'Disetujui') {
            return redirect()->to('mahasiswa/user-requirement')->with('error', 'Data tidak bisa diedit.');
        }

        return view('mahasiswa/EditUserRequirement', ['requirement' => $requirement]);
    }

    // Menyimpan hasil edit
    public function update($id)
    {
        $requirementModel = new UserRequirement();
        $requirement = $requirementModel->find($id);

        if (!$requirement || $requirement['mahasiswa_id'] != session()->get('user_id') || $requirement['status_validasi'] === 'Disetujui') {
            return redirect()->to('mahasiswa/user-requirement')->with('error', 'Data tidak bisa diperbarui.');
        }

        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'dikerjakan'       => $this->request->getPost('dikerjakan'),
            'user_requirement' => $this->request->getPost('user_requirement'),
        ];

        $requirementModel->update($id, $data);
        return redirect()->to('mahasiswa/user-requirement')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus user requirement
    public function delete($id)
    {
        $requirementModel = new UserRequirement();
        $requirement = $requirementModel->find($id);

        if (!$requirement || $requirement['mahasiswa_id'] != session()->get('user_id') || $requirement['status_validasi'] === 'Disetujui') {
            return redirect()->to('mahasiswa/user-requirement')->with('error', 'Data tidak bisa dihapus.');
        }

        $requirementModel->delete($id);
        return redirect()->to('mahasiswa/user-requirement')->with('success', 'Data berhasil dihapus.');
    }


    
}
