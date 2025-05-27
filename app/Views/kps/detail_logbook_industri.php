<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_kps'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-building me-2"></i>Log Aktivitas Industri
        </h2>
        <a href="<?= base_url('kps/logbook-aktivitas') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Student Information Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-person-badge me-2"></i>Detail Mahasiswa
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Nama Mahasiswa</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['nama_lengkap']) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">NIM</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['nim']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Perusahaan</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['nama_perusahaan']) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Divisi</label>
                        <p class="fw-medium mb-0"><?= esc($mahasiswa['divisi']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Table -->
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
                                <th class="ps-4">Tanggal</th>
                                <th>Judul Aktivitas</th>
                                <th>Catatan Industri</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logbook_industri as $log): ?>
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <?= date('d M Y', strtotime($log['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell"  style="max-height: 300px; overflow-y: auto;">
                                            <?= esc($log['aktivitas']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 300px; overflow-y: auto;">
                                            <?= !empty($log['catatan_industri']) ? esc($log['catatan_industri']) : '-' ?>
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
        <?php if (!empty($logbook_industri)): ?>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total Aktivitas: <?= count($logbook_industri) ?></span>
                <div>
                    <?php
                    $statusCounts = [
                        'disetujui' => 0,
                        'ditolak' => 0,
                        'menunggu' => 0
                    ];
                    foreach ($logbook_industri as $log) {
                        $status = strtolower($log['status_validasi']);
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