<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-success mb-0">📝 User Requirement / Spesifikasi</h2>
                <?php if (session()->get('logged_in')): ?>
                    <div class="badge bg-success bg-opacity-10 text-success p-2">
                        <i class="fas fa-user-circle me-2"></i><?= esc(session()->get('nama')) ?>
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

            <!-- Form Input -->
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Form Tambah User Requirement</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= site_url('mahasiswa/user-requirement/create'); ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                       value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="dikerjakan" class="form-label">Modul / Unit yang Dikerjakan</label>
                                <textarea name="dikerjakan" id="dikerjakan" class="form-control" rows="3" 
                                          placeholder="Deskripsikan modul atau unit yang sedang dikerjakan" required></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="user_requirement" class="form-label">User Requirement / Spesifikasi</label>
                                <textarea name="user_requirement" id="user_requirement" class="form-control" rows="3"
                                          placeholder="Tuliskan spesifikasi atau requirement dari modul/unit tersebut"></textarea>
                            </div>
                            
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Daftar User Requirement</h5>
                    <span class="badge bg-white text-success">Total: <?= count($requirements) ?></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%" class="ps-4">Tanggal</th>
                                    <th width="25%">Modul / Unit</th>
                                    <th width="30%">User Requirement</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="15%" class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($requirements)) : ?>
                                    <?php foreach ($requirements as $entry): ?>
                                        <tr>
                                            <td class="ps-4"><?= esc($entry['tanggal']) ?></td>
                                            <td>
                                                <div class="scrollable-content" style="max-height: 100px; overflow-y: auto;">
                                                    <?= esc($entry['dikerjakan']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="scrollable-content" style="max-height: 100px; overflow-y: auto;">
                                                    <?= !empty($entry['user_requirement']) ? esc($entry['user_requirement']) : '<span class="text-muted">Belum ada spesifikasi</span>' ?>
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
                                                    <?php if ($entry['status_validasi'] !== 'disetujui'): ?>
                                                        <a href="<?= site_url('mahasiswa/user-requirement/edit/' . $entry['requirement_id']) ?>" 
                                                           class="btn btn-sm btn-outline-primary rounded-circle"
                                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="<?= site_url('mahasiswa/user-requirement/delete/' . $entry['requirement_id']) ?>" 
                                                              method="POST">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger rounded-circle"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                                    onclick="return confirm('Yakin ingin menghapus?')">
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
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <div class="py-3">
                                                <i class="fas fa-file-alt fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">Belum ada entri user requirement</p>
                                                <small class="text-muted">Mulai dengan menambahkan data baru</small>
                                            </div>
                                        </td>
                                    </tr>
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