<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Detail User Requirement
        </h2>
        <a href="<?= base_url('kps/logbook') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Student Information -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Nama Mahasiswa</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">NIM</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['nim']) ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Program Studi</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['program_studi']) ?></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Divisi</label>
                    <p class="fw-medium mb-0"><?= esc($mahasiswa['divisi']) ?></p>
                </div>
 
            </div>
        </div>
    </div>

    <!-- Requirements Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <?php if (!empty($user_requirements)) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="15%">Tanggal</th>
                                <th width="35%">Modul/Unit</th>
                                <th width="35%">User Requirement</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_requirements as $req) : ?>
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <?= date('d M Y', strtotime($req['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 300px; overflow-y: auto;">
                                            <?= esc($req['dikerjakan']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 300px; overflow-y: auto;">
                                            <?= esc($req['user_requirement']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $req['status_validasi'];
                                            $badgeClass = match (strtolower($status)) {
                                                'disetujui' => 'bg-success-subtle text-success',
                                                'ditolak' => 'bg-danger-subtle text-danger',
                                                'menunggu' => 'bg-warning-subtle text-warning',
                                                default => 'bg-light text-muted'
                                            };
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill">
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
        <?php if (!empty($user_requirements)) : ?>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total Requirements: <?= count($user_requirements) ?></span>
                <div>
                    <?php
                    $statusCounts = [
                        'disetujui' => 0,
                        'ditolak' => 0,
                        'menunggu' => 0
                    ];
                    foreach ($user_requirements as $req) {
                        $status = strtolower($req['status_validasi']);
                        if (array_key_exists($status, $statusCounts)) {
                            $statusCounts[$status]++;
                        }
                    }
                    ?>
                    <span class="badge bg-success-subtle text-success me-2">
                        Disetujui: <?= $statusCounts['disetujui'] ?>
                    </span>
                    <span class="badge bg-warning-subtle text-warning me-2">
                        Menunggu: <?= $statusCounts['menunggu'] ?>
                    </span>
                    <span class="badge bg-danger-subtle text-danger">
                        Ditolak: <?= $statusCounts['ditolak'] ?>
                    </span>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>