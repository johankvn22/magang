<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-clipboard2-data me-2"></i>Detail Review Kinerja
        </h2>
        <a href="<?= base_url('/admin/review-kinerja') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Student & Company Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Informasi Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">Nama Mahasiswa:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['nama_mahasiswa']) ?></p>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Email:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['email']) ?></p>
                    </div>
                    <div class="mb-0">
                        <span class="text-muted small">No HP:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['no_hp']) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Informasi Pembimbing</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">Nama Pembimbing:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['nama_pembimbing_perusahaan']) ?></p>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Perusahaan:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['nama_perusahaan']) ?></p>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Jabatan/Divisi:</span>
                        <p class="fw-medium mb-0"><?= esc($review_id['jabatan']) ?> / <?= esc($review_id['divisi']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Section -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">Penilaian Kompetensi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40%">Kompetensi</th>
                            <th width="10%" class="text-center">Sangat Baik</th>
                            <th width="10%"class="text-center">Baik</th>
                            <th width="10%"class="text-center">Cukup</th>
                            <th width="10%"class="text-center">Kurang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $competencies = [
                            'integritas' => 'Integritas (Etika dan Moral)',
                            'keahlian_bidang' => 'Keahlian Berdasarkan Bidang Ilmu (Profesionalisme)',
                            'kemampuan_bahasa_inggris' => 'Kemampuan Bahasa Inggris',
                            'pengetahuan_bidang' => 'Pengetahuan di Bidang Teknik Informatika/Multimedia/Jaringan',
                            'komunikasi_adaptasi' => 'Kemampuan Berkomunikasi/Adaptasi',
                            'kerja_sama' => 'Kemampuan Bekerjasama',
                            'kemampuan_belajar' => 'Kemampuan Belajar',
                            'kreativitas' => 'Kreativitas',
                            'menuangkan_ide' => 'Kemampuan Menuangkan Ide/Pendapat',
                            'pemecahan_masalah' => 'Kemampuan Memecahkan Masalah',
                            'sikap' => 'Sikap kepada Atasan/Teman/Setingkat/Bawahan',
                            'kerja_dibawah_tekanan' => 'Kemampuan Bekerja Dibawah Tekanan',
                            'manajemen_waktu' => 'Manajemen Waktu',
                            'bekerja_mandiri' => 'Bekerja Secara Mandiri',
                            'negosiasi' => 'Negosiasi',
                            'analisis' => 'Kemampuan Analisis',
                            'bekerja_dengan_budaya_berbeda' => 'Kemampuan Bekerja dengan Orang yang Berbeda Budaya/Latar Belakang',
                            'kepemimpinan' => 'Kepemimpinan',
                            'tanggung_jawab' => 'Kemampuan dalam Memegang Tanggung Jawab',
                            'presentasi' => 'Kemampuan untuk Mempresentasikan Ide/Produk/Laporan',
                            'menulis_dokumen' => 'Kemampuan dalam Menulis Laporan, Memo dan Dokumen'
                        ];
                        
                        foreach ($competencies as $field => $label): 
                            $value = $review_id[$field] ?? '';
                        ?>
                        <tr>
                            <td><?= $label ?></td>
                            <td class="text-center">
                                <input type="radio" class="form-check-input" disabled <?= $value === 'sangat_baik' ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="radio" class="form-check-input" disabled <?= $value === 'baik' ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="radio" class="form-check-input" disabled <?= $value === 'cukup' ? 'checked' : '' ?>>
                            </td>
                            <td class="text-center">
                                <input type="radio" class="form-check-input" disabled <?= $value === 'kurang' ? 'checked' : '' ?>>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Saran untuk Lulusan</h5>
                </div>
                <div class="card-body">
                    <p><?= !empty($review_id['saran_lulusan']) ? esc($review_id['saran_lulusan']) : '-' ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Kemampuan Teknik yang Dibutuhkan</h5>
                </div>
                <div class="card-body">
                    <p><?= !empty($review_id['kemampuan_teknik_dibutuhkan']) ? esc($review_id['kemampuan_teknik_dibutuhkan']) : '-' ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold">Profesi yang Cocok</h5>
                </div>
                <div class="card-body">
                    <p><?= !empty($review_id['profesi_cocok']) ? esc($review_id['profesi_cocok']) : '-' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-end mt-4">
        <small class="text-muted">Tanggal Review: <?= date('d M Y, H:i', strtotime($review_id['created_at'])) ?></small>
    </div>
</div>

<style>
    .form-check-input {
        transform: scale(1.2);
        cursor: default;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

<?= $this->endSection(); ?>