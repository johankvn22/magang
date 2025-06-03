<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-clipboard2-check me-2"></i>Daftar Review Kinerja Mahasiswa
        </h2>
        <form method="get" action="<?= site_url('industri/review-kinerja') ?>" class="row g-2 align-items-center">
            
            <div class="col-auto">
                
            </div>
        </form>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($mahasiswaList)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 30%;">Mahasiswa</th>
                                <th style="width: 20%;">Program Studi</th>
                                <th style="width: 30%;">Perusahaan</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswaList as $mhs): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div style="word-wrap: break-word;">
                                                <h6 class="mb-0 fw-medium"><?= esc($mhs['nama_lengkap']) ?></h6>
                                                <small class="text-muted"><?= esc($mhs['nim'] ?? '-') ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="word-wrap: break-word;">
                                        <h6 class="mb-0 fw-medium"><?= esc($mhs['program_studi']) ?></h6>
                                    </td>
                                    <td style="word-wrap: break-word;">
                                        <?php if (!empty($mhs['nama_perusahaan'])): ?>
                                            <span class="" style="white-space: normal;"><?= esc($mhs['nama_perusahaan']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (in_array($mhs['mahasiswa_id'], $mahasiswaReviewed)): ?>
                                                <a href="<?= site_url('industri/review-kinerja/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-info rounded-pill px-3">
                                                    <i class="bi bi-eye-fill me-1"></i> Detail
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= site_url('industri/review-kinerja/berikan/' . $mhs['bimbingan_industri_id']) ?>" class="btn btn-sm btn-success rounded-pill px-3">
                                                    <i class="bi bi-pencil-square me-1"></i> Beri Review
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Belum ada mahasiswa yang membutuhkan review kinerja</p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>