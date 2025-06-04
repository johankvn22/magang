<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_dosen'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-journal-text me-2"></i>Detail Logbook Bimbingan
        </h2>
        <a href="<?= site_url('dosen/bimbingan') ?>" class="btn btn-outline-secondary">
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


    <!-- Logbook Summary -->
    <?php
    $logbookLayakDinilai = array_filter($logbooks, fn($log) => isset($log['status_validasi']) && $log['status_validasi'] === 'disetujui');
    $jumlahDisetujui = count($logbookLayakDinilai);
    $totalLogbooks = count($logbooks);
    ?>
    <div class="alert alert-light border mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-info-circle me-2"></i>
                <strong>Status Logbook:</strong> 
                <span class="badge bg-success-subtle text-success"><?= $jumlahDisetujui ?> Disetujui</span>
                <span class="badge bg-warning-subtle text-warning mx-2"><?= $totalLogbooks - $jumlahDisetujui ?> Menunggu/Ditolak</span>
                dari total <?= $totalLogbooks ?> logbook
            </div>
            <?php if ($jumlahDisetujui >= 6): ?>
                <span class="badge bg-success-subtle text-success">
                    <i class="bi bi-check-circle me-1"></i>Memenuhi syarat penilaian
                </span>
            <?php else: ?>
                <span class="badge bg-warning-subtle text-warning">
                    <i class="bi bi-exclamation-circle me-1"></i>Belum memenuhi syarat (minimal 6 logbook disetujui)
                </span>
            <?php endif; ?>
        </div>
    <!-- Assessment Button -->
    <div class="d-flex justify-content-end align-items-center mb-3 mt-3">
        <?php if (!$penilaian_sudah_ada && $jumlahDisetujui >= 6 && !empty($bimbingan_id)) : ?>
            <a href="<?= site_url('dosen/penilaian-dosen/form/' . $bimbingan_id) ?>" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Beri Penilaian
            </a>
        <?php elseif ($penilaian_sudah_ada) : ?>
            <a href="<?= site_url('dosen/penilaian-dosen/detail/' . $bimbingan_id) ?>" class="btn btn-outline-success">
                <i class="bi bi-eye me-1"></i> Lihat Penilaian
            </a>
        <?php endif; ?>
    </div>

    <!-- Logbook Table -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-list-check me-2"></i>Daftar Logbook
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($logbooks)) : ?>
                <div class="alert alert-light text-center py-4 m-4">
                    <i class="bi bi-journal-x fs-3 text-muted"></i>
                    <p class="mt-2 mb-0">Belum ada logbook yang diinput oleh mahasiswa</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Tanggal</th>
                                <th width="25%">Kegiatan</th>
                                <th width="15%">Dokumen</th>
                                <th width="25%">Catatan Dosen</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logbooks as $log): ?>
                                <tr id="logbook-<?= $log['logbook_id'] ?>">
                                    <td class="fw-medium">
                                        <?= date('d M Y', strtotime($log['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <div class="scrollable-cell" style="max-height: 100px; overflow-y: auto;">
                                            <?= esc($log['aktivitas']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if (!empty($log['file_dokumen'])): ?>
                                            <a href="<?= site_url('dosen/download-logbook/' . $log['file_dokumen']) ?>" class="btn btn-sm btn-outline-success w-100 mb-1">
                                                <i class="bi bi-download me-1"></i>Download
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($log['link_drive'])): ?>
                                            <a href="<?= esc($log['link_drive']) ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="bi bi-google me-1"></i>Google Drive
                                            </a>
                                        <?php endif; ?>
                                        <?php if (empty($log['file_dokumen']) && empty($log['link_drive'])): ?>
                                            <span class="text-muted small">Tidak ada dokumen</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        
                                        <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                            <form action="<?= site_url('dosen/update_catatan/' . $log['logbook_id']) ?>?highlight=logbook-<?= $log['logbook_id'] ?>" method="post">
                                                <div class="mb-2">
                                                    <textarea 
                                                        name="catatan_dosen" 
                                                        class="form-control form-control-sm" 
                                                        rows="3"
                                                        placeholder="Tulis catatan untuk mahasiswa..." 
                                                        required><?= esc($log['catatan_dosen']) ?></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                                    <i class="bi bi-save me-1"></i>
                                                    <?= !empty($log['catatan_dosen']) ? 'Update Catatan' : 'Simpan Catatan' ?>
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <div class="scrollable-cell" style="max-height: 100px; overflow-y: auto;">
                                                <?= !empty($log['catatan_dosen']) ? esc($log['catatan_dosen']) : '<span class="text-muted fst-italic">Belum ada catatan</span>' ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>


                                    <td>
                                        <?php if ($log['status_validasi'] === 'disetujui') : ?>
                                            <span class="badge bg-success rounded-pill w-100">Disetujui</span>
                                        <?php elseif ($log['status_validasi'] === 'ditolak') : ?>
                                            <span class="badge bg-danger rounded-pill w-100">Ditolak</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning rounded-pill w-100">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($log['status_validasi'] === 'menunggu') : ?>
                                            <div class="d-grid gap-2">
                                                <form action="<?= site_url('dosen/bimbingan/setujui/' . $log['logbook_id']) ?>?highlight=logbook-<?= $log['logbook_id'] ?>" method="post" class="form-setujui">
                                                    <button type="button" class="btn btn-success btn-sm w-100 mb-1 btn-confirm-setujui-bimbingan">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <form action="<?= site_url('dosen/bimbingan/tolak/' . $log['logbook_id']) ?>?highlight=logbook-<?= $log['logbook_id'] ?>" method="post" class="form-tolak">
                                                    <button type="button" class="btn btn-danger btn-sm w-100 btn-confirm-tolak-bimbingan">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        <?php else : ?>
                                            <span class="text-muted small">Telah divalidasi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Assessment Button -->
    <div class="d-flex justify-content-end align-items-center">
        <a href="<?= site_url('dosen/bimbingan') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<?= $this->endSection(); ?>