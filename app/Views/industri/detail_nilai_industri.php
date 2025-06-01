<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-success fw-bold">
            <i class="fas fa-clipboard-check me-2"></i>Detail Nilai Industri
        </h2>
        <a href="<?= base_url('dosen/penilaian-dosen/listNilai') ?>" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i>Cetak
        </button>
    </div>

    <div class="row g-4 mb-4">
        <!-- Biodata Mahasiswa -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm card-hover border-primary">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-graduate fa-lg me-3"></i>
                        <h5 class="mb-0">Biodata Mahasiswa</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3" style="word-break: break-word; max-width: calc(100% - 60px);">
                            <h4 class="mb-0"><?= esc($penilaian['nama_lengkap']) ?></h4>
                            <span class="text-muted">NIM: <?= esc($penilaian['nim']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rangkuman Nilai -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm card-hover border-success">
                <div class="card-header bg-success text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-pie fa-lg me-3"></i>
                        <h5 class="mb-0">Rangkuman Nilai</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column h-100">
                        <div class="mb-4">
                            <h6 class="fw-bold text-success mb-3">
                                <i class="fas fa-industry me-2"></i>Nilai Industri (60%)
                            </h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Soft Skills (50%)</span>
                                <span class="fw-bold">
                                    <?= number_format((
                                        $penilaian['komunikasi'] + 
                                        $penilaian['berpikir_kritis'] + 
                                        $penilaian['kerja_tim'] + 
                                        $penilaian['inisiatif'] + 
                                        $penilaian['literasi_digital']
                                    ), 2) ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Hard Skills (50%)</span>
                                <span class="fw-bold">
                                    <?= number_format((
                                        $penilaian['deskripsi_produk'] + 
                                        $penilaian['spesifikasi_produk'] + 
                                        $penilaian['desain_produk'] + 
                                        $penilaian['implementasi_produk'] + 
                                        $penilaian['pengujian_produk']
                                    ), 2) ?>
                                </span>
                            </div>
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: <?= $penilaian['total_nilai_industri']?>%" 
                                     aria-valuenow="<?= $penilaian['total_nilai_industri'] ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total</span>
                                <span class="fw-bold text-success"><?= number_format($penilaian['total_nilai_industri'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Industri -->
        <div class="col-12">
            <?php if ($penilaian): ?>
                <div class="card h-100 shadow-sm card-hover border-success">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-industry fa-lg me-3"></i>
                            <h5 class="mb-0">Nilai Pembimbing Industri</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%" class="text-center">Kategori</th>
                                        <th>Kriteria Unjuk Kerja (KUK)</th>
                                        <th style="width: 15%" class="text-center">Range Nilai</th>
                                        <th style="width: 15%" class="text-center">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Soft Skills -->
                                    <tr>
                                        <td class="text-center align-middle fw-bold bg-info bg-opacity-10" rowspan="5">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <i class="fas fa-comments fa-2x mb-2 text-info"></i>
                                                <span>Soft Skills</span>
                                                <span class="badge bg-info mt-1">50%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>1.1 Kemampuan Komunikasi</strong><br>
                                            - Mampu berkomunikasi secara efektif dengan tim<br>
                                            - Menyampaikan ide dengan jelas<br>
                                            - Aktif dalam diskusi
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-info score-badge"><?= $penilaian['komunikasi'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>1.2 Berpikir Kritis</strong><br>
                                            - Mampu menganalisis masalah<br>
                                            - Memberikan solusi yang logis<br>
                                            - Mempertimbangkan berbagai perspektif
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-info score-badge"><?= $penilaian['berpikir_kritis'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>1.3 Kerja Tim</strong><br>
                                            - Berkolaborasi dengan anggota tim<br>
                                            - Menghargai pendapat orang lain<br>
                                            - Berkontribusi aktif dalam tim
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-info score-badge"><?= $penilaian['kerja_tim'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>1.4 Inisiatif dan Kreativitas</strong><br>
                                            - Proaktif dalam menyelesaikan tugas<br>
                                            - Memberikan ide-ide kreatif<br>
                                            - Cepat beradaptasi dengan perubahan
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-info score-badge"><?= $penilaian['inisiatif'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>1.5 Literasi Digital</strong><br>
                                            - Menguasai tools yang diperlukan<br>
                                            - Mampu mencari informasi digital<br>
                                            - Menggunakan teknologi secara efektif
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-info score-badge"><?= $penilaian['literasi_digital'] ?></span></td>
                                    </tr>

                                    <!-- Hard Skills -->
                                    <tr>
                                        <td class="text-center align-middle fw-bold bg-success bg-opacity-10" rowspan="5">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <i class="fas fa-cogs fa-2x mb-2 text-success"></i>
                                                <span>Hard Skills</span>
                                                <span class="badge bg-success mt-1">50%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>2.1 Deskripsi Produk</strong><br>
                                            - Mampu mendeskripsikan produk dengan jelas<br>
                                            - Menjelaskan tujuan dan manfaat produk<br>
                                            - Memahami fitur-fitur produk
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-success score-badge"><?= $penilaian['deskripsi_produk'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>2.2 Spesifikasi Produk</strong><br>
                                            - Mampu menentukan kebutuhan produk<br>
                                            - Menyusun spesifikasi teknis<br>
                                            - Memahami batasan produk
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-success score-badge"><?= $penilaian['spesifikasi_produk'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>2.3 Desain Produk</strong><br>
                                            - Mampu membuat desain yang sesuai kebutuhan<br>
                                            - Mempertimbangkan aspek teknis<br>
                                            - Membuat dokumentasi desain
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-success score-badge"><?= $penilaian['desain_produk'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>2.4 Implementasi Produk</strong><br>
                                            - Menerapkan desain ke produk nyata<br>
                                            - Menggunakan tools yang tepat<br>
                                            - Menyelesaikan masalah teknis
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-success score-badge"><?= $penilaian['implementasi_produk'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>2.5 Pengujian Produk</strong><br>
                                            - Melakukan pengujian sesuai standar<br>
                                            - Menganalisis hasil pengujian<br>
                                            - Melakukan perbaikan berdasarkan hasil uji
                                        </td>
                                        <td class="text-center">1 - 10</td>
                                        <td class="text-center"><span class="badge bg-success score-badge"><?= $penilaian['pengujian_produk'] ?></span></td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold fs-5">Total Nilai Industri</td>
                                        <td class="text-center fw-bold fs-4">
                                            <span class="badge bg-primary total-score"><?= number_format($penilaian['total_nilai_industri'], 2) ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center d-flex flex-column justify-content-center py-5">
                        <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                        </div>
                        <h5 class="text-dark mb-2">Belum ada nilai dari pembimbing industri</h5>
                        <p class="text-muted mb-0">Nilai akan muncul setelah pembimbing industri mengisi evaluasi</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>x`

<?= $this->endSection(); ?>
