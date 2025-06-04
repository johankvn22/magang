<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section (tetap sama) -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-building me-2"></i>Log Aktivitas Industri
        </h2>
        <a href="<?= base_url('kps/logbook-aktivitas') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Student & Dosen Information Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-body border-bottom">
            <h5 class="mb-3 d-flex align-items-center">
                <i class="bi bi-person-circle me-2 text-primary"></i>Informasi Mahasiswa
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <span class="text-muted small">Nama:</span>
                        <p class="mb-0 fw-medium"><?= isset($mahasiswa['nama_lengkap']) ? esc($mahasiswa['nama_lengkap']) : '-' ?></p>
                    </div>
                    <div>
                        <span class="text-muted small">NIM:</span>
                        <p class="mb-0 fw-medium"><?= isset($mahasiswa['nim']) ? esc($mahasiswa['nim']) : '-' ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <span class="text-muted small">Program Studi:</span>
                        <p class="mb-0 fw-medium"><?= isset($mahasiswa['program_studi']) ? esc($mahasiswa['program_studi']) : '-' ?></p>
                    </div>
                    <div>
                        <span class="text-muted small">Kelas:</span>
                        <p class="mb-0 fw-medium"><?= isset($mahasiswa['kelas']) ? esc($mahasiswa['kelas']) : '-' ?></p>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <h6 class="mb-2 d-flex align-items-center">
                        <i class="bi bi-person-badge me-2 text-secondary"></i>Informasi Pembimbing Industri
                    </h6>
                    <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small">Nama Pembimbing:</span>
                                    <p class="mb-0 fw-medium"><?= esc($mahasiswa['nama_pembimbing_perusahaan']) ?></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small">Nama Perusahaan:</span>
                                    <p class="mb-0 fw-medium"><?= esc($mahasiswa['nama_perusahaan']) ?></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small">Judul Magang:</span>
                                    <p class="mb-0 fw-medium"><?= esc($mahasiswa['judul_magang']) ?></p>
                                </div>
                    </div>
                        <div class="row">
                        <?php if (!empty($dosen_pembimbing)) : ?>
                            <?php foreach ($dosen_pembimbing as $dosen) : ?>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small">Nama Dosen:</span>
                                    <p class="mb-0 fw-medium"><?= esc($dosen['nama_lengkap']) ?></p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted small">NIP:</span>
                                    <p class="mb-0 fw-medium"><?= esc($dosen['nip']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12">
                                <p class="text-muted">Belum ada dosen pembimbing terdaftar.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Table - MODIFIED SECTION -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-list-check me-2"></i>Catatan Aktivitas
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($logbook_industri)): ?>
                <div class="alert alert-light text-center py-4 m-4">
                    <i class="bi bi-journal-x fs-3 text-muted"></i>
                    <p class="mt-2 mb-0">Belum ada data aktivitas industri</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%;" class="ps-4">Tanggal</th>
                                <th style="width: 40%;">Judul Aktivitas</th>
                                <th style="width: 30%;">Catatan Industri</th>
                                <th style="width: 15%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logbook_industri as $log): ?>
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <?= date('d M Y', strtotime($log['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <div class="activity-content" style="max-height: 150px; overflow-y: auto;">
                                            <?= esc($log['aktivitas']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="notes-content" style="max-height: 150px; overflow-y: auto;">
                                            <?= !empty($log['catatan_industri']) ? esc($log['catatan_industri']) : 'Belum ada catatan' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $log['status_validasi'];
                                            $badgeClass = match (strtolower($status)) {
                                                'disetujui' => 'bg-success-subtle text-success',
                                                'ditolak' => 'bg-danger-subtle text-danger',
                                                'menunggu' => 'bg-warning-subtle text-warning',
                                                default => 'bg-light text-muted'
                                            };
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill text-capitalize">
                                            <?= esc($status) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <!-- Footer (tetap sama) -->
    </div>
</div>

<?= $this->endSection(); ?>