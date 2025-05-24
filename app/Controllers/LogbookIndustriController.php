<?php

namespace App\Controllers;

use App\Models\LogbookIndustri; // Memanggil model logbook industri

class LogbookIndustriController extends BaseController
{
    public function index()
    {
        $logbookModel = new LogbookIndustri();
        $mahasiswaId = session()->get('user_id'); // Ambil user_id mahasiswa dari session

        // Mengambil logbook mahasiswa dari database
        $logbook = $logbookModel->where('mahasiswa_id', $mahasiswaId)->findAll();

        // Mengembalikan view logbook dengan data logbook
        return view('mahasiswa/LogbookIndustri', ['logbook' => $logbook]);
    }

    // Method untuk menambah logbook baru
    public function create()
    {
        $logbookModel = new LogbookIndustri();
        $mahasiswaId = session()->get('user_id'); // Ambil user_id mahasiswa dari session

        // Ambil data dari form
        $data = [
            'mahasiswa_id' => $mahasiswaId, // Setting mahasiswa_id
            'tanggal'      => $this->request->getPost('tanggal'),
            'aktivitas'    => $this->request->getPost('aktivitas'),
            'catatan_industri' => $this->request->getPost('catatan_industri'),
        ];

        // Menyimpan logbook
        if ($logbookModel->insert($data)) {
            return redirect()->to('/mahasiswa/logbook_industri')->with('success', 'Logbook industri berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan logbook industri.');
        }
    }

    public function edit($id)
    {
        $logbookModel = new LogbookIndustri();
        $entry = $logbookModel->find($id);

        if (!$entry || $entry['mahasiswa_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Logbook tidak ditemukan');
        }

        if (strtolower($entry['status_validasi']) === 'disetujui') {
            return redirect()->to('/mahasiswa/logbook_industri')->with('error', 'Logbook yang sudah disetujui tidak bisa diedit.');
        }


        return view('mahasiswa/EditLogbookIndustri', ['entry' => $entry]);
    }

    public function update($id)
    {
        $logbookModel = new LogbookIndustri();
        $entry = $logbookModel->find($id);

        if (!$entry || $entry['mahasiswa_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Logbook tidak ditemukan');
        }

        if (strtolower($entry['status_validasi']) === 'disetujui') {
            return redirect()->to('/mahasiswa/logbook_industri')->with('error', 'Logbook yang sudah disetujui tidak bisa diedit.');
        }


        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'catatan_industri' => $this->request->getPost('catatan_industri'),
        ];

        $logbookModel->update($id, $data);
        return redirect()->to('/mahasiswa/logbook_industri')->with('success', 'Logbook berhasil diperbarui.');
    }

    public function delete($id)
    {
        $logbookModel = new LogbookIndustri();
        $entry = $logbookModel->find($id);

        if (!$entry || $entry['mahasiswa_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Logbook tidak ditemukan');
        }

        if (strtolower($entry['status_validasi']) === 'disetujui') {
            return redirect()->to('/mahasiswa/logbook_industri')->with('error', 'Logbook yang sudah disetujui tidak bisa diedit.');
        }


        $logbookModel->delete($id);
        return redirect()->to('/mahasiswa/logbook_industri')->with('success', 'Logbook berhasil dihapus.');
    }

}
