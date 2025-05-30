<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-activity me-2"></i>Daftar Aktivitas Mahasiswa Bimbingan
        </h2>

        <form method="get" action="<?= site_url('dosen/aktivitas') ?>" class="row g-2 align-items-center">
            <div class="col-md-8">
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" 
                       class="form-control form-control-sm" 
                       placeholder="Cari Nama/NIM/Prodi/Kelas...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Activity List Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($mahasiswaList)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 25%;">Mahasiswa</th>
                                <th style="width: 20%;">Program Studi</th>
                                <th style="width: 25%;">Perusahaan</th>
                                <th style="width: 15%;">Aktivitas</th>
                                <th style="width: 15%;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswaList as $mhs): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div style="word-break: break-word;">
                                                <h6 class="mb-0 fw-medium"><?= esc($mhs['nama_lengkap']) ?></h6>
                                                <small class="text-muted"><?= esc($mhs['nim'] ?? '-') ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="word-break: break-word;">
                                        <h6 class="mb-0 fw-medium"><?= esc($mhs['program_studi'] ?? '-') ?></h6>
                                        <small class="text-muted"><?= esc($mhs['kelas'] ?? '-') ?></small>
                                    </td>
                                    <td style="word-break: break-word;">
                                        <?php if (!empty($mhs['nama_perusahaan'])): ?>
                                            <span class="badge bg-success-subtle text-success" style="white-space: normal;">
                                                <?= esc($mhs['nama_perusahaan']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($mhs['jumlah_aktivitas'])): ?>
                                            <span class="badge bg-primary rounded-pill">
                                                <?= esc($mhs['jumlah_aktivitas']) ?> aktivitas
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">0 aktivitas</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('dosen/logbook/' . $mhs['mahasiswa_id']) ?>" 
                                           class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i> Aktivitas
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-activity text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Belum ada aktivitas mahasiswa yang tercatat</p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>