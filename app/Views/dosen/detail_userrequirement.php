<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Data User Requirement
        </h2>
        <a href="<?= site_url('dosen/user-requirement') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Student Information Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-person-badge me-2"></i>Informasi Mahasiswa
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Student Info Column -->
                <div class="col-md-6">
                <!-- Foto Profil -->
                <div class="mb-3 text-center">
                    <img src="<?= base_url('uploads/foto_profil/' . esc($mahasiswa['foto_profil'])) ?>"
                         alt="Foto Profil Mahasiswa"
                         class="img-thumbnail rounded-circle"
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Nama Mahasiswa</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">NIM</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['nim']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Program Studi</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['program_studi']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Kelas</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['kelas']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Kontak</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['no_hp']) ?> | <?= esc($mahasiswa['email']) ?></p>
                </div>
            </div>

            <!-- Internship Info Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Perusahaan</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['nama_perusahaan']) ?> (<?= esc($mahasiswa['divisi']) ?>)</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Durasi Magang</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['durasi_magang']) ?> Bulan</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Periode Magang</label>
                    <p class="fw-medium mb-0">
                        <?= date('d M Y', strtotime($mahasiswa['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($mahasiswa['tanggal_selesai'])) ?>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Pembimbing Perusahaan</label>
                    <p class="fw-medium mb-0">
                        <?= esc($mahasiswa['nama_pembimbing_perusahaan']) ?><br>
                        <?= esc($mahasiswa['no_hp_pembimbing_perusahaan']) ?> | <?= esc($mahasiswa['email_pembimbing_perusahaan']) ?>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Judul Magang</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['judul_magang']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


    

    <!-- Requirements Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-list-check me-2"></i>Daftar User Requirement
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($requirements)) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="15%" class="ps-4">Tanggal</th>
                                <th width="25%">Modul/Unit</th>
                                <th width="40%">User Requirement</th>
                                <th width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requirements as $req): ?>
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <?= date('d M Y', strtotime($req['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 100px; overflow-y: auto;">
                                            <?= esc($req['dikerjakan']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 100px; overflow-y: auto;">
                                            <?= esc($req['user_requirement']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $req['status_validasi'];
                                            $badgeClass = match ($status) {
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
            <?php else : ?>
                <div class="alert alert-light text-center py-4 m-4">
                    <i class="bi bi-journal-x fs-3 text-muted"></i>
                    <p class="mt-2 mb-0">Belum ada data user requirement</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>