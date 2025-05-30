<?php
/** @var \CodeIgniter\View\View $this */
?>
<?= $this->extend('layouts/template_mahasiswa'); ?>
<?= $this->section('content'); ?>

<div class="container">
  <div class="">
    <div class="col-12">
      <!-- Header Section -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">📝 Logbook Bimbingan</h2>
        
        <?php if (session()->get('logged_in')): ?>
          <div class="alert alert-success mb-0 py-2">
            <i class="fas fa-user-circle me-2"></i>Selamat datang, <?= esc(session()->get('nama')) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- Logbook Form -->
      <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-success text-white rounded-top-3">
          <h5 class="mb-0">Form Tambah Logbook</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="<?= site_url('mahasiswa/logbook/create'); ?>" enctype="multipart/form-data">
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
              
              <div class="col-md-6">
                <label for="file_dokumen" class="form-label">Dokumen Pendukung (PDF)</label>
                <input type="file" name="file_dokumen" id="file_dokumen" class="form-control" accept=".pdf">
                <small class="text-muted">Maksimal ukuran file: 5MB. Format PDF saja.</small>
              </div>
              
              <div class="col-md-6">
                <label for="link_drive" class="form-label">Link Google Drive (Opsional)</label>
                <input type="url" name="link_drive" id="link_drive" class="form-control" 
                       placeholder="https://drive.google.com/...">
              </div>
              
              <div class="col-12">
                <button type="submit" class="btn btn-primary px-4">
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
        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Daftar Logbook Bimbingan</h5>
        <span class="badge bg-white text-success">Total: <?= count($logbook) ?></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="120" class="ps-4">Tanggal</th>
                        <th width="300">Bimbingan</th>
                        <th width="300">Catatan Dosen</th>
                        <th width="150" class="text-center">Dokumen</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="140" class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logbook)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
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
                                
                                <!-- Scrollable Bimbingan Column -->
                                <td>
                                    <div class="scrollable-content" style="max-height: 300px; overflow-y: auto;">
                                        <div class=""><?= esc($entry['aktivitas']) ?></div>
                                    </div>
                                </td>
                                
                                <!-- Scrollable Catatan Dosen Column -->
                                <td>
                                    <div class="scrollable-content" style="max-height: 300px; overflow-y: auto;">
                                        <?php if (!empty($entry['catatan_dosen'])): ?>
                                            <div class="d-flex align-items-start">
                                                <i class=" text-muted me-2 mt-1"></i>
                                                <div><?= esc($entry['catatan_dosen']) ?></div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada catatan dari dosen</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <!-- Enhanced Document Column -->
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1 align-items-center">
                                        <?php if (!empty($entry['file_dokumen'])): ?>
                                            <a href="<?= site_url('mahasiswa/logbook/download/' . $entry['file_dokumen']) ?>" 
                                               class="btn btn-sm btn-outline-success w-100">
                                               <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($entry['link_drive'])): ?>
                                            <a href="<?= esc($entry['link_drive']) ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary w-100">
                                               <i class="fab fa-google-drive me-1"></i>Google Drive
                                            </a>
                                        <?php endif; ?>
                                        <?php if (empty($entry['file_dokumen']) && empty($entry['link_drive'])): ?>
                                            <span class="text-muted small">Tidak ada dokumen</span>
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
                                            <a href="<?= site_url('mahasiswa/logbook/edit/' . $entry['logbook_id']) ?>" 
                                               class="btn btn-sm btn-outline-primary rounded-circle"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('mahasiswa/logbook/delete/' . $entry['logbook_id']) ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-circle"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus logbook ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
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
</div>

<?= $this->endSection(); ?>