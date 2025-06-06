<?php
namespace App\Controllers;

use App\Models\LogbookBimbingan; // Pastikan untuk menggunakan model logbook

class LogbookController extends BaseController
{
    // Menampilkan logbook
    public function index()
    {
        $logbookModel = new LogbookBimbingan();
        $mahasiswaId = session()->get('user_id'); // Mengambil user_id mahasiswa dari session
        
        // Mengambil logbook mahasiswa dari database
        $logbook = $logbookModel->where('mahasiswa_id', $mahasiswaId)->findAll();

        // Mengembalikan view logbook dengan data
        return view('mahasiswa/LogbookBimbingan', ['logbook' => $logbook, 'title' => 'Logbook Bimbingan']);
    }

    // Method untuk menambah logbook baru
    public function create()
    {
        $logbookModel = new LogbookBimbingan();
        $mahasiswaId = session()->get('user_id');

        // Validasi input dasar
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tanggal' => 'required|valid_date',
            'aktivitas' => 'required|min_length[10]',
            'file_dokumen' => 'max_size[file_dokumen,5120]|ext_in[file_dokumen,pdf]|mime_in[file_dokumen,application/pdf]',
            'link_drive' => 'permit_empty|valid_url'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Proses upload file
        $fileName = null;
        $file = $this->request->getFile('file_dokumen');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi tambahan untuk memastikan
            if ($file->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()
                    ->with('error', 'Ukuran file melebihi 5MB')
                    ->withInput();
            }

            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/logbook/', $fileName);
        }

        // Persiapkan data
        $data = [
            'mahasiswa_id' => $mahasiswaId,
            'tanggal' => $this->request->getPost('tanggal'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'file_dokumen' => $fileName,
            'link_drive' => $this->request->getPost('link_drive'),
            'status_validasi' => 'menunggu'
        ];

        // Simpan ke database
        if ($logbookModel->save($data)) {
            return redirect()->to('/mahasiswa/logbook')->with('success', 'Logbook berhasil ditambahkan.');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan logbook')
                ->withInput();
        }
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $logbookModel = new LogbookBimbingan();
        $entry = $logbookModel->find($id);

        // Cek apakah logbook milik mahasiswa dan belum divalidasi
        if ($entry['mahasiswa_id'] != session()->get('user_id') || $entry['status_validasi'] != 'menunggu') {
            return redirect()->to('/mahasiswa/logbook')->with('error', 'Tidak bisa mengedit data yang sudah divalidasi.');
        }

        return view('mahasiswa/EditLogbook', ['entry' => $entry, 'title' => 'Edit Logbook']);
    }

    // Simpan perubahan
    public function update($id)
    {
        $logbookModel = new LogbookBimbingan();
        $entry = $logbookModel->find($id);

        if ($entry['mahasiswa_id'] != session()->get('user_id') || $entry['status_validasi'] != 'menunggu') {
            return redirect()->to('/mahasiswa/logbook')->with('error', 'Tidak bisa mengedit data yang sudah divalidasi.');
        }

        // Proses file jika ada
        $file = $this->request->getFile('file_dokumen');
        $fileName = $entry['file_dokumen']; // default lama

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 5 * 1024 * 1024) { // 5MB
                return redirect()->back()->with('error', 'Ukuran file maksimal adalah 5MB.');
            }

            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/logbook/', $fileName);
        }


        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'link_drive' => $this->request->getPost('link_drive'),
            'file_dokumen' => $fileName,
        ];

        $logbookModel->update($id, $data);
        return redirect()->to('/mahasiswa/logbook')->with('success', 'Logbook berhasil diperbarui.');
    }

    // Hapus logbook
    public function delete($id)
    {
        $logbookModel = new LogbookBimbingan();
        $entry = $logbookModel->find($id);

        if ($entry['mahasiswa_id'] != session()->get('user_id') || $entry['status_validasi'] != 'menunggu') {
            return redirect()->to('/mahasiswa/logbook')->with('error', 'Tidak bisa menghapus data yang sudah divalidasi.');
        }

        $logbookModel->delete($id);
        return redirect()->to('/mahasiswa/logbook')->with('success', 'Logbook berhasil dihapus.');
    }

        public function downloadLogbookFile($filename)
    {
        $filePath = ROOTPATH . 'public/uploads/logbook/' . $filename;

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("File tidak ditemukan.");
        }

        return $this->response->download($filePath, null);
    }

}