<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\LogbookBimbingan;
use App\Models\PenilaianDosenModel;
use App\Models\UserRequirement;
use App\Models\ReviewKinerjaModel;
use App\Models\BimbinganIndustriModel;
use App\Models\LogbookIndustri;
use App\Models\Bimbingan;
use App\Models\DosenPembimbingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminLogbookController extends BaseController
{
    // Monitoring semua mahasiswa
    public function index()
    {
        $model = new MahasiswaModel();
        $logbookModel   = new LogbookBimbingan();

        // 1. Ambil semua data mahasiswa + status
        $allData = $model->getMahasiswaWithStatus();

            // Tambahkan jumlah bimbingan diverifikasi ke setiap mahasiswa
        foreach ($allData as &$mhs) {
            $mhs['jumlah_verifikasi'] = $logbookModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }

        // 2. Ambil parameter search & perPage dari query string
        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (! in_array($perPage, [5,10,25,50,100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);

        // 3. Filter data jika ada keyword
        if ($keyword) {
            $allData = array_filter($allData, function($mhs) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($mhs['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($mhs['nim']), $kw)
                    || str_contains(mb_strtolower($mhs['program_studi']), $kw)
                    || str_contains(mb_strtolower($mhs['kelas']), $kw)
                    || str_contains(mb_strtolower($mhs['status']), $kw);
            });
            // reindex array agar pagination benar
            $allData = array_values($allData);
        }

        // 4. Hitung total & slice untuk pagination
        $total      = count($allData);
        $offset     = ($currentPage - 1) * $perPage;
        $pagedData  = array_slice($allData, $offset, $perPage);

        // 5. Buat pager manual
        $pager = \Config\Services::pager();
        // 'default_full' bisa diganti ke template pager custom-mu
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // 6. Kirim ke view
        return view('/logbook_mahasiswa', [
            'mahasiswa' => $pagedData,
            'pager'     => $pager,
            'offset'    => $offset,
            'perPage'   => $perPage,
            'keyword'   => $keyword,
        ]);
    }

    // Detail logbook mahasiswa
    public function detail($id)
    {
        $logbookModel = new LogbookBimbingan();
        $mahasiswaModel = new MahasiswaModel();
        $bimbinganModel = new Bimbingan();
        $dosenModel = new DosenPembimbingModel();

        // Ambil data logbook
        $data['logbook'] = $logbookModel->where('mahasiswa_id', $id)->findAll();

        // Ambil data mahasiswa
        $data['mahasiswa'] = $mahasiswaModel->find($id);

        // Ambil dosen pembimbing
        $bimbingan = $bimbinganModel->where('mahasiswa_id', $id)->findAll();
        $dosenIds = array_column($bimbingan, 'dosen_id');
        $data['dosen_pembimbing'] = [];
        if (!empty($dosenIds)) {
            $data['dosen_pembimbing'] = $dosenModel->whereIn('dosen_id', $dosenIds)->findAll();
        }

        return view('/detail_logbook', $data);
    }

    public function aktivitas()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $model = new MahasiswaModel();
        $logbookIndustriModel = new LogbookIndustri();

        // 1. Ambil semua data mahasiswa dengan status industri
        $allData = $model->getMahasiswaWithStatusIndustri();

        // Tambahkan jumlah logbook aktivitas disetujui untuk setiap mahasiswa
        foreach ($allData as &$mhs) {
            $mhs['jumlah_aktivitas_disetujui'] = $logbookIndustriModel
                ->where('mahasiswa_id', $mhs['mahasiswa_id'])
                ->where('status_validasi', 'disetujui')
                ->countAllResults();
        }

        // 2. Ambil parameter pencarian dan pagination
        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if (! in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }
        $currentPage = (int) ($this->request->getGet('page') ?? 1);

        // 3. Filter data jika keyword pencarian tersedia
        if ($keyword) {
            $allData = array_filter($allData, function($mhs) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($mhs['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($mhs['nim']), $kw)
                    || str_contains(mb_strtolower($mhs['program_studi']), $kw)
                    || str_contains(mb_strtolower($mhs['kelas']), $kw)
                    || str_contains(mb_strtolower($mhs['status']), $kw);
            });
            $allData = array_values($allData); // reindex array
        }

        // 4. Hitung total dan data sesuai halaman
        $total     = count($allData);
        $offset    = ($currentPage - 1) * $perPage;
        $pagedData = array_slice($allData, $offset, $perPage);

        // 5. Buat pager manual
        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // 6. Kirim ke view
        return view('/logbook_aktivitas_mahasiswa', [
            'mahasiswa' => $pagedData,
            'pager'     => $pager,
            'offset'    => $offset,
            'perPage'   => $perPage,
            'keyword'   => $keyword,
        ]);
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
        $model = new UserRequirement();

        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }

        $dataAll = $model->getMahasiswaPengisiRequirement();

        // Filter berdasarkan keyword
        if ($keyword) {
            $dataAll = array_filter($dataAll, function ($item) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($item['nama_lengkap']), $kw)
                    || str_contains(mb_strtolower($item['nim']), $kw)
                    || str_contains(mb_strtolower($item['program_studi']), $kw)
                    || str_contains(mb_strtolower($item['kelas']), $kw);
            });
            $dataAll = array_values($dataAll); // reindex
        }

        $total = count($dataAll);
        $pagedData = array_slice($dataAll, $offset, $perPage);

        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('user_requirement_mahasiswa', [
            'mahasiswaList' => $pagedData,
            'pager' => $pager,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'offset' => $offset,
        ]);
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

        $keyword = $this->request->getGet('keyword');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 10;
        }

        $allReviews = $reviewModel->getAll(); // pastikan sudah join ke mahasiswa

        // Filter berdasarkan keyword
        if ($keyword) {
            $allReviews = array_filter($allReviews, function ($item) use ($keyword) {
                $kw = mb_strtolower($keyword);
                return str_contains(mb_strtolower($item['nama_mahasiswa'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nim'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nama_perusahaan'] ?? ''), $kw)
                    || str_contains(mb_strtolower($item['nama_pembimbing_perusahaan'] ?? ''), $kw);
            });
            $allReviews = array_values($allReviews); // reindex
        }

        $total = count($allReviews);
        $pagedData = array_slice($allReviews, $offset, $perPage);

        $pager = \Config\Services::pager();
        $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('list_review', [
            'reviews' => $pagedData,
            'pager' => $pager,
            'keyword' => $keyword,
            'perPage' => $perPage,
            'offset' => $offset,
        ]);
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

    public function downloadReviewExcel()
{
    $reviewModel = new ReviewKinerjaModel();
    // $reviews = $reviewModel->findAll(); // ambil semua data
    $reviews = $reviewModel->getAllWithMahasiswa(); 


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $headers = [
        'No', 'Nama Mahasiswa', 'NIM', 'Nama Perusahaan', 'Nama Pembimbing Perusahaan', 'Jabatan', 'Divisi',
        'Integritas', 'Keahlian Bidang', 'Kemampuan Bahasa Inggris', 'Pengetahuan Bidang',
        'Komunikasi & Adaptasi', 'Kerja Sama', 'Kemampuan Belajar', 'Kreativitas', 'Menuangkan Ide',
        'Pemecahan Masalah', 'Sikap', 'Kerja di Bawah Tekanan', 'Manajemen Waktu', 'Bekerja Mandiri',
        'Negosiasi', 'Analisis', 'Bekerja dgn Budaya Berbeda', 'Kepemimpinan', 'Tanggung Jawab',
        'Presentasi', 'Menulis Dokumen', 'Saran Lulusan', 'Kemampuan Teknik Diperlukan',
        'Profesi Cocok', 'Created At'
    ];

    $sheet->fromArray($headers, null, 'A1');

    // Isi data
    $row = 2;
    foreach ($reviews as $i => $review) {
        $sheet->setCellValue('A' . $row, $i + 1);
$sheet->setCellValue('B' . $row, isset($review['nama_mahasiswa']) ? $review['nama_mahasiswa'] : '');
    $sheet->setCellValue('C' . $row, isset($review['nim']) ? $review['nim'] : '');
        $sheet->setCellValue('D' . $row, $review['nama_perusahaan']);
        $sheet->setCellValue('E' . $row, $review['nama_pembimbing_perusahaan']);
        $sheet->setCellValue('F' . $row, $review['jabatan']);
        $sheet->setCellValue('G' . $row, $review['divisi']);
        $sheet->setCellValue('H' . $row, $review['integritas']);
        $sheet->setCellValue('I' . $row, $review['keahlian_bidang']);
        $sheet->setCellValue('J' . $row, $review['kemampuan_bahasa_inggris']);
        $sheet->setCellValue('K' . $row, $review['pengetahuan_bidang']);
        $sheet->setCellValue('L' . $row, $review['komunikasi_adaptasi']);
        $sheet->setCellValue('M' . $row, $review['kerja_sama']);
        $sheet->setCellValue('N' . $row, $review['kemampuan_belajar']);
        $sheet->setCellValue('O' . $row, $review['kreativitas']);
        $sheet->setCellValue('P' . $row, $review['menuangkan_ide']);
        $sheet->setCellValue('Q' . $row, $review['pemecahan_masalah']);
        $sheet->setCellValue('R' . $row, $review['sikap']);
        $sheet->setCellValue('S' . $row, $review['kerja_dibawah_tekanan']);
        $sheet->setCellValue('T' . $row, $review['manajemen_waktu']);
        $sheet->setCellValue('U' . $row, $review['bekerja_mandiri']);
        $sheet->setCellValue('V' . $row, $review['negosiasi']);
        $sheet->setCellValue('W' . $row, $review['analisis']);
        $sheet->setCellValue('X' . $row, $review['bekerja_dengan_budaya_berbeda']);
        $sheet->setCellValue('Y' . $row, $review['kepemimpinan']);
        $sheet->setCellValue('Z' . $row, $review['tanggung_jawab']);
        $sheet->setCellValue('AA' . $row, $review['presentasi']);
        $sheet->setCellValue('AB' . $row, $review['menulis_dokumen']);
        $sheet->setCellValue('AC' . $row, $review['saran_lulusan']);
        $sheet->setCellValue('AD' . $row, $review['kemampuan_teknik_dibutuhkan']);
        $sheet->setCellValue('AE' . $row, $review['profesi_cocok']);
        $sheet->setCellValue('AF' . $row, $review['created_at']);
        $row++;
    }

    // Set response
    $filename = 'review_kinerja_mahasiswa_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

    
    

}
