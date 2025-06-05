<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_panitia'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold">📋 Detail Logbook Bimbingan</h4>
                <a href="<?= base_url('panitia/logbook-mahasiswa') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Student Info Section -->
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
                        <i class="bi bi-person-badge me-2 text-secondary"></i>Informasi Dosen Pembimbing
                    </h6>
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

        <!-- Logbook Table Section -->
        <div class="card-body p-0">
            <?php if (empty($logbook)): ?>
                <div class="alert alert-light text-center py-4 m-4">
                    <i class="bi bi-journal-text fs-3 text-muted"></i>
                    <p class="mt-2 mb-0">Belum ada data logbook bimbingan untuk mahasiswa ini.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="20%" class="ps-4">Tanggal</th>
                                <th width="40%">Materi Bimbingan</th>
                                <th width="30%">Catatan Dosen</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logbook as $entry): ?>
                                <tr>
                                    <td class="ps-4 align-middle">
                                        <?= date('d-m-Y', strtotime($entry['tanggal'])) ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="scrollable-cell" style="max-height: 300px; overflow-y: auto;">
                                            <?= esc($entry['aktivitas']) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="scrollable-cell" style="max-height: 300px; overflow-y: auto;">
                                            <?= !empty($entry['catatan_dosen']) 
                                                ? esc($entry['catatan_dosen']) 
                                                : '<span class="text-muted fst-italic">Belum ada catatan</span>' ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                            $status = $entry['status_validasi'];
                                            $badgeClass = match ($status) {
                                                'disetujui' => 'bg-success-subtle text-success',
                                                'ditolak'   => 'bg-danger-subtle text-danger',
                                                'menunggu'  => 'bg-warning-subtle text-warning',
                                                default     => 'bg-light text-muted'
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

        <!-- Summary Footer -->
        <?php if (!empty($logbook)): ?>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total Bimbingan: <?= count($logbook) ?></span>
                <div>
                    <?php
                    $approvedCount = array_reduce($logbook, function($carry, $item) {
                        return $carry + ($item['status_validasi'] === 'disetujui' ? 1 : 0);
                    }, 0);
                    ?>
                    <span class="badge bg-success-subtle text-success me-2">
                        Disetujui: <?= $approvedCount ?>
                    </span>
                    <span class="badge bg-warning-subtle text-warning me-2">
                        Menunggu: <?= count($logbook) - $approvedCount ?>
                    </span>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>