<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-success mb-0">📝 Logbook Aktivitas Industri</h2>
                <?php if (session()->get('logged_in')): ?>
                    <div class="alert alert-success mb-0 py-2">
                        <i class="fas fa-user-circle me-2"></i>Selamat datang, <?= esc(session()->get('nama')) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Flash Message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Add Logbook Card -->
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Form Tambah Logbook</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= site_url('mahasiswa/logbook_industri/create'); ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="tanggal" class="form-label">Tanggal Bimbingan</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required 
                                       value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            
                            <div class="col-12">
                                <label for="aktivitas" class="form-label">Deskripsi Bimbingan</label>
                                <textarea name="aktivitas" id="aktivitas" class="form-control" rows="3" required
                                          placeholder="Deskripsikan kegiatan bimbingan yang dilakukan"></textarea>
                            </div>
                            
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Logbook
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logbook List -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Daftar Logbook Aktivitas</h5>
                    <span class="badge bg-white text-success">Total: <?= count($logbook) ?></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="120" class="ps-4">Tanggal</th>
                                    <th width="300">Aktivitas</th>
                                    <th width="300">Catatan Industri</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="140" class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($logbook)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <div class="py-3">
                                                <i class="fas fa-book-open fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">Belum ada data logbook</p>
                                                <small class="text-muted">Mulai dengan menambahkan logbook baru</small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($logbook as $entry): ?>
                                        <tr class="<?= $entry['status_validasi'] == 'tidak valid' ? 'table-danger-light' : '' ?>">
                                            <td class="ps-4">
                                                <div class="fw-semibold"><?= date('d/m/Y', strtotime($entry['tanggal'])) ?></div>
                                                <small class="text-muted"><?= date('H:i', strtotime($entry['created_at'] ?? $entry['tanggal'])) ?></small>
                                            </td>
                                            
                                            <!-- Scrollable Aktivitas Column -->
                                            <td>
                                                <div class="scrollable-content" style="max-height: 300px; overflow-y: auto;">
                                                    <div class="fw-semibold"><?= esc($entry['aktivitas']) ?></div>
                                                </div>
                                            </td>
                                            
                                            <!-- Scrollable Catatan Industri Column -->
                                            <td>
                                                <div class="scrollable-content" style="max-height: 300px; overflow-y: auto;">
                                                    <?php if (!empty($entry['catatan_industri'])): ?>
                                                        <div class="d-flex align-items-start">
                                                            <i class="text-muted"></i>
                                                            <div><?= esc($entry['catatan_industri']) ?></div>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted">Belum ada catatan dari industri</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <?php 
                                                $statusClass = [
                                                    'disetujui' => 'success',
                                                    'ditolak' => 'danger',
                                                    'menunggu' => 'warning'
                                                ];
                                                ?>
                                                <span class="badge bg-<?= $statusClass[strtolower($entry['status_validasi'])] ?>">
                                                    <?= esc($entry['status_validasi']) ?>
                                                </span>
                                            </td>
                                            
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <?php if ($entry['status_validasi'] == 'menunggu'): ?>
                                                        <a href="<?= site_url('mahasiswa/logbook_industri/edit/' . $entry['logbook_id']) ?>" 
                                                           class="btn btn-sm btn-outline-primary rounded-circle"
                                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="<?= site_url('mahasiswa/logbook_industri/delete/' . $entry['logbook_id']) ?>" 
                                                              method="post">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger rounded-circle"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                                    onclick="return confirm('Yakin ingin menghapus logbook ini?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="text-muted small align-self-center">Terkunci</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>