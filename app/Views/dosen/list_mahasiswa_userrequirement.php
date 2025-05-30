<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Daftar User Requirement Mahasiswa
        </h2>
        
        <form method="get" action="<?= site_url('dosen/user-requirement') ?>" class="row g-2 align-items-center">
            <div class="col-md-8">
                <input type="text" name="keyword" 
                       class="form-control form-control-sm" 
                       placeholder="Cari Nama/NIM/Kelas/Prodi..." 
                       value="<?= esc($keyword ?? '') ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($mahasiswaList)) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 25%;">Mahasiswa</th>
                                <th style="width: 20%;">Program Studi</th>
                                <th style="width: 25%;">Perusahaan</th>
                                <th style="width: 15%;" >Aksi</th>
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
                                            <div style="word-break: break-word;">
                                                <h6 class="mb-0 fw-medium"><?= esc($mhs['nama_lengkap']) ?></h6>
                                                <small class="text-muted"><?= esc($mhs['nim'] ?? '-') ?></small>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="word-break: break-word;">
                                                <h6 class="mb-0 fw-medium"><?= esc($mhs['program_studi']) ?></h6>
                                                <small class="text-muted"><?= esc($mhs['kelas'] ?? '-') ?></small>
                                    </td>
                                    <td style="word-break: break-word;">
                                        <?php if (!empty($mhs['nama_perusahaan'])) : ?>
                                            <span class="" style="white-space: normal;"><?= esc($mhs['nama_perusahaan']) ?></span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Tidak ada perusahaan</span>
                                        <?php endif; ?>
                                    <td>
                                        <a href="<?= base_url('dosen/user-requirement/detail/' . $mhs['mahasiswa_id']) ?>" 
                                           class="btn btn-sm btn-success rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i> User Requirement
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else : ?>
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Belum ada mahasiswa yang ditugaskan sebagai bimbingan Anda</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>