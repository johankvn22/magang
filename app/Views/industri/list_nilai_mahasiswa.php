<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_industri'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-clipboard-data me-2"></i>Daftar Mahasiswa Nilai Industri
        </h2>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($mahasiswaList)) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 30%;">Mahasiswa</th>
                                <th style="width: 30%;">Program Studi</th>
                                <th style="width: 20%;">Status</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswaList as $mhs) : ?>
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
                                    <td>
                                        <?php if ($mhs['sudah_dinilai']) : ?>
                                            <span class="badge bg-success-subtle text-success">Sudah Dinilai</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Belum Dinilai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($mhs['sudah_dinilai']) : ?>
                                            <a href="<?= base_url('industri/penilaian-industri/detail/' . $mhs['mahasiswa_id']) ?>" class="btn btn-sm btn-info rounded-pill px-3">
                                                <i class="bi bi-eye-fill me-1"></i> Detail Nilai
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">Menunggu logbook</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center py-5">
                    <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Belum ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Data penilaian belum tersedia</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
