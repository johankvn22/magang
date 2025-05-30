<?php

namespace App\Controllers;

use App\Models\Bimbingan;
use App\Models\LogbookBimbingan;
use App\Models\DosenPembimbingModel;
use App\Models\MahasiswaModel;
use App\Models\PenilaianDosenModel;
use App\Models\BimbinganIndustriModel;
use App\Models\LogbookIndustri;

class BimbinganController extends BaseController
{
    public function index()
    {
        $dosenId = session()->get('user_id');
        $keyword = $this->request->getGet('search'); // ini HARUS 'search'

        $bimbinganModel = new Bimbingan();
        $mahasiswaModel = new MahasiswaModel();

        $bimbingan = $bimbinganModel->where('dosen_id', $dosenId)->findAll();

        $mahasiswaList = [];

        foreach ($bimbingan as $item) {
            $mahasiswa = $mahasiswaModel->find($item['mahasiswa_id']);
            if ($mahasiswa) {
                $mahasiswaList[] = $mahasiswa;
            }
        }

        $logbookModel = new LogbookBimbingan();

        foreach ($mahasiswaList as &$mhs) {
            $mhs['jumlah_verifikasi'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }


        // Jika keyword ada, filter data
        if ($keyword) {
            $kw = mb_strtolower($keyword);
            $mahasiswaList = array_filter($mahasiswaList, function ($item) use ($kw) {
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw)
                    || str_contains(mb_strtolower($item['nama_perusahaan']), $kw);
            });
            $mahasiswaList = array_values($mahasiswaList); // reindex array
        }

        return view('dosen/list_mahasiswa_bimbingan', [
            'mahasiswaList' => $mahasiswaList,
            'keyword' => $keyword
        ]);
    }


    public function detail($mahasiswaId)
    {
        $logbookModel = new LogbookBimbingan();
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $penilaianModel = new PenilaianDosenModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswaId);
        $logbooks = $logbookModel->where('mahasiswa_id', $mahasiswaId)->findAll();

        $disetujuiCount = $logbookModel->where('mahasiswa_id', $mahasiswaId)
            ->where('status_validasi', 'disetujui')
            ->countAllResults();
        $totalCount = $logbookModel->where('mahasiswa_id', $mahasiswaId)->countAllResults();

        // Ambil bimbingan_id berdasarkan mahasiswa dan dosen yang login
        $dosenId = session()->get('user_id');
        $bimbingan = $bimbinganModel->where([
            'mahasiswa_id' => $mahasiswaId,
            'dosen_id' => $dosenId
        ])->first();

        $bimbingan_id = $bimbingan['bimbingan_id'] ?? null;

        // 🔍 Cek apakah penilaian sudah ada
        $penilaian_sudah_ada = false;
        if ($bimbingan_id) {
            $penilaian_sudah_ada = $penilaianModel
                ->where('bimbingan_id', $bimbingan_id)
                ->first() ? true : false;
        }

        return view('dosen/bimbingan_logbook', [
            'mahasiswa' => $mahasiswa,
            'logbooks' => $logbooks,
            'disetujuiCount' => $disetujuiCount,
            'totalCount' => $totalCount,
            'bimbingan_id' => $bimbingan_id, // ✅ Kirim ke view
            'penilaian_sudah_ada' => $penilaian_sudah_ada // ✅ Kirim ke view
        ]);
    }

    public function setujui($logbookId)
    {
        $logbookModel = new LogbookBimbingan();

        // Tambahkan pengecekan data
        $logbook = $logbookModel->find($logbookId);
        if (!$logbook) {
            return redirect()->back()->with('error', 'Logbook tidak ditemukan.');
        }

        $logbookModel->update($logbookId, ['status_validasi' => 'disetujui']);
        return redirect()->back()->with('success', 'Logbook disetujui.');
    }

    public function tolak($logbookId)
    {
        $logbookModel = new LogbookBimbingan();

        $logbook = $logbookModel->find($logbookId);
        if (!$logbook) {
            return redirect()->back()->with('error', 'Logbook tidak ditemukan.');
        }

        $logbookModel->update($logbookId, ['status_validasi' => 'ditolak']);
        return redirect()->back()->with('success', 'Logbook ditolak.');
    }

    public function downloadLogbookFile($filename)
    {
        $filePath = ROOTPATH . 'public/uploads/logbook/' . $filename;

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("File tidak ditemukan.");
        }

        return $this->response->download($filePath, null);
    }

    public function update_catatan($id)
{
    $model = new LogbookBimbingan();
    $logbook = $model->find($id);

    if (!$logbook) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    if ($logbook['status_validasi'] !== 'menunggu') {
        return redirect()->back()->with('error', 'Catatan hanya bisa ditambahkan saat status menunggu.');
    }

    $model->update($id, [
        'catatan_dosen' => $this->request->getPost('catatan_dosen')
    ]);

    return redirect()->back()->with('success', 'Catatan berhasil disimpan.');
}


    //menampilkan logbook aktivitas mahasiswa
    public function aktivitasMahasiswaBimbingan()
    {
        $dosenId = session()->get('user_id');
        $keyword = $this->request->getGet('keyword');

        $bimbinganModel = new Bimbingan();
        $mahasiswaModel = new MahasiswaModel();

        $bimbinganList = $bimbinganModel->where('dosen_id', $dosenId)->findAll();
        $mahasiswaList = [];

        foreach ($bimbinganList as $bimbingan) {
            $mahasiswa = $mahasiswaModel->find($bimbingan['mahasiswa_id']);
            if ($mahasiswa) {
                $mahasiswaList[] = $mahasiswa;
            }
        }

        $logbookModel = new LogbookIndustri();
        // Tambahkan jumlah aktivitas untuk setiap mahasiswa
        foreach ($mahasiswaList as &$mhs) {
            $mhs['jumlah_aktivitas'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->countAllResults();
            $mhs['nama_perusahaan'] = $mhs['nama_perusahaan'] ?? '-'; // Pastikan ada nama perusahaan
        }

        // Filter pencarian jika ada keyword
        if ($keyword) {
            $kw = mb_strtolower($keyword);
            $mahasiswaList = array_filter($mahasiswaList, function ($item) use ($kw) {
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw)
                    || str_contains(mb_strtolower($item['nama_perusahaan']), $kw);
            });
            $mahasiswaList = array_values($mahasiswaList); // reindex
        }

        return view('dosen/logbook_aktivitas_mahasiswa', [
            'mahasiswaList' => $mahasiswaList,
            'keyword' => $keyword
        ]);
    }


    public function detailAktivitasMahasiswa($mahasiswaId)
    {
       $logbookModel   = new LogbookIndustri();
        $mahasiswaModel = new MahasiswaModel();

        $mahasiswa = $mahasiswaModel->find($mahasiswaId);
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        $logbooks = $logbookModel
            ->where('mahasiswa_id', $mahasiswaId)
            // ->orderBy('tanggal', 'DESC')
            ->findAll();

        return view('dosen/detail_logbook_aktivitas', [
            'mahasiswa' => $mahasiswa,
            'logbooks'  => $logbooks
        ]);

    }






}
